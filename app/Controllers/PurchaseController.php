<?php
namespace App\Controllers;
use App\Models\ProductModel;
use App\Models\ProductBrandModel;
use App\Models\ProductPurchaseModel;
use App\Models\ProductPurchaseDetailsModel;
use App\Models\SupplierModel;

//============For Opening Stock=========================
use App\Models\ProductCategoryModel;
use App\Models\ProductGroupModel;
use App\Models\ProductStrengthModel;
use App\Models\ProductUnitModel;
use App\Models\TaxModel;
//============For Opening Stock=========================

class PurchaseController extends BaseController
{
    protected ProductPurchaseModel $product_purchase_object;
    protected ProductBrandModel $ProductBrandModel;
    protected ProductModel $product_add_object;
    protected ProductPurchaseDetailsModel $product_purchase_details_object;
    protected SupplierModel $supplier_object;
//============For Opening Stock=========================
    protected ProductCategoryModel $productCategory_object;
    protected ProductGroupModel $productgroup_object;
    protected ProductStrengthModel $ProductStrengthModel_object;
    protected ProductUnitModel $productunit_object;
    protected TaxModel $tax_object;
    protected \CodeIgniter\Database\BaseConnection $db;
    //============For Opening Stock=========================

    public function __construct()
    {
        $this->product_purchase_object = new ProductPurchaseModel();
         $this->ProductBrandModel = new ProductBrandModel();
        $this->product_purchase_details_object = new ProductPurchaseDetailsModel();
        $this->product_add_object = new ProductModel();
        $this->supplier_object = new SupplierModel();

//============For Opening Stock=========================
        $this->productCategory_object = new ProductCategoryModel();
        $this->productgroup_object = new ProductGroupModel();
        $this->ProductStrengthModel_object = new ProductStrengthModel();
        $this->productunit_object = new ProductUnitModel();
        $this->tax_object = new TaxModel();
        $this->db = \Config\Database::connect();
 //============For Opening Stock=========================
    }

