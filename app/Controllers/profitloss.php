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




    

//     // =========================
//     // PROFIT LOSS REPORT
//     // =========================
//     public function profitlosspdfcreate()
//     {
//         $start = $this->request->getVar('start_date');
//         $end = $this->request->getVar('end_date');

//         if (!$start || !$end) {
//             return redirect()->back()->with('error', 'Date range is required');
//         }

//         $start_date = date('Y-m-d 00:00:00', strtotime($start));
//         $end_date = date('Y-m-d 23:59:59', strtotime($end));

// // =========================
// // SALES
// // =========================
//         $sales_total = $this->db->query("
//     SELECT IFNULL(SUM(total_amount),0) AS total_sales
//     FROM sales
//     WHERE sales_date BETWEEN ? AND ?
// ", [$start_date, $end_date])->getRowArray();

// // =========================
// // COGS
// // =========================
//         $cogs = $this->db->query("
//     SELECT IFNULL(SUM(sd.total_buy_price),0) AS total_cogs
//     FROM sales_details sd
//     JOIN sales s
//         ON sd.sales_details_invoice = s.sales_invoice
//     WHERE s.sales_date BETWEEN ? AND ?
// ", [$start_date, $end_date])->getRowArray();

// // =========================
// // RETURNS (FIXED)
// // =========================
//         $returns = $this->db->query("
//     SELECT
//         IFNULL(SUM(rsd.total_sale_price),0) AS return_sales,
//         IFNULL(SUM(rsd.total_buy_price),0) AS return_cost
//     FROM return_sales_details rsd
//     JOIN return_sales rs
//         ON rs.sales_invoice = rsd.sales_details_invoice
//     WHERE rs.return_date BETWEEN ? AND ?
// ", [$start_date, $end_date])->getRowArray();



// $expense = $this->db->query("
//     SELECT IFNULL(SUM(expense_amount),0) AS total_expense
//     FROM expense
//     WHERE STR_TO_DATE(expense_date,'%d-%m-%Y')
//     BETWEEN DATE(?) AND DATE(?)
// ", [$start_date, $end_date])->getRowArray();

// // =========================
// // FINAL CALCULATION
// // =========================
//         $total_sales = $sales_total['total_sales'] - $returns['return_sales'];
//         $total_cost = $cogs['total_cogs'] - $returns['return_cost'];

//         $gross_profit = $total_sales - $total_cost;

//         $net_profit = $gross_profit - $expense['total_expense'];

//         // =========================
//         // DATA
//         // =========================
//         $data = [
//             'total_sales' => $total_sales,
//             'total_cogs' => $total_cost,
//             'gross_profit' => $gross_profit,
//             'net_profit' => $net_profit,
//             'expense' => $expense['total_expense'],
//            // 'credit' => $credit['credit'],
//             'credit' => 0,
//             // ADD THESE ↓↓↓
//             'discountOnTotalPrice' => $this->getDiscount($start_date, $end_date),
//             'vatOnTotalPrice' => $this->getVat($start_date, $end_date),

//             'start_date' => $start_date,
//             'end_date' => $end_date,
//         ];

//         // =========================
//         // PDF GENERATION
//         // =========================
//         $html = view('report/profitloss_pdf', $data);

//         $dompdf = new \Dompdf\Dompdf();
//         $dompdf->loadHtml($html);
//         $dompdf->setPaper('A4', 'portrait');
//         $dompdf->render();
//         $dompdf->stream("profit_loss.pdf", ["Attachment" => false]);
//         exit();
//     }


