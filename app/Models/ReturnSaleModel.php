<?php

namespace App\Models;

use CodeIgniter\Model;

class ReturnSaleModel extends Model
{
    protected $table = 'return_sales';

    protected $primaryKey = 'return_id';

    protected $returnType = 'array';

    protected $allowedFields = [
        'return_invoice',
        'sales_id',
        'return_date',
        'return_type',
        'total_return_amount',
        'remarks',
        'return_by',
    ];

    protected $useTimestamps = true;

    protected $createdField = 'created_at';

    protected $updatedField = 'updated_at';
}