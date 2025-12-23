<?php
 namespace App\Models;
use CodeIgniter\Model;

class ReturnCustomerDueModel extends Model
 {
    protected $table = 'return_customer_due';

    protected $primaryKey = 'due_id';

    protected $allowedFields = ['return_due_date', 'customer_id', 'due_invoice_no', 'due_amount', 'due_paid_amount', 'current_balance'];

} 

