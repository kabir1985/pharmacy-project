<?php

namespace App\Models;

use CodeIgniter\Model;

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
}