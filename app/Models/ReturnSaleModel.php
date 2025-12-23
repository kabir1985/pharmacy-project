<?php
namespace App\Models;

use CodeIgniter\Model;

class ReturnSaleModel extends Model
{
    protected $table = 'return_sales';
    protected $primaryKey = 'sales_id';
    protected $allowedFields = ['sales_invoice', 'customer_type', 'sales_date', 'payment_type', 'discountOnTotalPrice', 'vatOnTotalPrice','paid_amount','due_amount'];
}
