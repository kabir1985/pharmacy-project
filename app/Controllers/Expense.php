<?php

namespace App\Controllers;

use App\Models\ExpenseAddModel;
use App\Models\ExpenseCategoryModel;
use App\Models\ExpenseSubCategoryModel;

use CodeIgniter\HTTP\IncomingRequest;

class Expense extends BaseController
{

     private $expenseaddobject;
     private $expense_sub_category_model_object;
     private $expense_category_model_object;

    public function __construct()
    {
        $this->expenseaddobject = new ExpenseAddModel();
        $this->expense_sub_category_model_object = new ExpenseSubCategoryModel();
        $this->expense_category_model_object = new ExpenseCategoryModel();
        $this->db = db_connect();
    } 

    public function index()
    {
        ## Fetch all records from database
       $data['expense_show'] = $this->expenseaddobject->findAll();
       $data['expense_sub_category_show'] = $this->expense_sub_category_model_object->findAll();
       $data['expense_category_show'] = $this->expense_category_model_object->findAll();


       $sql = "SELECT * FROM expense AS ex
       JOIN expense_category AS exc ON ex.expense_category=exc.expense_category_id
       JOIN expense_sub_category as exsc ON ex.expense_sub_category =  exsc.expense_sub_category_id";
 
       $data['expense_category_sub_category_show'] = $this->db->query($sql)->getResult('array');

	  return view('expense/expense_add', $data);
    }

    public function create()
    {
		//print_r($_POST); 

        $data = [
            'expense_ref_no'       => $this->request->getVar('expense_ref_no'),
            'expense_category'     => $this->request->getVar('expense_category'),
            'expense_sub_category' => $this->request->getVar('expense_sub_category'),
            'expense_what_for'     => $this->request->getVar('expense_what_for'),
            'expense_amount'       => $this->request->getVar('expense_amount'),
			'expense_note'         => $this->request->getVar('expense_note'),
			'expense_date'         => $this->request->getVar('expense_date')
        ];
		//print_r($data);

       $d = $this->expenseaddobject->insert($data);
       if($d>0)
       {
        echo "1";
       }
       else
       {
        echo "0";
       }
    }


    public function update($id = 0)
    {
        $id = $this->request->getVar('expense_id');
        //echo $id;
        $data = [
            'expense_ref_no'       => $this->request->getVar('expense_ref_no'),
            'expense_category'     => $this->request->getVar('expense_category_name'),
            'expense_sub_category' => $this->request->getVar('expense_sub_category_name'),
            'expense_what_for'     => $this->request->getVar('expense_what_for'),
            'expense_amount'       => $this->request->getVar('expense_amount'),
            'expense_note'         => $this->request->getVar('expense_note'),
            'expense_date'         => $this->request->getVar('expense_date')
        ];

        $this->expenseaddobject->update($id, $data);

    }


    public function delete($id = 0)
    {

        $id = $this->request->getVar('delete_id');

        $this->expenseaddobject->where('expense_id', $id)->delete();

        //return into supplier page
        return $this->response->redirect(site_url('/Expense'));
    } 
}
