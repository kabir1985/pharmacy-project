<?php

namespace App\Controllers;

use App\Models\ProductBrandModel;
use App\Models\ProductCategoryModel;

use CodeIgniter\HTTP\IncomingRequest;

class Brand extends BaseController
{
   private $product_brand_object;
   private $product_category_object;
   protected $db;


   public function __construct()
   {
      $this->product_brand_object    = new ProductBrandModel();
      $this->product_category_object = new ProductCategoryModel();
      $this->db = db_connect();
   }

   public function index()
   {

      $data['category_show'] = $this->product_category_object->findAll();
      $data['brand_show'] = $this->product_brand_object->findAll();

      $sql = "SELECT * FROM product_brand AS pb
      JOIN product_category as pc ON pb.product_category_id =  pc.product_category_id";

      $data['product_brand_show'] = $this->db->query($sql)->getResult('array');



      return view('product/ProductBrandAdd', $data);
   }

   //--------------------------------------------------------------------//
   public function create()
   {
      $data = [
         'product_brand_name'   => $this->request->getVar('product_brand_name'),
         'product_category_id'   => $this->request->getVar('product_category_id'),
      ];
      $id =  $this->product_brand_object->insert($data);
      // if ($id > 0) {
      //    echo "1";
      // } else {
      //    echo "0";
      // }

      if ($id > 0) {
         // Redirect to category list page
         return redirect()->to(site_url('/productbrandView'));
     } else {
         // Redirect back with error message
         return redirect()->back()->with('error', 'Product Brand creation failed');
     }


   }

   //--------------------------------------------------------------------//
   public function update($id = 0)
   {

      $id   = $this->request->getVar('product_brand_id');

      $data = [
         'product_brand_name'   => $this->request->getVar('product_brand_name'),
      ];
      $update_id =  $this->product_brand_object->update($id, $data);
      // if ($update_id > 0) {
      //    echo "1";
      // } else {
      //    echo "0";
      // }

      if ($update_id > 0) {
         // Redirect to category list page
         return redirect()->to(site_url('/productbrandView'));
     } else {
         // Redirect back with error message
         return redirect()->back()->with('error', 'Product Brand update failed');
     }
   }
   //--------------------------------------------------------------------//
   public function delete($id = 0)
   {

      $id = $this->request->getVar('delete_id');

      $this->product_brand_object->where('brand_id', $id)->delete();

      //return into Brand page
      return $this->response->redirect(site_url('/productbrandView'));
   }
}
