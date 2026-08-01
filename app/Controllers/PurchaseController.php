<?php
namespace App\Controllers;
use App\Models\ProductModel;
use App\Models\ProductPurchaseModel;
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
    protected SupplierModel $supplier_object;
//============For Opening Stock=========================
    protected ProductCategoryModel $productCategory_object;
    protected ProductGroupModel $productgroup_object;
    protected ProductStrengthModel $ProductStrengthModel_object;
    protected ProductUnitModel $productunit_object;
    protected TaxModel $tax_object;
    //============For Opening Stock=========================

    public function __construct()
    {
        $this->product_purchase_object = new ProductPurchaseModel();
        $this->product_add_object = new ProductModel();
        $this->supplier_object = new SupplierModel();

//============For Opening Stock=========================
        $this->productCategory_object = new ProductCategoryModel();
        $this->productgroup_object = new ProductGroupModel();
        $this->ProductStrengthModel_object = new ProductStrengthModel();
        $this->productunit_object = new ProductUnitModel();
        $this->tax_object = new TaxModel();
 //============For Opening Stock=========================
    }

    public function index()
    {
   $data = [
            'product_show_for_sale' => $this->product_add_object->getProductsWithCurrentStock(),
            'supplier_show'         => $this->supplier_object->findAll(),
//============For Opening Stock=========================
            'category_show'         => $this->productCategory_object->findAll(),
            'group_show'            => $this->productgroup_object->findAll(),
            'strength_show'         => $this->ProductStrengthModel_object->findAll(),
            'unit_show'             => $this->productunit_object->findAll(),
            'tax_show'              => $this->tax_object->findAll(),
//============For Opening Stock=========================            
        ];

        return view('purchase/purchase_add', $data);
    }




    public function purchase_product()
    {
        try {
    
            $purchaseList = json_decode($this->request->getPost('cart_data'), true);
    
            // Validate cart
            if (empty($purchaseList) || !is_array($purchaseList)) {
                return $this->response->setJSON([
                    'status'  => false,
                    'message' => 'Cart is empty or invalid.'
                ]);
            }
    
            // Validate supplier
            $supplier_id = (int) $this->request->getPost('supplier_id');
    
            if ($supplier_id <= 0) {
                return $this->response->setJSON([
                    'status'  => false,
                    'message' => 'Please select a supplier.'
                ]);
            }
    
            $data = [
                'purchaseList'            => $purchaseList,
                'supplier_id'             => $supplier_id,
                'discount_on_total_price' => (float) $this->request->getPost('discount_on_total_price'),
                'vat_amt_on_total'        => (float) $this->request->getPost('vat_amt_on_total'),
                'purchaser_id'            => session()->get('user_id'),
            ];
    
            // Save purchase
            $result = $this->product_purchase_object->createPurchase($data);
    
            // If createPurchase() already returns status/message
            if (isset($result['status'])) {
                return $this->response->setJSON($result);
            }
    
            // Fallback
            if ($result) {
                return $this->response->setJSON([
                    'status'  => true,
                    'message' => 'Purchase completed successfully.'
                ]);
            }
    
            return $this->response->setJSON([
                'status'  => false,
                'message' => 'Purchase could not be completed.'
            ]);
    
        } catch (\Throwable $e) {
    
            log_message('error', 'Purchase Error: ' . $e->getMessage());
    
            return $this->response->setJSON([
                'status'  => false,
                'message' => 'An unexpected error occurred. Please try again.'
            ]);
        }
    }

}
