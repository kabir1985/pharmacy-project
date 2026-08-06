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
        $this->db = db_connect();
        $this->productSaleModel = new ProductSaleModel();
        $this->customerDueModel = new CustomerDueModel();
        $this->customerDuePaymentModel = new CustomerDuePaymentModel();
    }

    public function index()
    {
        $data = [
            'due_list' => $this->customerDueModel->getAllDue(),
        ];

        return view('payment/due-collection', $data);
    }

/**
 * Save Due Payment
 */
public function save()
{
    if (!$this->request->isAJAX()) {
        return $this->response->setJSON([
            'status'  => false,
            'message' => 'Invalid request.'
        ]);
    }


    $dueId          = $this->request->getPost('due_id');
    $salesId        = $this->request->getPost('sales_id');
    $customerId     = $this->request->getPost('customer_id');

    $paymentAmount  = (float) $this->request->getPost('payment_amount');
    $paymentDate    = $this->request->getPost('payment_date');
    $paymentMethod  = $this->request->getPost('payment_method');
    $referenceNo    = $this->request->getPost('reference_no');
    $note           = $this->request->getPost('note');


    if ($paymentAmount <= 0) {

        return $this->response->setJSON([
            'status'  => false,
            'message' => 'Invalid payment amount.'
        ]);

    }


    // Get Sale
    $sale = $this->productSaleModel->find($salesId);


    if (!$sale) {

        return $this->response->setJSON([
            'status'  => false,
            'message' => 'Invoice not found.'
        ]);

    }


    // Calculate Current Due
    $currentDue = $sale['grand_total'] - $sale['paid_amount'];


    // Validate
    if ($paymentAmount > $currentDue) {

        return $this->response->setJSON([
            'status'  => false,
            'message' => 'Payment exceeds due amount.'
        ]);

    }


    $this->db->transBegin();


    try {


        // Payment History
        $this->customerDuePaymentModel->insert([

            'due_id'         => $dueId,
            'sales_id'       => $salesId,
            'customer_id'    => $customerId,
            'payment_date'   => $paymentDate,
            'payment_amount' => $paymentAmount,
            'payment_method' => $paymentMethod,
            'reference_no'   => $referenceNo,
            'note'           => $note,
            'received_by'    => session()->get('user_id'),

        ]);



        // Update Sale Paid Amount

        $newPaidAmount = $sale['paid_amount'] + $paymentAmount;


        $paymentStatus = 'Partial';


        if ($newPaidAmount >= $sale['grand_total']) {

            $paymentStatus = 'Paid';

        }



        $this->productSaleModel->update($salesId, [

            'paid_amount'    => $newPaidAmount,
            'payment_status' => $paymentStatus,

        ]);



        // Optional: Update customer_due table
        // only if you keep this table for tracking

        if ($dueId) {

            $due = $this->customerDueModel->find($dueId);


            if ($due) {

                $newDueAmount = $due['due_amount'] - $paymentAmount;


                $this->customerDueModel->update($dueId, [

                    'paid_amount' => $due['paid_amount'] + $paymentAmount,
                    'due_amount'  => $newDueAmount,

                ]);

            }

        }



        if ($this->db->transStatus() === false) {

            $this->db->transRollback();

            return $this->response->setJSON([
                'status'  => false,
                'message' => 'Payment failed.'
            ]);

        }



        $this->db->transCommit();


        return $this->response->setJSON([
            'status'  => true,
            'message' => 'Payment collected successfully.'
        ]);



    } catch (\Throwable $e) {


        $this->db->transRollback();


        log_message('error', $e->getMessage());


        return $this->response->setJSON([
            'status'  => false,
            'message' => 'An unexpected error occurred.'
        ]);

    }
}

}
