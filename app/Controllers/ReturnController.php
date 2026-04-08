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
        $invoice = $this->request->getPost('invoice');

        $products = $this->db->table('sales_details')
            ->where('sales_details_invoice', $invoice)
            ->get()
            ->getResultArray();

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
    
        $invoice    = $this->request->getPost('return_invoice');
        $return_qty = $this->request->getPost('return_qty'); // array: product_id => qty
        $reason     = $this->request->getPost('reason');
    ///########################## validation #############################################///

        // Basic validation
        if (!$invoice || empty($return_qty)) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Invoice and return quantities are required.',
            ]);
        }
    
        // Validate each return quantity
        foreach ($return_qty as $product_id => $qty) {
    
            if ($qty <= 0) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Return quantity must be at least 1 for product ID: ' . $product_id,
                ]);
            }
    
            $product = $db->table('sales_details')
                ->where('sales_details_invoice', $invoice)
                ->where('product_id', $product_id)
                ->get()
                ->getRowArray();
    
            if (!$product) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Product not found for product ID: ' . $product_id,
                ]);
            }
    
            if ($qty > $product['product_quantity_sold']) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Return quantity cannot exceed sold quantity for product ID: ' . $product_id,
                ]);
            }
        }
        //#################################################################################


        $db->transStart();

        // ✅ Fetch data from sales
        $sale = $ProductSaleModel->where('sales_invoice', $invoice)->first();
        // ✅ Fetch data from sales_details
        $saleDetails = $ProductSaleDetailsModel->where('sales_details_invoice', $invoice)->findAll();

        // ✅ Fetch data from customer_due
        $CustomerDue = $CustomerDueModel->where('due_invoice_no', $invoice)->findAll();

        if (!$sale) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Sale not found.']);
        }

        // ✅ Insert return sale
        $returnSaleModel->insert([
            'sales_invoice' => $sale['sales_invoice'],
            'customer_type' => $sale['customer_type'],
            'sales_date' => $sale['sales_date'],
            'payment_type' => $sale['payment_type'],
            'discountOnTotalPrice' => $sale['discountOnTotalPrice'],
            'vatOnTotalPrice' => $sale['vatOnTotalPrice'],
            'paid_amount' => $sale['paid_amount'],
            'due_amount' => $sale['due_amount'],
            'return_by' => $sale['seller_id'] ?? 0,
        ]);


        // ✅ Insert return details + restore stock
       // foreach ($saleDetails as $detail) {
        foreach ($saleDetails as $detail) {

            $pid = $detail['product_id'];
            $qty = $return_qty[$pid] ?? 0;
        
            if ($qty > 0) {

            $returnSaleDetailsModel->insert([
                'sales_details_invoice' => $detail['sales_details_invoice'],
                'product_id' => $detail['product_id'],
                'product_quantity_sold' => $detail['product_quantity_sold'],
                'unit_price' => $detail['unit_price'],
                'total_buy_price' => $detail['total_buy_price'],
                'total_sale_price' => $detail['total_sale_price'],
                'productwiseVatPercnt' => $detail['productwiseVatPercnt'],
                'productwiseDiscountPercnt' => $detail['productwiseDiscountPercnt'],
            ]);

            // // ✅ RESTORE STOCK
            // $db->table('products')
            //     ->where('product_id', $detail['product_id'])
            //     ->set('quantity', 'quantity + ' . (int) $detail['product_quantity_sold'], false)
            //     ->update();
        }
       }

        // ✅ Insert return due
        foreach ($CustomerDue as $dueList) {
            $returnCustomerDueModel->insert([
                'return_due_date' => date('d-m-Y'),
                'customer_id' => $dueList['customer_id'],
                'due_invoice_no' => $dueList['due_invoice_no'],
                'due_amount' => $dueList['due_amount'],
                'due_paid_amount' => $dueList['due_paid_amount'],
                'current_balance' => $dueList['current_balance'],
            ]);
        }

        // ✅ DELETE AFTER LOOP (IMPORTANT)
        $ProductSaleDetailsModel->where('sales_details_invoice', $invoice)->delete();
        $CustomerDueModel->where('due_invoice_no', $invoice)->delete();
        $ProductSaleModel->where('sales_invoice', $invoice)->delete();

        $db->transComplete();

        if ($db->transStatus() === false) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Transaction failed.',
            ]);
        }

        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Return sale inserted successfully.',
        ]);
    }

}