public function profitlosspdfcreate()
{
    $start = $this->request->getVar('start_date');
    $end   = $this->request->getVar('end_date');

    // =========================
    // VALIDATION
    // =========================
    if (!$start || !$end) {

        return redirect()->back()
            ->with('error', 'Date range is required');
    }

    $start_date = date('Y-m-d 00:00:00', strtotime($start));
    $end_date   = date('Y-m-d 23:59:59', strtotime($end));

    // =====================================================
    // SALES
    // IMPORTANT:
    // DO NOT FILTER return_status
    // =====================================================
    $sales = $this->db->query("
        SELECT
            IFNULL(SUM(total_amount),0) AS gross_sales,
            IFNULL(SUM(discountOnTotalPrice),0) AS total_discount,
            IFNULL(SUM(vatOnTotalPrice),0) AS total_vat
        FROM sales
        WHERE sales_date BETWEEN ? AND ?
    ", [$start_date, $end_date])->getRowArray();

    // =====================================================
    // COST OF GOODS SOLD (COGS)
    // =====================================================
    $cogs = $this->db->query("
        SELECT
            IFNULL(SUM(sd.total_buy_price),0) AS total_cogs
        FROM sales_details sd
        INNER JOIN sales s
            ON s.sales_invoice = sd.sales_details_invoice
        WHERE s.sales_date BETWEEN ? AND ?
    ", [$start_date, $end_date])->getRowArray();

    // =====================================================
    // SALES RETURNS
    // =====================================================
    $returns = $this->db->query("
        SELECT
            IFNULL(SUM(rsd.total_sale_price),0) AS return_sales,
            IFNULL(SUM(rsd.total_buy_price),0) AS return_cost
        FROM return_sales_details rsd

        INNER JOIN return_sales rs
            ON rs.sales_invoice = rsd.sales_details_invoice

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
            date('Y-m-d', strtotime($end))
        ])->getRowArray();

    // =====================================================
    // FINAL CALCULATIONS
    // =====================================================

    // --------------------------------
    // GROSS SALES
    // --------------------------------
    $gross_sales = (float)$sales['gross_sales'];

    // --------------------------------
    // DISCOUNT
    // --------------------------------
    $total_discount = (float)$sales['total_discount'];

    // --------------------------------
    // VAT
    // --------------------------------
    $total_vat = (float)$sales['total_vat'];

    // --------------------------------
    // RETURNS
    // --------------------------------
    $return_sales = (float)$returns['return_sales'];

    // --------------------------------
    // RETURN COST
    // --------------------------------
    $return_cost = (float)$returns['return_cost'];

    // --------------------------------
    // COGS
    // --------------------------------
    $total_cogs = (float)$cogs['total_cogs'];

    // --------------------------------
    // EXPENSE
    // --------------------------------
    $total_expense = (float)$expense['total_expense'];

    // =====================================================
    // NET SALES
    //
    // Formula:
    // Gross Sales
    // - Discount
    // - VAT
    // - Returns
    // =====================================================
    $net_sales =
        $gross_sales
        - $total_discount
        - $total_vat
        - $return_sales;

    // =====================================================
    // NET COGS
    //
    // Return products come back to stock,
    // so return cost reduces COGS
    // =====================================================
    $net_cogs =
        $total_cogs
        - $return_cost;

    // =====================================================
    // GROSS PROFIT
    // =====================================================
    $gross_profit =
        $net_sales
        - $net_cogs;

    // =====================================================
    // NET PROFIT
    // =====================================================
    $net_profit =
        $gross_profit
        - $total_expense;

    // =====================================================
    // DATA FOR VIEW
    // =====================================================
    $data = [

        // SALES
        'gross_sales' => $gross_sales,

        // DISCOUNT
        'discount' => $total_discount,

        // VAT
        'vat' => $total_vat,

        // RETURNS
        'return_sales' => $return_sales,

        'return_cost' => $return_cost,

        // NET SALES
        'net_sales' => $net_sales,

        // COGS
        'total_cogs' => $net_cogs,

        // PROFITS
        'gross_profit' => $gross_profit,

        'net_profit' => $net_profit,

        // EXPENSES
        'expense' => $total_expense,

        // OTHER
        'credit' => 0,

        // DATE
        'start_date' => $start,

        'end_date' => $end,
    ];

    // =====================================================
    // PDF VIEW
    // =====================================================
    $html = view('report/profitloss_pdf', $data);

    // =====================================================
    // DOMPDF
    // =====================================================
    $dompdf = new \Dompdf\Dompdf();

    $dompdf->loadHtml($html);

    $dompdf->setPaper('A4', 'portrait');

    $dompdf->render();

    $dompdf->stream(
        "profit_loss.pdf",
        ["Attachment" => false]
    );

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