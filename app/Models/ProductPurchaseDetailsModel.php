<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductPurchaseDetailsModel extends Model
{
protected $table = 'product_purchase_details';

protected $primaryKey = 'purchase_details_id';

protected $allowedFields = [
                            'purchase_id',
                            'product_id',
                            'expiry_date',
                            'quantity_per_pack',
                            'box_quantity',
                            'free_qty',
                            'base_price_per_unit',
                            'tax_id',
                            'tax_percentage',
                            'product_wise_vat_amount',
                            'product_wise_discount_amount',
                            'selling_price',
                            'purchase_price',
                            'line_total'
                        ];


}
