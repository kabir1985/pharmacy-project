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
                s.product_discount,
                s.product_vat,
                s.other_charge_on_all,
                s.grand_total,
                s.paid_amount,

                c.customer_name,

                u.user_name AS seller_name,

                (
                    s.grand_total - COALESCE(s.paid_amount,0)
                ) AS invoice_due,

                COALESCE(SUM(cdp.payment_amount),0) AS due_paid,

                (
                    (s.grand_total - COALESCE(s.paid_amount,0))
                    -
                    COALESCE(SUM(cdp.payment_amount),0)
                ) AS due_balance,

                CASE

                    WHEN s.grand_total <= COALESCE(s.paid_amount,0)
                        THEN 'Fully Paid'

                    WHEN COALESCE(s.paid_amount,0) <= 0
                        THEN 'Unpaid'

                    ELSE 'Partially Paid'

                END AS payment_status

            ", false)

            ->join('customer c', 'c.customer_id = s.customer_id', 'left')

            ->join('user u', 'u.user_id = s.seller_id', 'left')

            ->join(
                'customer_due cd',
                'cd.sales_id = s.sales_id',
                'left'
            )

            ->join(
                'customer_due_payment cdp',
                'cdp.due_id = cd.due_id',
                'left'
            )

            ->groupBy([
                's.sales_id',
                's.sales_invoice',
                's.sales_date',
                's.product_discount',
                's.product_vat',
                's.other_charge_on_all',
                's.grand_total',
                's.paid_amount',
                'c.customer_name',
                'u.user_name',
            ])

            ->orderBy('s.sales_date', 'DESC')
            ->orderBy('s.sales_id', 'DESC')

            ->get()
            ->getResultArray();
    }
}
