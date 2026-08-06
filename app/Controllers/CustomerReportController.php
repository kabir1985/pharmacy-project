<?php

namespace App\Controllers;

class CustomerReportController extends BaseController
{
    public function index()
    {
        $db = \Config\Database::connect();

        $sql = "
            SELECT
                c.customer_id,
                c.customer_name,
                c.phone,

                IFNULL(d.total_due, 0) AS total_due,

                IFNULL(p.total_paid, 0) AS total_paid,

                (
                    IFNULL(d.total_due, 0)
                    -
                    IFNULL(p.total_paid, 0)
                ) AS current_balance

            FROM customer c

            LEFT JOIN
            (
                SELECT
                    customer_id,
                    SUM(due_amount) AS total_due
                FROM customer_due
                GROUP BY customer_id
            ) d
                ON d.customer_id = c.customer_id

            LEFT JOIN
            (
                SELECT
                    customer_id,
                    SUM(payment_amount) AS total_paid
                FROM customer_due_payment
                GROUP BY customer_id
            ) p
                ON p.customer_id = c.customer_id

            ORDER BY c.customer_name ASC
        ";

        $query = $db->query($sql);

        $data['customers'] = $query->getResult();

        return view('report/customer_due_report', $data);
    }
}