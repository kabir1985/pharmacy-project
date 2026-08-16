<?php

namespace App\Controllers;

use App\Models\CustomerModel;
use App\Models\CustomerGroupModel;

class CustomerController extends BaseController
{
    private $customerModelObject;
    private $customerGroupObject;

    public function __construct()
    {
        $this->customerModelObject = new CustomerModel();
        $this->customerGroupObject = new CustomerGroupModel();
    }

    /**
     * Customer List
     */
    public function index()
    {
        $data['customer_group_show'] = $this->customerGroupObject->findAll();
        $data['customer_show']       = $this->customerModelObject->getCustomers();

        return view('customer/customer_add', $data);
    }

    /**
     * Create Customer
     */
    public function create()
    {
        $customer_name     = trim($this->request->getPost('customer_name'));
        $phone             = trim($this->request->getPost('phone'));
        $customer_group_id = $this->request->getPost('customer_group_id');

        if ($customer_name == '') {
            return $this->response->setBody('0');
        }

        // Duplicate phone check
        if ($phone != '') {

            $exists = $this->customerModelObject
                ->where('phone', $phone)
                ->first();

            if ($exists) {
                return $this->response->setBody('duplicate');
            }
        }

        $data = [
            'customer_group_id' => !empty($customer_group_id) ? $customer_group_id : null,
            'customer_name'     => $customer_name,
            'phone'             => $phone,
            'address'           => trim($this->request->getPost('address')),
            'status'            => $this->request->getPost('status') ?? 1,
        ];

        if ($this->customerModelObject->insert($data)) {
            return $this->response->setBody('1');
        }

        return $this->response->setBody('0');
    }

    /**
     * Update Customer
     */
    public function update()
    {
        $id = $this->request->getPost('customer_id');

        if (!$id) {
            return $this->response->setBody('0');
        }

        $customer = $this->customerModelObject->find($id);

        if (!$customer) {
            return $this->response->setBody('0');
        }

        $phone = trim($this->request->getPost('phone'));

        // Duplicate phone except current customer
        if ($phone != '') {

            $exists = $this->customerModelObject
                ->where('phone', $phone)
                ->where('customer_id !=', $id)
                ->first();

            if ($exists) {
                return $this->response->setBody('duplicate');
            }
        }

        $data = [
            'customer_group_id' => !empty($this->request->getPost('customer_group_id'))
                ? $this->request->getPost('customer_group_id')
                : null,

            'customer_name' => trim($this->request->getPost('customer_name')),
            'phone'         => $phone,
            'address'       => trim($this->request->getPost('address')),
            'status'        => $this->request->getPost('status'),
        ];

        if ($this->customerModelObject->update($id, $data)) {
            return $this->response->setBody('1');
        }

        return $this->response->setBody('0');
    }

    /**
     * Delete Customer
     */
    public function delete()
    {
        $id = $this->request->getPost('delete_id');

        if (!$id) {
            return redirect()->to('/customer');
        }

        $customer = $this->customerModelObject->find($id);

        if ($customer) {
            $this->customerModelObject->delete($id);
        }

        return redirect()->to('/customer');
    }



public function CustomerAccountStatementView()
{

    $data['customer_show'] = $this->customerModelObject
        ->where('status', 1)
        ->orderBy('customer_name', 'ASC')
        ->findAll();

return view('customer/accountStatementView', $data);

}



/**
 * Customer Account Statement Data
 *
 * AJAX endpoint
 */
public function CustomerAccountStatementData()
{
    $customerId = $this->request->getPost('customer_id');

    // -----------------------------------------------------
    // Validate customer ID
    // -----------------------------------------------------

    if (empty($customerId)) {

        return $this->response->setJSON([
            'status'  => false,
            'message' => 'Customer ID is required.'
        ]);
    }


    // -----------------------------------------------------
    // Get customer
    // -----------------------------------------------------

    $customer = $this->customerModelObject
        ->where('customer_id', $customerId)
        ->where('status', 1)
        ->first();


    if (!$customer) {

        return $this->response->setJSON([
            'status'  => false,
            'message' => 'Customer not found.'
        ]);
    }


    // -----------------------------------------------------
    // Get account statement
    // -----------------------------------------------------

    $statement = $this->customerModelObject
        ->getCustomerAccountStatement($customerId);


    // -----------------------------------------------------
    // Calculate summary
    // -----------------------------------------------------

    $totalDue = 0;
    $totalPaid = 0;
    $totalOutstanding = 0;


    foreach ($statement as $row) {

        $totalDue += (float) ($row['due_amount'] ?? 0);

        $totalPaid += (float) ($row['paid_amount'] ?? 0);

        $totalOutstanding +=
            (float) ($row['remaining_due'] ?? 0);
    }


    // -----------------------------------------------------
    // Response
    // -----------------------------------------------------

    return $this->response->setJSON([
        'status' => true,

        'customer' => [
            'customer_id'   => $customer['customer_id'],
            'customer_name' => $customer['customer_name'],
            'phone'         => $customer['phone'] ?? '',
            'address'       => $customer['address'] ?? ''
        ],

        'summary' => [
            'total_due'         => number_format($totalDue, 2, '.', ''),
            'total_paid'        => number_format($totalPaid, 2, '.', ''),
            'total_outstanding' => number_format($totalOutstanding, 2, '.', '')
        ],

        'data' => $statement
    ]);
}






}