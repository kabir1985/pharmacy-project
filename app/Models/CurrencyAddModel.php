<?php

namespace App\Models;

use CodeIgniter\Model;

class CurrencyAddModel extends Model
{
    protected $table = 'currency';

    protected $primaryKey = 'id';

    protected $allowedFields = ['currency_code','currency_name','currency_symbol'];
}
