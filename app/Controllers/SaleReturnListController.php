<?php

namespace App\Controllers;

//use App\Models\NewProductAddModel;


use CodeIgniter\HTTP\IncomingRequest;

class SaleReturnListController extends BaseController
{
    // private $product_initial_stock_object;
    private $db;

    public function __construct()
    {
        //$this->product_initial_stock_object = new NewProductAddModel();
        $this->db = db_connect();
    }

    public function index()
    {
        $sql = "SELECT
    
                    s.sales_invoice,
                    s.sales_date,
    
                    s.seller_id,
                    u.user_name AS seller_name,
    
                    sd.total_sale,
    
                    s.product_vat,
                    s.product_discount,
                    s.other_charge_on_all,
    
                    s.paid_amount,
    
                    IFNULL(cd.customer_due,0) AS customer_due,
                    IFNULL(cd.total_due_paid,0) AS due_paid_amount,
    
                    (s.paid_amount + IFNULL(cd.total_due_paid,0)) AS total_paid,
    
                    s.due_amount,
    
                    CASE
                        WHEN s.customer_type REGEXP '^[0-9]+$'
                        THEN c.cus_first_name
                        ELSE s.customer_type
                    END AS customer_name,
    
                    CASE
                        WHEN s.customer_type = 'Walk-In-Customer' THEN 'Fully Paid'
                        WHEN IFNULL(cd.customer_due,0)=0 THEN 'Fully Paid'
                        ELSE 'Partially Paid'
                    END AS payment_status
    
                FROM sales s
    
                LEFT JOIN
                (
                    SELECT
    
                        sales_details_invoice,
    
                        SUM(total_sale_price) AS total_sale
    
                    FROM sales_details
    
                    GROUP BY sales_details_invoice
    
                ) sd
                    ON s.sales_invoice = sd.sales_details_invoice
    
                LEFT JOIN
                (
                    SELECT
    
                        due_invoice_no,
    
                        SUM(due_amount - due_paid_amount) AS customer_due,
    
                        SUM(due_paid_amount) AS total_due_paid
    
                    FROM customer_due
    
                    GROUP BY due_invoice_no
    
                ) cd
                    ON s.sales_invoice = cd.due_invoice_no
    
                LEFT JOIN customer c
                    ON c.customer_id = s.customer_type
                    AND s.customer_type REGEXP '^[0-9]+$'
    
                LEFT JOIN user u
                    ON u.user_id = s.seller_id
    
                WHERE s.return_status <> 'FULL'
    
                ORDER BY s.sales_date DESC,
                         s.sales_invoice DESC";
    
        $data['saleReturnList'] = $this->db->query($sql)->getResultArray();
    
        return view('return/sales_return_list', $data);
    }

    public function saleReturnListShow()
    {
          $sql = " SELECT 
                    rs.sales_invoice,
                    rs.return_date,
                    rsd.total_sale,
                    rs.other_charge_on_all,
                    rs.paid_amount,
                    IFNULL(rcd.customer_due, 0) AS customer_due,
                    IFNULL(rcd.total_due_paid, 0) AS due_paid_amount,
                    (rs.paid_amount + IFNULL(rcd.total_due_paid, 0)) AS total_paid,
                    rs.due_amount,
                    CASE 
                        WHEN rs.customer_type REGEXP '^[0-9]+$' THEN c.cus_first_name
                        ELSE rs.customer_type
                    END AS customer_name,
                    CASE
                        WHEN rs.customer_type = 'Walk-In-Customer' THEN 'Fully Paid'
                        WHEN IFNULL(rcd.customer_due, 0) = 0 THEN 'Fully Paid'
                        ELSE 'Partially Paid'
                    END AS payment_status
                FROM return_sales rs
                JOIN (
                    SELECT 
                        sales_details_invoice, 
                        SUM(total_sale_price) AS total_sale
                    FROM return_sales_details
                    GROUP BY sales_details_invoice
                ) rsd ON rs.sales_invoice = rsd.sales_details_invoice
                LEFT JOIN (
                    SELECT 
                        due_invoice_no, 
                        SUM(due_amount - due_paid_amount) AS customer_due,
                        SUM(due_paid_amount) AS total_due_paid
                    FROM return_customer_due
                    GROUP BY due_invoice_no
                ) rcd ON rs.sales_invoice = rcd.due_invoice_no
                LEFT JOIN customer c ON c.customer_id = rs.customer_type AND rs.customer_type REGEXP '^[0-9]+'
            ";

        $query = $this->db->query($sql);
        $data['saleReturnList'] = $query->getResultArray();
       // return view('report/sales_return_list', $data);
        return view('return/saleReturnListShow', $data);
    }

}
