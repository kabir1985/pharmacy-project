<?php

namespace App\Models;

use CodeIgniter\Model;

class StockAdjustmentDetailsModel extends Model
{
    protected $table            = 'stock_adjustment_details';
    protected $primaryKey       = 'id';

    protected $useAutoIncrement = true;

    protected $returnType       = 'array';

    protected $allowedFields = [

        'adjustment_no',
        'product_id',
        'current_stock',
        'adjustment_qty',
        'new_stock'
        //'unit_cost'

    ];

    protected $useTimestamps = false;

}