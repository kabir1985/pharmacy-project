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

    public function index()
    {

        $sql = "SELECT piq.*, productinitial_quantity + IFNULL(ppd.new_purchased,0) AS total_stock
        FROM product_inital_stock as piq
        LEFT JOIN (SELECT product_id,SUM(quantity) as new_purchased
        FROM product_purchase_details
        GROUP BY product_id) as ppd
        ON piq.product_id = ppd.product_id";

        //$data['product_show_for_sale'] = $this->product_id_object->findAll();
        $data['product_show_for_sale'] = $this->db->query($sql)->getResult('array');
        //$data['product_show_for_sale'] = $this->product_add_object->findAll();

        $data['supplier_show'] = $this->supplier_object->findAll();

        return view('barcode/barcodeAdd', $data);
    }

    public function barcodeprint()
    {
        // $productsList = $this->request->getVar("cart_data");
        // // echo "<pre>";
        // // print_r($productsList);
        // // echo "</pre>";
        // // exit();

        // foreach ($productsList as $row) {
        //    $product_name = $row['product_name'];

        //    $product_quantity = $row['quantity'];

        //    $generator = new \Picqer\Barcode\BarcodeGeneratorPNG();

        //    for ($i = 0; $i < $product_quantity; $i++) {
        //       echo  '<div class="col-sm-6">
        //       <div class="card mb-3 border-primary">
        //           <div class="card-body">
        //               <h5 class="card-title">' . $product_name . '</h5>';
        //       echo '<p class="card-text"><img src="data:image/png;base64,' . base64_encode($generator->getBarcode('$product_name', $generator::TYPE_CODE_128)) . '"></p>';
        //       echo  ' <a>Code</a>
        //           </div>
        //       </div>
        //   </div>';
        //    }
        // }

        $productsList = $this->request->getVar("cart_data");

        $generator = new \Picqer\Barcode\BarcodeGeneratorPNG();

        foreach ($productsList as $row) {

            $product_name = $row['product_name'];
            $product_quantity = (int) $row['quantity'];

            for ($i = 0; $i < $product_quantity; $i++) {

                echo '<div class="col-sm-6">
                <div class="card mb-3 border-primary">
                    <div class="card-body">
                        <h5 class="card-title">' . $product_name . '</h5>

                        <p class="card-text">
                            <img src="data:image/png;base64,' . base64_encode($generator->getBarcode($product_name, $generator::TYPE_CODE_128)) . '"></p>
                        <a>Code</a>
                    </div>
                </div>
            </div>';
            }
        }

    }
}
