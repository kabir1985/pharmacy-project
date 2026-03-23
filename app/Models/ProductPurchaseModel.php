<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductPurchaseModel extends Model
{
    protected $table = 'product_purchase';

    protected $primaryKey = 'product_purchase_id';

    protected $allowedFields = [
                               'purchase_invoice',
                               'purchaser_id', 
                               'payment_type', 
                               'supplier_id', 
                               'total_price', 
                               'discount_on_total_price',
                               'vat_on_total',
                               'net_total',
                               'purchase_date'
                               ];
}
