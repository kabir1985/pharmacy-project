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
        'product_strength',
        'product_unit', 
        'codefor_barcode', 
        'productinitial_quantity', 
        'base_price',
        'cost_without_vat',  
        'tax_type',  
        'tax_id',    // for tax percentage %         
        'tax_amount', 
        'purchase_price', 
        'profit_margin_%',
        // 'sales_price_before_vat',
        // 'vat_on_sales', 
        'sales_price_for_customer', 
        'alert_quantity', 
        'product_image'
    ];

}
