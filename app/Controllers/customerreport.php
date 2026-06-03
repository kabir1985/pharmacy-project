<?php

namespace App\Controllers;

class Customerreport extends BaseController
{
    public function index()
    {
        $db = \Config\Database::connect();

        $sql = "
            SELECT 
                c.customer_id,
                CONCAT(c.cus_first_name, ' ', c.cus_last_name) AS customer_name,
                c.cus_phone,

                SUM(cd.due_amount) AS total_due,
                SUM(cd.due_paid_amount) AS total_paid,

                (SUM(cd.due_amount) - SUM(cd.due_paid_amount)) AS current_balance

            FROM customer c
            LEFT JOIN customer_due cd 
                ON c.customer_id = cd.customer_id

            GROUP BY c.customer_id
        ";

        $query = $db->query($sql);
        $data['customers'] = $query->getResult();

        return view('report/customer_due_report', $data);
    }
}