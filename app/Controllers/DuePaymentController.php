<?php

namespace App\Controllers;

use App\Models\CustomerDueModel;
use App\Models\CustomerDuePaymentModel;
use App\Models\SalesModel;

class DuePaymentController extends BaseController
{
    protected $db;
    protected $salesModel;
    protected $customerDueModel;
    protected $paymentModel;

    public function __construct()
    {
        $this->db               = db_connect();
        $this->salesModel       = new SalesModel();
        $this->customerDueModel = new CustomerDueModel();
        $this->paymentModel     = new CustomerDuePaymentModel();
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

        $sale = $this->salesModel->find($salesId);

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

            $this->paymentModel->insert([
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

            $this->salesModel->update($salesId, [

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