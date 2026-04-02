<?php

namespace App\Controllers;

use App\Models\NewProductAddModel;
use App\Models\ProductPurchaseDetailsModel;
use App\Models\ProductPurchaseModel;
use App\Models\SupplierModel;

class barcodegenerate extends BaseController
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

    // public function index()
    // {

    //     $sql = "SELECT piq.*, productinitial_quantity + IFNULL(ppd.new_purchased,0) AS total_stock
    //     FROM product_inital_stock as piq
    //     LEFT JOIN (SELECT product_id,SUM(quantity_per_pack) as new_purchased
    //     FROM product_purchase_details
    //     GROUP BY product_id) as ppd
    //     ON piq.product_id = ppd.product_id";

    //     //$data['product_show_for_sale'] = $this->product_id_object->findAll();
    //     $data['product_show_for_sale'] = $this->db->query($sql)->getResult('array');
    //     //$data['product_show_for_sale'] = $this->product_add_object->findAll();

    //     $data['supplier_show'] = $this->supplier_object->findAll();

    //     return view('barcode/barcodeAdd', $data);
    // }

    public function index()
    {
        $sql = "SELECT  piq.*,
    
            -- ✅ Correct total stock
            (
                piq.productinitial_quantity 
                + IFNULL(ppd.new_purchased,0) 
                - IFNULL(sd.total_sold,0)
            ) AS total_stock
    
        FROM product_inital_stock as piq
    
        -- ✅ Purchase যোগ
        LEFT JOIN (
            SELECT 
                product_id,
                SUM(quantity_per_pack * box_quantity) as new_purchased
            FROM product_purchase_details
            GROUP BY product_id
        ) as ppd
        ON piq.product_id = ppd.product_id
    
        -- ✅ Sale বাদ
        LEFT JOIN (
            SELECT 
                product_id,
                SUM(product_quantity_sold) as total_sold
            FROM sales_details
            GROUP BY product_id
        ) as sd
        ON piq.product_id = sd.product_id";

    
        $data['product_show_for_sale'] = $this->db->query($sql)->getResult('array');
    
        $data['supplier_show'] = $this->supplier_object->findAll();
    
        return view('barcode/barcodeAdd', $data);
    }




    public function barcodeprint()
    {
       // $productsList = $this->request->getVar("cart_data");
               // ✅ JSON decode
               $productsList = json_decode($this->request->getPost("cart_data"), true);
    
               if (!$productsList || !is_array($productsList)) {
                   return "No data found!";
               }

        $generator = new \Picqer\Barcode\BarcodeGeneratorPNG();

        foreach ($productsList as $row) {

            $product_name = $row['product_name'] ?? '';
            $product_quantity = (int) $row['quantity_per_pack'] ?? '';
            $product_id   = $row['product_id'] ?? '';

            for ($i = 0; $i < $product_quantity; $i++) {

           echo '<div class="col-sm-6">
                <div class="card mb-3 border-primary">
                    <div class="card-body">
                        <h5 class="card-title">' . $product_name . '</h5>
                        <p class="card-text">
                            <img src="data:image/png;base64,' . base64_encode($generator->getBarcode($product_id, $generator::TYPE_CODE_128)) . '">
                        </p>
                        <a>'.$product_id.'</a>
                    </div>
                </div>
            </div>';
            }
        }

    }



}