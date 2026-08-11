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
    
                sad.adjustment_qty,
    
                sl.balance_qty AS current_stock,
    
                CASE
                    WHEN sa.adjustment_type = 'STOCK_IN'
                        THEN sl.balance_qty - sad.adjustment_qty
                    ELSE
                        sl.balance_qty + sad.adjustment_qty
                END AS previous_stock,
    
                p.product_name,
                u.user_name
            ")
            ->join(
                'stock_adjustment_details sad',
                'sad.adjustment_id = sa.adjustment_id'
            )
            ->join(
                'products p',
                'p.product_id = sad.product_id'
            )
            ->join(
                'stock_ledger sl',
                "sl.reference_id = sa.adjustment_id
                 AND sl.transaction_type = sa.adjustment_type
                 AND sl.product_id = sad.product_id"
            )
            ->join(
                'user u',
                'u.user_id = sa.adjusted_by',
                'left'
            )
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
    
            // Save Header
            $this->insert($header);
    
            $adjustment_id = $this->getInsertID();
    
            // Save Detail
            $detail['adjustment_id'] = $adjustment_id;
    
            $detailModel = new StockAdjustmentDetailsModel();
            $detailModel->insert($detail);
    
            // Save Stock Ledger
            $qtyIn  = 0;
            $qtyOut = 0;
            
            // if ($header['adjustment_type'] == 'STOCK_IN') {
            //     $qtyIn = $detail['adjustment_qty'];
            // } else {
            //     $qtyOut = $detail['adjustment_qty'];
            // }

            $productId = $detail['product_id'];

            // Get current stock from ledger
            $currentStock = $db->table('stock_ledger')
                ->select('COALESCE(SUM(qty_in - qty_out),0) AS stock', false)
                ->where('product_id', $productId)
                ->get()
                ->getRow()
                ->stock;
            
            if ($header['adjustment_type'] == 'stock_in') {
                $newStock = $currentStock + $detail['adjustment_qty'];
                $qtyIn = $detail['adjustment_qty'];
                $qtyOut = 0;
            } else {
                $newStock = $currentStock - $detail['adjustment_qty'];
                $qtyIn = 0;
                $qtyOut = $detail['adjustment_qty'];
            }

            
            $ledger = [
                'product_id'       => $detail['product_id'],
                'transaction_type' => $header['adjustment_type'], // STOCK_IN / STOCK_OUT
                'reference_id'     => $adjustment_id,
                'qty_in'           => $qtyIn,
                'qty_out'          => $qtyOut,
                'balance_qty'      => $newStock,
                'unit_cost'        => 0, // or purchase price
                'transaction_date' => $header['adjustment_date'],
                'remarks'          => $header['reason'],
                'created_by'       => $header['adjusted_by']
            ];
            
            $db->table('stock_ledger')->insert($ledger);
    
            $db->transCommit();
    
            return [
                'status'  => true,
                'message' => 'Stock Adjustment Saved Successfully.'
            ];
    
        } catch (\Throwable $e) {
    
            $db->transRollback();
    
            return [
                'status'  => false,
                'message' => $e->getMessage()
            ];
        }
    }



    public function getAdjustmentForEdit($adjustmentId)
{
    return $this->db->table('stock_adjustment sa')
        ->select("
            sa.adjustment_id,
            sa.adjustment_no,
            sa.adjustment_date,
            sa.adjustment_type,
            sa.reason,
            sa.reference_no,
            sa.remarks,
            sa.adjusted_by,

            sad.id AS detail_id,
            sad.product_id,
            sad.adjustment_qty,
            sad.unit_cost,

            p.product_name
        ")
        ->join(
            'stock_adjustment_details sad',
            'sad.adjustment_id = sa.adjustment_id'
        )
        ->join(
            'products p',
            'p.product_id = sad.product_id'
        )
        ->where('sa.adjustment_id', $adjustmentId)
        ->get()
        ->getRowArray();
}


}