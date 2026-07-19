<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Models\StockAdjustmentDetailsModel;

class StockAdjustmentModel extends Model
{
    protected $table            = 'stock_adjustment';
    protected $primaryKey       = 'adjustment_id';

    protected $useAutoIncrement = true;
    protected $returnType       = 'array';

    protected $protectFields    = true;

    protected $allowedFields = [
        'adjustment_no',
        'adjustment_date',
        'adjustment_type',
        'reason',
        'reference_no',
        'remarks',
        'adjusted_by'
    ];


public function getAdjustmentList()
    {
        return $this->db->table('stock_adjustment sa')
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
    }



    public function createAdjustment(array $header, array $detail)
{
    $db = \Config\Database::connect();

    $db->transBegin();

    try {

        // Generate Adjustment No
        $last = $this->orderBy('adjustment_id', 'DESC')->first();

        if ($last) {
            $number = (int) str_replace('SA-', '', $last['adjustment_no']);
            $header['adjustment_no'] = 'SA-' . str_pad($number + 1, 6, '0', STR_PAD_LEFT);
        } else {
            $header['adjustment_no'] = 'SA-000001';
        }

        $this->insert($header);

        $adjustment_id = $this->getInsertID();

        $detail['adjustment_id'] = $adjustment_id;

        $detailModel = new StockAdjustmentDetailsModel();
        $detailModel->insert($detail);

        $db->transCommit();

        return [
            'status' => true,
            'message' => 'Stock Adjustment Saved Successfully.'
        ];

    } catch (\Throwable $e) {

        $db->transRollback();

        return [
            'status' => false,
            'message' => $e->getMessage()
        ];
    }
}


}