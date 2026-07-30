<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Invoice - <?= esc($invoice_info[0]['sales_invoice']) ?></title>

    <style>
        @page {
            margin: 5mm;
        }

        body {
            width: 72mm;
            margin: 0;
            color: #000;
            font-family: DejaVu Sans, sans-serif;
            font-size: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        td,
        th {
            padding: 2px 0;
            vertical-align: top;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .product-name {
            font-weight: bold;
            padding-top: 4px;
        }

        .grand-total {
            border-top: 1px dashed #000;
            border-bottom: 1px dashed #000;
            font-weight: bold;
            font-size: 12px;
        }

        hr {
            border: none;
            border-top: 1px dashed #000;
            margin: 5px 0;
        }

        .footer {
            margin-top: 10px;
            text-align: center;
            font-size: 9px;
            line-height: 1.4;
        }
    </style>
</head>

<body>

    <!-- ========================= -->
    <!-- Pharmacy Information -->
    <!-- ========================= -->

    <div class="text-center">

        <div style="font-size:18px;font-weight:bold;">
            YOUR PHARMACY NAME
        </div>

        House #10, Road #05, Dhaka<br>
        Phone: 017XXXXXXXX<br>
        Email: info@yourpharmacy.com

    </div>

    <hr>

    <!-- ========================= -->
    <!-- Invoice Information -->
    <!-- ========================= -->

    <table>

        <tr>
            <td>Invoice</td>
            <td class="text-right">
                <?= esc($invoice_info[0]['sales_invoice']) ?>
            </td>
        </tr>

        <tr>
            <td>Date</td>
            <td class="text-right">
                <?= date('d-m-Y h:i A', strtotime($invoice_info[0]['sales_date'])) ?>
            </td>
        </tr>

        <tr>
            <td>Customer</td>
            <td class="text-right">
                <?= esc($invoice_info[0]['customer_name']) ?>
            </td>
        </tr>

        <?php if (!empty($invoice_info[0]['phone'])) : ?>
            <tr>
                <td>Phone</td>
                <td class="text-right">
                    <?= esc($invoice_info[0]['phone']) ?>
                </td>
            </tr>
        <?php endif; ?>

        <?php if (!empty($invoice_info[0]['address'])) : ?>
            <tr>
                <td>Address</td>
                <td class="text-right">
                    <?= esc($invoice_info[0]['address']) ?>
                </td>
            </tr>
        <?php endif; ?>

        <tr>
            <td>Payment</td>
            <td class="text-right">
                <?= esc($invoice_info[0]['payment_type']) ?>
            </td>
        </tr>

        <tr>
            <td>Status</td>
            <td class="text-right">
                <?= esc($invoice_info[0]['payment_status']) ?>
            </td>
        </tr>

    </table>

    <hr>

    <!-- ========================= -->
    <!-- Product List -->
    <!-- ========================= -->

    <?php
    $subTotal = 0;
    $sl = 1;
    ?>

    <table>

        <?php foreach ($product_info as $row) : ?>

            <?php $subTotal += (float)$row['total_sale_price']; ?>

            <tr>
                <td colspan="2" class="product-name">
                    <?= $sl++ ?>.
                    <?= esc($row['product_name']) ?>
                </td>
            </tr>

            <tr>
                <td>
                    <?= number_format($row['product_quantity_sold'], 2) ?>
                    ×
                    <?= number_format($row['unit_price'], 2) ?>
                </td>

                <td class="text-right">
                    <?= number_format($row['total_sale_price'], 2) ?>
                </td>
            </tr>

        <?php endforeach; ?>

    </table>

    <hr>

    <!-- ========================= -->
    <!-- Invoice Summary -->
    <!-- ========================= -->

    <table>

        <tr>
            <td>Subtotal</td>
            <td class="text-right">
                <?= number_format($subTotal, 2) ?>
            </td>
        </tr>

        <?php if ((float)$invoice_info[0]['product_discount'] > 0) : ?>
            <tr>
                <td>Discount</td>
                <td class="text-right">
                    -<?= number_format($invoice_info[0]['product_discount'], 2) ?>
                </td>
            </tr>
        <?php endif; ?>

        <?php if ((float)$invoice_info[0]['product_vat'] > 0) : ?>
            <tr>
                <td>VAT</td>
                <td class="text-right">
                    +<?= number_format($invoice_info[0]['product_vat'], 2) ?>
                </td>
            </tr>
        <?php endif; ?>

        <?php if ((float)$invoice_info[0]['other_charge_on_all'] > 0) : ?>
            <tr>
                <td>Other Charge</td>
                <td class="text-right">
                    +<?= number_format($invoice_info[0]['other_charge_on_all'], 2) ?>
                </td>
            </tr>
        <?php endif; ?>

        <tr class="grand-total">
            <td>Grand Total</td>
            <td class="text-right">
                <?= number_format($invoice_info[0]['grand_total'], 2) ?>
            </td>
        </tr>

        <tr>
            <td>Paid</td>
            <td class="text-right">
                <?= number_format($invoice_info[0]['paid_amount'], 2) ?>
            </td>
        </tr>

        <?php if ($invoice_due > 0) : ?>
            <tr>
                <td>Due</td>
                <td class="text-right">
                    <?= number_format($invoice_due, 2) ?>
                </td>
            </tr>
        <?php endif; ?>

    </table>

    <hr>

    <!-- ========================= -->
    <!-- Footer -->
    <!-- ========================= -->

    <div class="footer">

        <strong>THANK YOU</strong><br>

        Please visit again.<br>

        Medicines once sold cannot be returned.<br><br>

        <strong>Powered By</strong><br>
        Pharmacy Management System

    </div>

    <script>
        window.onload = function () {
            window.print();
        };
    </script>

</body>

</html>