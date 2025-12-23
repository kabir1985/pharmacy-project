<?php

namespace App\Models;

use CodeIgniter\Model;

class CustomerGroupModel extends Model
{
    protected $table = 'customer_group';

    protected $primaryKey = 'customer_group_id';

    protected $allowedFields = ['cus_group_name', 'cus_due_limit', 'discount_percent'];
}
