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

        $this->db->transBegin();

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

            $taxId = (int) $this->request->getPost('tax_id');
            $taxPercentage = (float) $this->request->getPost('tax_percentage');

            $basePrice = (float) $this->request->getPost('base_price');
            $purchasePrice = (float) $this->request->getPost('purchase_price');
            $sellingPrice = (float) $this->request->getPost('sales_price');
            $profitMargin = (float) $this->request->getPost('profit_margin');

            $taxType = ($this->request->getPost('tax_type') === 'with_tax')
                ? 'with_tax'
                : 'without_tax';

            // =====================================================
            // Tax Calculation
            // =====================================================

            if ($taxType === 'with_tax') {

                $taxAmount = ($basePrice * $taxPercentage) / (100 + $taxPercentage);

                $costWithoutVat = $basePrice - $taxAmount;

            } else {

                $taxAmount = ($basePrice * $taxPercentage) / 100;

                $purchasePrice = $basePrice + $taxAmount;

                $costWithoutVat = $basePrice;
            }

            $basePrice = round($basePrice, 2);
            $taxAmount = round($taxAmount, 2);
            $purchasePrice = round($purchasePrice, 2);
            $costWithoutVat = round($costWithoutVat, 2);
            $sellingPrice = round($sellingPrice, 2);

            // =====================================================
            // Prepare Insert Data
            // =====================================================

            $data = [

                'product_name' => trim($this->request->getPost('product_name')),
                'product_category' => $this->request->getPost('product_category'),
                'product_brand' => $this->request->getPost('product_brand'),
                'product_group' => $this->request->getPost('product_group'),
                'product_strength' => $this->request->getPost('strength'),
                'product_unit' => $this->request->getPost('product_unit'),

                'barcode' => trim($this->request->getPost('barcode')),

                'base_price' => $basePrice,
                'cost_without_vat' => $costWithoutVat,

                'tax_type' => $taxType,
                'tax_id' => $taxId,
                'tax_amount' => $taxAmount,

                'purchase_price' => $purchasePrice,

                'profit_margin_percent' => $profitMargin,

                'selling_price' => $sellingPrice,

                'alert_quantity' => (float) $this->request->getPost('alert_quantity'),

                'product_image' => $productImage
            ];

            // =====================================================
            // Duplicate Barcode Check
            // =====================================================

            $exists = $this->productModelObject
                ->where('barcode', $data['barcode'])
                ->countAllResults();

            if ($exists > 0) {

                $this->db->transRollback();

                echo "2"; // Barcode already exists

                return;
            }

            // =====================================================
            // Insert Product
            // =====================================================

            $productId = $this->productModelObject->insert($data);

            if (!$productId) {

                throw new \Exception('Product insert failed.');
            }

            $this->db->transCommit();

            echo "1";

        } catch (\Throwable $e) {

            $this->db->transRollback();

            log_message('error', '[ProductController::create] ' . $e->getMessage());

            echo "0";
        }
    }

    public function update()
    {
        try {

            $id = (int) $this->request->getPost('product_id');

            $data = [

                'product_name' => trim($this->request->getPost('product_name')),
                'product_category' => $this->request->getPost('product_category'),
                'product_brand' => $this->request->getPost('product_brand'),
                'product_group' => $this->request->getPost('product_group'),
                'product_strength' => $this->request->getPost('product_strength'),
                'product_unit' => $this->request->getPost('product_unit'),

                'barcode' => trim($this->request->getPost('barcode')),

                'base_price' => (float) $this->request->getPost('base_price'),
                'cost_without_vat' => (float) $this->request->getPost('cost_without_vat'),

                'tax_type' => $this->request->getPost('tax_type'),
                'tax_id' => (int) $this->request->getPost('tax_id'),
                'tax_amount' => (float) $this->request->getPost('tax_amount'),

                'purchase_price' => (float) $this->request->getPost('purchase_price'),

                'profit_margin_percent' => (float) $this->request->getPost('profit_margin'),

                'selling_price' => (float) $this->request->getPost('sales_price'),

                'alert_quantity' => (float) $this->request->getPost('alert_quantity'),

            ];

            $updated = $this->productModelObject->update($id, $data);

            echo $updated ? "1" : "0";

        } catch (\Throwable $e) {

            log_message('error', '[ProductController::update] ' . $e->getMessage());

            echo "0";
        }
    }
    public function delete()
    {
        try {

            $productId = (int) $this->request->getPost('delete_id');

            if ($productId <= 0) {
                session()->setFlashdata('msg', 'Invalid Product ID.');
                return redirect()->to(site_url('product'));
            }

            // Already inactive?
            $product = $this->productModelObject->find($productId);

            if (!$product) {
                session()->setFlashdata('msg', 'Product not found.');
                return redirect()->to(site_url('product'));
            }

            if ($product['status'] === 'inactive') {
                session()->setFlashdata('msg', 'Product is already inactive.');
                return redirect()->to(site_url('product'));
            }

            // Soft Delete (Deactivate Product)
            $this->productModelObject->update($productId, [
                'status' => 'inactive'
            ]);

            session()->setFlashdata('msg', 'Product deactivated successfully.');

        } catch (\Throwable $e) {

            log_message('error', '[ProductController::delete] ' . $e->getMessage());

            session()->setFlashdata('msg', 'Something went wrong.');
        }

        return redirect()->to(site_url('products'));
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
