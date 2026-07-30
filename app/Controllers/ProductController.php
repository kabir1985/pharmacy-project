<?php

namespace App\Controllers;

use App\Models\ProductModel;
use App\Models\ProductBrandModel;
use App\Models\ProductCategoryModel;
use App\Models\ProductGroupModel;
use App\Models\ProductStrengthModel;
use App\Models\ProductUnitModel;
use App\Models\TaxModel;

class ProductController extends BaseController
{
    protected ProductModel $productModelObject;
    protected ProductCategoryModel $productCategory_object;
    protected ProductBrandModel $ProductBrandModel;
    protected ProductGroupModel $productgroup_object;
    protected ProductUnitModel $productunit_object;
    protected ProductStrengthModel $ProductStrengthModel_object;
    protected TaxModel $tax_object;
    protected \CodeIgniter\Database\BaseConnection $db;

    public function __construct()
    {
        $this->productModelObject = new ProductModel();
        $this->productCategory_object = new ProductCategoryModel();
        $this->ProductBrandModel = new ProductBrandModel();
        $this->productgroup_object = new ProductGroupModel();
        $this->productunit_object = new ProductUnitModel();
        $this->ProductStrengthModel_object = new ProductStrengthModel();
        $this->tax_object = new TaxModel();

        $this->db = db_connect();
    }

    public function index()
    {
        $data = [
            'category_show' => $this->productCategory_object->findAll(),
            'brand_show' => $this->ProductBrandModel->findAll(),
            'group_show' => $this->productgroup_object->findAll(),
            'unit_show' => $this->productunit_object->findAll(),
            'strength_show' => $this->ProductStrengthModel_object->findAll(),
            'tax_show' => $this->tax_object->findAll(),
            'product_show' => $this->productModelObject->getProductList(),
        ];

        return view('product/productAdd', $data);
    }

    //--------------------------------------------------------------------

    public function create()
    {
        helper(['form', 'url']);

        try {

            // =====================================================
            // Product Image Upload
            // =====================================================

            $productImage = 'default-medicine.png';

            $file = $this->request->getFile('file');

            if ($file && $file->isValid() && !$file->hasMoved()) {

                $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

                if (in_array(strtolower($file->getExtension()), $allowedExtensions)) {

                    $productImage = $file->getRandomName();

                    $file->move(ROOTPATH . 'public/uploads/', $productImage);

                }
            }

            // =====================================================
            // Get Form Data
            // =====================================================

            $tax_id = (int) $this->request->getPost('tax_id');
            $tax_percentage = (float) $this->request->getPost('tax_percentage');

            $base_price = (float) $this->request->getPost('base_price');
            $purchase_price = (float) $this->request->getPost('purchase_price');

            $tax_type_db = $this->request->getPost('tax_type') === 'with_tax'
            ? 'with_tax'
            : 'without_tax';

            $profit_margin = (int) $this->request->getPost('profit_margin');
            $sales_price = (float) $this->request->getPost('sales_price');

            // =====================================================
            // Tax Calculation
            // =====================================================

            if ($tax_type_db === 'with_tax') {

                $tax_amount = $base_price * $tax_percentage / (100 + $tax_percentage);

                $cost_without_vat = $base_price - $tax_amount;

            } else {

                $tax_amount = ($base_price * $tax_percentage) / 100;

                $purchase_price = $base_price + $tax_amount;

                $cost_without_vat = $base_price;
            }

            $base_price = round($base_price, 2);
            $tax_amount = round($tax_amount, 2);
            $purchase_price = round($purchase_price, 2);
            $cost_without_vat = round($cost_without_vat, 2);

            // =====================================================
            // Prepare Insert Data
            // =====================================================

            $data = [

                'product_name' => trim($this->request->getPost('product_name')),
                'product_category' => $this->request->getPost('product_category'),
                'product_brand' => $this->request->getPost('product_brand'),
                'product_group' => (int) $this->request->getPost('product_group'),
                'product_strength' => (int) $this->request->getPost('strength'),
                'product_unit' => $this->request->getPost('product_unit'),
                'codefor_barcode' => trim($this->request->getPost('codefor_barcode')),
                'productinitial_quantity' => (int) $this->request->getPost('productinitial_quantity'),
                'base_price' => $base_price,
                'cost_without_vat' => $cost_without_vat,
                'tax_type' => $tax_type_db,
                'tax_id' => $tax_id,
                'tax_amount' => $tax_amount,
                'purchase_price' => $purchase_price,
                'profit_margin_%' => $profit_margin,
                'sales_price_for_customer' => $sales_price,
                'alert_quantity' => (int) $this->request->getPost('alert_quantity'),
                'product_image' => $productImage,

            ];

            // =====================================================
            // Insert Product
            // =====================================================

            $id = $this->productModelObject->insert($data);

            echo($id > 0) ? "1" : "0";

        } catch (\Throwable $e) {

            log_message('error', '[ProductController::create] ' . $e->getMessage());

            echo "0";
        }
    }

    public function update($id = 0)
    {
        try {

            $id = (int) $this->request->getPost('product_id');

            $data = [

                'product_name' => trim($this->request->getPost('product_name')),
                'product_category' => $this->request->getPost('product_category12'),
                'product_brand' => $this->request->getPost('product_brand12'),
                'product_group' => $this->request->getPost('product_group12'),
                'product_unit' => $this->request->getPost('product_unit12'),
                'codefor_barcode' => trim($this->request->getPost('codefor_barcode')),
                'tax_perchantage' => $this->request->getPost('tax_perchantage12'),
                'productinitial_quantity' => (int) $this->request->getPost('productinitial_quantity'),
                'buying_unit_price' => (float) $this->request->getPost('buying_unit_price'),
                'selling_unit_price' => (float) $this->request->getPost('selling_unit_price'),
                'alert_quantity' => (int) $this->request->getPost('alert_quantity'),

                // 'product_image' => $this->request->getPost('product_image'),

            ];

            $updated = $this->productModelObject->update($id, $data);

            echo($updated) ? "1" : "0";

        } catch (\Throwable $e) {

            log_message('error', '[ProductController::update] ' . $e->getMessage());

            echo "0";
        }
    }

    public function delete($id = 0)
    {
        // Get delete_id from POST request
        $id = $this->request->getPost('delete_id'); // safer than getVar() for POST form

        if ($id) {
            // Delete product from database
            $this->productModelObject->where('product_id', $id)->delete();

            // Optional: set a flash message
            session()->setFlashdata('msg', 'Product deleted successfully.');
        } else {
            session()->setFlashdata('msg', 'Invalid product ID.');
        }

        // Redirect back to product list page
        return redirect()->to(site_url('/product'));
    }

    // public function barcodegenerate()
    // {

    //     //$generator = new Picqer\Barcode\BarcodeGeneratorHTML();
    //     $generator = new \Picqer\Barcode\BarcodeGeneratorPNG();

    //     //echo $generator->getBarcode('rasel', $generator::TYPE_CODE_128);

    //     // $generator = new Picqer\Barcode\BarcodeGeneratorPNG();
    //     echo '<img src="data:image/png;base64,' . base64_encode($generator->getBarcode('081231723897', $generator::TYPE_CODE_128)) . '">';
    // }

}