    public function index()
    {
   $data = [
            'getDefaultOpeningStock' => $this->product_add_object->getProductsWithCurrentStock(),

            'supplier_show'         => $this->supplier_object->findAll(),
              'brand_show' => $this->ProductBrandModel->findAll(),
//============For Opening Stock=========================
            'category_show'         => $this->productCategory_object->findAll(),
            'group_show'            => $this->productgroup_object->findAll(),
            'strength_show'         => $this->ProductStrengthModel_object->findAll(),
            'unit_show'             => $this->productunit_object->findAll(),
            'tax_show'              => $this->tax_object->findAll(),
//============For Opening Stock=========================            
        ];


//         echo '<pre>';
// print_r($data['product_show_for_sale']);
// exit;

return view('purchase/purchase_add', $data);
    }




public function store()
{
    $this->db->transBegin();

    try {

        //==================================================
        // Cart
        //==================================================

        $purchaseList = json_decode(
            $this->request->getPost('cart_data'),
            true
        );


        // echo "<pre>";
        // print_r($purchaseList);
        // echo "</pre>";

        // exit();

        if (empty($purchaseList) || !is_array($purchaseList)) {

            $this->db->transRollback();

            return $this->response->setJSON([
                'status'  => false,
                'message' => 'Cart is empty.'
            ]);
        }

        //==================================================
        // Supplier
        //==================================================

        $supplier_id = (int)$this->request->getPost('supplier_id');
        $purchase_date = $this->request->getPost('purchase_date');

        if ($supplier_id <= 0) {

            $this->db->transRollback();

            return $this->response->setJSON([
                'status'  => false,
                'message' => 'Please select supplier.'
            ]);
        }

//==================================================
// Invoice Totals
//==================================================

$invoiceTotal  = 0;
$discountTotal = 0;
$vatTotal      = 0;
$netTotal      = 0;

foreach ($purchaseList as $item) {

    //==================================================
    // Basic Product Validation
    //==================================================

    $productId = (int)($item['product_id'] ?? 0);

    $productName = trim(
        $item['product_name'] ?? 'Unknown Product'
    );

    $qtyPerPack = (float)(
        $item['quantity_per_pack'] ?? 0
    );

    $boxQty = (float)(
        $item['box_quantity'] ?? 0
    );

    $basePrice = (float)(
        $item['purchase_price_without_vat'] ?? 0
    );

    //==================================================
    // Validate Product
    //==================================================

    if ($productId <= 0) {

        $this->db->transRollback();

        return $this->response->setJSON([
            'status'  => false,
            'step'    => 'validation',
            'message' => 'Invalid product found in cart.'
        ]);
    }

    if ($qtyPerPack <= 0) {

        $this->db->transRollback();

        return $this->response->setJSON([
            'status'  => false,
            'step'    => 'validation',
            'message' => 'Quantity per pack must be greater than 0 for "' .
                         $productName . '".'
        ]);
    }

    if ($boxQty <= 0) {

        $this->db->transRollback();

        return $this->response->setJSON([
            'status'  => false,
            'step'    => 'validation',
            'message' => 'Box quantity must be greater than 0 for "' .
                         $productName . '".'
        ]);
    }

    if ($basePrice <= 0) {

        $this->db->transRollback();

        return $this->response->setJSON([
            'status'  => false,
            'step'    => 'validation',
            'message' => 'Purchase price must be greater than 0 for "' .
                         $productName . '".'
        ]);
    }

    //==================================================
    // Tax
    //==================================================

    $taxPercentage = (float)(
        $item['tax_percentage'] ?? 0
    );

    //==================================================
    // Quantity
    //==================================================

    $qty = $qtyPerPack * $boxQty;

    //==================================================
    // Purchase Total
    //==================================================

    $purchaseTotal = $qty * $basePrice;

    if ($purchaseTotal <= 0) {

        $this->db->transRollback();

        return $this->response->setJSON([
            'status'  => false,
            'step'    => 'validation',
            'message' => 'Purchase amount must be greater than 0 for "' .
                         $productName . '".'
        ]);
    }

    //==================================================
    // Discount
    //==================================================

    if (($item['discount_type'] ?? '') === 'fixed') {

        $discount = (float)(
            $item['discount_fixed'] ?? 0
        );

    } else {

        $discountPercent = (float)(
            $item['discount_percent'] ?? 0
        );

        $discount =
            $purchaseTotal *
            ($discountPercent / 100);
    }

    $discount = min(
        max(0, $discount),
        $purchaseTotal
    );

    //==================================================
    // Taxable
    //==================================================

    $taxable = max(
        0,
        $purchaseTotal - $discount
    );

    //==================================================
    // VAT
    //==================================================

    $vat =
        $taxable *
        ($taxPercentage / 100);

    //==================================================
    // Line Total
    //==================================================

    $lineTotal =
        $taxable + $vat;

    //==================================================
    // Validate Line Total
    //==================================================

    if ($lineTotal <= 0) {

        $this->db->transRollback();

        return $this->response->setJSON([
            'status'  => false,
            'step'    => 'validation',
            'message' => 'Product "' . $productName .
                         '" has a zero purchase value.'
        ]);
    }

    //==================================================
    // Invoice Totals
    //==================================================

    $invoiceTotal  += $purchaseTotal;
    $discountTotal += $discount;
    $vatTotal      += $vat;
    $netTotal      += $lineTotal;
}


//==================================================
// Validate Net Total
//==================================================

if ($netTotal <= 0) {

    $this->db->transRollback();

    return $this->response->setJSON([
        'status'  => false,
        'step'    => 'validation',
        'message' => 'Purchase amount must be greater than 0.'
    ]);
}


        //==================================================
        // Invoice Number
        //==================================================

        $invoiceNo = 'PUR-' . date('YmdHis');

        //==================================================
        // Purchase Master
        //==================================================

        $purchaseData = [

            'purchase_invoice' =>
                $invoiceNo,

            'payment_type' =>
                'Due',

            'supplier_id' =>
                $supplier_id,

            'invoice_total' =>
                $invoiceTotal,

            'discount_amount_on_invoice_total' =>
                $discountTotal,

            'vat_amount_on_invoice_total' =>
                $vatTotal,

            'invoice_net_total' =>
                $netTotal,

            'paid_amount' =>
                0,

            'due_amount' =>
                $netTotal,

           'purchase_date' => date('Y-m-d H:i:s', strtotime($purchase_date) ),

            'purchase_by' =>
                session('user_id'),

            'status' =>
                'active'
        ];

        //==================================================
        // Insert Purchase Master
        //==================================================

        if (!$this->product_purchase_object->insert($purchaseData)) {

            $this->db->transRollback();

            return $this->response->setJSON([
                'status'       => false,
                'step'         => 'product_purchase',
                'message'      => 'Failed to save purchase.',
                'model_errors' => $this->product_purchase_object->errors(),
                'db_error'     => $this->db->error()
            ]);
        }

        $purchase_id =
            $this->product_purchase_object->getInsertID();

        if (!$purchase_id) {

            $this->db->transRollback();

            return $this->response->setJSON([
                'status'  => false,
                'step'    => 'product_purchase',
                'message' => 'Purchase ID was not generated.'
            ]);
        }

        //==================================================
        // Purchase Details
        //==================================================

        foreach ($purchaseList as $item) {

            //==================================================
            // Basic Values
            //==================================================

            $productId = (int)$item['product_id'];

            $qtyPerPack =
                (float)($item['quantity_per_pack'] ?? 0);

            $boxQty =
                (float)($item['box_quantity'] ?? 1);

            $freeQty =
                (float)($item['free_qty'] ?? 0);

            $basePrice =
                (float)($item['purchase_price_without_vat'] ?? 0);

            $taxPercentage =
                (float)($item['tax_percentage'] ?? 0);

            //==================================================
            // Quantity
            //==================================================

            $qty =
                $qtyPerPack * $boxQty;

            //==================================================
            // Purchase Total
            //==================================================

            $purchaseTotal =
                $qty * $basePrice;

            //==================================================
            // Discount
            //==================================================

            if (($item['discount_type'] ?? '') === 'fixed') {

                $discount =
                    (float)($item['discount_fixed'] ?? 0);

            } else {

                $discountPercent =
                    (float)($item['discount_percent'] ?? 0);

                $discount =
                    $purchaseTotal *
                    ($discountPercent / 100);
            }

            $discount =
                min($discount, $purchaseTotal);

            //==================================================
            // Taxable
            //==================================================

            $taxable =
                max(
                    0,
                    $purchaseTotal - $discount
                );

            //==================================================
            // VAT
            //==================================================

            $vat =
                $taxable *
                ($taxPercentage / 100);

            //==================================================
            // Line Total
            //==================================================

            $lineTotal =
                $taxable + $vat;

            //==================================================
            // Purchase Price With VAT
            //==================================================

            $purchasePriceWithVat =
                $basePrice +
                ($basePrice * $taxPercentage / 100);

            //==================================================
            // Tax ID
            //==================================================

            $taxId = !empty($item['tax_id'])
                ? (int)$item['tax_id']
                : null;

            
            
            
            
            //==================================================
// Selling Price
//==================================================

$sellingUnitPrice = (float)($item['selling_unit_price'] ?? 0);

$sellingPrice =
    $sellingUnitPrice *
    $qtyPerPack *
    $boxQty;

            //==================================================
            // Purchase Details
            //==================================================

            $details = [

                'purchase_id' => $purchase_id,

                'product_id' => $productId,

                'expiry_date' => $item['expiry_date'] ?? null,

                'quantity_per_pack' => $qtyPerPack,

                'box_quantity' => $boxQty,

                'free_qty' => $freeQty,

                'base_price_per_unit' => $basePrice,

                'tax_id' => $taxId,

                'tax_percentage' => $taxPercentage,

                'product_wise_vat_amount' =>$vat,

                'product_wise_discount_amount' => $discount,

                'selling_price' => $sellingPrice,
                'selling_unit_price' => $sellingUnitPrice,

                'purchase_price' => $purchasePriceWithVat,

                'line_total' => $lineTotal
            ];

            //==================================================
            // Insert Purchase Details
            //==================================================

            if (!$this->product_purchase_details_object->insert($details)) {

                $this->db->transRollback();

                return $this->response->setJSON([
                    'status'       => false,
                    'step'         => 'product_purchase_details',
                    'message'      => 'Failed to save purchase details.',
                    'model_errors' =>
                        $this->product_purchase_details_object->errors(),
                    'db_error'     =>
                        $this->db->error(),
                    'details'      =>
                        $details
                ]);
            }

            //==================================================
            // Stock Quantity
            //==================================================

            $qtyIn =
                ($qtyPerPack * $boxQty)
                + $freeQty;

            //==================================================
            // Current Stock
            //==================================================

            $currentStock =
                $this->db
                    ->table('stock_ledger')
                    ->selectSum('qty_in')
                    ->selectSum('qty_out')
                    ->where('product_id', $productId)
                    ->get()
                    ->getRow();

            $previousBalance =
                (float)($currentStock->qty_in ?? 0)
                -
                (float)($currentStock->qty_out ?? 0);

            $newBalance =
                $previousBalance + $qtyIn;

            //==================================================
            // Stock Ledger
            //==================================================

            $ledgerData = [

                'product_id' =>
                    $productId,

                'transaction_type' =>
                    'PURCHASE',

                'reference_id' =>
                    $purchase_id,

                'qty_in' =>
                    $qtyIn,

                'qty_out' =>
                    0,

                'balance_qty' =>
                    $newBalance,

                'unit_cost' =>
                    $purchasePriceWithVat,

                'transaction_date' =>
                    date('Y-m-d H:i:s'),

                'remarks' =>
                    'Purchase Invoice : ' . $invoiceNo,

                'created_by' =>
                    session('user_id')
            ];

            //==================================================
            // Insert Stock Ledger
            //==================================================

            if (!$this->db->table('stock_ledger')->insert($ledgerData)) {

                $dbError = $this->db->error();

                $this->db->transRollback();

                return $this->response->setJSON([
                    'status'  => false,
                    'step'    => 'stock_ledger',
                    'message' => 'Failed to save stock ledger.',
                    'db_error' => $dbError,
                    'ledger_data' => $ledgerData
                ]);
            }
        }

        //==================================================
        // Transaction Status
        //==================================================

        if ($this->db->transStatus() === false) {

            $dbError = $this->db->error();

            $this->db->transRollback();

            return $this->response->setJSON([
                'status'  => false,
                'step'    => 'transaction',
                'message' => 'Purchase failed.',
                'db_error' => $dbError
            ]);
        }

        //==================================================
        // Commit
        //==================================================

        $this->db->transCommit();

        return $this->response->setJSON([
            'status'      => true,
            'message'     => 'Purchase completed successfully.',
            'purchase_id' => $purchase_id
        ]);

    } catch (\Throwable $e) {

        $this->db->transRollback();

        log_message(
            'error',
            'Purchase Store Error: ' . $e->getMessage()
        );

        return $this->response->setJSON([
            'status'  => false,
            'step'    => 'exception',
            'message' => $e->getMessage()
        ]);
    }
}




}