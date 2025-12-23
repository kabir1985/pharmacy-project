<?php
namespace App\Models;
use CodeIgniter\Model;

class SupplierModel extends Model
 {
    protected $table = 'supplier';

    protected $primaryKey = 'supplier_id';

    protected $allowedFields = ['supplier_name', 'business_name', 'contact_number', 'supplier_email', 'supplier_address', 'supplier_entry_date'];

}

