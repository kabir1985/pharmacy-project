<?php

namespace App\Controllers;

use App\Models\CustomerGroupModel;
class CustomerGroupController extends BaseController
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
            'group_name' => trim($this->request->getPost('group_name')),
            'discount_percent' => trim($this->request->getPost('discount_percent'))
        ];

        if ($this->customerGroupObject->insert($data)) {
            return $this->response->setJSON([
                'status' => true,
                'message' => 'Customer group created successfully.'
            ]);
        }

        return $this->response->setJSON([
            'status' => false,
            'message' => 'Failed to create customer group.'
        ]);
    }
    public function update()
    {
        $id = $this->request->getPost('customer_group_id');

        $data = [
            'group_name' => trim($this->request->getPost('group_name')),
            'discount_percent' => trim($this->request->getPost('discount_percent'))
        ];

        if ($this->customerGroupObject->update($id, $data)) {
            return $this->response->setJSON([
                'status' => true,
                'message' => 'Customer group updated successfully.'
            ]);
        }

        return $this->response->setJSON([
            'status' => false,
            'message' => 'Failed to update customer group.'
        ]);
    }


    public function delete()
    {
        $id = $this->request->getPost('delete_id');

        if (empty($id)) {
            return $this->response->setJSON([
                'status' => false,
                'message' => 'Invalid Customer Group.'
            ]);
        }

        if ($this->customerGroupObject->delete($id)) {
            return $this->response->setJSON([
                'status' => true,
                'message' => 'Customer Group deleted successfully.'
            ]);
        }

        return $this->response->setJSON([
            'status' => false,
            'message' => 'Failed to delete Customer Group.'
        ]);
    }
}
