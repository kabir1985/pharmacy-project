<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductCategoryModel extends Model
{
    protected $table = 'product_category';

    protected $primaryKey = 'product_category_id';

    protected $allowedFields = ['category_name'];
}
