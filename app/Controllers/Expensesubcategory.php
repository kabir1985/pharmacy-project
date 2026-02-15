<?php

namespace App\Controllers;

use App\Models\ExpenseSubCategoryModel;
use App\Models\ExpenseCategoryModel;

use CodeIgniter\HTTP\IncomingRequest;

class Expensesubcategory extends BaseController
{
   private $expense_sub_category_model_object;
   private $expense_category_model_object;


   public function __construct()
   {
      $this->expense_sub_category_model_object = new ExpenseSubCategoryModel();
      $this->expense_category_model_object = new ExpenseCategoryModel();
   }

   public function index()
   {
      $data['expense_sub_category_show'] = $this->expense_sub_category_model_object->findAll();
      $data['expense_category_show'] = $this->expense_category_model_object->findAll();

      return view('expense/ExpenseSubCategoryAdd', $data);
   }

   //--------------------------------------------------------------------//
   public function create()
   {
      $data = [
         'expense_category_id'   => $this->request->getVar('expense_category_name'),
         'expense_sub_category_name'   => $this->request->getVar('expense_sub_category_name')
      ];
      //$df = new ProductCategoryModel();
      $id =  $this->expense_sub_category_model_object->insert($data);
      if ($id > 0) {
         echo "1";
      } else {
         echo "0";
      }
   }

   //--------------------------------------------------------------------//
   public function update($id = 0)
   {

      $id   = $this->request->getVar('expense_sub_category_id');

      $data = [
         'expense_sub_category_name'   => $this->request->getVar('expense_sub_category_name_update'),
      ];
      $this->expense_sub_category_model_object->update($id, $data);
   }

   public function delete($id = 0)
   {

      $id = $this->request->getVar('delete_id');

      $this->expense_sub_category_model_object->where('expense_sub_category_id', $id)->delete();
      //$this->NewProductAddModel_Object->where('product_id', $id)->delete();

      //return into supplier page
      return $this->response->redirect(site_url('/Expensesubcategory'));
   }
}
