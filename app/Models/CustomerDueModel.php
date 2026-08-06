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
            ->select("
                cd.*,
                s.sales_invoice,
                s.grand_total,
                c.customer_name,

                IFNULL(p.total_paid,0) AS total_paid,

                (cd.due_amount - IFNULL(p.total_paid,0)) AS current_due
            ")
            ->join('sales s', 's.sales_id = cd.sales_id')
            ->join('customer c', 'c.customer_id = cd.customer_id')

            ->join("
                (
                    SELECT
                        due_id,
                        SUM(payment_amount) AS total_paid
                    FROM customer_due_payment
                    GROUP BY due_id
                ) p
            ", 'p.due_id = cd.due_id', 'left')

            ->where('(cd.due_amount - IFNULL(p.total_paid,0)) >', 0, false)

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