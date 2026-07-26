<?php

namespace App\Controllers;

use App\Models\CustomerDueModel;
use App\Models\CustomerDuePaymentModel;
use App\Models\ProductSaleModel;

class DuePaymentController extends BaseController
{
    protected $db;
    protected $productSaleModel;
    protected $customerDueModel;
    protected $customerDuePaymentModel;

    public function __construct()
    {
        $this->db               = db_connect();
        $this->productSaleModel = new ProductSaleModel();
        $this->customerDueModel = new CustomerDueModel();
        $this->customerDuePaymentModel = new CustomerDuePaymentModel();
    }

public function index()
{
    $data = [
        'due_list' => $this->customerDueModel->getAllDue()
    ];

    return view('payment/due-list', $data);
}

public function collect($dueId)
{
    $due = $this->customerDueModel->getDueById($dueId);

    if (empty($due)) {
        throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Due record not found.');
    }

    return view('payment/due-collection', [
        'due' => $due
    ]);
}

    /**
     * Save Due Payment
     */
    public function save()
    {
        $dueId          = $this->request->getPost('due_id');
        $salesId        = $this->request->getPost('sales_id');
        $customerId     = $this->request->getPost('customer_id');

        $paymentAmount  = (float)$this->request->getPost('payment_amount');

        $paymentDate    = $this->request->getPost('payment_date');
        $paymentMethod  = $this->request->getPost('payment_method');
        $referenceNo    = $this->request->getPost('reference_no');
        $note           = $this->request->getPost('note');

        if ($paymentAmount <= 0) {
            return redirect()->back()->with('error', 'Invalid payment amount.');
        }

        $sale = $this->productSaleModel->find($salesId);

        if (!$sale) {
            return redirect()->back()->with('error', 'Invoice not found.');
        }

        if ($paymentAmount > $sale['due_amount']) {
            return redirect()->back()->with('error', 'Payment exceeds due amount.');
        }

        $this->db->transBegin();

        try {

            //---------------------------------------
            // Insert Payment History
            //---------------------------------------

            $this->customerDuePaymentModel->insert([
                'due_id'         => $dueId,
                'sales_id'       => $salesId,
                'customer_id'    => $customerId,
                'payment_date'   => $paymentDate,
                'payment_amount' => $paymentAmount,
                'payment_method' => $paymentMethod,
                'reference_no'   => $referenceNo,
                'note'           => $note,
                'received_by'    => session()->get('user_id')
            ]);

            //---------------------------------------
            // Update Sales
            //---------------------------------------

            $this->productSaleModel->update($salesId, [

                'paid_amount' => $sale['paid_amount'] + $paymentAmount,

                'due_amount'  => $sale['due_amount'] - $paymentAmount

            ]);

            //---------------------------------------
            // Update Customer Due
            //---------------------------------------

            $due = $this->customerDueModel->find($dueId);

            $this->customerDueModel->update($dueId, [

                'paid_amount' => $due['paid_amount'] + $paymentAmount

            ]);

            //---------------------------------------

            if ($this->db->transStatus() === false) {

                $this->db->transRollback();

                return redirect()->back()->with('error', 'Payment failed.');
            }

            $this->db->transCommit();

            return redirect()->to('/payment/customer-due')
                             ->with('success', 'Payment collected successfully.');
        } catch (\Exception $e) {

            $this->db->transRollback();

            return redirect()->back()
                             ->with('error', $e->getMessage());
        }
    }
}