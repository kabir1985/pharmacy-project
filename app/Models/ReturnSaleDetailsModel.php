<?php
namespace App\Models;

use CodeIgniter\Model;

class ReturnSaleDetailsModel extends Model
{
    protected $table = 'return_sales_details';
    protected $primaryKey = 'return_detail_id';
    protected $allowedFields = [
                                'sales_details_invoice', 
                                'product_id', 
                                'return_qty', 
                                'unit_price', 
                                'total_buy_price', 
                                'total_sale_price'
                               ];
}
