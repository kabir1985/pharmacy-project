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
            session()->setFlashdata('msg', 'Invalid product.');
            return redirect()->to(site_url('products'));
        }

        $updated = $this->productModelObject->update($productId, [
            'status' => 'inactive'
        ]);

        if ($updated) {
            session()->setFlashdata(
                'msg',
                'Product deactivated successfully.'
            );
        } else {
            session()->setFlashdata(
                'msg',
                'Failed to deactivate product.'
            );
        }

    } catch (\Throwable $e) {

        log_message(
            'error',
            '[ProductController::delete] ' . $e->getMessage()
        );

        session()->setFlashdata(
            'msg',
            'Something went wrong.'
        );
    }

    return redirect()->to(site_url('products'));
}


public function importCsv()
{
    $db = \Config\Database::connect();

    // ==================================================
    // 1. Get uploaded CSV
    // ==================================================
    $file = $this->request->getFile('csv_file');

    if (!$file || !$file->isValid()) {
        return redirect()->back()
            ->with('error', 'Please select a valid CSV file.');
    }

    // ==================================================
    // 2. Validate extension
    // ==================================================
    if (strtolower($file->getClientExtension()) !== 'csv') {
        return redirect()->back()
            ->with('error', 'Only CSV files are allowed.');
    }

    // ==================================================
    // 3. Open CSV
    // ==================================================
    $handle = fopen($file->getTempName(), 'r');

    if ($handle === false) {
        return redirect()->back()
            ->with('error', 'Unable to read CSV file.');
    }

    // ==================================================
    // 4. Read CSV header
    // ==================================================
    $header = fgetcsv($handle);

    if (!$header) {
        fclose($handle);

        return redirect()->back()
            ->with('error', 'CSV file is empty.');
    }

    // Remove UTF-8 BOM
    $header[0] = preg_replace('/^\xEF\xBB\xBF/', '', $header[0]);

    // Normalize header
    $header = array_map(function ($value) {
        return strtolower(trim($value));
    }, $header);

    // ==================================================
    // 5. Required CSV columns
    // ==================================================
    $requiredColumns = [
        'product_name',
        'category',
        'brand',
        'generic_name',
        'strength',
        'product_unit',
        'sku',
        'barcode',
        'alert_quantity'
    ];

    foreach ($requiredColumns as $column) {

        if (!in_array($column, $header, true)) {

            fclose($handle);

            return redirect()->back()
                ->with(
                    'error',
                    'Missing required column: ' . $column
                );
        }
    }

    // ==================================================
    // 6. Column indexes
    // ==================================================
    $columns = array_flip($header);

    // ==================================================
    // 7. Product model
    // ==================================================
    $productModel = new \App\Models\ProductModel();

    // ==================================================
    // 8. Counters
    // ==================================================
    $imported = 0;
    $skipped  = 0;
    $errors   = [];

    $rowNumber = 1;

    // ==================================================
    // 9. Start transaction
    // ==================================================
    $db->transBegin();

    try {

        while (($row = fgetcsv($handle)) !== false) {

            $rowNumber++;

            // Ignore completely empty rows
            if (
                count(array_filter($row, function ($value) {
                    return trim($value) !== '';
                })) === 0
            ) {
                continue;
            }

            // ==================================================
            // 10. Validate column count
            // ==================================================
            if (count($row) < count($header)) {

                $errors[] =
                    "Row {$rowNumber}: Invalid number of columns.";

                $skipped++;

                continue;
            }

            // ==================================================
            // 11. Read CSV values
            // ==================================================

            $productName = trim(
                $row[$columns['product_name']]
            );

            $categoryName = trim(
                $row[$columns['category']]
            );

            $brandName = trim(
                $row[$columns['brand']]
            );

            $genericName = trim(
                $row[$columns['generic_name']]
            );

            $strengthName = trim(
                $row[$columns['strength']]
            );

            $unitName = trim(
                $row[$columns['product_unit']]
            );

            $sku = trim(
                $row[$columns['sku']]
            );

            $barcode = trim(
                $row[$columns['barcode']]
            );

            $alertQuantity = trim(
                $row[$columns['alert_quantity']]
            );

            // ==================================================
            // 12. Required field validation
            // ==================================================

            if ($productName === '') {
                $errors[] =
                    "Row {$rowNumber}: Product name is required.";

                $skipped++;
                continue;
            }

            if ($categoryName === '') {
                $errors[] =
                    "Row {$rowNumber}: Category is required.";

                $skipped++;
                continue;
            }

            if ($brandName === '') {
                $errors[] =
                    "Row {$rowNumber}: Brand is required.";

                $skipped++;
                continue;
            }

            if ($genericName === '') {
                $errors[] =
                    "Row {$rowNumber}: Generic name is required.";

                $skipped++;
                continue;
            }

            if ($strengthName === '') {
                $errors[] =
                    "Row {$rowNumber}: Strength is required.";

                $skipped++;
                continue;
            }

            if ($unitName === '') {
                $errors[] =
                    "Row {$rowNumber}: Product unit is required.";

                $skipped++;
                continue;
            }

            // ==================================================
            // 13. Alert quantity validation
            // ==================================================

            if (
                $alertQuantity === '' ||
                !is_numeric($alertQuantity) ||
                (float) $alertQuantity < 0
            ) {

                $errors[] =
                    "Row {$rowNumber}: Invalid alert quantity.";

                $skipped++;
                continue;
            }

            // ==================================================
            // 14. SKU duplicate check
            // ==================================================

            if ($sku !== '') {

                $existingSku = $productModel
                    ->where('sku', $sku)
                    ->first();

                if ($existingSku) {

                    $errors[] =
                        "Row {$rowNumber}: SKU already exists - {$sku}.";

                    $skipped++;
                    continue;
                }
            }

            // ==================================================
            // 15. Barcode validation
            // ==================================================

            if ($barcode === '') {

                $errors[] =
                    "Row {$rowNumber}: Barcode is required.";

                $skipped++;
                continue;
            }

            // Barcode is UNIQUE in products table
            $existingBarcode = $productModel
                ->where('barcode', $barcode)
                ->first();

            if ($existingBarcode) {

                $errors[] =
                    "Row {$rowNumber}: Barcode already exists - {$barcode}.";

                $skipped++;
                continue;
            }

            // ==================================================
            // 16. Category lookup
            // ==================================================

            $category = $db->table('product_category')
                ->where('category_name', $categoryName)
                ->get()
                ->getRow();

            if (!$category) {

                $errors[] =
                    "Row {$rowNumber}: Category '{$categoryName}' not found.";

                $skipped++;
                continue;
            }

            // ==================================================
            // 17. Brand lookup
            // ==================================================

            $brand = $db->table('product_brand')
                ->where('brand_name', $brandName)
                ->get()
                ->getRow();

            if (!$brand) {

                $errors[] =
                    "Row {$rowNumber}: Brand '{$brandName}' not found.";

                $skipped++;
                continue;
            }

            // ==================================================
            // 18. Generic / Group lookup
            // ==================================================

            $group = $db->table('product_group')
                ->where('group_name', $genericName)
                ->get()
                ->getRow();

            if (!$group) {

                $errors[] =
                    "Row {$rowNumber}: Generic name '{$genericName}' not found.";

                $skipped++;
                continue;
            }

            // ==================================================
            // 19. Strength lookup
            // ==================================================

            $strength = $db->table('product_strength')
                ->where('strength_name', $strengthName)
                ->get()
                ->getRow();

            if (!$strength) {

                $errors[] =
                    "Row {$rowNumber}: Strength '{$strengthName}' not found.";

                $skipped++;
                continue;
            }

            // ==================================================
            // 20. Unit lookup
            // ==================================================

            $unit = $db->table('product_unit')
                ->where('product_unit_name', $unitName)
                ->get()
                ->getRow();

            if (!$unit) {

                $errors[] =
                    "Row {$rowNumber}: Unit '{$unitName}' not found.";

                $skipped++;
                continue;
            }

            // ==================================================
            // 21. Prepare product data
            // ==================================================

            $productData = [
                'product_name'     => $productName,
                'product_category' => $category->product_category_id,
                'product_brand'    => $brand->brand_id,
                'product_group'    => $group->product_group_id,
                'product_strength' => $strength->strength_id,
                'product_unit'     => $unit->product_unit_id,
                'sku'              => $sku !== '' ? $sku : null,
                'barcode'          => $barcode,
                'alert_quantity'   => $alertQuantity,
                'product_image'    => 'default-medicine.png',
                'status'           => 'active'
            ];

            // ==================================================
            // 22. Insert product
            // ==================================================

            if (!$productModel->insert($productData)) {

                $modelErrors = $productModel->errors();

                $errorMessage = !empty($modelErrors)
                    ? implode(', ', $modelErrors)
                    : 'Unable to insert product.';

                $errors[] =
                    "Row {$rowNumber}: {$errorMessage}";

                $skipped++;
                continue;
            }

            $imported++;
        }

        fclose($handle);

        // ==================================================
        // 23. Check transaction
        // ==================================================

        if ($db->transStatus() === false) {

            $db->transRollback();

            return redirect()->back()
                ->with(
                    'error',
                    'Product import failed. Database transaction was rolled back.'
                );
        }

        // ==================================================
        // 24. Commit
        // ==================================================

        $db->transCommit();

    } catch (\Throwable $e) {

        if (is_resource($handle)) {
            fclose($handle);
        }

        $db->transRollback();

        log_message(
            'error',
            'Product CSV Import Error: ' . $e->getMessage()
        );

        return redirect()->back()
            ->with(
                'error',
                'Product import failed: ' . $e->getMessage()
            );
    }

    // ==================================================
    // 25. Store row errors
    // ==================================================

    if (!empty($errors)) {

        session()->setFlashdata(
            'import_errors',
            $errors
        );
    }

    // ==================================================
    // 26. Final result
    // ==================================================

    $message =
        "CSV import completed. " .
        "Imported: {$imported}, " .
        "Skipped: {$skipped}.";

    return redirect()->back()
        ->with('success', $message);
}




public function downloadTemplate()
{
    $filename = 'product_import_template.csv';

    $headers = [
        'product_name',
        'category',
        'brand',
        'generic_name',
        'strength',
        'product_unit',
        'sku',
        'barcode',
        'alert_quantity'
    ];

    $output = fopen('php://memory', 'w');

    fputcsv($output, $headers);

    fputcsv($output, [
        'Napa',
        'Tablet',
        'Beximco',
        'Paracetamol',
        '500mg',
        'Piece',
        'NAPA-500',
        '1234567890123',
        '10'
    ]);

    rewind($output);

    $csvContent = stream_get_contents($output);

    fclose($output);

    return $this->response
        ->setHeader('Content-Type', 'text/csv; charset=UTF-8')
        ->setHeader(
            'Content-Disposition',
            'attachment; filename="' . $filename . '"'
        )
        ->setBody($csvContent);
}

}
