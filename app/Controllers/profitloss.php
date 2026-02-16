<?php
namespace App\Controllers;

use CodeIgniter\HTTP\IncomingRequest;

class profitloss extends BaseController
{
   private $db;


   public function __construct()
   {
      //$this->product_initial_stock_object = new NewProductAddModel();
      $this->db = db_connect();
   }

   public function index()
   {

      $sql = "SELECT piq.*, productinitial_quantity + IFNULL(ppd.new_purchased,0) AS total_stock
      FROM product_inital_stock as piq
      LEFT JOIN (SELECT product_id,SUM(quantity) as new_purchased
      FROM product_purchase_details
      GROUP BY product_id) as ppd
      ON piq.product_id = ppd.product_id";

      //$data['product_initial_stock_show'] = $this->product_initial_stock_object->findAll();
      $data['stock_report_show'] = $this->db->query($sql)->getResult('array');
      return view('report/profitloss_report', $data);
   }

   function profitlosspdfcreate()
   {
      $start_date_input = $this->request->getVar('start_date');
      $end_date_input = $this->request->getVar('end_date');

      if (!$start_date_input || !$end_date_input) {
         return redirect()->back()->with('error', 'Date range is required');
      }

      $start_date = date('Y-m-d', strtotime($start_date_input));
      $end_date = date('Y-m-d', strtotime($end_date_input));

      $db = \Config\Database::connect();

      // Main sales + expense query
      $query = $db->query("
        SELECT
            IFNULL(SUM(sd.total_sale_price), 0) AS total_sales,
            IFNULL(SUM(sd.total_buy_price), 0) AS total_cogs,
            (
                SELECT IFNULL(SUM(s.discountOnTotalPrice), 0) 
                FROM sales s 
                WHERE s.sales_date BETWEEN '$start_date' AND '$end_date'
            ) AS discountOnTotalPrice,
            (
                SELECT IFNULL(SUM(s.vatOnTotalPrice), 0) 
                FROM sales s 
                WHERE s.sales_date BETWEEN '$start_date' AND '$end_date'
            ) AS vatOnTotalPrice,
            (
                SELECT IFNULL(SUM(e.expense_amount), 0)
                FROM expense e 
                WHERE STR_TO_DATE(e.expense_date, '%d-%m-%Y') 
                BETWEEN '$start_date' AND '$end_date'
            ) AS general_expense
        FROM sales_details sd
        JOIN sales s ON sd.sales_details_invoice = s.sales_invoice
        WHERE s.sales_date BETWEEN '$start_date' AND '$end_date'
    ");
      $data = $query->getRowArray();

      // Get total credit sales from customer_due table
      $creditQuery = $db->query("
        SELECT IFNULL(SUM(due_amount - due_paid_amount), 0) AS total_credit_sales
        FROM customer_due
        WHERE due_date BETWEEN '$start_date' AND '$end_date'
    ");
      $creditResult = $creditQuery->getRowArray();
      $data['total_credit_sales'] = $creditResult['total_credit_sales'];

      // Calculations
      $gross_profit = $data['total_sales'] - $data['total_cogs'];
      $net_profit = $gross_profit - $data['general_expense'] - $data['discountOnTotalPrice'] - $data['vatOnTotalPrice'];

      $data['gross_profit'] = $gross_profit;
      $data['net_profit'] = $net_profit;
      $data['start_date'] = $start_date;
      $data['end_date'] = $end_date;

      // Load view and generate PDF
      $html = view('report/profitloss_pdf', $data);
      $dompdf = new \Dompdf\Dompdf();
      $dompdf->loadHtml($html);
      $dompdf->setPaper('A4', 'portrait');
      $dompdf->render();
      $dompdf->stream("profit_loss_statement.pdf", array("Attachment" => false));
      exit(0);

   }

}
