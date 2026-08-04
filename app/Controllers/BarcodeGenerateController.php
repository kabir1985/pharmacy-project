<?php

namespace App\Controllers;

use App\Models\ProductModel;
//use App\Models\ProductPurchaseDetailsModel;
//use App\Models\ProductPurchaseModel;
use App\Models\SupplierModel;

class BarcodeGenerateController extends BaseController
{

   // private $product_purchase_object;
   // private $product_purchase_details_object;
    private $product_add_object;
    private $supplier_object;
    private $db;

    public function __construct()
    {
       // $this->product_purchase_object = new ProductPurchaseModel();
       // $this->product_purchase_details_object = new ProductPurchaseDetailsModel();
        $this->product_add_object = new ProductModel();
        $this->supplier_object = new SupplierModel();
        $this->db = db_connect();
    }
    public function index()
    {
        $data = [
            'product_barcode' => $this->product_add_object->getProductsForBarcode(true), // true = only stock > 0
            'supplier_show'         => $this->supplier_object->findAll(),
        ];
    
        return view('barcode/barcodeAdd', $data);
    }

    // public function barcodeprint()
    // {
    //     // $productsList = $this->request->getVar("cart_data");
    //     // ✅ JSON decode
    //     $productsList = json_decode($this->request->getPost("cart_data"), true);

    //     if (!$productsList || !is_array($productsList)) {
    //         return "No data found!";
    //     }

    //     $generator = new \Picqer\Barcode\BarcodeGeneratorPNG();

    //     foreach ($productsList as $row) {

    //         $product_name = $row['product_name'] ?? '';
    //         $product_quantity = (int) $row['quantity_per_pack'] ?? '';
    //         $product_id = $row['product_id'] ?? '';

    //         for ($i = 0; $i < $product_quantity; $i++) {

    //             echo '<div class="col-sm-6">
    //             <div class="card mb-3 border-primary">
    //                 <div class="card-body">
    //                     <h5 class="card-title">' . $product_name . '</h5>
    //                     <p class="card-text">
    //                         <img src="data:image/png;base64,' . base64_encode($generator->getBarcode($product_id, $generator::TYPE_CODE_128)) . '">
    //                     </p>
    //                     <a>' . $product_id . '</a>
    //                 </div>
    //             </div>
    //         </div>';
    //         }
    //     }

    // }




    public function barcodeprint()
{
    $products = json_decode($this->request->getPost('cart_data'), true);

    if (empty($products) || !is_array($products)) {
        return redirect()->back()->with('error', 'No products selected.');
    }

    $generator = new \Picqer\Barcode\BarcodeGeneratorPNG();

    foreach ($products as &$product) {

        $barcodeValue = $product['barcode'] ?: $product['product_id'];

        $product['barcode_image'] = base64_encode(
            $generator->getBarcode(
                $barcodeValue,
                $generator::TYPE_CODE_128
            )
        );
    }

    return view('barcode/barcode_print', [
        'products' => $products
    ]);
}

}
