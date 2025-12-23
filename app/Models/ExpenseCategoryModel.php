<?php

namespace App\Models;

use CodeIgniter\Model;

class ExpenseCategoryModel extends Model
{
    protected $table = 'expense_category';

    protected $primaryKey = 'expense_category_id';

    protected $allowedFields = ['expense_category_name'];
}
