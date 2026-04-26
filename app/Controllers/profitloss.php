<?php

namespace App\Controllers;

class Profitloss extends BaseController
{
    private $db;

    public function __construct()
    {
        $this->db = db_connect();
    }

    // =========================
    // STOCK REPORT
    // =========================
    public function index()
    {
        $sql = "
            SELECT 
                piq.*,
                COALESCE(piq.productinitial_quantity,0)
                + COALESCE(ppd.new_purchased,0) AS total_stock

            FROM product_inital_stock piq

            LEFT JOIN (
                SELECT 
                    product_id,
                    SUM(quantity_per_pack * box_quantity) AS new_purchased
                FROM product_purchase_details
                GROUP BY product_id
            ) ppd ON piq.product_id = ppd.product_id
        ";

        $data['stock_report_show'] = $this->db->query($sql)->getResultArray();

        return view('report/profitloss_report', $data);
    }

    // =========================
    // PROFIT LOSS REPORT
    // =========================
    public function profitlosspdfcreate()
    {
        $start = $this->request->getVar('start_date');
        $end   = $this->request->getVar('end_date');

        if (!$start || !$end) {
            return redirect()->back()->with('error', 'Date range is required');
        }

      echo  $start_date = date('Y-m-d', strtotime($start));
      echo  $end_date   = date('Y-m-d', strtotime($end));
      exit();

        // =========================
        // SALES + COST
        // =========================
        $sales = $this->db->query("
            SELECT 
                IFNULL(SUM(sd.total_sale_price),0) AS total_sales,
                IFNULL(SUM(sd.total_buy_price),0) AS total_cogs
            FROM sales_details sd
            JOIN sales s 
                ON sd.sales_details_invoice = s.sales_invoice
            WHERE s.sales_date BETWEEN ? AND ?
        ", [$start_date, $end_date])->getRowArray();

        // =========================
        // RETURNS (IMPORTANT FIX)
        // =========================
        $returns = $this->db->query("
            SELECT 
                IFNULL(SUM(rsd.total_sale_price),0) AS return_sales,
                IFNULL(SUM(rsd.total_buy_price),0) AS return_cost
            FROM return_sales_details rsd
            WHERE rsd.sales_details_invoice IN (
                SELECT sales_invoice 
                FROM sales 
                WHERE sales_date BETWEEN ? AND ?
            )
        ", [$start_date, $end_date])->getRowArray();

        // =========================
        // EXPENSES
        // =========================
        $expense = $this->db->query("
            SELECT IFNULL(SUM(expense_amount),0) AS total_expense
            FROM expense
            WHERE STR_TO_DATE(expense_date,'%d-%m-%Y')
            BETWEEN ? AND ?
        ", [$start_date, $end_date])->getRowArray();

        // =========================
        // CREDIT SALES
        // =========================
        $credit = $this->db->query("
            SELECT IFNULL(SUM(due_amount - due_paid_amount),0) AS credit
            FROM customer_due
            WHERE due_date BETWEEN ? AND ?
        ", [$start_date, $end_date])->getRowArray();

        // =========================
        // FINAL CALCULATION
        // =========================
        $total_sales = $sales['total_sales'] - $returns['return_sales'];
        $total_cost  = $sales['total_cogs'] - $returns['return_cost'];

        $gross_profit = $total_sales - $total_cost;

        $net_profit = $gross_profit
                      - $expense['total_expense'];

        // =========================
        // DATA
        // =========================
        $data = [
            'total_sales'   => $total_sales,
            'total_cogs'    => $total_cost,
            'gross_profit'  => $gross_profit,
            'net_profit'    => $net_profit,
            'expense'       => $expense['total_expense'],
            'credit'        => $credit['credit'],
            // ADD THESE ↓↓↓
            'discountOnTotalPrice' => $this->getDiscount($start_date, $end_date),
            'vatOnTotalPrice'      => $this->getVat($start_date, $end_date),

            'start_date'    => $start_date,
            'end_date'      => $end_date,
        ];

        // =========================
        // PDF GENERATION
        // =========================
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