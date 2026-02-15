<?php

namespace App\Controllers;

use App\Models\SupplierModel;
use CodeIgniter\HTTP\IncomingRequest;

class Supplier extends BaseController
{

    private $supplierModelObject;

    public function __construct()
    {
        $this->supplierModelObject = new SupplierModel();
    }

    public function index()
    {
        ## Fetch all records from database
        $data['subjects'] = $this->supplierModelObject->findAll();
        return view('supplier/supplier_add', $data);
    }

    // insert Supplier data

    public function create()
    {
        $data = [
            'supplier_name'       => $this->request->getVar('supplier_name'),
            'business_name'       => $this->request->getVar('business_name'),
            'contact_number'      => $this->request->getVar('contact_number'),
            'supplier_email'      => $this->request->getVar('supplier_email'),
            'supplier_address'    => $this->request->getVar('supplier_address'),
            'supplier_entry_date' => $this->request->getVar('supplier_entry_date'),
        ];

        $this->supplierModelObject->insert($data);

        //return into supplier page
        return $this->response->redirect(site_url('/Supplier'));
    }


    public function update($id = 0)
    {
        $id = $this->request->getVar('supplier_id');
        //echo $id;
        $data = [
            'supplier_name'       => $this->request->getVar('supplier_name'),
            'business_name'       => $this->request->getVar('business_name'),
            'contact_number'      => $this->request->getVar('contact_number'),
            'supplier_email'      => $this->request->getVar('supplier_email'),
            'supplier_address'    => $this->request->getVar('supplier_address'),
            'supplier_entry_date' => $this->request->getVar('supplier_entry_date'),
        ];

        $this->supplierModelObject->update($id, $data);

        //return into supplier page
        return $this->response->redirect(site_url('/Supplier'));
    }


    public function delete($id = 0)
    {

        $id = $this->request->getVar('delete_id');

        $this->supplierModelObject->where('supplier_id', $id)->delete();

        //return into supplier page
        return $this->response->redirect(site_url('/Supplier'));
    }
}
