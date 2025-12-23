<?php

namespace App\Models;

use CodeIgniter\Model;

class TaxModel extends Model
{
    protected $table = 'tax';

    protected $primaryKey = 'tax_id';

    protected $allowedFields = ['tax_name', 'tax_percentage'];
}
