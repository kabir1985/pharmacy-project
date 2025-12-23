<?php

namespace App\Controllers;

use App\Models\ProductUnitModel;


use CodeIgniter\HTTP\IncomingRequest;

class Unit extends BaseController
{
   private $productunit_object;


   public function __construct()
   {
      $this->productunit_object   = new ProductUnitModel();
   }

   public function index()
   {
      $data['unit_show'] = $this->productunit_object->findAll();

      return view('product/ProductUnitAdd', $data);
   }
   //--------------------------------------------------------------------//
   public function create()
   {
      $data = [
         'product_unit_name'   => $this->request->getVar('product_unit'),
      ];
      $id = $this->productunit_object->insert($data);
      if ($id > 0) {
         // Redirect to category list page
         return redirect()->to(site_url('/Unit'));
     } else {
         // Redirect back with error message
         return redirect()->back()->with('error', 'Unit creation failed');
     }
   }

   public function update($id = 0)
   {

      $id   = $this->request->getVar('product_unit_id');

      $data = [
         'product_unit_name'   => $this->request->getVar('product_unit_name'),
      ];
      $id =  $this->productunit_object->update($id, $data);
      if ($id > 0) {
         // Redirect to category list page
         return redirect()->to(site_url('/Unit'));
     } else {
         // Redirect back with error message
         return redirect()->back()->with('error', 'Unit update failed');
     }
   }


   public function delete($id = 0)
   {

      $id = $this->request->getVar('delete_id');

      $this->productunit_object->where('product_unit_id', $id)->delete();

      //return into supplier page
      return $this->response->redirect(site_url('/Unit'));
   }
}
