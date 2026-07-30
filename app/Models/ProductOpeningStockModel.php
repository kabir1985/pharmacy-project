<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductOpeningStockModel extends Model
{
    protected $table = 'product_opening_stock';

    protected $primaryKey = 'opening_stock_id';

    protected $useAutoIncrement = true;

    protected $returnType = 'array';

    protected $useTimestamps = true;

    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    protected $allowedFields = [
        'product_id',
        'batch_no',
        'manufacturing_date',
        'expiry_date',
        'quantity',
        'unit_cost',
        'total_cost',
        'stock_date',
        'created_by'
    ];


    /**
     * Get opening stock with product information
     */
    public function getOpeningStockList()
    {
        return $this->select('
                product_opening_stock.*,
                products.product_name,
                products.barcode
            ')
            ->join(
                'products',
                'products.product_id = product_opening_stock.product_id'
            )
            ->orderBy('opening_stock_id', 'DESC')
            ->findAll();
    }


    /**
     * Get single opening stock
     */
    public function getOpeningStock($id)
    {
        return $this->select('
                product_opening_stock.*,
                products.product_name,
                products.barcode
            ')
            ->join(
                'products',
                'products.product_id = product_opening_stock.product_id'
            )
            ->where('opening_stock_id', $id)
            ->first();
    }


    /**
     * Check duplicate product batch
     */
    public function checkProductBatch($productId, $batchNo)
    {
        return $this->where([
                'product_id' => $productId,
                'batch_no'   => $batchNo
            ])
            ->first();
    }
}