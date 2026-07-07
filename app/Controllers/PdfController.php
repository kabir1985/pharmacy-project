<?php

namespace App\Controllers;

use Dompdf\Dompdf;
use Dompdf\Options;

class PdfController extends BaseController
{
    protected $db;

    public function __construct()
    {
        $this->db = db_connect();
    }

    public function invoice($salesId)
    {
        // Invoice Header Information
        $invoice = $this->db->table('sales')
            ->select("
                sales.*,

                CASE
                    WHEN sales.customer_type = 'Walk-In-Customer'
                    THEN 'Walk-In-Customer'
                    ELSE CONCAT(customer.cus_first_name,' ',customer.cus_last_name)
                END AS customer_name,

                customer.cus_phone,
                customer.cus_address
            ")
            ->join('customer', 'customer.customer_id = sales.customer_type', 'left')
            ->where('sales.sales_id', $salesId)
            ->get()
            ->getRowArray();

        if (!$invoice) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Invoice not found.');
        }

        // Product Details
        $products = $this->db->table('sales_details sd')
            ->select("
                sd.*,
                pis.product_name
            ")
            ->join('product_inital_stock pis', 'pis.product_id = sd.product_id')
            ->where('sd.sales_details_invoice', $invoice['sales_invoice'])
            ->get()
            ->getResultArray();

        $data = [
            'invoice_info' => [$invoice],
            'product_info' => $products
        ];

        // Dompdf Options
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);

        $dompdf = new Dompdf($options);

        $dompdf->loadHtml(view('report/sales-invoice', $data));
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $dompdf->stream(
            'Invoice_' . $invoice['sales_invoice'] . '.pdf',
            ['Attachment' => false]
        );

        exit;
    }
}