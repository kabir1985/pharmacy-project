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

    $dueId        = (int) $this->request->getPost('due_id');
    $salesId      = (int) $this->request->getPost('sales_id');
    $customerId   = (int) $this->request->getPost('customer_id');

    $paymentAmount = round(
        (float) $this->request->getPost('payment_amount'),
        2
    );

    $paymentDate  = $this->request->getPost('payment_date');
    $paymentMethod = $this->request->getPost('payment_method');
    $referenceNo   = $this->request->getPost('reference_no');
    $note          = $this->request->getPost('note');


    // =========================================================
    // Basic Validation
    // =========================================================

    if ($dueId <= 0 || $salesId <= 0 || $customerId <= 0) {
        return $this->response->setJSON([
            'status'  => false,
            'message' => 'Invalid due information.'
        ]);
    }

    if ($paymentAmount <= 0) {
        return $this->response->setJSON([
            'status'  => false,
            'message' => 'Payment amount must be greater than zero.'
        ]);
    }


    // =========================================================
    // Start Transaction
    // =========================================================

    $this->db->transBegin();

    try {

        // =====================================================
        // Lock Customer Due Row
        // =====================================================

        $due = $this->db->query(
            "SELECT *
             FROM customer_due
             WHERE due_id = ?
             FOR UPDATE",
            [$dueId]
        )->getRowArray();


        if (!$due) {

            throw new \RuntimeException(
                'Customer due record not found.'
            );
        }


        // =====================================================
        // Validate Customer / Sales Relationship
        // =====================================================

        if ((int) $due['sales_id'] !== $salesId) {

            throw new \RuntimeException(
                'Sales invoice does not match customer due.'
            );
        }

        if ((int) $due['customer_id'] !== $customerId) {

            throw new \RuntimeException(
                'Customer does not match customer due.'
            );
        }


        // =====================================================
        // Original Due & Already Paid
        // =====================================================

        $originalDue = round(
            (float) $due['due_amount'],
            2
        );

        $alreadyPaid = round(
            (float) $due['paid_amount'],
            2
        );


        // =====================================================
        // Current Due
        // =====================================================

        $currentDue = round(
            $originalDue - $alreadyPaid,
            2
        );


        // =====================================================
        // Already Fully Paid
        // =====================================================

        if ($currentDue <= 0) {

            throw new \RuntimeException(
                'This invoice has no outstanding due.'
            );
        }


        // =====================================================
        // Prevent Over Payment
        // =====================================================

        if ($paymentAmount > $currentDue) {

            throw new \RuntimeException(
                'Payment cannot exceed current due of ৳' .
                number_format($currentDue, 2)
            );
        }


        // =====================================================
        // New Paid Amount
        // =====================================================

        $newPaidAmount = round(
            $alreadyPaid + $paymentAmount,
            2
        );


        // =====================================================
        // New Current Due
        // =====================================================

        $newCurrentDue = round(
            $originalDue - $newPaidAmount,
            2
        );


        // =====================================================
        // Payment Status
        // =====================================================

        if ($newCurrentDue <= 0) {
            $paymentStatus = 'Paid';
        } else {
            $paymentStatus = 'Partial';
        }


        // =====================================================
        // Insert Payment History
        // =====================================================

        $this->customerDuePaymentModel->insert([

            'due_id'         => $dueId,
            'sales_id'       => $salesId,
            'customer_id'    => $customerId,

            'payment_date'   => $paymentDate
                ?: date('Y-m-d H:i:s'),

            'payment_amount' => $paymentAmount,

            'payment_method' => $paymentMethod ?: 'Cash',

            'reference_no'   => $referenceNo ?: null,

            'note'           => $note ?: null,

            'received_by'    => session()->get('user_id'),

        ]);


        // =====================================================
        // Update Customer Due
        // IMPORTANT:
        // due_amount remains ORIGINAL DUE
        // only paid_amount increases
        // =====================================================

        $this->customerDueModel
            ->where('due_id', $dueId)
            ->set('paid_amount', $newPaidAmount)
            ->update();


        // =====================================================
        // Update Sales Paid Amount
        // =====================================================

        $this->productSaleModel->update(
            $salesId,
            [
                'paid_amount'   => $newPaidAmount,
                'payment_status' => $paymentStatus,
            ]
        );


        // =====================================================
        // Transaction Check
        // =====================================================

        if ($this->db->transStatus() === false) {

            throw new \RuntimeException(
                'Database transaction failed.'
            );
        }


        // =====================================================
        // Commit
        // =====================================================

        $this->db->transCommit();


        return $this->response->setJSON([

            'status'  => true,

            'message' =>
                'Payment collected successfully.',

            'data' => [

                'due_id' => $dueId,

                'sales_id' => $salesId,

                'payment_amount' =>
                    number_format($paymentAmount, 2, '.', ''),

                'paid_amount' =>
                    number_format($newPaidAmount, 2, '.', ''),

                'current_due' =>
                    number_format($newCurrentDue, 2, '.', ''),

                'payment_status' =>
                    $paymentStatus,

            ]

        ]);


    } catch (\Throwable $e) {

        $this->db->transRollback();

        log_message(
            'error',
            'Customer Due Payment Error: ' .
            $e->getMessage()
        );


        return $this->response->setJSON([

            'status'  => false,

            'message' => $e->getMessage(),

        ]);
    }
}

}
