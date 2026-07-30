<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductSaleModel extends Model
{
    protected $table = 'sales';

    protected $primaryKey = 'sales_id';
    protected $allowedFields = [
                                'sales_invoice',
                                'customer_id',
                                'sales_date',
                                'payment_type',
                            
                                'product_discount',
                                'product_vat',
                                'other_charge_on_all',

                                'grand_total',
                                'paid_amount',
                                'due_amount',
                                'payment_status',

                                'seller_id',
                                'return_status',
                            ];

    public function getSaleList()
    {
        return $this->db->table('sales s')
            ->select("
                                        s.sales_id,
                                        s.sales_invoice,
                                        s.sales_date,
                                        s.total_amount,
                                        s.product_discount,
                                        s.product_vat,
                                        s.other_charge_on_all,
                                        s.paid_amount,
                                        s.due_amount,

                                        c.customer_name,

                                        u.user_name AS seller_name,

                                        CASE
                                            WHEN s.due_amount <= 0 THEN 'Fully Paid'
                                            WHEN s.paid_amount <= 0 THEN 'Unpaid'
                                            ELSE 'Partially Paid'
                                        END AS payment_status
                                    ", false)

            ->join('customer c', 'c.customer_id = s.customer_id', 'left')
            ->join('user u', 'u.user_id = s.seller_id', 'left')

            ->orderBy('s.sales_date', 'DESC')
            ->orderBy('s.sales_id', 'DESC')

            ->get()
            ->getResultArray();
    }
}
