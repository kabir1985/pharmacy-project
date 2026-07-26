<?php
 namespace App\Models;
use CodeIgniter\Model;

class CustomerDueModel extends Model
 {
    protected $table = 'customer_due';

    protected $primaryKey = 'due_id';

    protected $allowedFields = ['customer_id', 'sales_id', 'due_amount', 'paid_amount'];

public function getAllDue()
{
    return $this->db->table('customer_due cd')
        ->select('
            cd.*,
            s.sales_invoice,
            s.total_amount,
            c.customer_name
        ')
        ->join('sales s', 's.sales_id = cd.sales_id')
        ->join('customer c', 'c.customer_id = cd.customer_id')
        ->where('cd.due_amount >', 0)
        ->orderBy('cd.due_id', 'DESC')
        ->get()
        ->getResultArray();
}

public function getDueById($dueId)
{
    return $this->db->table('customer_due cd')
        ->select('
            cd.*,
            s.sales_invoice,
            s.total_amount,
            c.customer_name
        ')
        ->join('sales s', 's.sales_id = cd.sales_id')
        ->join('customer c', 'c.customer_id = cd.customer_id')
        ->where('cd.due_id', $dueId)
        ->get()
        ->getRowArray();
}

} 

