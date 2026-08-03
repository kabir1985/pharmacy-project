<?php

namespace App\Models;

use CodeIgniter\Model;
//use App\Models\ProductPurchaseDetailsModel;

class ProductPurchaseModel extends Model
{
protected $table = 'product_purchase';

protected $primaryKey = 'purchase_id';

protected $allowedFields = [
    'purchase_invoice',
    'payment_type',
    'supplier_id',
    'invoice_total',
    'discount_amount_on_invoice_total',
    'vat_amount_on_invoice_total',
    'invoice_net_total',
    'paid_amount',
    'due_amount',
    'purchase_date',
    'purchase_by',
    'status'
];

protected $useTimestamps = true;
protected $createdField  = 'created_at';
protected $updatedField  = 'updated_at';




}
