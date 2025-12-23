<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductGroupModel extends Model
{
    protected $table = 'product_group';

    protected $primaryKey = 'product_group_id';

    protected $allowedFields = ['group_name'];
}
