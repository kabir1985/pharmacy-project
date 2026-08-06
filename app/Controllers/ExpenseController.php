<?php

namespace App\Controllers;

use App\Models\ExpenseAddModel;
use App\Models\ExpenseCategoryModel;
use App\Models\ExpenseSubCategoryModel;

class ExpenseController extends BaseController
{

    private ExpenseAddModel $expenseaddobject;
    private ExpenseSubCategoryModel $expense_sub_category_model_object;
    private ExpenseCategoryModel $expense_category_model_object;

    public function __construct()
    {
        $this->expenseaddobject = new ExpenseAddModel();
        $this->expense_sub_category_model_object = new ExpenseSubCategoryModel();
        $this->expense_category_model_object = new ExpenseCategoryModel();
    }

    public function index()
    {
        $data = [
            'expense_category_show' => $this->expense_category_model_object->findAll(),
            'expense_sub_category_show' => $this->expense_sub_category_model_object->findAll(),
            'expense_category_sub_category_show' => $this->expenseaddobject->getExpenseList(),
        ];

        return view('expense/expense_add', $data);
    }

    public function create()
    {
        $rules = [
            'expense_ref_no' => 'required|max_length[50]',
            'expense_category' => 'required|integer',
            'expense_sub_category_add' => 'required|integer',
            'expense_amount' => 'required|decimal',
            'expense_date' => 'required',
        ];

        if (!$this->validate($rules)) {

            return $this->response->setJSON([
                'status' => false,
                'message' => 'Validation failed.',
                'errors' => $this->validator->getErrors(),
            ]);
        }

        $data = [
            'expense_ref_no' => $this->request->getPost('expense_ref_no'),
            'expense_category' => $this->request->getPost('expense_category'),
            'expense_sub_category' => $this->request->getPost('expense_sub_category_add'),
            'expense_what_for' => $this->request->getPost('expense_what_for'),
            'expense_amount' => $this->request->getPost('expense_amount'),
            'expense_note' => $this->request->getPost('expense_note'),
            'expense_date' => $this->request->getPost('expense_date'),
        ];

        if ($this->expenseaddobject->insert($data)) {

            return $this->response->setJSON([
                'status' => true,
                'message' => 'Expense added successfully.',
            ]);
        }

        return $this->response->setJSON([
            'status' => false,
            'message' => 'Failed to save expense.',
        ]);
    }

    public function update()
    {
        $id = (int) $this->request->getPost('expense_id');

        $rules = [
            'expense_ref_no' => 'required|max_length[50]',
            'expense_category' => 'required|integer',
            'expense_sub_category_edit' => 'required|integer',
            'expense_amount' => 'required|decimal',
            'expense_date' => 'required',
        ];

        if (!$this->validate($rules)) {

            return $this->response->setJSON([
                'status' => false,
                'message' => 'Validation failed.',
                'errors' => $this->validator->getErrors(),
            ]);
        }

        $data = [
            'expense_ref_no' => $this->request->getPost('expense_ref_no'),
            'expense_category' => $this->request->getPost('expense_category'),
            'expense_sub_category' => $this->request->getPost('expense_sub_category_edit'),
            'expense_what_for' => $this->request->getPost('expense_what_for'),
            'expense_amount' => $this->request->getPost('expense_amount'),
            'expense_note' => $this->request->getPost('expense_note'),
            'expense_date' => $this->request->getPost('expense_date'),
        ];

        if ($this->expenseaddobject->update($id, $data)) {

            return $this->response->redirect(site_url('expense'));
        }
    }

    public function delete($id = 0)
    {

        $id = $this->request->getPost('delete_id');

        $this->expenseaddobject->where('expense_id', $id)->delete();

        //return into supplier page
        return $this->response->redirect(site_url('expense'));
    }

// public function getSubCategory()
// {
//     $category_id = $this->request->getPost('expense_category_id');

//     $result = $this->expense_sub_category_model_object
//                     ->where('expense_category_id', $category_id)
//                     ->findAll();

//     return $this->response->setJSON($result);
// }

    public function getExpenseSubCategory()
    {
        $category_id = $this->request->getPost('expense_category_id');

        $data = $this->expense_sub_category_model_object
            ->where('expense_category_id', $category_id)
            ->findAll();

        return $this->response->setJSON($data);
    }

}
