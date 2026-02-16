<?php
namespace App\Controllers;
//use App\Models\NewProductAddModel;
use CodeIgniter\HTTP\IncomingRequest;
class SaleSummeryReport extends BaseController
{
  // private $product_initial_stock_object;
  private $db;
  public function __construct()
  {
    $this->db = db_connect();
  }
  public function index()
  {
    $sql = " SELECT 
                            s.sales_invoice,
                            s.sales_date,
                            s.seller_id,
                            u.user_name AS seller_name,    -- ✅ Added seller name
                            sd.total_sale,
                            sd.productwiseVatPercnt,
                            s.discountOnTotalPrice,
                            s.vatOnTotalPrice,
                            s.paid_amount,
                            IFNULL(cd.customer_due, 0) AS customer_due,
                            IFNULL(cd.total_due_paid, 0) AS due_paid_amount,
                            (s.paid_amount + IFNULL(cd.total_due_paid, 0)) AS total_paid,
                            s.due_amount,
                            CASE 
                                WHEN s.customer_type REGEXP '^[0-9]+$' THEN c.cus_first_name
                                ELSE s.customer_type
                            END AS customer_name,
                            CASE
                                WHEN s.customer_type = 'Walk-In-Customer' THEN 'Fully Paid'
                                WHEN IFNULL(cd.customer_due, 0) = 0 THEN 'Fully Paid'
                                ELSE 'Partially Paid'
                            END AS payment_status
                        FROM sales s
                        JOIN (
                            SELECT 
                                sales_details_invoice, 
                                SUM(total_sale_price) AS total_sale, 
                                SUM(productwiseVatPercnt) AS productwiseVatPercnt
                            FROM sales_details
                            GROUP BY sales_details_invoice
                        ) sd ON s.sales_invoice = sd.sales_details_invoice
                        LEFT JOIN (
                            SELECT 
                                due_invoice_no, 
                                SUM(due_amount - due_paid_amount) AS customer_due,
                                SUM(due_paid_amount) AS total_due_paid
                            FROM customer_due
                            GROUP BY due_invoice_no
                        ) cd ON s.sales_invoice = cd.due_invoice_no
                        LEFT JOIN customer c 
                            ON c.customer_id = s.customer_type AND s.customer_type REGEXP '^[0-9]+'
                        LEFT JOIN `user` u 
                            ON u.user_id = s.seller_id ";
    $query = $this->db->query($sql);
    $data['sales_summery_report_show'] = $query->getResultArray();

    return view('report/sale_summery_report', $data);

    // return view('pos/salelistShow', $data);


  }

}
