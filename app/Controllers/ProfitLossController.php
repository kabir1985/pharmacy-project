<?php

namespace App\Controllers;

class ProfitLossController extends BaseController
{
    private $db;

    public function __construct()
    {
        $this->db = db_connect();
    }

    public function index()
    {

        return view('report/profitloss_report');
    }

    public function profitlosspdfcreate()
    {
        $start = $this->request->getVar('start_date');
        $end = $this->request->getVar('end_date');

        // =========================
        // VALIDATION
        // =========================
        if (!$start || !$end) {

            return redirect()->back()
                ->with('error', 'Date range is required');
        }

        $start_date = date('Y-m-d 00:00:00', strtotime($start));
        $end_date = date('Y-m-d 23:59:59', strtotime($end));

        if (empty($start_date) || empty($end_date)) {
            return redirect()->to('dashboard')
                ->with('error', 'Please select a date range first.');
        }
        // =====================================================
        // SALES
        // IMPORTANT:
        // DO NOT FILTER return_status
        // =====================================================
        $sales = $this->db->query("
        SELECT
            IFNULL(SUM(grand_total),0) AS gross_sales,
            IFNULL(SUM(product_discount),0) AS product_discount,
            IFNULL(SUM(product_vat),0) AS total_vat,
            IFNULL(SUM(other_charge_on_all),0) AS other_charge
        FROM sales
        WHERE sales_date BETWEEN ? AND ?
        ", [$start_date, $end_date])->getRowArray();

        // =====================================================
        // COGS
        // =====================================================

        $cogs = $this->db->query("
SELECT
    IFNULL(SUM(sd.total_buy_price),0) AS total_cogs
FROM sales_details sd
INNER JOIN sales s
    ON s.sales_id = sd.sales_id
WHERE s.sales_date BETWEEN ? AND ?
", [$start_date, $end_date])->getRowArray();

        // =====================================================
        // SALES RETURNS
        // =====================================================
        $returns = $this->db->query("
        SELECT

            IFNULL(SUM(rsd.total_return_amount),0) AS return_sales,

            IFNULL(
                SUM(
                    (
                        sd.total_buy_price /
                        NULLIF(sd.product_quantity_sold,0)
                    )
                    * rsd.return_qty
                    ),
            0) AS return_cost

        FROM return_sales rs

        INNER JOIN return_sales_details rsd
            ON rs.return_id = rsd.return_id

        INNER JOIN sales_details sd
            ON sd.sales_details_id = rsd.sales_details_id

        WHERE rs.return_date BETWEEN ? AND ?
        ", [$start_date, $end_date])->getRowArray();

        // =====================================================
        // EXPENSES
        // =====================================================
        $expense = $this->db->query("
        SELECT
            IFNULL(SUM(expense_amount),0) AS total_expense
        FROM expense
        WHERE expense_date BETWEEN ? AND ?
        ", [
            date('Y-m-d', strtotime($start)),
            date('Y-m-d', strtotime($end)),
        ])->getRowArray();

        //=====================================================
// Final Profit Calculation
//=====================================================

        $gross_sales = (float) $sales['gross_sales'];
        $product_discount = (float) $sales['product_discount'];
        $total_vat = (float) $sales['total_vat'];
        $other_charge = (float) $sales['other_charge'];

        $return_sales = (float) $returns['return_sales'];
        $return_cost = (float) $returns['return_cost'];

        $total_cogs = (float) $cogs['total_cogs'];
        $total_expense = (float) $expense['total_expense'];

        $other_income = 0;
        $financial_cost = 0;

// Net Sales
        $net_sales = $gross_sales - $return_sales;

// Net COGS
        $net_cogs = $total_cogs - $return_cost;

// Gross Profit
        $gross_profit = $net_sales - $net_cogs;

// Operating Profit
        $operating_profit = $gross_profit - $total_expense;

// Net Profit
        $net_profit = $operating_profit + $other_income - $financial_cost;

        $data = [

            'gross_sales' => $gross_sales,

            'product_discount' => $product_discount,

            'vat' => $total_vat,

            'other_charge' => $other_charge,

            'return_sales' => $return_sales,

            'return_cost' => $return_cost,

            'net_sales' => $net_sales,

            'total_cogs' => $total_cogs,

            'net_cogs' => $net_cogs,

            'gross_profit' => $gross_profit,

            'expense' => $total_expense,

            'operating_profit' => $operating_profit,

            'other_income' => $other_income,

            'financial_cost' => $financial_cost,

            'net_profit' => $net_profit,

            'start_date' => $start,

            'end_date' => $end,
        ];

        // =====================================================
        // PDF VIEW
        // =====================================================
        $html = view('report/profitloss_pdf', $data);

        $dompdf = new \Dompdf\Dompdf();

        $dompdf->loadHtml($html);

        $dompdf->setPaper('A4', 'portrait');

        $dompdf->render();

        $dompdf->stream("profit_loss.pdf", ["Attachment" => false]);

        exit();
    }

    private function getDiscount($start, $end)
    {
        $db = db_connect();

        return $db->query("
        SELECT IFNULL(SUM(discountOnTotalPrice),0) AS total
        FROM sales
        WHERE sales_date BETWEEN ? AND ?
    ", [$start, $end])->getRow()->total;
    }

    private function getVat($start, $end)
    {
        $db = db_connect();

        return $db->query("
        SELECT IFNULL(SUM(vatOnTotalPrice),0) AS total
        FROM sales
        WHERE sales_date BETWEEN ? AND ?
    ", [$start, $end])->getRow()->total;
    }
}
