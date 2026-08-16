<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductOpeningStockModel extends Model
{
  protected $table            = 'product_opening_stock';
    protected $primaryKey       = 'opening_stock_id';
    protected $useAutoIncrement = true;

    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;

    protected $protectFields    = true;

    protected $allowedFields = [
        'product_id',
        'supplier_id',    
        'quantity',
        'bonus_quantity',
    
        'tax_type',
        'tax_id',
        'tax_percentage',
        'tax_amount',
    
        'purchase_price_without_vat',
        'purchase_price_with_vat',
    
        'profit_margin_percent',
        'selling_unit_price',
    
        'stock_date',
        'remarks',
    
        'created_by',
        'status',
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
                'product_id' => $productId
                  ])
            ->first();
    }
}