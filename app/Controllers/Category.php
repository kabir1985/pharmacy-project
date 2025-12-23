<?php

namespace App\Controllers;

use App\Models\ProductCategoryModel;


use CodeIgniter\HTTP\IncomingRequest;

class Category extends BaseController
{
   private $productCategory_object;


   public function __construct()
   {
      $this->productCategory_object = new ProductCategoryModel();
   }

   public function index()
   {
      $data['category_show'] = $this->productCategory_object->findAll();

      return view('product/ProductCategoryAdd', $data);
   }

   //--------------------------------------------------------------------//
   public function create()
   {
      $data = [
         'category_name'   => $this->request->getVar('product_category_name'),
      ];
      $id =  $this->productCategory_object->insert($data);
      if ($id > 0) {
         // Redirect to category list page
         return redirect()->to(site_url('/productcategoryView'));
     } else {
         // Redirect back with error message
         return redirect()->back()->with('error', 'Category creation failed');
     }
   }

   //--------------------------------------------------------------------//
   public function update($id = 0)
   {

      $id   = $this->request->getVar('product_category_id');

      $data = [
         'category_name'   => $this->request->getVar('category_name'),
      ];
      $update_id =  $this->productCategory_object->update($id, $data);
      if ($update_id > 0) {
           // Redirect to category list page
           return redirect()->to(site_url('/productcategoryView'));
      } else {
           // Redirect back with error message
           return redirect()->back()->with('error', 'Category update failed');
      }
   }

   public function delete($id = 0)
   {

      $id = $this->request->getVar('delete_id');

      $this->productCategory_object->where('product_category_id', $id)->delete();
      //$this->NewProductAddModel_Object->where('product_id', $id)->delete();

      //return into supplier page
      return $this->response->redirect(site_url('/productcategoryView'));
   }
}
