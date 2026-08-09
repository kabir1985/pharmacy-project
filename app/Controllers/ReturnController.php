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

        $sales_id = $this->request->getPost('sales_id');

        $builder = $db->query("
        SELECT
            sd.sales_id,
            sd.sales_details_id,
            sd.product_id,

            p.product_name,

            sd.unit_price,
            sd.total_buy_price,
            sd.total_sale_price,

            sd.product_quantity_sold AS sold_qty,

            IFNULL(sd.returned_qty, 0) AS return_qty,

            (
                sd.product_quantity_sold
                - IFNULL(sd.returned_qty, 0)
            ) AS remaining_qty,

            CASE
                WHEN IFNULL(sd.returned_qty, 0) = 0
                    THEN 'ACTIVE'

                WHEN IFNULL(sd.returned_qty, 0) < sd.product_quantity_sold
                    THEN 'PARTIAL'

                WHEN IFNULL(sd.returned_qty, 0) >= sd.product_quantity_sold
                    THEN 'FULL'
            END AS return_status

        FROM sales_details sd

        INNER JOIN products p
            ON p.product_id = sd.product_id

        WHERE sd.sales_id = ?

        ORDER BY sd.sales_details_id ASC
    ", [$sales_id]);

        $products = $builder->getResultArray();

        // echo "<pre>";
        // print_r($products);
        // echo "</pre>";
        // exit

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
    //     $existingReturn = $this->ReturnSaleModel
    //         ->where('sales_invoice', $invoice)
    //         ->first();

    //     if (!$existingReturn) {
    //         $ReturnSaleModel->insert([
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
    //         $this->ReturnSaleDetailsModel->insert([
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
        $db = \Config\Database::connect();

        // =========================================
        // INPUT
        // =========================================

        $salesId = (int) $this->request->getPost('sales_id');
        $returnQty = $this->request->getPost('return_qty');
        $reason = trim((string) $this->request->getPost('reason'));
        $remarks = trim((string) $this->request->getPost('remarks'));
        $paymentType = trim((string) $this->request->getPost('payment_type'));

        // =========================================
        // BASIC VALIDATION
        // =========================================

        if ($salesId <= 0) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Invalid Sales ID.',
            ]);
        }

        if (empty($returnQty) || !is_array($returnQty)) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Please enter return quantity.',
            ]);
        }

        // =========================================
        // LOAD SALE BY SALES ID
        // =========================================

        $sale = $this->ProductSaleModel
            ->where('sales_id', $salesId)
            ->first();

        if (!$sale) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Sales record not found.',
            ]);
        }

        // Invoice is only used as reference/display data
        $invoice = $sale['sales_invoice'] ?? '';

        $customerId = !empty($sale['customer_id'])
        ? (int) $sale['customer_id']
        : null;

        // =========================================
        // CHECK SALE RETURN STATUS
        // =========================================

        if (($sale['return_status'] ?? 'NO_RETURN') === 'FULL') {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'This sale is already fully returned.',
            ]);
        }

        // =========================================
        // LOAD SALE DETAILS BY SALES ID
        // =========================================

        $saleDetails = $this->ProductSaleDetailsModel
            ->where('sales_id', $salesId)
            ->orderBy('sales_details_id', 'ASC')
            ->findAll();

        if (!$saleDetails) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Sale details not found.',
            ]);
        }

        // =========================================
        // VALIDATE RETURN QUANTITIES
        //
        // JS should send:
        // return_qty[sales_details_id]
        // =========================================

        $totalReturnQty = 0;

        foreach ($saleDetails as $detail) {

            $salesDetailsId = (int) $detail['sales_details_id'];

            $qty = isset($returnQty[$salesDetailsId])
            ? (float) $returnQty[$salesDetailsId]
            : 0;

            // Negative quantity
            if ($qty < 0) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Return quantity cannot be negative.',
                ]);
            }

            // Nothing to return for this product
            if ($qty == 0) {
                continue;
            }

            $soldQty = (float) $detail['product_quantity_sold'];

            $returnedQty = (float) (
                $detail['returned_qty'] ?? 0
            );

            // Remaining returnable quantity
            $availableQty = $soldQty - $returnedQty;

            // Already completely returned
            if ($availableQty <= 0) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'This product has already been fully returned.',
                ]);
            }

            // Requested quantity exceeds remaining
            if ($qty > $availableQty) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' =>
                    'Return quantity exceeds available quantity for product ID '
                    . $detail['product_id'],
                ]);
            }

            $totalReturnQty += $qty;
        }

        // =========================================
        // AT LEAST ONE PRODUCT MUST BE RETURNED
        // =========================================

        if ($totalReturnQty <= 0) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Please enter at least one return quantity.',
            ]);
        }

        // =========================================
        // DETERMINE FULL / PARTIAL RETURN
        // =========================================

        $isFullReturn = true;

        foreach ($saleDetails as $detail) {

            $soldQty = (float) $detail['product_quantity_sold'];

            $oldReturnedQty = (float) (
                $detail['returned_qty'] ?? 0
            );

            $salesDetailsId = (int) $detail['sales_details_id'];

            $newReturnQty = isset($returnQty[$salesDetailsId])
            ? (float) $returnQty[$salesDetailsId]
            : 0;

            $finalReturnedQty =
                $oldReturnedQty + $newReturnQty;

            if ($finalReturnedQty < $soldQty) {
                $isFullReturn = false;
                break;
            }
        }

        $returnType = $isFullReturn
        ? 'FULL'
        : 'PARTIAL';

        // =========================================
        // START TRANSACTION
        // =========================================

        $db->transBegin();

        try {

            // =====================================
            // CREATE RETURN INVOICE
            // =====================================

            $returnInvoice =
            'RET-' .
            date('YmdHis') .
            '-' .
            strtoupper(
                substr(bin2hex(random_bytes(3)), 0, 6)
            );

            // =====================================
            // CREATE RETURN MASTER
            // =====================================

            $this->ReturnSaleModel->insert([
                'return_invoice'      => $returnInvoice,
                'sales_id'            => $salesId,
                'return_date'         => date('Y-m-d H:i:s'),
                'return_type'         => $returnType,
                'total_return_amount' => 0,
                'remarks'             => $reason ?: $remarks,
                'return_by'           => session()->get('user_id'),
            ]);

             $returnId = $this->ReturnSaleModel->getInsertID();

             if (!$returnId) {
                 throw new \Exception(
                     'Failed to create return transaction.'
                 );
             }


            // =====================================
            // VARIABLES
            // =====================================

            $grandReturnAmount = 0;

            // =====================================
            // PROCESS EACH PRODUCT
            // =====================================

            foreach ($saleDetails as $detail) {

                $salesDetailsId = (int) $detail['sales_details_id'];

                $productId = (int) $detail['product_id'];

                $qty = isset($returnQty[$salesDetailsId])
                ? (float) $returnQty[$salesDetailsId]
                : 0;

                // Skip products with no return quantity
                if ($qty <= 0) {
                    continue;
                }

                // ----------------------------------
                // SOLD QUANTITY
                // ----------------------------------

                $soldQty = (float) $detail['product_quantity_sold'];

                // ----------------------------------
                // PREVIOUSLY RETURNED QUANTITY
                // ----------------------------------

                $oldReturnedQty = (float) (
                    $detail['returned_qty'] ?? 0
                );

                // ----------------------------------
                // AVAILABLE QUANTITY
                // ----------------------------------

                $availableQty =
                    $soldQty - $oldReturnedQty;

                // ----------------------------------
                // FINAL VALIDATION
                // ----------------------------------

                if ($qty > $availableQty) {

                    throw new \Exception(
                        'Return quantity exceeds available quantity for product ID '
                        . $productId
                    );
                }

                // ----------------------------------
                // UNIT SALE PRICE
                // ----------------------------------

                $unitPrice = (float) $detail['unit_price'];

                // ----------------------------------
                // RETURN AMOUNT
                // ----------------------------------

                $returnAmount = round(
                    $qty * $unitPrice,
                    2
                );

                // ----------------------------------
                // NEW RETURNED QUANTITY
                // ----------------------------------

                $newReturnedQty =
                    $oldReturnedQty + $qty;

                // ----------------------------------
                // REMAINING QUANTITY
                // ----------------------------------

                $remainingQty =
                    $soldQty - $newReturnedQty;

                // ----------------------------------
                // INSERT RETURN DETAILS
                // ----------------------------------

                $this->ReturnSaleDetailsModel->insert([
                    'return_id' => $returnId,
                    'sales_details_id' => $salesDetailsId,
                    'product_id' => $productId,
                    'sold_qty' => $soldQty,
                    'return_qty' => $qty,
                    'remaining_qty' => $remainingQty,
                    'unit_price' => $unitPrice,
                    'total_return_amount' => $returnAmount,
                    'return_reason' => $reason ?: null,
                ]);

                // ----------------------------------
                // UPDATE SALES DETAILS
                // ----------------------------------

                $this->ProductSaleDetailsModel
                    ->where(
                        'sales_details_id',
                        $salesDetailsId
                    )
                    ->set([
                        'returned_qty' => $newReturnedQty,
                    ])
                    ->update();

                // ----------------------------------
                // STOCK LEDGER
                //
                // SALE RETURN = STOCK IN
                // ----------------------------------

                $currentStockRow = $db->query(
                    "
                    SELECT COALESCE(
                        SUM(qty_in - qty_out),
                        0
                    ) AS current_stock
                    FROM stock_ledger
                    WHERE product_id = ?
                    ",
                    [$productId]
                )->getRowArray();

                $currentStock = (float) (
                    $currentStockRow['current_stock'] ?? 0
                );

                $newBalance =
                    $currentStock + $qty;

                // Average/unit buy cost
                $unitCost =
                (float) (
                    $detail['total_buy_price']
                    / max($soldQty, 1)
                );

                $db->table('stock_ledger')->insert([
                    'product_id' => $productId,
                    'transaction_type' => 'SALE_RETURN',
                    'reference_id' => $returnId,
                    'qty_in' => $qty,
                    'qty_out' => 0,
                    'balance_qty' => $newBalance,
                    'unit_cost' => $unitCost,
                    'transaction_date' => date('Y-m-d H:i:s'),
                    'remarks' =>
                    'Sales Return : ' . $returnInvoice,
                    'created_by' =>
                    session()->get('user_id'),
                ]);

                // ----------------------------------
                // ADD RETURN AMOUNT
                // ----------------------------------

                $grandReturnAmount += $returnAmount;
            }

            // =====================================
            // ROUND GRAND TOTAL
            // =====================================

            $grandReturnAmount =
                round($grandReturnAmount, 2);

            // =====================================
            // UPDATE RETURN MASTER
            // =====================================

            $this->ReturnSaleModel
                ->update($returnId, [
                    'total_return_amount' =>
                    $grandReturnAmount,
                ]);

            // =====================================
            // GET CUSTOMER CURRENT DUE
            // =====================================

            $currentDue = 0;

            $dueRow = null;

            if ($customerId !== null) {

                $dueRow = $db->table('customer_due')
                    ->where('sales_id', $salesId)
                    ->where('customer_id', $customerId)
                    ->get()
                    ->getRowArray();

                if ($dueRow) {

                    $currentDue =
                    (float) $dueRow['due_amount']
                     -
                    (float) $dueRow['paid_amount'];

                    if ($currentDue < 0) {
                        $currentDue = 0;
                    }
                }
            }

            // =====================================
            // PAYMENT / DUE LOGIC
            // =====================================

            $adjustDueAmount = 0;
            $refundAmount = 0;

            // =====================================
            // CUSTOMER HAS OUTSTANDING DUE
            // =====================================

            if (
                $currentDue > 0 &&
                $customerId !== null &&
                $dueRow
            ) {

                // Return <= customer due
                if ($grandReturnAmount <= $currentDue) {

                    $adjustDueAmount =
                        $grandReturnAmount;

                    $refundAmount = 0;

                } else {

                    // Due fully adjusted
                    $adjustDueAmount =
                        $currentDue;

                    // Remaining amount refunded
                    $refundAmount =
                        $grandReturnAmount -
                        $currentDue;
                }

            } else {

                // No customer due
                $refundAmount =
                    $grandReturnAmount;
            }

            $adjustDueAmount =
                round($adjustDueAmount, 2);

            $refundAmount =
                round($refundAmount, 2);

            // =====================================
            // UPDATE CUSTOMER DUE
            // =====================================

            if (
                $adjustDueAmount > 0 &&
                $dueRow
            ) {

                $newDueAmount = max(
                    0,
                    (float) $dueRow['due_amount']
                     -
                    $adjustDueAmount
                );

                $db->table('customer_due')
                    ->where(
                        'due_id',
                        $dueRow['due_id']
                    )
                    ->update([
                        'due_amount' =>
                        round(
                            $newDueAmount,
                            2
                        ),
                    ]);
            }

            // =====================================
            // INSERT REFUND PAYMENT
            // =====================================

            if ($refundAmount > 0) {

                if ($paymentType === '') {

                    throw new \Exception(
                        'Please select a refund payment method.'
                    );
                }

                $allowedMethods = [
                    'Cash',
                    'Bank',
                    'Mobile Banking',
                    'Adjust Due',
                ];

                if (
                    !in_array(
                        $paymentType,
                        $allowedMethods,
                        true
                    )
                ) {

                    throw new \Exception(
                        'Invalid refund payment method.'
                    );
                }

                if ($paymentType === 'Adjust Due') {

                    throw new \Exception(
                        'Refund amount cannot use Adjust Due.'
                    );
                }

                $this->ReturnPaymentModel->insert([
                    'return_id' => $returnId,
                    'payment_type' => $paymentType,
                    'amount' => $refundAmount,
                    'payment_date' => date('Y-m-d'),
                    'remarks' =>
                    'Sales Return Refund - '
                    . $returnInvoice,
                ]);
            }

            // =====================================
            // DETERMINE FINAL SALES RETURN STATUS
            // =====================================

            $finalStatus = 'FULL';

            $finalSaleDetails =
            $this->ProductSaleDetailsModel
                ->where('sales_id', $salesId)
                ->findAll();

            foreach ($finalSaleDetails as $item) {

                $sold =
                (float) $item['product_quantity_sold'];

                $returned =
                (float) (
                    $item['returned_qty'] ?? 0
                );

                if ($returned < $sold) {

                    $finalStatus = 'PARTIAL';

                    break;
                }
            }

            // =====================================
            // UPDATE SALES RETURN STATUS
            // =====================================

            $this->ProductSaleModel
                ->where('sales_id', $salesId)
                ->set([
                    'return_status' => $finalStatus,
                ])
                ->update();

            // =====================================
            // TRANSACTION CHECK
            // =====================================

            // if ($db->transStatus() === false) {

            //     $db->transRollback();

            //     return $this->response->setJSON([
            //         'status' => 'error',
            //         'message' =>
            //         'Return transaction failed.',
            //     ]);
            // }



            if ($db->transStatus() === false) {

                $error = $db->error();
            
                $db->transRollback();
            
                log_message(
                    'error',
                    'RETURN TRANSACTION FAILED: ' . print_r($error, true)
                );
            
                return $this->response->setJSON([
                    'status'  => 'error',
                    'message' => 'Return transaction failed.',
                    'db_error' => $error
                ]);
            }


            // =====================================
            // COMMIT
            // =====================================

            $db->transCommit();

            // =====================================
            // SUCCESS
            // =====================================

            return $this->response->setJSON([
                'status' => 'success',

                'message' =>
                $finalStatus === 'FULL'
                ? 'Full return completed successfully.'
                : 'Partial return completed successfully.',

                'sales_id' =>
                $salesId,

                'sales_invoice' =>
                $invoice,

                'return_invoice' =>
                $returnInvoice,

                'return_id' =>
                $returnId,

                'total_return' =>
                $grandReturnAmount,

                'adjust_due_amount' =>
                $adjustDueAmount,

                'refund_amount' =>
                $refundAmount,

                'return_status' =>
                $finalStatus,
            ]);

        } catch (\Throwable $e) {

            // =====================================
            // ROLLBACK
            // =====================================

            $db->transRollback();

            log_message(
                'error',
                'Sales Return Error: ' . $e->getMessage()
            );

            return $this->response->setJSON([
                'status' => 'error',
                'message' => $e->getMessage(),
            ]);
        }
    }

}
