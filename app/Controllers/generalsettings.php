<?php

namespace App\Controllers;

use App\Models\GeneralSettingsModel;
use App\Models\CurrencyAddModel;

use CodeIgniter\HTTP\IncomingRequest;

class generalsettings extends BaseController
{
   private $generalsetting_obj;
   private $currency_obj;


   public function __construct()
   {
      $this->generalsetting_obj = new GeneralSettingsModel();
      $this->currency_obj = new CurrencyAddModel();
   }

   public function index()
   {
     $data['system_settings_show'] = $this->generalsetting_obj->findAll();
     $data['currency_show'] = $this->currency_obj->findAll();

      return view('settings/GeneralSettingsAdd', $data);
   }

   //--------------------------------------------------------------------//
   public function create()
   {
      $data = [
         'company_name'   => $this->request->getVar('company_name'),
         'company_email'  => $this->request->getVar('company_email'),
         'country'        => $this->request->getVar('country'),
         'currency_id'    => $this->request->getVar('currency_id'),
         'company_phone'  => $this->request->getVar('company_phone'),
         'company_logo'   => $this->request->getVar('company_logo'),
         'company_address'=> $this->request->getVar('company_address')
      ];

     $id = $this->generalsetting_obj->insert($data);

      if ($id > 0) {
         echo "1";
      } else {
         echo "0";
      }
   }

   //--------------------------------------------------------------------//
   public function update($id = 0)
   {

      $id   = $this->request->getVar('system_settings_id');

      $data = [
         'company_name'   => $this->request->getVar('company_name'),
         'company_email'  => $this->request->getVar('company_email'),
         'country'        => $this->request->getVar('country'),
         'currency_id'    => $this->request->getVar('currency_id'),
         'company_phone'  => $this->request->getVar('company_phone'),
         'company_logo'   => $this->request->getVar('company_logo'),
         'company_address'=> $this->request->getVar('company_address')
      ];
      $update_id =  $this->generalsetting_obj->update($id, $data);
      if ($update_id > 0) {
         echo "1";
      } else {
         echo "0";
      }
   }

   public function delete($id = 0)
   {

      $id = $this->request->getVar('delete_id');

      $this->generalsetting_obj->where('id', $id)->delete();
      //$this->NewProductAddModel_Object->where('product_id', $id)->delete();

      //return into supplier page
      return $this->response->redirect(site_url('/generalsettings'));
   }
}
