<?php

namespace App\Models;

use CodeIgniter\Model;

class CustomerModel extends Model
{
    protected $table = 'customer';
    protected $primaryKey = 'customer_id';

    protected $allowedFields = [
        'customer_group_id',
        'customer_name',
        'phone',
        'address',
        'status'
    ];


    // =========================================================
    // CUSTOMER LIST
    // =========================================================

    public function getCustomers()
    {
        return $this->select('
                customer.*,
                customer_group.group_name
            ')
            ->join(
                'customer_group',
                'customer.customer_group_id = customer_group.customer_group_id',
                'left'
            )
            ->orderBy(
                'customer.customer_name',
                'ASC'
            )
            ->findAll();
    }


    // =========================================================
    // CUSTOMER ACCOUNT STATEMENT
    // =========================================================
public function getCustomerAccountStatement($customerId)
{
    $builder = $this->db->table('customer_due cd');

    $builder->select("
        cd.due_id,
        cd.customer_id,
        cd.sales_id,

        s.sales_invoice,
        s.sales_date,

        cd.due_amount,

        COALESCE(
            SUM(cdp.payment_amount),
            0
        ) AS paid_amount,

        (
            cd.due_amount
            -
            COALESCE(
                SUM(cdp.payment_amount),
                0
            )
        ) AS remaining_due,

        MAX(cdp.payment_date) AS last_payment_date
    ", false);

    $builder->join(
        'sales s',
        's.sales_id = cd.sales_id',
        'left'
    );

    $builder->join(
        'customer_due_payment cdp',
        'cdp.due_id = cd.due_id',
        'left'
    );

    $builder->where(
        'cd.customer_id',
        $customerId
    );

    $builder->groupBy([
        'cd.due_id',
        'cd.customer_id',
        'cd.sales_id',
        's.sales_invoice',
        's.sales_date',
        'cd.due_amount'
    ]);

    $builder->orderBy(
        's.sales_date',
        'ASC'
    );

    $builder->orderBy(
        'cd.due_id',
        'ASC'
    );

    return $builder
        ->get()
        ->getResultArray();
}
}