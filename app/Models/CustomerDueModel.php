<?php
 namespace App\Models;
use CodeIgniter\Model;

class CustomerDueModel extends Model
 {
    protected $table = 'customer_due';

    protected $primaryKey = 'due_id';

    protected $allowedFields = ['due_date', 'customer_id', 'due_invoice_no', 'due_amount', 'due_paid_amount', 'current_balance'];

} 

