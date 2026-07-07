<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductSaleModel extends Model
{
    protected $table = 'sales';

    protected $primaryKey = 'sales_id';

    protected $allowedFields = [
                                'sales_invoice',
                                'customer_type',
                                'sales_date',
                                'payment_type',
                                'total_amount', 
                                'product_discount',
                                'product_vat',
                                'discount_on_all',
                                'other_charge_on_all',
                                'paid_amount',
                                'due_amount',
                                'seller_id',
                                'return_status'
                            ];
}
