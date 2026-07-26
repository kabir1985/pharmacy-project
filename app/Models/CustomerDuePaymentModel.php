<?php

namespace App\Models;

use CodeIgniter\Model;

class CustomerDuePaymentModel extends Model
{
    protected $table      = 'customer_due_payment';

    protected $primaryKey = 'payment_id';

    protected $returnType = 'array';

    protected $allowedFields = [

        'due_id',
        'sales_id',
        'customer_id',
        'payment_date',
        'payment_amount',
        'payment_method',
        'reference_no',
        'note',
        'received_by'

    ];



    public function getDuePayments()
{
    return $this->select('customer_due_payment.*, customer.customer_name')
                ->join('customer', 'customer.customer_id = customer_due_payment.customer_id', 'left')
                ->orderBy('customer_due_payment.payment_id', 'DESC')
                ->findAll();
}
}