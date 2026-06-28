<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductPurchaseDetailsModel extends Model
{
    protected $table = 'product_purchase_details';

    protected $primaryKey = 'purchase_id';

    protected $allowedFields = [
                                'purchase_invoice_id',
                                'product_id',
                                'quantity_per_pack',
                                'box_quantity',
                                'base_price_per_unit',
                                'free_qty',
                                'product_wise_vat_amount',
                                'product_wise_discount_amount',
                                'purchase_price'
                                ];
}
