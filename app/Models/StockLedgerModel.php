<?php

namespace App\Models;

use CodeIgniter\Model;

class StockLedgerModel extends Model
{
    protected $table      = 'stock_ledger';
    protected $primaryKey = 'stock_ledger_id';

    protected $allowedFields = [
        'product_id',
        'transaction_type',
        'reference_id',
        'qty_in',
        'qty_out',
        'balance_qty',
        'unit_cost',
        'transaction_date',
        'remarks',
        'created_by'
    ];

    /**
     * Get Current Stock
     */
    public function getCurrentStock($productId)
    {
        $row = $this->db->table($this->table)
            ->select('COALESCE(SUM(qty_in - qty_out),0) AS stock', false)
            ->where('product_id', $productId)
            ->get()
            ->getRow();

        return $row ? (float)$row->stock : 0;
    }

    /**
     * Get Average Purchase Price
     */
    public function getAveragePurchasePrice($productId)
    {
        $row = $this->db->table($this->table)
            ->select('
                COALESCE(
                    SUM(qty_in * unit_cost) /
                    NULLIF(SUM(qty_in),0),
                0) AS avg_price
            ', false)
            ->where('product_id', $productId)
            ->where('qty_in >', 0)
            ->get()
            ->getRow();

        return $row ? (float)$row->avg_price : 0;
    }
}