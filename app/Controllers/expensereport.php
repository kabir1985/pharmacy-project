<?php
namespace App\Controllers;

use CodeIgniter\HTTP\IncomingRequest;
//return view('report/viewExpenseReport');

class expensereport extends BaseController
{   private $db;
   public function __construct()
   {
      //$this->product_initial_stock_object = new NewProductAddModel();
      $this->db = db_connect();
   }
    public function index()
    {
        $db = \Config\Database::connect();

        $start_date_input = $this->request->getVar('start_date');
        $end_date_input = $this->request->getVar('end_date');

        $start_date = '';
        $end_date = '';
        $expenses = [];

        if ($start_date_input && $end_date_input) {
            $start_date = date('Y-m-d', strtotime($start_date_input));
            $end_date = date('Y-m-d', strtotime($end_date_input));

            $sql = "SELECT 
                        e.expense_id,
                        e.expense_ref_no,
                        ec.expense_category_name,
                        esc.expense_sub_category_name,
                        e.expense_what_for,
                        e.expense_amount,
                        e.expense_note,
                        e.expense_date
                    FROM 
                        expense e
                    LEFT JOIN 
                        expense_category ec ON e.expense_category = ec.expense_category_id
                    LEFT JOIN 
                        expense_sub_category esc ON e.expense_sub_category = esc.expense_sub_category_id
                    WHERE 
                        STR_TO_DATE(e.expense_date, '%d-%m-%Y') BETWEEN ? AND ?
                    ORDER BY 
                        STR_TO_DATE(e.expense_date, '%d-%m-%Y') ASC";

            $query = $db->query($sql, [$start_date, $end_date]);
            $expenses = $query->getResult();
        }

        return view('report/viewExpenseReport', [
            'expenses' => $expenses,
            'start_date' => $start_date_input,
            'end_date' => $end_date_input
        ]);
    }



}
