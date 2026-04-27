<?php
namespace App\Models;

use CodeIgniter\Model;

class ReturnSaleModel extends Model
{
    protected $table = 'return_sales';
    protected $primaryKey = 'return_id';
    protected $allowedFields = [ 
                                 'sales_invoice',
                                 'customer_type',
                                 'return_date',
                                 'payment_type',
                                 'discountOnTotalPrice',
                                 'vatOnTotalPrice',
                                 'paid_amount',
                                 'due_amount',
                                 'return_by',
                                 'return_type',
                                 'return_reason'
                                ];
}
