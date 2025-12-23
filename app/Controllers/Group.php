<?php

namespace App\Controllers;

use App\Models\ProductGroupModel;


use CodeIgniter\HTTP\IncomingRequest;

class Group extends BaseController
{
   private $productgroup_object;


   public function __construct()
   {
      $this->productgroup_object  = new ProductGroupModel();
   }

   public function index()
   {
      $data['group_show'] = $this->productgroup_object->findAll();

      return view('product/ProductGroupAdd', $data);
   }

   //--------------------------------------------------------------------//
   public function create()
   {
      $data = [
         'group_name'   => $this->request->getVar('product_group_name'),
      ];
      //$df = new ProductCategoryModel();
      $id = $this->productgroup_object->insert($data);
      if ($id > 0) {
         // Redirect to category list page
         return redirect()->to(site_url('/Group'));
     } else {
         // Redirect back with error message
         return redirect()->back()->with('error', 'Product Group create failed');
     }

   }

   //--------------------------------------------------------------------//
   public function update($id = 0)
   {

      $id   = $this->request->getVar('product_group_id');

      $data = [
         'group_name'   => $this->request->getVar('group_name'),
      ];
      $update_id =  $this->productgroup_object->update($id, $data);

      if ($update_id > 0) {
         // Redirect to category list page
         return redirect()->to(site_url('/Group'));
     } else {
         // Redirect back with error message
         return redirect()->back()->with('error', 'Product Group update failed');
     }

   }
   //..........................................................................//
   public function delete($id = 0)
   {

      $id = $this->request->getVar('delete_id');

      $this->productgroup_object->where('product_group_id', $id)->delete();

      //return into supplier page
      return $this->response->redirect(site_url('/Group'));
   }
}
