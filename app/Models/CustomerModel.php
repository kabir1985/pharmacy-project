<?php
 namespace App\Models;
use CodeIgniter\Model;

class CustomerModel extends Model
 {
    protected $table = 'customer';

    protected $primaryKey = 'customer_id';

    protected $allowedFields = ['cus_first_name', 'cus_last_name', 'cus_email', 'cus_phone', 'cus_address', 'cus_tin', 'cus_company', 'cus_type', 'cus_creation_date'];

} 

