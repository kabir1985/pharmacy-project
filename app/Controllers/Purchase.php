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
            SELECT product_id,SUM(quantity_per_pack) as new_purchased
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

    // echo "<pre>";
    // print_r($purchaseList);
    // echo "</pre>";
    // exit();

    if (!$purchaseList || !is_array($purchaseList)) {
        return $this->response->setJSON([
            "status" => "error",
            "message" => "Cart is empty or invalid!"
        ]);
    }

    $discount_on_total_price = (float) $this->request->getPost('discount_on_total_price') ?? 0;
    $vat_percent_on_total = (float) $this->request->getPost('vat_percent_on_total') ?? 0;
    $supplier_id = $this->request->getPost('supplier_id');

    $purchaser_id = $session->get('user_id');
        // Generate unique invoice
    $day_no = date('z') + 1;
    $unique_text = substr(md5(microtime(true) . mt_rand()), -5);
    $invoice_id = strtoupper(
        "PUR" . date("y") . str_pad($day_no, 3, "0", STR_PAD_LEFT) . $unique_text
    );

    // Start DB Transaction
    $this->db->transStart();


    $total_purchase_amount = 0;
    $purchase_details_invoice_data = [];

    foreach ($purchaseList as $row) {

        $quantity_per_pack = (int) $row['quantity_per_pack'] ?? 1;
        $box_quantity = (int) $row['box_quantity'] ?? 1;
        $base_price_per_unit = (float) $row['base_price'] ?? 0;
        $tax_percentage = (float) $row['tax_percentage'] ?? 0;
        $discount_percent = (float) $row['discount_percent'] ?? 0;

        $total_qty = $quantity_per_pack * $box_quantity;
        $base_total = $total_qty * $base_price_per_unit;

        $vat_amount = $base_total * ($tax_percentage / 100);
       //$vat_amount = $row['tax_amount'];
        $discount_amount = $base_total * ($discount_percent / 100);
        $row_total = $base_total + $vat_amount - $discount_amount;

        $total_purchase_amount += $row_total;

        $purchase_details_invoice_data[] = [
            "purchase_invoice_id" => $invoice_id,
            "product_id" => $row['product_id'],
            "quantity_per_pack" => $quantity_per_pack,
            "box_quantity" => $box_quantity,
            "base_price_per_unit" => $base_price_per_unit,
            "product_wise_vat_amount" => $vat_amount,
            "product_wise_discount_amount" => $discount_amount,
            "purchase_price" => $row_total
           // "total_price" => $row_total
        ];

        // Update tax table if needed
        $tax_id = $row['tax_id'] ?? null;
        if ($tax_id) {
            $current_tax = $this->db->table('tax')
                ->select('tax_percentage')
                ->where('tax_id', $tax_id)
                ->get()->getRowArray()['tax_percentage'] ?? 0;

            if ($current_tax != $tax_percentage) {
                $this->db->table('tax')
                    ->where('tax_id', $tax_id)
                    ->update(['tax_percentage' => $tax_percentage]);
            }
        }
    }

    // Insert purchase details batch
    $this->product_purchase_details_object->insertBatch($purchase_details_invoice_data);

    // Update master table with totals
    $net_total = ($total_purchase_amount - $discount_on_total_price);
    $net_total += ($net_total * ($vat_percent_on_total / 100));

    $vat_amount_on_total_price = $total_purchase_amount * ( $vat_percent_on_total / 100);


    // Insert Master Purchase
    $purchase_data = [
        "purchase_invoice" => $invoice_id,
        "purchaser_id" => $purchaser_id,
        "payment_type" => "Cash",
        "supplier_id" => $supplier_id,
        "invoice_total" => $total_purchase_amount, // Will update later
        "discount_amount_on_invoice_total" => $discount_on_total_price,
        "vat_amount_on_invoice_total" => $vat_amount_on_total_price,
        "invoice_net_total" => $net_total, // Will update later
        "purchase_date" => date("Y-m-d H:i:s"),
    ];
    $this->product_purchase_object->insert($purchase_data);

    // $this->product_purchase_object
    //     ->where('purchase_invoice', $invoice_id)
    //     ->set(['total_price' => $total_purchase_amount, 'net_total' => $net_total])
    //     ->update();

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
