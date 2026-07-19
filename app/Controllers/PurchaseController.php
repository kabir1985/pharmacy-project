<?php
namespace App\Controllers;
use App\Models\NewProductAddModel;
use App\Models\ProductPurchaseModel;
use App\Models\SupplierModel;

class PurchaseController extends BaseController
{
    private $product_purchase_object;
    private $product_add_object;
    private $supplier_object;

    public function __construct()
    {
        $this->product_purchase_object = new ProductPurchaseModel();
        $this->product_add_object = new NewProductAddModel();
        $this->supplier_object = new SupplierModel();
    }
 
   public function index()
{
    $data['product_show_for_sale'] = $this->product_add_object->getProductsWithCurrentStock();
    $data['supplier_show'] = $this->supplier_object->findAll();

    return view('purchase/purchase_add', $data);
} 

    public function purchase_product()
{
    $purchaseList = json_decode($this->request->getPost('cart_data'), true);

    if (!$purchaseList || !is_array($purchaseList)) {
        return $this->response->setJSON([
            'status'  => 'error',
            'message' => 'Cart is empty or invalid!'
        ]);
    }

    $data = [
        'purchaseList'            => $purchaseList,
        'supplier_id'             => $this->request->getPost('supplier_id'),
        'discount_on_total_price' => (float)$this->request->getPost('discount_on_total_price'),
        'vat_amt_on_total'        => (float)$this->request->getPost('vat_amt_on_total'),
        'purchaser_id'            => session()->get('user_id')
    ];

    $result = $this->product_purchase_object->createPurchase($data);

    return $this->response->setJSON($result);
}
}
