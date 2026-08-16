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
        return $this->response->setJSON($products);
    }



    public function process()
{
    $db = \Config\Database::connect();

    // =========================================================
    // INPUT
    // =========================================================

    $salesId     = (int) $this->request->getPost('sales_id');
    $returnQty   = $this->request->getPost('return_qty');
    $reason      = trim((string) $this->request->getPost('reason'));
    $remarks     = trim((string) $this->request->getPost('remarks'));
    //$paymentType = trim((string) $this->request->getPost('payment_type'));
    $paymentType = 'Cash'; // Default to CASH for now

    // =========================================================
    // BASIC VALIDATION
    // =========================================================

    if ($salesId <= 0) {
        return $this->response->setJSON([
            'status'  => 'error',
            'message' => 'Invalid Sales ID.',
        ]);
    }

    if (!is_array($returnQty) || empty($returnQty)) {
        return $this->response->setJSON([
            'status'  => 'error',
            'message' => 'Please enter return quantity.',
        ]);
    }

    // =========================================================
    // LOAD SALE
    // =========================================================

    $sale = $this->ProductSaleModel
        ->where('sales_id', $salesId)
        ->first();

    if (!$sale) {
        return $this->response->setJSON([
            'status'  => 'error',
            'message' => 'Sales record not found.',
        ]);
    }

    $invoice = $sale['sales_invoice'] ?? '';

    $customerId = !empty($sale['customer_id'])
        ? (int) $sale['customer_id']
        : null;

    // =========================================================
    // CHECK RETURN STATUS
    // =========================================================

    if (($sale['return_status'] ?? 'NO_RETURN') === 'FULL') {
        return $this->response->setJSON([
            'status'  => 'error',
            'message' => 'This sale is already fully returned.',
        ]);
    }

    // =========================================================
    // LOAD SALE DETAILS
    // =========================================================

    $saleDetails = $this->ProductSaleDetailsModel
        ->where('sales_id', $salesId)
        ->orderBy('sales_details_id', 'ASC')
        ->findAll();

    if (empty($saleDetails)) {
        return $this->response->setJSON([
            'status'  => 'error',
            'message' => 'Sale details not found.',
        ]);
    }

    // =========================================================
    // INVOICE LEVEL CHARGES
    //
    // These are ACTUAL AMOUNTS stored in sales table:
    //
    // product_discount
    // product_vat
    // other_charge_on_all
    //
    // They are NOT percentages.
    // =========================================================

    $invoiceDiscount = round(
        (float) ($sale['product_discount'] ?? 0),
        2
    );

    $invoiceVat = round(
        (float) ($sale['product_vat'] ?? 0),
        2
    );

    $invoiceOtherCharge = round(
        (float) ($sale['other_charge_on_all'] ?? 0),
        2
    );

    // =========================================================
    // TOTAL ORIGINAL PRODUCT SELLING VALUE
    //
    // Example:
    // line 1 = 100
    // line 2 = 50
    // total product value = 150
    //
    // Return 25 from line 1:
    // return ratio = 25 / 150
    //
    // Discount/VAT/other charge are allocated using this ratio.
    // =========================================================

    $invoiceProductTotal = 0;

    foreach ($saleDetails as $detail) {

        $lineTotal = (float) ($detail['total_sale_price'] ?? 0);

        if ($lineTotal > 0) {
            $invoiceProductTotal += $lineTotal;
        }
    }

    $invoiceProductTotal = round($invoiceProductTotal, 2);

    if ($invoiceProductTotal <= 0) {
        return $this->response->setJSON([
            'status'  => 'error',
            'message' => 'Invalid sales product total.',
        ]);
    }

    // =========================================================
    // VALIDATE RETURN QUANTITIES
    // =========================================================

    $totalReturnQty = 0;

    foreach ($saleDetails as $detail) {

        $salesDetailsId = (int) $detail['sales_details_id'];

        $qty = isset($returnQty[$salesDetailsId])
            ? (float) $returnQty[$salesDetailsId]
            : 0;

        $qty = round($qty, 2);

        // Negative
        if ($qty < 0) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'Return quantity cannot be negative.',
            ]);
        }

        // Nothing returned for this line
        if ($qty <= 0) {
            continue;
        }

        $soldQty = round(
            (float) $detail['product_quantity_sold'],
            2
        );

        $oldReturnedQty = round(
            (float) ($detail['returned_qty'] ?? 0),
            2
        );

        $availableQty = round(
            $soldQty - $oldReturnedQty,
            2
        );

        if ($availableQty <= 0) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' =>
                    'Product ID ' .
                    $detail['product_id'] .
                    ' has already been fully returned.',
            ]);
        }

        if ($qty > $availableQty) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' =>
                    'Return quantity exceeds available quantity for Product ID '
                    . $detail['product_id']
                    . '. Available: '
                    . number_format($availableQty, 2),
            ]);
        }

        $totalReturnQty += $qty;
    }

    $totalReturnQty = round($totalReturnQty, 2);

    if ($totalReturnQty <= 0) {
        return $this->response->setJSON([
            'status'  => 'error',
            'message' => 'Please enter at least one return quantity.',
        ]);
    }

    // =========================================================
    // DETERMINE FULL / PARTIAL RETURN
    // =========================================================

    $isFullReturn = true;

    foreach ($saleDetails as $detail) {

        $salesDetailsId = (int) $detail['sales_details_id'];

        $soldQty = round(
            (float) $detail['product_quantity_sold'],
            2
        );

        $oldReturnedQty = round(
            (float) ($detail['returned_qty'] ?? 0),
            2
        );

        $newReturnQty = isset($returnQty[$salesDetailsId])
            ? round((float) $returnQty[$salesDetailsId], 2)
            : 0;

        $finalReturnedQty = round(
            $oldReturnedQty + $newReturnQty,
            2
        );

        if ($finalReturnedQty < $soldQty) {
            $isFullReturn = false;
            break;
        }
    }

    $returnType = $isFullReturn
        ? 'FULL'
        : 'PARTIAL';

    // =========================================================
    // START TRANSACTION
    // =========================================================

    $db->transBegin();

    try {

        // =====================================================
        // CREATE UNIQUE RETURN INVOICE
        // =====================================================

        $returnInvoice =
            'RET-' .
            date('YmdHis') .
            '-' .
            strtoupper(substr(bin2hex(random_bytes(3)), 0, 6));

        // =====================================================
        // INSERT RETURN MASTER
        //
        // Use DB builder directly so we can immediately verify
        // the actual auto-increment return_id.
        // =====================================================

        $returnMasterData = [
            'return_invoice'      => $returnInvoice,
            'sales_id'            => $salesId,
            'return_date'         => date('Y-m-d H:i:s'),
            'return_type'         => $returnType,
            'total_return_amount' => 0,
            'remarks'             => $reason ?: ($remarks ?: null),
            'return_by'           => session()->get('user_id'),
        ];

        $db->table('return_sales')->insert($returnMasterData);

        if ($db->affectedRows() !== 1) {

            $error = $db->error();

            throw new \Exception(
                'Failed to create return master. DB Error: '
                . json_encode($error)
            );
        }

        // =====================================================
        // GET ACTUAL RETURN ID
        // =====================================================

        $returnId = (int) $db->insertID();

        if ($returnId <= 0) {
            throw new \Exception(
                'Failed to obtain Return ID after creating return master.'
            );
        }

        // =====================================================
        // VERY IMPORTANT:
        // VERIFY RETURN MASTER EXISTS BEFORE CHILD INSERT
        // =====================================================

        $returnMasterCheck = $db->table('return_sales')
            ->where('return_id', $returnId)
            ->get()
            ->getRowArray();

        if (!$returnMasterCheck) {
            throw new \Exception(
                'Return master was created but Return ID '
                . $returnId
                . ' could not be verified.'
            );
        }

        // =====================================================
        // VARIABLES
        // =====================================================

        $grandReturnAmount = 0;

        $returnProductSubtotal = 0;

        // =====================================================
        // FIRST PASS
        //
        // Calculate the ORIGINAL SELLING VALUE of returned
        // products.
        //
        // This is required to allocate invoice-level:
        // discount
        // VAT
        // other charge
        // =====================================================

        foreach ($saleDetails as $detail) {

            $salesDetailsId = (int) $detail['sales_details_id'];

            $qty = isset($returnQty[$salesDetailsId])
                ? round((float) $returnQty[$salesDetailsId], 2)
                : 0;

            if ($qty <= 0) {
                continue;
            }

            $unitPrice = round(
                (float) $detail['unit_price'],
                2
            );

            $lineReturnGross = round(
                $qty * $unitPrice,
                2
            );

            $returnProductSubtotal += $lineReturnGross;
        }

        $returnProductSubtotal = round(
            $returnProductSubtotal,
            2
        );

        if ($returnProductSubtotal <= 0) {
            throw new \Exception(
                'Return product subtotal cannot be zero.'
            );
        }

        // =====================================================
        // SECOND PASS
        // PROCESS EACH PRODUCT
        // =====================================================

        foreach ($saleDetails as $detail) {

            $salesDetailsId = (int) $detail['sales_details_id'];

            $productId = (int) $detail['product_id'];

            $qty = isset($returnQty[$salesDetailsId])
                ? round((float) $returnQty[$salesDetailsId], 2)
                : 0;

            // -------------------------------------------------
            // SKIP
            // -------------------------------------------------

            if ($qty <= 0) {
                continue;
            }

            // -------------------------------------------------
            // SOLD QTY
            // -------------------------------------------------

            $soldQty = round(
                (float) $detail['product_quantity_sold'],
                2
            );

            // -------------------------------------------------
            // OLD RETURNED QTY
            // -------------------------------------------------

            $oldReturnedQty = round(
                (float) ($detail['returned_qty'] ?? 0),
                2
            );

            // -------------------------------------------------
            // AVAILABLE QTY
            // -------------------------------------------------

            $availableQty = round(
                $soldQty - $oldReturnedQty,
                2
            );

            // -------------------------------------------------
            // FINAL VALIDATION
            // -------------------------------------------------

            if ($qty > $availableQty) {

                throw new \Exception(
                    'Return quantity exceeds available quantity for Product ID '
                    . $productId
                );
            }

            // -------------------------------------------------
            // ACTUAL SELLING UNIT PRICE
            //
            // This is the actual price customer paid per unit.
            // -------------------------------------------------

            $unitPrice = round(
                (float) $detail['unit_price'],
                2
            );

            // -------------------------------------------------
            // GROSS RETURN VALUE
            //
            // BEFORE invoice-level discount/VAT/charge.
            // -------------------------------------------------

            $grossReturnAmount = round(
                $qty * $unitPrice,
                2
            );

            // =================================================
            // PROPORTIONAL ALLOCATION
            //
            // Example:
            //
            // Invoice product total = 1,000
            // Discount = 100
            // VAT = 50
            // Other charge = 20
            //
            // Returned product value = 200
            //
            // Ratio = 200 / 1000 = 20%
            //
            // Return discount = 20
            // Return VAT = 10
            // Return other = 4
            //
            // Net return = 200 - 20 + 10 + 4 = 194
            // =================================================

            $allocationRatio =
                $grossReturnAmount /
                $invoiceProductTotal;

            $allocationRatio = min(
                1,
                max(0, $allocationRatio)
            );

            // -------------------------------------------------
            // PROPORTIONAL DISCOUNT
            // -------------------------------------------------

            $returnDiscount = round(
                $invoiceDiscount * $allocationRatio,
                2
            );

            // -------------------------------------------------
            // PROPORTIONAL VAT
            // -------------------------------------------------

            $returnVat = round(
                $invoiceVat * $allocationRatio,
                2
            );

            // -------------------------------------------------
            // PROPORTIONAL OTHER CHARGE
            // -------------------------------------------------

            $returnOtherCharge = round(
                $invoiceOtherCharge * $allocationRatio,
                2
            );

            // -------------------------------------------------
            // FINAL RETURN AMOUNT
            //
            // Gross
            // - Discount
            // + VAT
            // + Other Charge
            // -------------------------------------------------

            $returnAmount = round(
                $grossReturnAmount
                - $returnDiscount
                + $returnVat
                + $returnOtherCharge,
                2
            );

            // Prevent negative return
            if ($returnAmount < 0) {
                $returnAmount = 0;
            }

            // -------------------------------------------------
            // NEW RETURNED QTY
            // -------------------------------------------------

            $newReturnedQty = round(
                $oldReturnedQty + $qty,
                2
            );

            // -------------------------------------------------
            // REMAINING QTY
            // -------------------------------------------------

            $remainingQty = round(
                $soldQty - $newReturnedQty,
                2
            );

            if ($remainingQty < 0) {
                $remainingQty = 0;
            }

            // =================================================
            // INSERT RETURN DETAILS
            // =================================================

            $returnDetailData = [
                'return_id'           => $returnId,
                'sales_details_id'    => $salesDetailsId,
                'product_id'          => $productId,
                'sold_qty'            => $soldQty,
                'return_qty'          => $qty,
                'remaining_qty'       => $remainingQty,
                'unit_price'          => $unitPrice,
                'total_return_amount' => $returnAmount,
                'return_reason'       => $reason ?: null,
            ];

            $detailInserted = $db
                ->table('return_sales_details')
                ->insert($returnDetailData);

            if (!$detailInserted) {

                $error = $db->error();

                throw new \Exception(
                    'Failed to insert return details for Product ID '
                    . $productId
                    . '. DB Error: '
                    . json_encode($error)
                );
            }

            // =================================================
            // UPDATE SALES DETAILS
            // =================================================

            $updated = $this->ProductSaleDetailsModel
                ->where(
                    'sales_details_id',
                    $salesDetailsId
                )
                ->set([
                    'returned_qty' => $newReturnedQty,
                ])
                ->update();

            if ($updated === false) {

                $error = $db->error();

                throw new \Exception(
                    'Failed to update returned quantity for Product ID '
                    . $productId
                    . '. DB Error: '
                    . json_encode($error)
                );
            }

            // =================================================
            // CURRENT STOCK
            // =================================================

            $stockRow = $db->query(
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

            $currentStock = round(
                (float) ($stockRow['current_stock'] ?? 0),
                2
            );

            // =================================================
            // NEW STOCK BALANCE
            // =================================================

            $newBalance = round(
                $currentStock + $qty,
                2
            );

            // =================================================
            // UNIT BUY COST
            //
            // total_buy_price is the total purchase cost stored
            // in sales_details.
            //
            // Example:
            // sold 10
            // total_buy_price = 90
            // unit cost = 9
            // =================================================

            $totalBuyPrice = (float) (
                $detail['total_buy_price'] ?? 0
            );

            $unitCost = round(
                $totalBuyPrice / max($soldQty, 1),
                2
            );

            // =================================================
            // STOCK LEDGER
            //
            // SALES RETURN = STOCK IN
            // =================================================

            $stockInserted = $db
                ->table('stock_ledger')
                ->insert([
                    'product_id'      => $productId,
                    'transaction_type'=> 'SALE_RETURN',
                    'reference_id'    => $returnId,
                    'qty_in'          => $qty,
                    'qty_out'         => 0,
                    'balance_qty'     => $newBalance,
                    'unit_cost'       => $unitCost,
                    'transaction_date'=> date('Y-m-d H:i:s'),
                    'remarks'         => 'Sales Return : ' . $returnInvoice,
                    'created_by'      => session()->get('user_id'),
                ]);

            if (!$stockInserted) {

                $error = $db->error();

                throw new \Exception(
                    'Failed to update stock for Product ID '
                    . $productId
                    . '. DB Error: '
                    . json_encode($error)
                );
            }

            // =================================================
            // ADD TO GRAND RETURN
            // =================================================

            $grandReturnAmount += $returnAmount;
        }

        // =====================================================
        // ROUND GRAND RETURN
        // =====================================================

        $grandReturnAmount = round(
            $grandReturnAmount,
            2
        );

        // =====================================================
        // IMPORTANT:
        //
        // For a FULL return, make sure the total returned
        // amount equals the original invoice grand total.
        //
        // This prevents rounding differences caused by
        // proportional allocation.
        // =====================================================

        if ($returnType === 'FULL') {

            $originalGrandTotal = round(
                (float) ($sale['grand_total'] ?? 0),
                2
            );

            if ($originalGrandTotal > 0) {

                $roundingDifference = round(
                    $originalGrandTotal -
                    $grandReturnAmount,
                    2
                );

                if (
                    abs($roundingDifference) <= 0.05 &&
                    abs($roundingDifference) > 0
                ) {
                    $grandReturnAmount =
                        $originalGrandTotal;
                }
            }
        }

        // =====================================================
        // UPDATE RETURN MASTER
        // =====================================================

        $returnMasterUpdated = $db
            ->table('return_sales')
            ->where('return_id', $returnId)
            ->update([
                'total_return_amount' => $grandReturnAmount,
            ]);

        if (!$returnMasterUpdated) {

            $error = $db->error();

            throw new \Exception(
                'Failed to update return master. DB Error: '
                . json_encode($error)
            );
        }

        // =====================================================
        // GET CURRENT CUSTOMER DUE
        //
        // IMPORTANT:
        //
        // customer_due.due_amount is already the REAL CURRENT
        // REMAINING DUE.
        //
        // DO NOT DO:
        //
        // due_amount - paid_amount
        //
        // =====================================================

        $currentDue = 0;

        $dueRow = null;

        if ($customerId !== null) {

            $dueRow = $db
                ->table('customer_due')
                ->where('sales_id', $salesId)
                ->where('customer_id', $customerId)
                ->get()
                ->getRowArray();

            if ($dueRow) {

                $currentDue = round(
                    (float) $dueRow['due_amount'],
                    2
                );

                if ($currentDue < 0) {
                    $currentDue = 0;
                }
            }
        }

        // =====================================================
        // PAYMENT / DUE CALCULATION
        // =====================================================

        $adjustDueAmount = 0;
        $refundAmount    = 0;

        if (
            $customerId !== null &&
            $dueRow &&
            $currentDue > 0
        ) {

            // -------------------------------------------------
            // RETURN IS LESS THAN OR EQUAL TO CURRENT DUE
            // -------------------------------------------------

            if ($grandReturnAmount <= $currentDue) {

                $adjustDueAmount =
                    $grandReturnAmount;

                $refundAmount = 0;

            } else {

                // -------------------------------------------------
                // RETURN FIRST CLEARS CURRENT DUE
                // -------------------------------------------------

                $adjustDueAmount =
                    $currentDue;

                // -------------------------------------------------
                // EXCESS IS ACTUAL REFUND
                // -------------------------------------------------

                $refundAmount = round(
                    $grandReturnAmount -
                    $currentDue,
                    2
                );
            }

        } else {

            // -------------------------------------------------
            // NO CUSTOMER DUE
            //
            // Entire return is refunded.
            // -------------------------------------------------

            $refundAmount =
                $grandReturnAmount;
        }

        $adjustDueAmount = round(
            $adjustDueAmount,
            2
        );

        $refundAmount = round(
            $refundAmount,
            2
        );

        // =====================================================
        // UPDATE CUSTOMER DUE
        //
        // Since due_amount is already the real remaining due:
        //
        // NEW DUE = OLD DUE - ADJUSTED RETURN
        // =====================================================

        if (
            $adjustDueAmount > 0 &&
            $dueRow
        ) {

            $newDueAmount = round(
                max(
                    0,
                    (float) $dueRow['due_amount']
                    - $adjustDueAmount
                ),
                2
            );

            $dueUpdated = $db
                ->table('customer_due')
                ->where('due_id', $dueRow['due_id'])
                ->update([
                    'due_amount' => $newDueAmount,
                ]);

            if (!$dueUpdated) {

                $error = $db->error();

                throw new \Exception(
                    'Failed to update customer due. DB Error: '
                    . json_encode($error)
                );
            }
        }

        // =====================================================
        // REFUND PAYMENT
        //
        // ONLY REQUIRED WHEN REFUND AMOUNT > 0
        // =====================================================

        if ($refundAmount > 0) {

            // -------------------------------------------------
            // PAYMENT METHOD REQUIRED
            // -------------------------------------------------

            if ($paymentType === '') {

                throw new \Exception(
                    'Please select a refund payment method.'
                );
            }

            // -------------------------------------------------
            // ALLOWED REFUND METHODS
            // -------------------------------------------------

            $allowedMethods = [
                'Cash',
                'Bank',
                'Mobile Banking',
            ];

            if (!in_array(
                $paymentType,
                $allowedMethods,
                true
            )) {

                throw new \Exception(
                    'Invalid refund payment method.'
                );
            }

            // -------------------------------------------------
            // INSERT REFUND PAYMENT
            //
            // return_id MUST EXIST in return_sales.
            // =================================================

            $paymentInserted = $db
                ->table('return_payment')
                ->insert([
                    'return_id'    => $returnId,
                    'payment_type' => $paymentType,
                    'amount'       => $refundAmount,
                    'payment_date' => date('Y-m-d'),
                    'remarks'      =>
                        'Sales Return Refund - '
                        . $returnInvoice,
                ]);

            if (!$paymentInserted) {

                $error = $db->error();

                throw new \Exception(
                    'Failed to insert refund payment. DB Error: '
                    . json_encode($error)
                );
            }
        }

        // =====================================================
        // DETERMINE FINAL SALES RETURN STATUS
        // =====================================================

        $finalStatus = 'FULL';

        $finalSaleDetails = $this->ProductSaleDetailsModel
            ->where('sales_id', $salesId)
            ->findAll();

        foreach ($finalSaleDetails as $item) {

            $soldQty = round(
                (float) $item['product_quantity_sold'],
                2
            );

            $returnedQty = round(
                (float) ($item['returned_qty'] ?? 0),
                2
            );

            if ($returnedQty < $soldQty) {

                $finalStatus = 'PARTIAL';

                break;
            }
        }

        // =====================================================
        // UPDATE SALES RETURN STATUS
        // =====================================================

        $saleUpdated = $this->ProductSaleModel
            ->where('sales_id', $salesId)
            ->set([
                'return_status' => $finalStatus,
            ])
            ->update();

        if ($saleUpdated === false) {

            $error = $db->error();

            throw new \Exception(
                'Failed to update sales return status. DB Error: '
                . json_encode($error)
            );
        }

        // =====================================================
        // FINAL TRANSACTION CHECK
        // =====================================================

        if ($db->transStatus() === false) {

            $error = $db->error();

            $db->transRollback();

            log_message(
                'error',
                'RETURN TRANSACTION FAILED: '
                . print_r($error, true)
            );

            return $this->response->setJSON([
                'status'   => 'error',
                'message'  => 'Return transaction failed.',
                'db_error' => $error,
            ]);
        }

        // =====================================================
        // COMMIT
        // =====================================================

        $db->transCommit();

        // =====================================================
        // SUCCESS
        // =====================================================

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

            'return_type' =>
                $returnType,

            'total_return' =>
                $grandReturnAmount,

            'product_subtotal_return' =>
                $returnProductSubtotal,

            'invoice_discount_allocated' =>
                round(
                    $invoiceDiscount *
                    (
                        $returnProductSubtotal /
                        $invoiceProductTotal
                    ),
                    2
                ),

            'invoice_vat_allocated' =>
                round(
                    $invoiceVat *
                    (
                        $returnProductSubtotal /
                        $invoiceProductTotal
                    ),
                    2
                ),

            'other_charge_allocated' =>
                round(
                    $invoiceOtherCharge *
                    (
                        $returnProductSubtotal /
                        $invoiceProductTotal
                    ),
                    2
                ),

            'current_due_before_return' =>
                $currentDue,

            'adjust_due_amount' =>
                $adjustDueAmount,

            'refund_amount' =>
                $refundAmount,

            'refund_payment_type' =>
                $refundAmount > 0
                    ? $paymentType
                    : null,

            'remaining_due' =>
                round(
                    max(
                        0,
                        $currentDue -
                        $adjustDueAmount
                    ),
                    2
                ),

            'return_status' =>
                $finalStatus,
        ]);

    } catch (\Throwable $e) {

        // =====================================================
        // ROLLBACK
        // =====================================================

        $db->transRollback();

        log_message(
            'error',
            'Sales Return Error: '
            . $e->getMessage()
            . "\nTrace: "
            . $e->getTraceAsString()
        );

        return $this->response->setJSON([
            'status'  => 'error',
            'message' => $e->getMessage(),
        ]);
    }
}
}
