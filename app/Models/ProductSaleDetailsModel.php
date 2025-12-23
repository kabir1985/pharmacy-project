<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductSaleDetailsModel extends Model
{
    protected $table = 'sales_details';

    protected $primaryKey = 'sales_details_id';

    protected $allowedFields = ['sales_details_invoice', 'product_id', 'product_quantity_sold', 'unit_price', 'total_buy_price' ,'total_sale_price','productwiseVatPercnt','productwiseDiscountPercnt'];
}
