<?php

namespace App\Models;

use CodeIgniter\Model;

class ReturnPaymentModel extends Model
{
    protected $table            = 'return_payment';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';

    protected $allowedFields = [
        'return_id',
        'payment_type',
        'amount',
        'payment_date',
        'remarks',
    ];

    protected $useTimestamps = true;

    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    protected $validationRules = [
        'return_id' => 'required|integer',
        'payment_type' => 'required|max_length[30]',
        'amount' => 'required|decimal',
        'payment_date' => 'required|valid_date',
    ];

    protected $validationMessages = [
        'return_id' => [
            'required' => 'Return ID is required.',
            'integer'  => 'Invalid Return ID.',
        ],

        'payment_type' => [
            'required'   => 'Payment type is required.',
            'max_length' => 'Payment type cannot exceed 30 characters.',
        ],

        'amount' => [
            'required' => 'Payment amount is required.',
            'decimal'  => 'Payment amount must be a valid decimal.',
        ],

        'payment_date' => [
            'required'   => 'Payment date is required.',
            'valid_date' => 'Invalid payment date.',
        ],
    ];
}