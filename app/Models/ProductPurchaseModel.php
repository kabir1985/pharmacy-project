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
                               'invoice_total', 
                               'discount_amount_on_invoice_total',
                               'vat_amount_on_invoice_total',
                               'invoice_net_total',
                               'purchase_date'
                               ];
}
