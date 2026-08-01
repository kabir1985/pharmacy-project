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

        $productName     = trim($this->request->getPost('product_name'));
        $productCategory = (int) $this->request->getPost('product_category');
        $productBrand    = (int) $this->request->getPost('product_brand');
        $productGroup    = (int) $this->request->getPost('product_group');
        $productStrength = (int) $this->request->getPost('strength');
        $productUnit     = (int) $this->request->getPost('product_unit');

        $sku             = trim($this->request->getPost('sku'));
        $barcode         = trim($this->request->getPost('barcode'));

        $alertQuantity   = (float) ($this->request->getPost('alert_quantity') ?? 0);

        // =====================================================
        // Validation
        // =====================================================

        if (
            empty($productName) ||
            empty($productCategory) ||
            empty($productBrand) ||
            empty($productGroup) ||
            empty($productStrength) ||
            empty($productUnit) ||
            empty($barcode)
        ) {

            $this->db->transRollback();

            echo "0";

            return;
        }

        // =====================================================
        // Duplicate Barcode Check
        // =====================================================

        $barcodeExists = $this->productModelObject
            ->where('barcode', $barcode)
            ->countAllResults();

        if ($barcodeExists > 0) {

            $this->db->transRollback();

            echo "2"; // Barcode already exists

            return;
        }

        // =====================================================
        // Duplicate SKU Check
        // =====================================================

        if (!empty($sku)) {

            $skuExists = $this->productModelObject
                ->where('sku', $sku)
                ->countAllResults();

            if ($skuExists > 0) {

                $this->db->transRollback();

                echo "3"; // SKU already exists

                return;
            }
        }

        // =====================================================
        // Prepare Data
        // =====================================================

        $data = [

            'product_name'     => $productName,
            'product_category' => $productCategory,
            'product_brand'    => $productBrand,
            'product_group'    => $productGroup,
            'product_strength' => $productStrength,
            'product_unit'     => $productUnit,

            'sku'              => $sku,
            'barcode'          => $barcode,

            'alert_quantity'   => $alertQuantity,

            'product_image'    => $productImage,
        ];

        // =====================================================
        // Insert Product
        // =====================================================

        $productId = $this->productModelObject->insert($data);

        if (!$productId) {
            throw new \Exception('Product insert failed.');
        }

        // =====================================================
        // Commit
        // =====================================================

        $this->db->transCommit();

        echo "1";

    } catch (\Throwable $e) {

        $this->db->transRollback();

        log_message(
            'error',
            '[ProductController::create] ' . $e->getMessage()
        );

        echo "0";
    }
}

public function update()
{
    try {

        $id = (int) $this->request->getPost('product_id');

        if ($id <= 0) {
            echo "0";
            return;
        }

        $barcode = trim($this->request->getPost('barcode'));
        $sku     = trim($this->request->getPost('sku'));

        // ===========================================
        // Duplicate Barcode Check
        // ===========================================

        $barcodeExists = $this->productModelObject
            ->where('barcode', $barcode)
            ->where('product_id !=', $id)
            ->countAllResults();

        if ($barcodeExists > 0) {
            echo "2"; // Barcode already exists
            return;
        }

        // ===========================================
        // Duplicate SKU Check
        // ===========================================

        if (!empty($sku)) {

            $skuExists = $this->productModelObject
                ->where('sku', $sku)
                ->where('product_id !=', $id)
                ->countAllResults();

            if ($skuExists > 0) {
                echo "3"; // SKU already exists
                return;
            }
        }

        // ===========================================
        // Prepare Data
        // ===========================================

        $data = [

            'product_name'     => trim($this->request->getPost('product_name')),
            'product_category' => (int) $this->request->getPost('product_category'),
            'product_brand'    => (int) $this->request->getPost('product_brand'),
            'product_group'    => (int) $this->request->getPost('product_group'),
            'product_strength' => (int) $this->request->getPost('product_strength'),
            'product_unit'     => (int) $this->request->getPost('product_unit'),

            'sku'              => $sku,
            'barcode'          => $barcode,

            'alert_quantity'   => (float) ($this->request->getPost('alert_quantity') ?? 0),

        ];

        $updated = $this->productModelObject->update($id, $data);

        echo $updated ? "1" : "0";

    } catch (\Throwable $e) {

        log_message(
            'error',
            '[ProductController::update] ' . $e->getMessage()
        );

        echo "0";
    }
}
 public function delete()
{
    try {

        $productId = (int) $this->request->getPost('delete_id');

        if ($productId <= 0) {
            session()->setFlashdata('msg', 'Invalid Product ID.');
            return redirect()->to(site_url('products'));
        }

        // Find Product
        $product = $this->productModelObject->find($productId);

        if (!$product) {
            session()->setFlashdata('msg', 'Product not found.');
            return redirect()->to(site_url('products'));
        }

        // Already Inactive
        if ($product['status'] === 'inactive') {
            session()->setFlashdata('msg', 'Product is already inactive.');
            return redirect()->to(site_url('products'));
        }

        // Soft Delete
        $updated = $this->productModelObject->update($productId, [
            'status' => 'inactive'
        ]);

        if (!$updated) {
            session()->setFlashdata('msg', 'Failed to deactivate product.');
            return redirect()->to(site_url('products'));
        }

        session()->setFlashdata('msg', 'Product deactivated successfully.');

    } catch (\Throwable $e) {

        log_message(
            'error',
            '[ProductController::delete] ' . $e->getMessage()
        );

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
