

<?php
//namespace App\Controllers;

 use App\Models\StockAdjustmentModel;
use App\Models\StockAdjustmentDetailsModel;
// use App\Models\NewProductAddModel;
// use App\Models\ProductBrandModel;
// use App\Models\ProductCategoryModel;
// use App\Models\ProductSaleDetailsModel;
// use App\Models\ProductSaleModel;

class StockAdjustmentController extends BaseController
{

public function stockAdjustmentForm()
    {
        $db = \Config\Database::connect();

        $data['product_show_for_sale'] = $this->products(); //products function called

        $data['adjustments'] = $db->table('stock_adjustment sa')
            ->select("
     sa.adjustment_id,
     sa.adjustment_no,
     sa.adjustment_date,
     sa.adjustment_type,
     sa.reason,
     sa.adjusted_by,

     sad.current_stock,
     sad.adjustment_qty,
     sad.new_stock,

     p.product_name,
     u.user_name
 ")
            ->join('stock_adjustment_details sad', 'sad.adjustment_id = sa.adjustment_id')
            ->join('product_inital_stock p', 'p.product_id = sad.product_id')
            ->join('user u', 'u.user_id = sa.adjusted_by', 'left')
            ->orderBy('sa.adjustment_id', 'DESC')
            ->get()
            ->getResultArray();

        return view('product/StockAdjustMentView', $data);
    }

    public function createStockAdjustment()
    {
        $db = \Config\Database::connect();

        $StockAdjustmentModel = new \App\Models\StockAdjustmentModel();
        $StockAdjustmentDetailsModel = new \App\Models\StockAdjustmentDetailsModel();
        // $ProductModel = new \App\Models\ProductInitialStockModel();

        $db->transBegin();

        try {

            // Generate Adjustment No
            $last = $StockAdjustmentModel
                ->orderBy('adjustment_id', 'DESC')
                ->first();

            if ($last) {

                $number = (int) substr($last['adjustment_no'], 3);

                $adjustment_no = 'SA-' . str_pad($number + 1, 6, '0', STR_PAD_LEFT);

            } else {

                $adjustment_no = 'SA-000001';

            }

            $header = [

                'adjustment_no' => $adjustment_no,
                'adjustment_date' => $this->request->getPost('adjustment_date'),
                'adjustment_type' => $this->request->getPost('adjustment_type'),
                'reason' => $this->request->getPost('reason'),
                'reference_no' => $this->request->getPost('reference_no'),
                'remarks' => $this->request->getPost('remarks'),
                'adjusted_by' => session()->get('user_id'),

            ];

            $StockAdjustmentModel->insert($header);
            $adjustment_id = $StockAdjustmentModel->getInsertID();

            //  $product = $ProductModel
            // ->find($this->request->getPost('product_id'));

            $detail = [

                'adjustment_id' => $adjustment_id,
                'product_id' => $this->request->getPost('product_id'),
                'current_stock' => $this->request->getPost('current_stock'),
                'adjustment_qty' => $this->request->getPost('adjustment_qty'),
                'new_stock' => $this->request->getPost('new_stock'),
                //'unit_cost'=>$product['purchase_price']

            ];

            $StockAdjustmentDetailsModel->insert($detail);

            // $ProductModel->update(
            //     $this->request->getPost('product_id'),
            //     [
            //         'total_stock'=>$this->request->getPost('new_stock')
            //     ]
            // );

            $db->transCommit();

            return $this->response->setJSON([

                'status' => 'success',
                'message' => 'Stock Adjustment Saved Successfully.',

            ]);

        } catch (\Exception $e) {

            $db->transRollback();

            return $this->response->setJSON([

                'status' => 'error',
                'message' => $e->getMessage(),

            ]);

        }

    }

    public function view($id)
    {
        $StockAdjustmentModel = new \App\Models\StockAdjustmentModel();

        $data['adjustment'] = $StockAdjustmentModel
            ->where('adjustment_id', $id)
            ->first();

        if (!$data['adjustment']) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        return view('stock_adjustment/view', $data);
    }

    public function edit($id)
    {
        $StockAdjustmentModel = new \App\Models\StockAdjustmentModel();

        $data['adjustment'] = $StockAdjustmentModel
            ->where('adjustment_id', $id)
            ->first();

        if (!$data['adjustment']) {
            return redirect()->back()->with('error', 'Record not found');
        }

        return view('stock_adjustment/edit', $data);
    }

}