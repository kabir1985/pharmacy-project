<?php

namespace App\Controllers;

class ProfitLossController extends BaseController
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
        // $sql = "
        //     SELECT
        //         piq.*,
        //         COALESCE(piq.productinitial_quantity,0)
        //         + COALESCE(ppd.new_purchased,0) AS total_stock

        //     FROM product_inital_stock piq

        //     LEFT JOIN (
        //         SELECT
        //             product_id,
        //             SUM(quantity_per_pack * box_quantity) AS new_purchased
        //         FROM product_purchase_details
        //         GROUP BY product_id
        //     ) ppd ON piq.product_id = ppd.product_id
        // ";

        // $data['stock_report_show'] = $this->db->query($sql)->getResultArray();

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
            IFNULL(SUM(total_amount),0) AS gross_sales,
            IFNULL(SUM(product_discount),0) AS product_discount,
            IFNULL(SUM(product_vat),0) AS total_vat,
            IFNULL(SUM(other_charge_on_all),0) AS other_charge
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
            date('Y-m-d', strtotime($end)),
        ])->getRowArray();

        // =====================================================
        // FINAL CALCULATIONS
        // =====================================================

       //=====================================================
// SALES
//=====================================================

$gross_sales       = (float)$sales['gross_sales'];
$product_discount  = (float)$sales['product_discount'];
$total_vat         = (float)$sales['total_vat'];
$other_charge      = (float)$sales['other_charge'];

//=====================================================
// RETURNS
//=====================================================

$return_sales = (float)$returns['return_sales'];
$return_cost  = (float)$returns['return_cost'];

//=====================================================
// COGS
//=====================================================

$total_cogs = (float)$cogs['total_cogs'];

//=====================================================
// EXPENSE
//=====================================================

$total_expense = (float)$expense['total_expense'];

//=====================================================
// OTHER INCOME & FINANCIAL COST
//=====================================================

$other_income  = 0;
$financial_cost = 0;

//=====================================================
// NET SALES
//=====================================================

// If total_amount ALREADY excludes VAT, use this:
$net_sales =
    $gross_sales
    - $product_discount
    - $return_sales
    + $other_charge;

/*
If your total_amount INCLUDES VAT, use this instead:

$net_sales =
    $gross_sales
    - $product_discount
    - $total_vat
    - $return_sales
    + $other_charge;
*/

//=====================================================
// NET COGS
//=====================================================

$net_cogs =
    $total_cogs
    - $return_cost;

//=====================================================
// GROSS PROFIT
//=====================================================

$gross_profit =
    $net_sales
    - $net_cogs;

//=====================================================
// OPERATING PROFIT
//=====================================================

$operating_profit =
    $gross_profit
    - $total_expense;

//=====================================================
// NET PROFIT
//=====================================================

$net_profit =
    $operating_profit
    + $other_income
    - $financial_cost;



    $data = [

        'gross_sales'       => $gross_sales,
    
        'product_discount'  => $product_discount,
    
        'vat'               => $total_vat,
    
        'other_charge'      => $other_charge,
    
        'return_sales'      => $return_sales,
    
        'return_cost'       => $return_cost,
    
        'net_sales'         => $net_sales,
    
        'total_cogs'        => $total_cogs,
    
        'net_cogs'          => $net_cogs,
    
        'gross_profit'      => $gross_profit,
    
        'expense'           => $total_expense,
    
        'operating_profit'  => $operating_profit,
    
        'other_income'      => $other_income,
    
        'financial_cost'    => $financial_cost,
    
        'net_profit'        => $net_profit,
    
        'start_date'        => $start,
    
        'end_date'          => $end,
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