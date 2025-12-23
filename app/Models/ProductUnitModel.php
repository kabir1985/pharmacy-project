<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductUnitModel extends Model
{
    protected $table = 'product_unit';

    protected $primaryKey = 'product_unit_id';

    protected $allowedFields = ['product_unit_name'];
}
