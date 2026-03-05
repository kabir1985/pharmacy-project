<?php

namespace App\Models;

use CodeIgniter\Model;

class NewProductAddModel extends Model
{
    protected $table = 'product_inital_stock';

    protected $primaryKey = 'product_id';

    //protected $allowedFields = ['product_name', 'product_category', 'product_brand', 'product_group', 'product_unit', 'codefor_barcode', 'tax_id', 'productinitial_quantity', 'buying_unit_price', 'selling_unit_price', 'alert_quantity', 'product_image'];

    protected $allowedFields = [
        'product_name', 
        'product_category', 
        'product_brand', 
        'product_group', 
        'product_unit', 
        'codefor_barcode', 
        'tax_id', 
        'productinitial_quantity', 
        'base_price',            // selling unit price before tax
        'tax_amount', 
        'purchase_price', 
        'tax_type', 
        'profit_margin', 
        'sales_price', 
        'final_price', 
        'selling_unit_price', 
        'alert_quantity', 
        'product_image'
    ];

}
