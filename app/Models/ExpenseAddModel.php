<?php
namespace App\Models;
use CodeIgniter\Model;

class ExpenseAddModel extends Model
 {
    protected $table = 'expense';

    protected $primaryKey = 'expense_id';

    protected $allowedFields = ['expense_ref_no', 'expense_category', 'expense_sub_category', 'expense_what_for', 'expense_amount', 'expense_note', 'expense_date'];

}

