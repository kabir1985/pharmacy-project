<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductStrengthModel extends Model
{
    protected $table = ' product_strength';

    protected $primaryKey = 'strength_id';

    protected $allowedFields = ['strength_name'];
}
