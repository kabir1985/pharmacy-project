<?php

namespace App\Models;

use CodeIgniter\Model;

class ExpenseSubCategoryModel extends Model
{
    protected $table = 'expense_sub_category';

    protected $primaryKey = 'expense_sub_category_id';

    protected $allowedFields = ['expense_category_id', 'expense_sub_category_name'];
}
