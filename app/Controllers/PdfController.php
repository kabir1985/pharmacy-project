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

//   public function invoice($salesId)
// {
//     // Invoice Header Information
//     $invoice = $this->db->table('sales')
//         ->select("
//             sales.*,
//             CASE
//                 WHEN sales.customer_type = 'Walk-In-Customer'
//                 THEN 'Walk-In-Customer'
//                 ELSE CONCAT(customer.cus_first_name,' ',customer.cus_last_name)
//             END AS customer_name,
//             customer.cus_phone,
//             customer.cus_address
//         ")
//         ->join('customer', 'customer.customer_id = sales.customer_id', 'left')
//         ->where('sales.sales_id', $salesId)
//         ->get()
//         ->getRowArray();

//     if (!$invoice) {
//         throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Invoice not found.');
//     }

//     $products = $this->db->table('sales_details sd')
//         ->select("sd.*, pis.product_name")
//         ->join('product_inital_stock pis', 'pis.product_id = sd.product_id')
//         ->where('sd.sales_details_invoice', $invoice['sales_invoice'])
//         ->get()
//         ->getResultArray();

//     $data = [
//         'invoice_info' => [$invoice],
//         'product_info' => $products
//     ];

//     return view('report/sales-invoice_pos', $data);
// }


// public function invoice($salesId)
// {
//     // Invoice Header
//     $invoice = $this->db->table('sales')
//         ->select("
//             sales.*,
//             CASE
//                 WHEN sales.customer_id IS NULL
//                 THEN 'Walk-In Customer'
//                 ELSE customer.customer_name
//             END AS customer_name,
//             customer.phone,
//             customer.address
//         ")
//         ->join('customer', 'customer.customer_id = sales.customer_id', 'left')
//         ->where('sales.sales_id', $salesId)
//         ->get()
//         ->getRowArray();

//     if (!$invoice) {
//         throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Invoice not found.');
//     }

//     // Invoice Products
//     $products = $this->db->table('sales_details sd')
//         ->select("
//             sd.*,
//             pis.product_name
//         ")
//         ->join('product_inital_stock pis', 'pis.product_id = sd.product_id', 'left')
//         ->where('sd.sales_details_invoice', $invoice['sales_invoice'])
//         ->get()
//         ->getResultArray();

//     return view('report/sales-invoice_pos', [
//         'invoice_info' => $invoice,
//         'product_info' => $products
//     ]);
// }
// public function invoice($salesId)
// {
//     // Invoice Header
//     $invoice = $this->db->table('sales')
//         ->select("
//             sales.*,
//             IF(
//                 sales.customer_id IS NULL,
//                 'Walk-In Customer',
//                 customer.customer_name
//             ) AS customer_name,
//             customer.phone,
//             customer.address
//         ")
//         ->join('customer', 'customer.customer_id = sales.customer_id', 'left')
//         ->where('sales.sales_id', $salesId)
//         ->get()
//         ->getRowArray();

//     if (!$invoice) {
//         throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Invoice not found.');
//     }

//     // Invoice Products
//     $products = $this->db->table('sales_details sd')
//         ->select("
//             sd.*,
//             pis.product_name
//         ")
//         ->join('product_inital_stock pis', 'pis.product_id = sd.product_id')
//         ->where('sd.sales_details_invoice', $invoice['sales_invoice'])
//         ->get()
//         ->getResultArray();

//     return view('report/sales-invoice_pos', [
//         'invoice_info' => [$invoice],
//         'product_info' => $products
//     ]);
// }



public function invoice($salesId)
{
    // ==========================
    // Invoice Header
    // ==========================
    $invoice = $this->db->table('sales')
        ->select("
            sales.*,
            IF(
                sales.customer_id IS NULL,
                'Walk-In Customer',
                customer.customer_name
            ) AS customer_name,
            customer.phone,
            customer.address
        ")
        ->join('customer', 'customer.customer_id = sales.customer_id', 'left')
        ->where('sales.sales_id', $salesId)
        ->get()
        ->getRowArray();

    if (!$invoice) {
        throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Invoice not found.');
    }

    // ==========================
    // Invoice Products
    // ==========================
    $products = $this->db->table('sales_details sd')
        ->select("
            sd.sales_details_id,
            sd.product_id,
            p.product_name,
            p.barcode,

            sd.product_quantity_sold,
            sd.returned_qty,
            sd.unit_price,
            sd.total_sale_price,
            sd.total_buy_price
        ")
        ->join('products p', 'p.product_id = sd.product_id', 'left')
        ->where('sd.sales_id', $salesId)
        ->orderBy('sd.sales_details_id', 'ASC')
        ->get()
        ->getResultArray();

    // ==========================
    // Invoice Due
    // ==========================
    $due = $this->db->table('customer_due')
        ->select("
            COALESCE(SUM(due_amount),0) AS due_amount,
            COALESCE(SUM(paid_amount),0) AS paid_amount
        ", false)
        ->where('sales_id', $salesId)
        ->get()
        ->getRowArray();

    $invoiceDue = 0;

    if ($due) {
        $invoiceDue = max(
            0,
            (float)$due['due_amount'] - (float)$due['paid_amount']
        );
    }

    return view('report/sales-invoice_pos', [
        'invoice_info' => [$invoice],
        'product_info' => $products,
        'invoice_due'  => $invoiceDue,
    ]);
}

}