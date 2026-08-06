<?php
namespace App\Controllers;

use CodeIgniter\HTTP\IncomingRequest;

class ExpenseReportController extends BaseController
{   private $db;
   public function __construct()
   {
      $this->db = db_connect();
   }
   public function index()
   {
       $start_date_input = $this->request->getVar('start_date');
       $end_date_input   = $this->request->getVar('end_date');
   
       $expenses = [];
   
       if (!empty($start_date_input) && !empty($end_date_input)) {
   
           $start_date = date('Y-m-d', strtotime($start_date_input));
           $end_date   = date('Y-m-d', strtotime($end_date_input));
   
           $sql = "
               SELECT
                   e.expense_id,
                   e.expense_ref_no,
                   ec.expense_category_name,
                   esc.expense_sub_category_name,
                   e.expense_what_for,
                   e.expense_amount,
                   e.expense_note,
                   e.expense_date
               FROM expense e
   
               LEFT JOIN expense_category ec
                   ON ec.expense_category_id = e.expense_category
   
               LEFT JOIN expense_sub_category esc
                   ON esc.expense_sub_category_id = e.expense_sub_category
   
               WHERE e.expense_date BETWEEN ? AND ?
   
               ORDER BY e.expense_date ASC
           ";
   
           $expenses = $this->db
               ->query($sql, [$start_date, $end_date])
               ->getResult();
       }
   
       return view('report/viewExpenseReport', [
           'expenses'   => $expenses,
           'start_date' => $start_date_input,
           'end_date'   => $end_date_input
       ]);
   }



}
