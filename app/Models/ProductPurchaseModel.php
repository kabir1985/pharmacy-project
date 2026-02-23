<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductPurchaseModel extends Model
{
    protected $table = 'product_purchase';

    protected $primaryKey = 'product_purchase_id';

    protected $allowedFields = ['purchase_invoice', 'purchaser_id', 'payment_type', 'discount_on_total_price', 'supplier_id', 'purchase_date'];
}
