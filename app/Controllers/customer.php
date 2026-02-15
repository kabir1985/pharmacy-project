<?php

namespace App\Controllers;

use App\Models\CustomerModel;
use CodeIgniter\HTTP\IncomingRequest;

class Customer extends BaseController
{

   private $customerModelObject;

    public function __construct()
    {
        $this->customerModelObject = new CustomerModel();
    } 
 
    public function index()
    {
		
        ## Fetch all records from database
       $data['customer_show'] = $this->customerModelObject->findAll();
	   return view('customer/customer_add', $data);
       //return view('report/pdftest', $data);
    }

    // insert Supplier data

    public function create()
    {
        $data = [
            'cus_first_name'    => $this->request->getVar('cus_first_name'),
            'cus_last_name'     => $this->request->getVar('cus_last_name'),
            'cus_email'        => $this->request->getVar('cus_email'),
            'cus_phone'        => $this->request->getVar('cus_phone'),
            'cus_address'      => $this->request->getVar('cus_address'),
            'cus_tin'          => $this->request->getVar('cus_tin'),
			'cus_company'     => $this->request->getVar('cus_company'),
			'cus_type'         => $this->request->getVar('cus_type'),
			'cus_creation_date' => $this->request->getVar('cus_creation_date')
        ];

        $d = $this->customerModelObject->insert($data);
        if($d>0)
        { 
            echo "1";
        }
        else
        {
            echo "0";
        }

        //return into supplier page
        //return $this->response->redirect(site_url('/Customer'));
    }


    public function update($id = 0)
    {
        $id = $this->request->getVar('customer_id');
        //echo $id;
        $data = [
            'cus_first_name'    => $this->request->getVar('cus_first_name'),
            'cus_last_name'     => $this->request->getVar('cus_last_name'),
            'cus_email'        => $this->request->getVar('cus_email'),
            'cus_phone'        => $this->request->getVar('cus_phone'),
            'cus_address'      => $this->request->getVar('cus_address'),
            'cus_tin'          => $this->request->getVar('cus_tin'),
            'cus_company'     => $this->request->getVar('cus_company')
        ];

        $d =  $this->customerModelObject->update($id, $data);
                //$d = $this->customerModelObject->insert($data);
        if($d>0)
        { 
            echo "1";
        }
        else
        {
            echo "0";
        }

        //return into supplier page
        //return $this->response->redirect(site_url('/Customer'));
    }


    public function delete($id = 0)
    {

        $id = $this->request->getVar('delete_id');

        // echo $id;
        // exit();

        $this->customerModelObject->where('customer_id', $id)->delete();

        //return into supplier page
        return $this->response->redirect(site_url('/customer'));
    } 
}
