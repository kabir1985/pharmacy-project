<?php
namespace App\Models;
use CodeIgniter\Model;

class ExpenseAddModel extends Model
 {
    protected $table = 'expense';

    protected $primaryKey = 'expense_id';

    protected $allowedFields = ['expense_ref_no', 'expense_category', 'expense_sub_category', 'expense_what_for', 'expense_amount', 'expense_note', 'expense_date'];



    public function getExpenseList()
    {
        return $this->db->table('expense ex')
            ->select('
                ex.*,
                exc.expense_category_name,
                exsc.expense_sub_category_name
            ')
            ->join(
                'expense_category exc',
                'exc.expense_category_id = ex.expense_category',
                'left'
            )
            ->join(
                'expense_sub_category exsc',
                'exsc.expense_sub_category_id = ex.expense_sub_category',
                'left'
            )
            ->orderBy('ex.expense_id', 'DESC')
            ->get()
            ->getResultArray();
    }

}

