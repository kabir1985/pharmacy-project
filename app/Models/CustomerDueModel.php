<?php
 namespace App\Models;
use CodeIgniter\Model;

class CustomerDueModel extends Model
 {
    protected $table = 'customer_due';

    protected $primaryKey = 'due_id';

    protected $allowedFields = ['customer_id', 'sales_id', 'due_amount', 'paid_amount'];

} 

