<?php

namespace App\Controllers;

use App\Models\CustomerGroupModel;
use CodeIgniter\HTTP\IncomingRequest;

class Customergroup extends BaseController
{

     private $customerGroupObject;

    public function __construct()
    {
        $this->customerGroupObject = new CustomerGroupModel();
    }   

    public function index()
    {
		
        ## Fetch all records from database
       $data['customer_group_show'] = $this->customerGroupObject->findAll();
	   return view('customer/customer_group_add', $data);
    }

    // insert Supplier data
 
     public function create()
    {
        $data = [
            'cus_group_name'       => $this->request->getVar('cus_group_name'),
            'cus_due_limit'       => $this->request->getVar('cus_due_limit'),
            'discount_percent'    => $this->request->getVar('discount_percent')
        ];

      $d = $this->customerGroupObject->insert($data);

      if($d>0)
      {
         echo "1";
      }
      else
      {
       echo "0";
      }

        //return into supplier page
       // return $this->response->redirect(site_url('/customergroup'));
    } 


    public function update($id = 0)
    {
        $id = $this->request->getVar('customer_group_id');
        //echo $id;
        $data = [
            'cus_group_name'       => $this->request->getVar('cus_group_name'),
            'cus_due_limit'       => $this->request->getVar('cus_due_limit'),
            'discount_percent'    => $this->request->getVar('discount_percent')
        ];

        $this->customerGroupObject->update($id, $data);

        //return into supplier page
       // return $this->response->redirect(site_url('/Customergroup'));
    }


    public function delete($id = 0)
    {

        $id = $this->request->getVar('delete_id');

        $this->customerGroupObject->where('customer_group_id', $id)->delete();

        //return into supplier page
        return $this->response->redirect(site_url('/Customergroup'));
    } 
}
