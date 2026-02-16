<?php

namespace App\Controllers;

use App\Models\TaxModel;


use CodeIgniter\HTTP\IncomingRequest;

class Tax extends BaseController
{
   private $taxmodel_object;


   public function __construct()
   {
      $this->taxmodel_object  = new TaxModel();
   }

   public function index()
   {
      $data['tax_show'] = $this->taxmodel_object->findAll();

      //view('settings/taxAdd', $data);
      return view('settings/taxAdd', $data);
   }

   //--------------------------------------------------------------------//
   public function create()
   {
      $data = [
         'tax_name'         => $this->request->getVar('tax_name'),
         'tax_percentage'   => $this->request->getVar('tax_percentage')
      ];
      $id = $this->taxmodel_object->insert($data);
      if ($id > 0) {
         echo "1";
      } else {
         echo "0";
      }
   }

   //--------------------------------------------------------------------//
   public function update($id = 0)
   {

      $id   = $this->request->getVar('tax_id');

      $data = [
         'tax_name'   => $this->request->getVar('tax_name'),
         'tax_percentage'   => $this->request->getVar('tax_percentage')
      ];
      $update_id =  $this->taxmodel_object->update($id, $data);
      if ($update_id > 0) {
         echo "1";
      } else {
         echo "0";
      }
   }
   // //..........................................................................//
   public function delete($id = 0)
   {

      $id = $this->request->getVar('delete_id');

      $this->taxmodel_object->where('tax_id', $id)->delete();

      //    //return into supplier page
      return $this->response->redirect(site_url('/tax'));
   }
}
