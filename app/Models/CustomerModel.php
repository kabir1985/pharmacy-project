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
            ->orderBy('customer.customer_name', 'ASC')
            ->findAll();
    }
}