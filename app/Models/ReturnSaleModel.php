<?php

namespace App\Models;

use CodeIgniter\Model;

class ReturnSaleModel extends Model
{
    protected $table = 'return_sales';

    protected $primaryKey = 'return_id';

    protected $returnType = 'array';

    protected $allowedFields = [
        'return_invoice',
        'sales_id',
        'return_date',
        'return_type',
        'total_return_amount',
        'remarks',
        'return_by',
    ];

    protected $useTimestamps = true;

    protected $createdField = 'created_at';

    protected $updatedField = 'updated_at';




public function getSaleReturnList()
{
    $sql = "SELECT
        s.sales_id,
        s.sales_invoice,
        s.sales_date,

        c.customer_name AS customer_name,

        u.user_name AS seller_name,

        s.grand_total AS total_sale,
        s.product_vat,
        s.product_discount,
        s.other_charge_on_all,

        s.paid_amount AS total_paid,

        IFNULL(cd.total_due, 0) AS customer_due,

        CASE
            WHEN IFNULL(cd.total_due, 0) = 0
                THEN 'Fully Paid'
            ELSE 'Partially Paid'
        END AS payment_status

    FROM sales s

    LEFT JOIN customer c
        ON c.customer_id = s.customer_id

    LEFT JOIN user u
        ON u.user_id = s.seller_id

    LEFT JOIN
    (
        SELECT
            sales_id,
            SUM(due_amount) AS total_due
        FROM customer_due
        GROUP BY sales_id
    ) cd
        ON cd.sales_id = s.sales_id

    WHERE COALESCE(s.return_status, '') <> 'FULL'

    ORDER BY
        s.sales_date DESC,
        s.sales_invoice DESC";

    return $this->db
        ->query($sql)
        ->getResultArray();
}



public function saleReturnListShow()
{
    $sql = "
        SELECT
            s.sales_id,
            s.sales_invoice,
            s.sales_date,

            c.customer_name AS customer_name,

            u.user_name AS seller_name,

            s.grand_total AS total_sale,

            s.product_vat,
            s.product_discount,
            s.other_charge_on_all,

            IFNULL(cdp.total_paid, 0) AS total_paid,

            IFNULL(cd.total_due, 0) AS customer_due,

            CASE
                WHEN IFNULL(cd.total_due, 0) = 0
                    THEN 'Fully Paid'
                ELSE 'Partially Paid'
            END AS payment_status

        FROM sales s

        LEFT JOIN customer c
            ON c.customer_id = s.customer_id

        LEFT JOIN user u
            ON u.user_id = s.seller_id

        LEFT JOIN
        (
            SELECT
                sales_id,
                SUM(due_amount) AS total_due
            FROM customer_due
            GROUP BY sales_id
        ) cd
            ON cd.sales_id = s.sales_id

        LEFT JOIN
        (
            SELECT
                sales_id,
                SUM(payment_amount) AS total_paid
            FROM customer_due_payment
            GROUP BY sales_id
        ) cdp
            ON cdp.sales_id = s.sales_id

        WHERE COALESCE(s.return_status, '') <> 'FULL'

        ORDER BY
            s.sales_date DESC,
            s.sales_invoice DESC
    ";

    return $this->db
        ->query($sql)
        ->getResultArray();
}





}