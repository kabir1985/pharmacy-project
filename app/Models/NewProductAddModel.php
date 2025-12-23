<?php

namespace App\Models;

use CodeIgniter\Model;

class NewProductAddModel extends Model
{
    protected $table = 'product_inital_stock';

    protected $primaryKey = 'product_id';

    protected $allowedFields = ['product_name', 'product_category', 'product_brand', 'product_group', 'product_unit', 'codefor_barcode', 'tax_perchantage', 'productinitial_quantity', 'buying_unit_price', 'selling_unit_price', 'alert_quantity', 'product_image'];
}
