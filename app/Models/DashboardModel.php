<?php

namespace App\Models;

use CodeIgniter\Model;

class DashboardModel extends Model
{
    protected $DBGroup = 'default';

    /**
     * Get today's sales amount
     */
    public function getTodaySales(): float
    {
        $row = $this->db->query("
            SELECT COALESCE(SUM(grand_total), 0) AS total
            FROM sales
            WHERE DATE(sales_date) = CURDATE()
        ")->getRow();

        return (float) ($row->total ?? 0);
    }


    /**
     * Get today's purchase amount
     */
    public function getTodayPurchase(): float
    {
        $row = $this->db->query("
            SELECT COALESCE(SUM(invoice_total), 0) AS total
            FROM product_purchase
            WHERE DATE(purchase_date) = CURDATE()
        ")->getRow();

        return (float) ($row->total ?? 0);
    }


    /**
     * =========================================================
     * TODAY SALES RETURN
     * =========================================================
     *
     * return_sales.total_return_amount
     * is the actual return amount.
     */
public function getTodayReturn(): float
{
    $row = $this->db->query("
        SELECT COALESCE(SUM(total_return_amount), 0) AS total
        FROM return_sales
        WHERE DATE(return_date) = CURDATE()
    ")->getRow();

    return (float) ($row->total ?? 0);
}

    /**
     * Get today's credit sales amount
     *
     * Adjust payment_status / payment_method
     * according to your actual sales table.
     */
    public function getTodayCreditSale(): float
    {
        $row = $this->db->query("
            SELECT COALESCE(SUM(grand_total), 0) AS total
            FROM sales
            WHERE DATE(sales_date) = CURDATE()
            AND payment_status = 'Credit'
        ")->getRow();

        return (float) ($row->total ?? 0);
    }


    /**
     * Get monthly sales for current year
     */
    public function getMonthlySales(): array
    {
        $query = $this->db->query("
            SELECT
                MONTH(sales_date) AS month_no,
                MONTHNAME(sales_date) AS month_name,
                COALESCE(SUM(grand_total), 0) AS total_sale
            FROM sales
            WHERE YEAR(sales_date) = YEAR(CURDATE())
            GROUP BY
                MONTH(sales_date),
                MONTHNAME(sales_date)
            ORDER BY month_no
        ");

        $labels = [];
        $amounts = [];

        foreach ($query->getResult() as $row) {

            $labels[] = $row->month_name;
            $amounts[] = (float) $row->total_sale;
        }

        return [
            'labels'  => $labels,
            'amounts' => $amounts,
        ];
    }


    /**
     * Get all dashboard statistics
     *
     * This is useful because the controller
     * can make one method call.
     */
    public function getDashboardSummary(): array
    {
        $monthlySales = $this->getMonthlySales();

        return [

            'today_sales' => $this->getTodaySales(),

            'today_purchase' => $this->getTodayPurchase(),

            'today_return' => $this->getTodayReturn(),

           // 'today_credit_sale' => $this->getTodayCreditSale(),

            'sales_labels' => json_encode(
                $monthlySales['labels']
            ),

            'sales_amounts' => json_encode(
                $monthlySales['amounts']
            ),
        ];
    }
}