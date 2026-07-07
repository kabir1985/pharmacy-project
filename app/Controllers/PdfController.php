<?php

namespace App\Controllers;

class PdfController extends BaseController
{
    protected $db;
    public function __construct()
    {
        // $this->load->library('Pdf');

        $this->db = db_connect();
    }

    public function invoice($salesId)
    {

        $data['invoice_info'] = $this->db->table('sales')
            ->select("
        sales.*,

        CASE
            WHEN sales.customer_type = 'Walk-In-Customer'
            THEN 'Walk-In-Customer'
            ELSE CONCAT(customer.cus_first_name, ' ', customer.cus_last_name)
        END as customer_name,
        customer.cus_phone,
        customer.cus_address
    ")
            ->join('customer', 'customer.customer_id = sales.customer_type', 'left')
            ->where('sales.sales_id', $salesId)
            ->get()
            ->getResultArray();

        if (!empty($data['invoice_info'])) {

            $sales_invoice_no = $data['invoice_info'][0]['sales_invoice'];

            // Fetch sales details with product info
            // $sql2 = "SELECT sd.*, pis.product_name, pis.tax_perchantage

            // $sql2 = "SELECT sd.*, pis.product_name
            //      FROM sales_details AS sd
            //      JOIN product_inital_stock AS pis ON pis.product_id = sd.product_id
            //      WHERE sd.sales_details_invoice = '" . $sales_invoice_no . "'";

            // $product_details = $this->db->query($sql2)->getResult('array');




    // Fetch sales, sales details with product info
            $sql2 = "SELECT  sd.*,
                            pis.product_name,
                            s.discountOnTotalPrice,
                            s.otherChargeOnTotalPrice

        FROM sales_details AS sd
        JOIN product_inital_stock AS pis 
            ON pis.product_id = sd.product_id
        JOIN sales AS s 
            ON s.sales_invoice = sd.sales_details_invoice
        WHERE sd.sales_details_invoice = '" . $sales_invoice_no . "'";

 $product_details = $this->db->query($sql2)->getResult('array');

            // Calculate VAT, Discount, and Subtotal per product
            foreach ($product_details as $key => $item) {
                $quantity = $item['product_quantity_sold'];
                $unit_price = $item['unit_price'];
                $vat_percent = $item['productwiseVatPercnt']; // assuming tax_perchantage stored per product
                $discount_percent = isset($item['productwiseDiscountPercnt']) ? $item['productwiseDiscountPercnt'] : 0;

                $base_total = $quantity * $unit_price;
                $vat_amount = $base_total * ($vat_percent / 100);
                $discount_amount = $base_total * ($discount_percent / 100);

                $subtotal = ($base_total + $vat_amount) - $discount_amount;

                $product_details[$key]['vat_amount'] = $vat_amount;
                $product_details[$key]['discount_amount'] = $discount_amount;
                $product_details[$key]['subtotal'] = $subtotal;
                $product_details[$key]['discount_percent'] = $discount_percent;
                $product_details[$key]['vat_percentage'] = $vat_percent;
            }

            $data['product_info'] = $product_details;

            // Load Dompdf
            $dompdf = new \Dompdf\Dompdf();
            $dompdf->loadHtml(view('report/sales-invoice', $data));
            $dompdf->setPaper('A4', 'portrait');
            $dompdf->render();

            $dompdf->stream("Invoice_" . $sales_invoice_no . ".pdf", ["Attachment" => false]);
            exit;
        }
    }

}
