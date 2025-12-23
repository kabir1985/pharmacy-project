<?php

namespace App\Controllers;

use App\Models\CurrencyAddModel;


use CodeIgniter\HTTP\IncomingRequest;

class Currency extends BaseController
{
   private $currency_obj;


   public function __construct()
   {
      $this->currency_obj = new CurrencyAddModel();
   }

   public function index()
   {
      $data['currency_show'] = $this->currency_obj->findAll();

      return view('settings/currencyAdd', $data);
   }

   //--------------------------------------------------------------------//
   public function create()
   {
      $data = [
         'currency_code'   => $this->request->getVar('currency_code'),
         'currency_name'   => $this->request->getVar('currency_name'),
         'currency_symbol'   => $this->request->getVar('currency_symbol')
      ];
      //$df = new ProductCategoryModel();
      $id =  $this->currency_obj->insert($data);
      if ($id > 0) {
         echo "1";
      } else {
         echo "0";
      }
   }

   //--------------------------------------------------------------------//
   public function update($id = 0)
   {

      $id   = $this->request->getVar('currency_id');

      $data = [
         'currency_code'   => $this->request->getVar('currency_code'),
         'currency_name'   => $this->request->getVar('currency_name'),
         'currency_symbol'   => $this->request->getVar('currency_symbol')
      ];
      $update_id =  $this->currency_obj->update($id, $data);
      if ($update_id > 0) {
         echo "1";
      } else {
         echo "0";
      }
   }

   public function delete($id = 0)
   {

      $id = $this->request->getVar('delete_id');

      $this->currency_obj->where('id', $id)->delete();
      //$this->NewProductAddModel_Object->where('product_id', $id)->delete();

      //return into supplier page
      return $this->response->redirect(site_url('/Currency'));
   }
}
