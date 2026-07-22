<?php

namespace App\Controllers;

//use App\Models\NewProductAddModel;


use CodeIgniter\HTTP\IncomingRequest;

class SaleListController extends BaseController
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
    
                    customer.customer_name,
    
                    sale.total_sale,
    
                    s.product_vat,
                    s.other_charge_on_all,
    
                    s.paid_amount AS invoice_paid,
    
                    IFNULL(cd.total_due_paid,0) AS due_paid,
    
                    (s.paid_amount + IFNULL(cd.total_due_paid,0)) AS total_paid,
    
                    IFNULL(cd.customer_due,0) AS customer_due,
    
                    (
                        sale.total_sale
                        + IFNULL(s.product_vat,0)
                        + IFNULL(s.other_charge_on_all,0)
                    ) AS grand_total,
    
                    CASE
                        WHEN (
                            sale.total_sale
                            + IFNULL(s.product_vat,0)
                            + IFNULL(s.other_charge_on_all,0)
                        ) <=
                        (
                            s.paid_amount
                            + IFNULL(cd.total_due_paid,0)
                        )
                        THEN 'Fully Paid'
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
    
                ) sale
                    ON sale.sales_details_invoice = s.sales_invoice
    
                LEFT JOIN
                (
                    SELECT
    
                        due_invoice_no,
    
                        SUM(due_amount - due_paid_amount) AS customer_due,
    
                        SUM(due_paid_amount) AS total_due_paid
    
                    FROM customer_due
    
                    GROUP BY due_invoice_no
    
                ) cd
                    ON cd.due_invoice_no = s.sales_invoice
    
                LEFT JOIN
                (
                    SELECT
    
                        customer_id,
    
                        cus_first_name AS customer_name
    
                    FROM customer
    
                ) customer
                    ON customer.customer_id = s.customer_type
                    AND s.customer_type REGEXP '^[0-9]+$'
    
                LEFT JOIN user u
                    ON u.user_id = s.seller_id
    
                ORDER BY s.sales_date DESC, s.sales_invoice DESC";
    
        $data['saleList'] = $this->db->query($sql)->getResultArray();
    
        return view('pos/salelistShow', $data);
    }

}
