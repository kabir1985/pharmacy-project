<?php

namespace App\Controllers;

class SaleSummaryReportController extends BaseController
{
    protected $db;

    public function __construct()
    {
        $this->db = db_connect();
    }

    public function index()
    {
        // Get Date Filter
        $startDate = $this->request->getGet('startDate');
        $endDate   = $this->request->getGet('endDate');

        $where = "";
        $params = [];

        if (!empty($startDate) && !empty($endDate)) {

            // Convert dd/mm/yyyy to yyyy-mm-dd
            $startDate = date('Y-m-d', strtotime(str_replace('/', '-', $startDate)));
            $endDate   = date('Y-m-d', strtotime(str_replace('/', '-', $endDate)));

            $where = " WHERE DATE(s.sales_date) BETWEEN ? AND ? ";
            $params = [$startDate, $endDate];
        }

        $sql = "
        SELECT

            s.sales_id,
            s.sales_invoice,
            s.sales_date,

            COALESCE(c.customer_name,'Walk-In Customer') AS customer_name,

            u.user_name AS seller_name,

            COUNT(sd.sales_details_id) AS total_items,

            IFNULL(SUM(sd.product_quantity_sold),0) AS total_qty,

            IFNULL(SUM(sd.total_sale_price),0) AS subtotal,

            s.product_discount,
            s.product_vat,
            s.other_charge_on_all,
            s.grand_total,

            IFNULL(SUM(sd.total_buy_price),0) AS total_cost,

            (
                s.grand_total -
                IFNULL(SUM(sd.total_buy_price),0)
            ) AS gross_profit,

            s.paid_amount,

            IFNULL(cd.total_due,0) AS total_due,

            IFNULL(cd.total_due_paid,0) AS due_paid,

            (
                IFNULL(cd.total_due,0) -
                IFNULL(cd.total_due_paid,0)
            ) AS current_due,

            s.payment_status,
            s.payment_type,
            s.return_status

        FROM sales s

        LEFT JOIN customer c
            ON c.customer_id = s.customer_id

        LEFT JOIN user u
            ON u.user_id = s.seller_id

        LEFT JOIN sales_details sd
            ON sd.sales_id = s.sales_id

        LEFT JOIN
        (
            SELECT
                sales_id,
                SUM(due_amount) AS total_due,
                SUM(paid_amount) AS total_due_paid
            FROM customer_due
            GROUP BY sales_id
        ) cd
            ON cd.sales_id = s.sales_id

        $where

        GROUP BY
            s.sales_id,
            s.sales_invoice,
            s.sales_date,
            c.customer_name,
            u.user_name,
            s.product_discount,
            s.product_vat,
            s.other_charge_on_all,
            s.grand_total,
            s.paid_amount,
            cd.total_due,
            cd.total_due_paid,
            s.payment_status,
            s.payment_type,
            s.return_status

        ORDER BY s.sales_date DESC
        ";

        if (!empty($params)) {
            $query = $this->db->query($sql, $params);
        } else {
            $query = $this->db->query($sql);
        }

        $data['sales_summery_report_show'] = $query->getResultArray();

        // Preserve selected dates in the view
        $data['startDate'] = $this->request->getGet('startDate');
        $data['endDate']   = $this->request->getGet('endDate');

        return view('report/sale_summery_report', $data);
    }
}