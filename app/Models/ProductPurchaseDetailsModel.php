<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductPurchaseDetailsModel extends Model
{
    protected $table = 'product_purchase_details';

    protected $primaryKey = 'purchase_id';

    protected $allowedFields = ['purchase_invoice_id', 'product_id', 'unit_price', 'quantity', 'total_price'];
}
