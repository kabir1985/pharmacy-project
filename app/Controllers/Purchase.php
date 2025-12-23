<?php

namespace App\Controllers;

use App\Models\ProductPurchaseModel;
use App\Models\ProductPurchaseDetailsModel;
use App\Models\NewProductAddModel;
use App\Models\SupplierModel;

use CodeIgniter\HTTP\IncomingRequest;

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

        $sql = "SELECT piq.*, productinitial_quantity + IFNULL(ppd.new_purchased,0) AS total_stock
        FROM product_inital_stock as piq
        LEFT JOIN (SELECT product_id,SUM(quantity) as new_purchased
        FROM product_purchase_details
        GROUP BY product_id) as ppd
        ON piq.product_id = ppd.product_id";

        $data['product_show_for_sale'] = $this->db->query($sql)->getResult('array');
        
        $data['supplier_show'] = $this->supplier_object->findAll();

        return view('purchase/purchase_add', $data);
    }

    public function purchase_product()
    {
         $session = session();
        $purchaseList = $this->request->getVar("cart_data");
        $discount = $_POST['discount'];
        $others_cost = $_POST['others_cost'];
        $supplier_id = $_POST['supplier_id'];

        $purchaser_id = $session->get('user_id'); 

        ///// Auto Invoice Generate + Purchase Table entry start////////////////////////////////////////
        $day_no = date('z') + 1;
        $unique_text = substr(md5(microtime(true) . mt_Rand()), -5);

        $invoice_id = strtoupper("PUR" . date("y") .  str_pad($day_no, 3, "0", STR_PAD_LEFT) . "" .  $unique_text);

         $purchase_data = array(
             "purchase_invoice"  => $invoice_id,
             "purchaser_id"     => $purchaser_id,
             "payment_type"      => "Cash",
             "purchase_discount"  => $discount,
             "purchase_other_cost" => $others_cost,
             "supplier_id"         =>  $supplier_id,
             "purchase_date"    => date("Y-m-d H:i:s"),

         );
        ////////Auto Invoice Generate start///////////////////////////////////////////////////

        $purchase_details_invoice_data = [];

        foreach ($purchaseList as $row) {
            $item["purchase_invoice_id"] = $invoice_id;
            $item["product_id"] = $row['product_id'];
            $item["unit_price"] = $row['buying_unit_price'];
            $item["quantity"] = $row['quantity'];
            $item["total_price"] =  $item["unit_price"]*$item["quantity"];
            //$item['tax_amount'] = $row['tax_perchantage'] * $item["quantity"] * $item["unit_price"] / 100 ;

            array_push($purchase_details_invoice_data, $item);
        }

        $this->product_purchase_object->insert($purchase_data);
        $this->product_purchase_details_object->insertBatch($purchase_details_invoice_data);
    }
}
