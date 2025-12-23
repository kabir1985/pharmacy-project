<?php

namespace App\Controllers;

use App\Models\ProductCategoryModel;

use CodeIgniter\HTTP\IncomingRequest;
use Dompdf\Dompdf;

class PdfController extends BaseController
{
    protected $db;
    public function __construct()
    {
        // $this->load->library('Pdf');

        $this->db = db_connect();
    }

    function index($invoice)
    {

        // $dompdf = new \Dompdf\Dompdf();
        // $dompdf->loadHtml(view('report/pdftest'));
        // $dompdf->setPaper('A4', 'landscape');

        // $dompdf->render();
        // $dompdf->stream("dompdf_out.pdf", array("Attachment" => false));
        // exit(0);
    }


    // function invoice($salesId)
    // {
    //     // $data = ["name"=>"$salesId"];
    //     // $data = $salesId;

    //     //  print_r(json_decode($salesId));
    //     // exit('tst');


    //     $sql1 = "SELECT * FROM sales  WHERE sales_id = " . $salesId;
    //     $data['invoice_info'] = $this->db->query($sql1)->getResult('array');


    //     if ($data['invoice_info'] > 0) {
    //         $sql2 = "SELECT sd.*, pis.product_name,pis.tax_perchantage
    //     FROM sales_details AS sd, product_inital_stock AS pis
    //     WHERE sales_details_invoice = '" . $data['invoice_info'][0]["sales_invoice"] . "'" .
    //             "AND pis.product_id = sd.product_id";

    //         $data['product_info'] = $this->db->query($sql2)->getResult('array');

    //         $dompdf = new \Dompdf\Dompdf();

    //         $dompdf->loadHtml(view('report/sales-invoice', $data));
    //         $dompdf->setPaper('A4', 'portrait');

    //         $dompdf->render();
    //         $dompdf->stream("dompdf_out.pdf", array("Attachment" => false));
    //         exit(0);
    //     }
    // }





    public function invoice($salesId)
{
    // Fetch sales info
    $sql1 = "SELECT * FROM sales WHERE sales_id = " . $salesId;
    $data['invoice_info'] = $this->db->query($sql1)->getResult('array');

    if (!empty($data['invoice_info'])) {

        $sales_invoice_no = $data['invoice_info'][0]['sales_invoice'];

        // Fetch sales details with product info
        $sql2 = "SELECT sd.*, pis.product_name, pis.tax_perchantage
                 FROM sales_details AS sd
                 JOIN product_inital_stock AS pis ON pis.product_id = sd.product_id
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