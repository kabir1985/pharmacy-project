<?php
namespace App\Controllers;

use App\Models\CustomerDueModel;
use App\Models\ProductSaleDetailsModel;
use App\Models\ProductSaleModel;
use App\Models\ReturnCustomerDueModel;
use App\Models\ReturnSaleDetailsModel;
use App\Models\ReturnSaleModel;

class ReturnController extends BaseController
{

    private $db;
    public function __construct()
    {
        $this->db = db_connect();
    }

    // Get products for an invoice
    public function getProducts()
    {
        $db = \Config\Database::connect();

        $invoice = $this->request->getPost('invoice');

        $builder = $db->query("
                    SELECT
                        sd.sales_details_invoice,
                        sd.product_id,
                        p.product_name,
                        sd.unit_price,
                        sd.total_buy_price,
                        sd.total_sale_price,
                        sd.product_quantity_sold AS sold_qty,

                        IFNULL(r.return_qty,0) AS return_qty,
                        sd.product_quantity_sold - IFNULL(r.return_qty, 0) AS remaining_qty,

                        CASE
                            WHEN IFNULL(r.return_qty,0) = 0 THEN 'ACTIVE'
                            WHEN IFNULL(r.return_qty,0) < sd.product_quantity_sold THEN 'PARTIAL'
                            WHEN IFNULL(r.return_qty,0) = sd.product_quantity_sold THEN 'FULL'
                        END AS return_status

                    FROM sales_details sd

                    LEFT JOIN product_inital_stock p
                        ON p.product_id = sd.product_id

                    LEFT JOIN (
                        SELECT
                            sales_details_invoice,
                            product_id,
                            SUM(return_qty) AS return_qty
                        FROM return_sales_details
                        GROUP BY sales_details_invoice, product_id
                    ) r
                        ON r.sales_details_invoice = sd.sales_details_invoice
                        AND r.product_id = sd.product_id

                    WHERE sd.sales_details_invoice = ?
                ", [$invoice]);

        $products = $builder->getResultArray();

        return $this->response->setJSON($products);

    }

    public function process()
    {

        $db = \Config\Database::connect();

        $ProductSaleModel = new ProductSaleModel();
        $ProductSaleDetailsModel = new ProductSaleDetailsModel();
        $CustomerDueModel = new CustomerDueModel();

        $returnSaleModel = new ReturnSaleModel();
        $returnSaleDetailsModel = new ReturnSaleDetailsModel();
        $returnCustomerDueModel = new ReturnCustomerDueModel();

        $invoice = $this->request->getPost('return_invoice');
        $return_qty = $this->request->getPost('return_qty');
        $reason = $this->request->getPost('reason');

        // ---------------- VALIDATION ----------------
        if (!$invoice || empty($return_qty)) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Invoice and return quantities are required.',
            ]);
        }

        $saleDetails = $ProductSaleDetailsModel
            ->where('sales_details_invoice', $invoice)
            ->findAll();

        if (!$saleDetails) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'No sale details found.',
            ]);
        }

        // ---------------- VALIDATE BEFORE TRANSACTION ----------------
        foreach ($return_qty as $pid => $qty) {

            if ($qty <= 0) {
                continue;
            }

            $product = $db->table('sales_details')
                ->where('sales_details_invoice', $invoice)
                ->where('product_id', $pid)
                ->get()
                ->getRowArray();

            if (!$product) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => "Product not found: $pid",
                ]);
            }

            // already returned qty
            $returned = $db->table('return_sales_details')
                ->selectSum('return_qty')
                ->where('sales_details_invoice', $invoice)
                ->where('product_id', $pid)
                ->get()
                ->getRow()
                ->return_qty ?? 0;

            $available = $product['product_quantity_sold'] - $returned;

            if ($qty > $available) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => "Return qty exceeds available qty for product ID: $pid",
                ]);
            }
        }

        // ---------------- GET MASTER DATA ----------------
        $sale = $ProductSaleModel
            ->where('sales_invoice', $invoice)
            ->first();

        if (!$sale) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Sale not found.',
            ]);
        }

        // ---------------- FULL OR PARTIAL ----------------
        $totalSold = 0;
        $totalReturn = 0;

        foreach ($saleDetails as $d) {
            $pid = $d['product_id'];
            $totalSold += $d['product_quantity_sold'];
            $totalReturn += $return_qty[$pid] ?? 0;
        }

        $isFullReturn = ($totalSold == $totalReturn);

        // ---------------- START TRANSACTION ----------------
        $db->transStart();

        // ---------------- INSERT RETURN MASTER (NO DUPLICATE) ----------------
        $existingReturn = $returnSaleModel
            ->where('sales_invoice', $invoice)
            ->first();

        if (!$existingReturn) {
            $returnSaleModel->insert([
                'sales_invoice' => $sale['sales_invoice'],
                'customer_type' => $sale['customer_type'],
                'return_date' => $sale['sales_date'],
                'payment_type' => $sale['payment_type'],
                'product_discount' => $sale['product_discount'],
                'product_vat' => $sale['product_vat'],
                //'discount_on_all' => $sale['discount_on_all'],
                'other_charge_on_all' => $sale['other_charge_on_all'],
                // 'discountOnTotalPrice' => $sale['discountOnTotalPrice'],
                // 'vatOnTotalPrice' => $sale['vatOnTotalPrice'],
                'paid_amount' => $sale['paid_amount'],
                'due_amount' => $sale['due_amount'],
                'return_by' => $sale['seller_id'] ?? 0,
                'return_type' => $isFullReturn ? 'FULL' : 'PARTIAL',
                'return_reason' => $reason,
            ]);
        }

        // ---------------- INSERT RETURN DETAILS + STOCK UPDATE ----------------
        foreach ($saleDetails as $detail) {

            $pid = $detail['product_id'];
            $qty = $return_qty[$pid] ?? 0;

            if ($qty <= 0) {
                continue;
            }

            // insert return details
            $returnSaleDetailsModel->insert([
                'sales_details_invoice' => $detail['sales_details_invoice'],
                'product_id' => $pid,
                'return_qty' => $qty,
                'unit_price' => $detail['unit_price'],
                'total_buy_price' => $detail['total_buy_price'],
                'total_sale_price' => $detail['total_sale_price'],
            ]);

            // STOCK UPDATE// calculating stock by run time so do not need this code
            // $db->table('product_inital_stock')
            //     ->set('productinitial_quantity', 'productinitial_quantity + ' . $qty, false)
            //     ->where('product_id', $pid)
            //     ->update();
        }

        // ---------------- CUSTOMER DUE RETURN ----------------
        $CustomerDue = $CustomerDueModel
            ->where('due_invoice_no', $invoice)
            ->findAll();

        foreach ($CustomerDue as $due) {
            $returnCustomerDueModel->insert([
                'return_due_date' => date('d-m-Y'),
                'customer_id' => $due['customer_id'],
                'due_invoice_no' => $due['due_invoice_no'],
                'due_amount' => $due['due_amount'],
                'due_paid_amount' => $due['due_paid_amount'],
                'current_balance' => $due['current_balance'],
            ]);
        }

        // ---------------- UPDATE/DELETE SALE ----------------
        if ($isFullReturn) {

            // $ProductSaleDetailsModel->where('sales_details_invoice', $invoice)->delete();
            // $CustomerDueModel->where('due_invoice_no', $invoice)->delete();
            // $ProductSaleModel->where('sales_invoice', $invoice)->delete();
            $ProductSaleModel
                ->where('sales_invoice', $invoice)
                ->set('return_status', 'FULL')
                ->update();

        } else {

            $ProductSaleModel
                ->where('sales_invoice', $invoice)
                ->set('return_status', 'PARTIAL')
                ->update();
        }

        // ---------------- COMPLETE TRANSACTION ----------------
        $db->transComplete();

        if ($db->transStatus() === false) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Transaction failed.',
            ]);
        }

        return $this->response->setJSON([
            'status' => 'success',
            'message' => $isFullReturn
            ? 'Full return completed successfully.'
            : 'Partial return completed successfully.',
        ]);
    }
    ////////////////////////////////////////////////////////////////////////////

}
