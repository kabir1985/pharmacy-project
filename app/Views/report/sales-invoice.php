<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Invoice - <?= $invoice_info[0]['sales_invoice'] ?></title>
    <style>
    body {
        font-family: DejaVu Sans, sans-serif;
        margin: 0;
        padding: 0;
        font-size: 12px;
        color: #333;
    }

    .invoice-container {
        max-width: 900px;
        margin: auto;
        padding: 20px;
    }

    header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 20px;
    }

    header h2 {
        margin: 0;
        color: #2E86C1;
        font-size: 24px;
    }

    .invoice-info p {
        margin: 2px 0;
        font-size: 14px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;
    }

    th,
    td {
        border: 1px solid #ddd;
        padding: 8px;
        font-size: 12px;
    }

    th {
        background-color: #f7f7f7;
        text-align: left;
    }

    td.text-right {
        text-align: right;
    }

    tfoot tr th,
    tfoot tr td {
        font-weight: bold;
        border-top: 1px solid #0e0d0dff;
    }

    .totals-row th,
    .totals-row td {
        background-color: #f9f9f9;
    }

    @media only screen and (max-width: 768px) {
        header {
            flex-direction: column;
            align-items: flex-start;
        }

        .invoice-info {
            margin-top: 10px;
        }

        th,
        td {
            font-size: 11px;
            padding: 6px;
        }
    }

    .footer-note {
        text-align: center;
        font-size: 11px;
        color: #777;
        margin-top: 20px;
    }
    </style>
</head>

<body>
    <div class="invoice-container">
        <header>
            <h2>Invoice</h2>
            <div class="invoice-info">
                <p><strong>No:</strong> <?= $invoice_info[0]['sales_invoice'] ?></p>
                <p><strong>Date:</strong> <?= date('d-m-Y H:i', strtotime($invoice_info[0]['sales_date'])) ?></p>
                <p><strong>Customer:</strong> <?= $invoice_info[0]['customer_type'] ?></p>
            </div>
        </header>

        <table>
            <thead>
                <tr>
                    <th>S/L</th>
                    <th>Product</th>
                    <th>Qty</th>
                    <th>Unit Price</th>
                    <th>VAT (%)</th>
                    <th>VAT Amt</th>
                    <th>Discount (%)</th>
                    <th>Discount Amt</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $total_base = 0;
                $total_vat = 0;
                $total_discount = 0;
                $grand_total = 0;

                foreach ($product_info as $key => $item):
                    $item_vat_amt = $item['unit_price'] * $item['product_quantity_sold'] * ($item['vat_percentage'] ?? 0) / 100;
                    $item_discount_amt = $item['unit_price'] * $item['product_quantity_sold'] * ($item['discount_percent'] ?? 0) / 100;
                    $item_subtotal = ($item['unit_price'] * $item['product_quantity_sold']) + $item_vat_amt - $item_discount_amt;

                    $total_base += $item['unit_price'] * $item['product_quantity_sold'];
                    $total_vat += $item_vat_amt;
                    $total_discount += $item_discount_amt;
                    $grand_total += $item_subtotal;
                ?>
                <tr>
                    <td><?= $key + 1 ?></td>
                    <td><?= $item['product_name'] ?></td>
                    <td><?= $item['product_quantity_sold'] ?></td>
                    <td class="text-right"><?= number_format($item['unit_price'], 2) ?></td>
                    <td class="text-right"><?= number_format($item['vat_percentage'], 2) ?></td>
                    <td class="text-right"><?= number_format($item_vat_amt, 2) ?></td>
                    <td class="text-right"><?= number_format($item['discount_percent'], 2) ?></td>
                    <td class="text-right"><?= number_format($item_discount_amt, 2) ?></td>
                    <td class="text-right"><?= number_format($item_subtotal, 2) ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr class="totals-row">
                    <th colspan="5" class="text-right">Totals</th>
                    <th class="text-right"><?= number_format($total_vat, 2) ?></th>
                    <th></th>
                    <th class="text-right"><?= number_format($total_discount, 2) ?></th>
                    <th class="text-right"><?= number_format($grand_total, 2) ?></th>
                </tr>

                <!-- <tr class="totals-row">
                    <th colspan="8" class="text-right">VAT on Total</th>
                    <td class="text-right"><?= number_format($invoice_info[0]['vatOnTotalPrice'], 2) ?></td>
                </tr> -->
                <tr class="totals-row">
                    <th colspan="8">
                        <div style="text-align: right;">VAT on Total</div>
                    </th>
                    <td class="text-right"><?= number_format($invoice_info[0]['vatOnTotalPrice'], 2) ?></td>
                </tr>

                <!-- <tr class="totals-row">
                    <th colspan="8" class="text-right">Discount on Total</th>
                    <td class="text-right"><?= number_format($invoice_info[0]['discountOnTotalPrice'], 2) ?></td>
                </tr> -->


                <tr class="totals-row">
                    <th colspan="8">
                        <div style="text-align: right;">Discount on Total</div>
                    </th>
                    <td class="text-right"><?= number_format($invoice_info[0]['discountOnTotalPrice'], 2) ?></td>
                </tr>

                <!-- <tr class="totals-row">
                    <th colspan="8" class="text-right">Paid Amount</th>
                    <td class="text-right"><?= number_format($invoice_info[0]['paid_amount'], 2) ?></td>
                </tr> -->

                <tr class="totals-row">
                    <th colspan="8">
                        <div style="text-align: right;">Paid Amount</div>
                    </th>
                    <td class="text-right"><?= number_format($invoice_info[0]['paid_amount'], 2) ?></td>
                </tr>
                <tr class="totals-row">
                    <th colspan="8">
                        <div style="text-align: right;">Due Amount</div>
                    </th>
                    <td class="text-right"><?= number_format($invoice_info[0]['due_amount'], 2) ?></td>
                </tr>
            </tfoot>
        </table>

        <div class="footer-note">
            Thank you for your purchase!<br>
            Powered by Your Company Name
        </div>
    </div>
</body>

</html>