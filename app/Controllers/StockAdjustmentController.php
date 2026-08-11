<?php
namespace App\Controllers;
use App\Models\StockAdjustmentModel;
use App\Models\StockAdjustmentDetailsModel;
use App\Models\ProductModel;
class StockAdjustmentController extends BaseController
{
    protected ProductModel $products_object;
    protected StockAdjustmentModel $stockAdjustmentObject;
    protected StockAdjustmentDetailsModel $stockAdjustmentDetailsObject;
    protected \CodeIgniter\Database\BaseConnection $db;

    public function __construct()
    {
        $this->products_object = new ProductModel();
        $this->stockAdjustmentObject = new StockAdjustmentModel();
        $this->stockAdjustmentDetailsObject = new StockAdjustmentDetailsModel();
        $this->db = \Config\Database::connect();
    }

    public function index()
    {
        $category = $this->request->getPost('product_category');
        $data['product_show_for_sale'] = $this->products_object->getProducts($category);
        $data['adjustments'] = $this->stockAdjustmentObject->getAdjustmentList();
        return view('stockAdjustment/StockAdjustmentView', $data);
    }

public function createStockAdjustment()
{
    $header = [
        'adjustment_date' => $this->request->getPost('adjustment_date'),
        'adjustment_type' => $this->request->getPost('adjustment_type'),
        'reason'          => $this->request->getPost('reason'),
        'reference_no'    => $this->request->getPost('reference_no'),
        'remarks'         => $this->request->getPost('remarks'),
        'adjusted_by'     => session()->get('user_id'),
    ];

    // echo "<pre>";
    // print_r($header);
    // echo "</pre>";
    // exit();

    $detail = [
        'product_id'     => $this->request->getPost('product_id'),
        //'current_stock'  => $this->request->getPost('current_stock'),
        'adjustment_qty' => $this->request->getPost('adjustment_qty'),
       // 'new_stock'      => $this->request->getPost('new_stock'),
    ];

    $result = $this->stockAdjustmentObject->createAdjustment($header, $detail);

    return $this->response->setJSON([
        'status'  => $result['status'] ? 'success' : 'error',
        'message' => $result['message']
    ]);
}

public function edit($id)
{
    $adjustment = $this->stockAdjustmentObject
        ->getAdjustmentForEdit($id);

    if (!$adjustment) {
        return redirect()
            ->to(site_url('stock-adjustment'))
            ->with('error', 'Record not found');
    }

    $data = [
        'adjustment' => $adjustment
    ];

    return view('stockAdjustment/edit', $data);
}

}