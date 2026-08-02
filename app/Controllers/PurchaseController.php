<?php
namespace App\Controllers;
use App\Models\ProductModel;
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
    
            $purchaseList = json_decode($this->request->getPost('cart_data'), true);
    
            if (empty($purchaseList) || !is_array($purchaseList)) {
                return $this->response->setJSON([
                    'status' => false,
                    'message' => 'Cart is empty.'
                ]);
            }
    
            $supplier_id = (int)$this->request->getPost('supplier_id');
    
            if ($supplier_id <= 0) {
                return $this->response->setJSON([
                    'status' => false,
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
    
                $qty = ((float)$item['quantity_per_pack']) * ((float)$item['box_quantity']);
    
                $purchaseTotal = $qty * (float)$item['purchase_price_without_vat'];
    
                $discount = 0;
    
                if (
                    isset($item['discount_type']) &&
                    $item['discount_type'] == 'fixed'
                ) {
                    $discount = (float)($item['discount_fixed'] ?? 0);
                } else {
                    $discount = $purchaseTotal *
                        ((float)($item['discount_percent'] ?? 0) / 100);
                }
    
                $taxable = $purchaseTotal - $discount;
    
                $vat = $taxable *
                    ((float)$item['tax_percentage'] / 100);
    
                $lineTotal = $taxable + $vat;
    
                $invoiceTotal += $purchaseTotal;
                $discountTotal += $discount;
                $vatTotal += $vat;
                $netTotal += $lineTotal;
            }
    
            //--------------------------------------------------
            // Invoice Number
            //--------------------------------------------------
    
            $invoiceNo = 'PUR-' . date('YmdHis');
    
            //--------------------------------------------------
            // Purchase Master
            //--------------------------------------------------
    
            $purchaseData = [
    
                'purchase_invoice'                 => $invoiceNo,
                'payment_type'                     => 'Due',
                'supplier_id'                      => $supplier_id,
    
                'invoice_total'                    => $invoiceTotal,
                'discount_amount_on_invoice_total' => $discountTotal,
                'vat_amount_on_invoice_total'      => $vatTotal,
                'invoice_net_total'                => $netTotal,
    
                'paid_amount'                      => 0,
                'due_amount'                       => $netTotal,
    
                'purchase_date'                    => date('Y-m-d H:i:s'),
                'purchase_by'                      => session('user_id'),
                'status'                           => 'active'
            ];
    
            $this->product_purchase_object->insert($purchaseData);
    
            $purchase_id = $this->product_purchase_object->getInsertID();
    
            //--------------------------------------------------
            // Purchase Details
            //--------------------------------------------------
    
            foreach ($purchaseList as $item) {
    
                $qty = ((float)$item['quantity_per_pack']) * ((float)$item['box_quantity']);
    
                $purchaseTotal = $qty * (float)$item['purchase_price_without_vat'];
    
                $discount = 0;
    
                if (
                    isset($item['discount_type']) &&
                    $item['discount_type'] == 'fixed'
                ) {
                    $discount = (float)($item['discount_fixed'] ?? 0);
                } else {
                    $discount = $purchaseTotal *
                        ((float)($item['discount_percent'] ?? 0) / 100);
                }
    
                $taxable = $purchaseTotal - $discount;
    
                $vat = $taxable *
                    ((float)$item['tax_percentage'] / 100);
    
                $lineTotal = $taxable + $vat;
    
                $details = [
    
                    'purchase_id'                 => $purchase_id,
    
                    'product_id'                  => $item['product_id'],
    
                    'expiry_date'                 => $item['expiry_date'] ?? null,
    
                    'quantity_per_pack'           => $item['quantity_per_pack'],
    
                    'box_quantity'                => $item['box_quantity'],
    
                    'free_qty'                    => $item['free_qty'] ?? 0,
    
                    'base_price_per_unit'         => $item['purchase_price_without_vat'],
    
                    'tax_id'                      => $item['tax_id'],
    
                    'tax_percentage'              => $item['tax_percentage'],
    
                    'product_wise_vat_amount'     => $vat,
    
                    'product_wise_discount_amount'=> $discount,
    
                    'selling_price'               => $item['selling_price'],
    
                    'purchase_price'              => $item['purchase_price_with_vat'],
    
                    'line_total'                  => $lineTotal
                ];
    
                $this->product_purchase_details_object->insert($details);




                $qtyIn = (
                    ((float)$item['quantity_per_pack'] * (float)$item['box_quantity'])
                    + (float)($item['free_qty'] ?? 0)
                );
            
                $currentStock = $this->db->table('stock_ledger')
                    ->selectSum('qty_in')
                    ->selectSum('qty_out')
                    ->where('product_id', $item['product_id'])
                    ->get()
                    ->getRow();
            
                $previousBalance =
                    ((float)$currentStock->qty_in) -
                    ((float)$currentStock->qty_out);
            
                $newBalance = $previousBalance + $qtyIn;
            
                $ledgerData = [
            
                    'product_id'       => $item['product_id'],
                    'transaction_type' => 'PURCHASE',
                    'reference_id'     => $purchase_id,
            
                    'qty_in'           => $qtyIn,
                    'qty_out'          => 0,
            
                    'balance_qty'      => $newBalance,
            
                    'unit_cost'        => $item['purchase_price_with_vat'],
            
                    'transaction_date' => date('Y-m-d H:i:s'),
            
                    'remarks'          => 'Purchase Invoice : ' . $invoiceNo,
            
                    'created_by'       => session('user_id')
                ];
            
                $this->db->table('stock_ledger')->insert($ledgerData);


            }
    
            //--------------------------------------------------
            // Commit
            //--------------------------------------------------
    
            if ($this->db->transStatus() === false) {
    
                $this->db->transRollback();
    
                return $this->response->setJSON([
                    'status' => false,
                    'message' => 'Purchase failed.'
                ]);
            }
    
            $this->db->transCommit();
    
            return $this->response->setJSON([
                'status' => true,
                'message' => 'Purchase completed successfully.',
                'purchase_id' => $purchase_id
            ]);
    
        } catch (\Throwable $e) {
    
            $this->db->transRollback();
    
            log_message('error', $e->getMessage());
    
            return $this->response->setJSON([
                'status' => false,
                'message' => $e->getMessage()
            ]);
        }
    }






}
