<?php

namespace App\Controllers;

use App\Models\NewProductAddModel;
use App\Models\ProductPurchaseDetailsModel;
use App\Models\ProductPurchaseModel;
use App\Models\SupplierModel;

class Purchase extends BaseController
{
    private $product_purchase_object;
    private $product_purchase_details_object;
    private $product_add_object;
    private $supplier_object;
    private $db;

    public function __construct()
    {
        $this->product_purchase_object = new ProductPurchaseModel();
        $this->product_purchase_details_object = new ProductPurchaseDetailsModel();
        $this->product_add_object = new NewProductAddModel();
        $this->supplier_object = new SupplierModel();
        $this->db = db_connect();
    }

    public function index()
    {

        $sql = "SELECT piq.*,
                tx.tax_percentage,
                tx.tax_name,
                productinitial_quantity + IFNULL(ppd.new_purchased,0) AS total_stock
        FROM product_inital_stock as piq
        LEFT JOIN (
            SELECT product_id,SUM(quantity) as new_purchased
            FROM product_purchase_details
            GROUP BY product_id
            ) as ppd
           ON piq.product_id = ppd.product_id

           LEFT JOIN tax as tx  ON piq.tax_id = tx.tax_id ";

        $data['product_show_for_sale'] = $this->db->query($sql)->getResult('array');

        $data['supplier_show'] = $this->supplier_object->findAll();

        return view('purchase/purchase_add', $data);
    }

    public function purchase_product()
    {
        $session = session();
        $purchaseList = json_decode($this->request->getPost("cart_data"), true);

        echo "<pre>";
        echo print_r($purchaseList);
        echo "</pre>";
        exit();

        
        $discount_on_total_price = $this->request->getPost('discount_on_total_price');
        $supplier_id = $this->request->getPost('supplier_id');

        $purchaser_id = $session->get('user_id');

        // Start DB Transaction
        $this->db->transStart();

        // Invoice Generate
        $day_no = date('z') + 1;
        $unique_text = substr(md5(microtime(true) . mt_rand()), -5);

        $invoice_id = strtoupper(
            "PUR" . date("y") . str_pad($day_no, 3, "0", STR_PAD_LEFT) . $unique_text
        );

        $purchase_data = [
            "purchase_invoice" => $invoice_id,
            "purchaser_id" => $purchaser_id,
            "payment_type" => "Cash",
            "discount_on_total_price" => $discount_on_total_price,
            "supplier_id" => $supplier_id,
            "purchase_date" => date("Y-m-d H:i:s"),
        ];

        $this->product_purchase_object->insert($purchase_data);

        $purchase_details_invoice_data = [];

        foreach ($purchaseList as $row) {

            $unit_price = (float) $row['buying_unit_price'];
            $quantity = (int) $row['quantity'];

            $purchase_details_invoice_data[] = [
                "purchase_invoice_id" => $invoice_id,
                "product_id" => $row['product_id'],
                "unit_price" => $unit_price,
                "quantity" => $quantity,
                "total_price" => $unit_price * $quantity,
            ];
////////////////////////////////যদি tax এর value নতুন হয় তাহলে tax Table update করা /////////////////
            $tax_id = $row['tax_id'];
            $tax_percentage = (float) $row['tax_percentage'];

            $current_tax = $this->db->table('tax')->select('tax_percentage')
                ->where('tax_id', $tax_id)
                ->get()->getRowArray()['tax_percentage'];

            if ($current_tax != $tax_percentage) {
                $this->db->table('tax')
                    ->where('tax_id', $tax_id)
                    ->update(['tax_percentage' => $tax_percentage]);
            }
/////////////////////////////////////////////////////////////////////////////////////////////////

        } //foreach end here

        $this->product_purchase_details_object->insertBatch($purchase_details_invoice_data);

        $this->db->transComplete();

        if ($this->db->transStatus() === false) {
            return $this->response->setJSON([
                "status" => "error",
                "message" => "Purchase Failed!",
            ]);
        }

        return $this->response->setJSON([
            "status" => "success",
            "message" => "Purchase Successful!",
            "invoice_id" => $invoice_id,
        ]);
    }
}
