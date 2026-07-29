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
    private $ProductSaleModel;
    private $ProductSaleDetailsModel;
    private $CustomerDueModel;
    private $ReturnSaleModel;
    private $ReturnSaleDetailsModel;
    private $ReturnCustomerDueModel;

    public function __construct()
    {
        $this->db = db_connect();

        $this->ProductSaleModel = new ProductSaleModel();
        $this->ProductSaleDetailsModel = new ProductSaleDetailsModel();
        $this->CustomerDueModel = new CustomerDueModel();

        $this->ReturnSaleModel = new ReturnSaleModel();
        $this->ReturnSaleDetailsModel = new ReturnSaleDetailsModel();
        $this->ReturnCustomerDueModel = new ReturnCustomerDueModel();
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

    // public function process()
    // {
    //     $invoice = $this->request->getPost('return_invoice');
    //     $return_qty = $this->request->getPost('return_qty');
    //     $reason = $this->request->getPost('reason');

    //     // ---------------- VALIDATION ----------------
    //     if (!$invoice || empty($return_qty)) {
    //         return $this->response->setJSON([
    //             'status' => 'error',
    //             'message' => 'Invoice and return quantities are required.',
    //         ]);
    //     }

    //     $saleDetails = $this->ProductSaleDetailsModel
    //         ->where('sales_details_invoice', $invoice)
    //         ->findAll();

    //     if (!$saleDetails) {
    //         return $this->response->setJSON([
    //             'status' => 'error',
    //             'message' => 'No sale details found.',
    //         ]);
    //     }

    //     // ---------------- VALIDATE BEFORE TRANSACTION ----------------
    //     foreach ($return_qty as $pid => $qty) {

    //         if ($qty <= 0) {
    //             continue;
    //         }

    //         $product = $this->db->table('sales_details')
    //             ->where('sales_details_invoice', $invoice)
    //             ->where('product_id', $pid)
    //             ->get()
    //             ->getRowArray();

    //         if (!$product) {
    //             return $this->response->setJSON([
    //                 'status' => 'error',
    //                 'message' => "Product not found: $pid",
    //             ]);
    //         }

    //         // already returned qty
    //         $returned = $db->table('return_sales_details')
    //             ->selectSum('return_qty')
    //             ->where('sales_details_invoice', $invoice)
    //             ->where('product_id', $pid)
    //             ->get()
    //             ->getRow()
    //             ->return_qty ?? 0;

    //         $available = $product['product_quantity_sold'] - $returned;

    //         if ($qty > $available) {
    //             return $this->response->setJSON([
    //                 'status' => 'error',
    //                 'message' => "Return qty exceeds available qty for product ID: $pid",
    //             ]);
    //         }
    //     }

    //     // ---------------- GET MASTER DATA ----------------
    //     $sale = $this->ProductSaleModel
    //         ->where('sales_invoice', $invoice)
    //         ->first();

    //     if (!$sale) {
    //         return $this->response->setJSON([
    //             'status' => 'error',
    //             'message' => 'Sale not found.',
    //         ]);
    //     }

    //     // ---------------- FULL OR PARTIAL ----------------
    //     $totalSold = 0;
    //     $totalReturn = 0;

    //     foreach ($saleDetails as $d) {
    //         $pid = $d['product_id'];
    //         $totalSold += $d['product_quantity_sold'];
    //         $totalReturn += $return_qty[$pid] ?? 0;
    //     }

    //     $isFullReturn = ($totalSold == $totalReturn);

    //     // ---------------- START TRANSACTION ----------------
    //     $db->transStart();

    //     // ---------------- INSERT RETURN MASTER (NO DUPLICATE) ----------------
    //     $existingReturn = $this->returnSaleModel
    //         ->where('sales_invoice', $invoice)
    //         ->first();

    //     if (!$existingReturn) {
    //         $returnSaleModel->insert([
    //             'sales_invoice' => $sale['sales_invoice'],
    //             'customer_type' => $sale['customer_type'],
    //             'return_date' => $sale['sales_date'],
    //             'payment_type' => $sale['payment_type'],
    //             'product_discount' => $sale['product_discount'],
    //             'product_vat' => $sale['product_vat'],
    //             //'discount_on_all' => $sale['discount_on_all'],
    //             'other_charge_on_all' => $sale['other_charge_on_all'],
    //             // 'discountOnTotalPrice' => $sale['discountOnTotalPrice'],
    //             // 'vatOnTotalPrice' => $sale['vatOnTotalPrice'],
    //             'paid_amount' => $sale['paid_amount'],
    //             'due_amount' => $sale['due_amount'],
    //             'return_by' => $sale['seller_id'] ?? 0,
    //             'return_type' => $isFullReturn ? 'FULL' : 'PARTIAL',
    //             'return_reason' => $reason,
    //         ]);
    //     }

    //     // ---------------- INSERT RETURN DETAILS + STOCK UPDATE ----------------
    //     foreach ($saleDetails as $detail) {

    //         $pid = $detail['product_id'];
    //         $qty = $return_qty[$pid] ?? 0;

    //         if ($qty <= 0) {
    //             continue;
    //         }

    //         // insert return details
    //         $this->returnSaleDetailsModel->insert([
    //             'sales_details_invoice' => $detail['sales_details_invoice'],
    //             'product_id' => $pid,
    //             'return_qty' => $qty,
    //             'unit_price' => $detail['unit_price'],
    //             'total_buy_price' => $detail['total_buy_price'],
    //             'total_sale_price' => $detail['total_sale_price'],
    //         ]);

    //     }

    //     // ---------------- CUSTOMER DUE RETURN ----------------
    //     $CustomerDue = $this->CustomerDueModel
    //         ->where('due_invoice_no', $invoice)
    //         ->findAll();

    //     foreach ($CustomerDue as $due) {
    //         $this->returnCustomerDueModel->insert([
    //             'return_due_date' => date('d-m-Y'),
    //             'customer_id' => $due['customer_id'],
    //             'due_invoice_no' => $due['due_invoice_no'],
    //             'due_amount' => $due['due_amount'],
    //             'due_paid_amount' => $due['due_paid_amount'],
    //             'current_balance' => $due['current_balance'],
    //         ]);
    //     }

    //     // ---------------- UPDATE/DELETE SALE ----------------
    //     if ($isFullReturn) {
    //         $this->ProductSaleModel
    //             ->where('sales_invoice', $invoice)
    //             ->set('return_status', 'FULL')
    //             ->update();

    //     } else {

    //         $this->ProductSaleModel
    //             ->where('sales_invoice', $invoice)
    //             ->set('return_status', 'PARTIAL')
    //             ->update();
    //     }

    //     // ---------------- COMPLETE TRANSACTION ----------------
    //     $db->transComplete();

    //     if ($db->transStatus() === false) {
    //         return $this->response->setJSON([
    //             'status' => 'error',
    //             'message' => 'Transaction failed.',
    //         ]);
    //     }

    //     return $this->response->setJSON([
    //         'status' => 'success',
    //         'message' => $isFullReturn
    //         ? 'Full return completed successfully.'
    //         : 'Partial return completed successfully.',
    //     ]);
    // }
    ////////////////////////////////////////////////////////////////////////////

    public function process()
    {

        // এই Part-1 এ যা সম্পন্ন হয়েছে
        // ✅ Invoice Validation
        // ✅ Sale Validation
        // ✅ Full Returned Check
        // ✅ Sale Details Load
        // ✅ Qty Validation
        // ✅ Multiple Return Protection (returned_qty)
        // ✅ Full / Partial Return Detection
        // ✅ Transaction Start

        $db = \Config\Database::connect();

        $invoice = trim($this->request->getPost('return_invoice'));
        $returnQty = $this->request->getPost('return_qty');
        $reason = trim($this->request->getPost('reason'));
        $remarks = trim($this->request->getPost('remarks'));

        //=========================================
        // Basic Validation
        //=========================================

        if (empty($invoice)) {

            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Invoice number is required.',
            ]);
        }

        if (empty($returnQty) || !is_array($returnQty)) {

            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Please enter return quantity.',
            ]);
        }

        //=========================================
        // Load Sale
        //=========================================

        $sale = $this->ProductSaleModel
            ->where('sales_invoice', $invoice)
            ->first();

        if (!$sale) {

            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Sale invoice not found.',
            ]);
        }

        //=========================================
        // Check Sale Already Fully Returned
        //=========================================

        if ($sale['return_status'] == 'FULL') {

            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'This invoice is already fully returned.',
            ]);
        }

        //=========================================
        // Load Sale Details
        //=========================================

        $saleDetails = $this->ProductSaleDetailsModel
            ->where('sales_details_invoice', $invoice)
            ->findAll();

        if (!$saleDetails) {

            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Sale details not found.',
            ]);
        }

        //=========================================
        // Validate Return Qty
        //=========================================

        $totalSoldQty = 0;
        $totalReturnQty = 0;

        foreach ($saleDetails as $item) {

            $pid = $item['product_id'];

            $qty = isset($returnQty[$pid])
            ? (float) $returnQty[$pid]
            : 0;

            if ($qty < 0) {

                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Return quantity cannot be negative.',
                ]);
            }

            if ($qty == 0) {
                continue;
            }

            $soldQty = (float) $item['product_quantity_sold'];

            $returnedQty = (float) $item['returned_qty'];

            $availableQty = $soldQty - $returnedQty;

            if ($availableQty <= 0) {

                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Product already fully returned.',
                ]);
            }

            if ($qty > $availableQty) {

                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Return qty exceeds sold qty.',
                ]);
            }

            $totalSoldQty += $soldQty;
            $totalReturnQty += $qty;
        }

        if ($totalReturnQty <= 0) {

            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Please enter at least one return quantity.',
            ]);
        }

        //=========================================
        // Full Return or Partial Return
        //=========================================

        $isFullReturn = false;

        if ($totalSoldQty == ($totalReturnQty + array_sum(array_column($saleDetails, 'returned_qty')))) {

            $isFullReturn = true;
        }

        //=========================================
        // Start Transaction
        //=========================================

        $db->transBegin();

        try {

            /*
            =====================================================

            PART-2 START HERE

            1. Insert return_sales
            2. Get Return ID
            এই Part-2 শেষে যা সম্পন্ন হবে
            ✅ return_sales Insert
            ✅ return_id Generate
            ✅ return_sales_details Insert
            ✅ sales_details.returned_qty Update
            ✅ Total Return Amount Calculate ($grandReturnAmount)

            =====================================================
             */

            //=========================================
            // Return Master Insert
            //=========================================

            $returnMaster = [
                'sales_invoice' => $sale['sales_invoice'],
                'customer_id' => $sale['customer_id'] ?? null,
                'return_date' => date('Y-m-d'),
                'return_type' => $isFullReturn ? 'FULL' : 'PARTIAL',
                'return_status' => 'APPROVED',
                'total_return_amount' => 0,
                'refund_amount' => 0,
                'adjust_due_amount' => 0,
                'return_reason' => $reason,
                'remarks' => $remarks,
                'return_by' => session()->get('user_id'),
            ];

            $this->returnSaleModel->insert($returnMaster);

            $returnId = $this->returnSaleModel->getInsertID();

            //=========================================
            // Variables
            //=========================================

            $grandReturnAmount = 0;

            //=========================================
// Calculate Invoice Gross
//=========================================

            $invoiceGross = 0;

            foreach ($saleDetails as $row) {
                $invoiceGross += (float) $row['total_sale_price'];
            }

            //=========================================
            // Loop Sale Details
            //=========================================

            foreach ($saleDetails as $detail) {

                $productId = $detail['product_id'];

                $qty = isset($returnQty[$productId])
                ? (float) $returnQty[$productId]
                : 0;

                if ($qty <= 0) {
                    continue;
                }

                $soldQty = (float) $detail['product_quantity_sold'];

                $unitPrice = (float) $detail['unit_price'];

                $lineSale = (float) $detail['total_sale_price'];

                $lineBuy = (float) $detail['total_buy_price'];



                //---------------------------------------
// Allocate Invoice Discount/VAT
//---------------------------------------

$ratio = 0;

if ($invoiceGross > 0) {
    $ratio = $lineSale / $invoiceGross;
}

$lineDiscount = (float) $sale['product_discount'] * $ratio;
$lineVat      = (float) $sale['product_vat'] * $ratio;
$lineCharge   = (float) $sale['other_charge_on_all'] * $ratio;

$lineNetAmount = $lineSale - $lineDiscount + $lineVat + $lineCharge;

$perUnitNet = $soldQty > 0
    ? ($lineNetAmount / $soldQty)
    : 0;

                //---------------------------------------
                // Per Unit Buy Price
                //---------------------------------------

                $buyPerUnit = 0;

                if ($soldQty > 0) {
                    $buyPerUnit = $lineBuy / $soldQty;
                }

                //---------------------------------------
                // Return Amount
                //---------------------------------------

                // $subtotal = $qty * $unitPrice;

                // $buyAmount = $qty * $buyPerUnit;


                $perUnitDiscount = $soldQty > 0
                ? $lineDiscount / $soldQty
                : 0;
            
            $perUnitVat = $soldQty > 0
                ? $lineVat / $soldQty
                : 0;


                //---------------------------------------
// Return Amount
//---------------------------------------

$subtotal = round($qty * $perUnitNet, 2);

$buyAmount = round($qty * $buyPerUnit, 2);

                //---------------------------------------
                // Insert Return Details
                //---------------------------------------

                $this->returnSaleDetailsModel->insert([

                    'return_id' => $returnId,

                    'sales_invoice' => $sale['sales_invoice'],

                    'sales_details_invoice' => $detail['sales_details_invoice'],

                    'product_id' => $productId,

                    'sold_qty' => $soldQty,

                    'return_qty' => $qty,

                    'unit_price' => $unitPrice,

                    'buy_price' => $buyAmount,

                    'sale_price' => $subtotal,
                    'discount_amount' => round($perUnitDiscount * $qty, 2),

                    'vat_amount' => round($perUnitVat * $qty, 2),

                    'subtotal' => $subtotal,

                ]);

                //---------------------------------------
                // Update Returned Qty
                //---------------------------------------

                $newReturnedQty = $detail['returned_qty'] + $qty;

                $this->ProductSaleDetailsModel
                    ->where('sales_details_id', $detail['sales_details_id'])
                    ->set('returned_qty', $newReturnedQty)
                    ->update();

                //---------------------------------------
                // Grand Return
                //---------------------------------------

                $grandReturnAmount += $subtotal;

            }

            /*
            =============================================

            PART-3 START HERE

            1. Due Adjustment
            2. Refund Calculation
            3. Update return_sales
            এখানে আমরা করবো:

            Due Adjustment
            Refund Calculation
            return_sales Update
            return_payment Insert (যদি Refund থাকে)
            sales.return_status Update
            Transaction Commit / Rollback

            =============================================
             */

            //=========================================
            // Calculate Due & Refund
            //=========================================

            $paidAmount = (float) ($sale['paid_amount'] ?? 0);

            $dueAmount = (float) ($sale['due_amount'] ?? 0);

            $refundAmount = 0;

            $adjustDueAmount = 0;

            /*
            -------------------------------------------
            Case-1
            Due আছে
            -------------------------------------------
             */

            if ($dueAmount > 0) {

                if ($grandReturnAmount <= $dueAmount) {

                    $adjustDueAmount = $grandReturnAmount;

                    $refundAmount = 0;

                    $dueAmount -= $grandReturnAmount;

                } else {

                    $adjustDueAmount = $dueAmount;

                    $refundAmount = $grandReturnAmount - $dueAmount;

                    $dueAmount = 0;
                }

            }

            /*
            -------------------------------------------
            Case-2
            No Due
            -------------------------------------------
             */

            else {

                $refundAmount = $grandReturnAmount;
            }

            //=========================================
            // Update Return Master
            //=========================================

            $this->returnSaleModel
                ->update($returnId, [

                    'total_return_amount' => $grandReturnAmount,

                    'refund_amount' => $refundAmount,

                    'adjust_due_amount' => $adjustDueAmount,

                ]);

            //=========================================
            // Update Sales Due
            //=========================================

            $this->ProductSaleModel
                ->update($sale['sales_id'], [

                    'due_amount' => $dueAmount,

                ]);

            //=========================================
            // Insert Refund Payment
            //=========================================

            if ($refundAmount > 0) {

                $this->ReturnPaymentModel->insert([

                    'return_id' => $returnId,

                    'sales_invoice' => $sale['sales_invoice'],

                    'customer_id' => $sale['customer_id'],

                    'payment_date' => date('Y-m-d'),

                    'payment_method' => $sale['payment_type'],

                    'amount' => $refundAmount,

                    'received_by' => session()->get('user_id'),

                    'remarks' => 'Sales Return Refund',

                ]);

            }

            //=========================================
            // Update Return Status
            //=========================================

            $status = 'FULL';

            foreach ($this->ProductSaleDetailsModel
                ->where('sales_details_invoice', $invoice)
                ->findAll() as $item) {

                if ($item['returned_qty'] < $item['product_quantity_sold']) {

                    $status = 'PARTIAL';

                    break;
                }
            }

            $this->ProductSaleModel
                ->update($sale['sales_id'], [

                    'return_status' => $status,

                ]);

            //=========================================
            // Commit
            //=========================================

            if ($db->transStatus() === false) {

                $db->transRollback();

                return $this->response->setJSON([

                    'status' => 'error',

                    'message' => 'Return failed.',

                ]);

            }

            $db->transCommit();

            return $this->response->setJSON([

                'status' => 'success',

                'message' => $status == 'FULL'
                ? 'Full return completed successfully.'
                : 'Partial return completed successfully.',

            ]);

        } catch (\Exception $e) {

            $db->transRollback();

            return $this->response->setJSON([

                'status' => 'error',

                'message' => $e->getMessage(),

            ]);
        }
    }

}