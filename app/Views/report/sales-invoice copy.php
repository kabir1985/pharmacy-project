<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Invoice - <?= esc($invoice_info[0]['sales_invoice']) ?></title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #222;
            margin: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        .company {
            text-align: center;
            border-bottom: 2px solid #000;
            margin-bottom: 20px;
            padding-bottom: 10px;
        }

        .company h2 {
            margin: 0;
            font-size: 26px;
        }

        .company p {
            margin: 2px 0;
        }

        .info {
            margin-bottom: 12px;
        }

        .info td {
            border: none;
            padding: 3px;
            vertical-align: top;
        }

        .product-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
            border: 0.8px solid #666;
        }

        .product-table th {
            background: #e9ecef;
            border: 0.8px solid #666;
            padding: 8px;
            font-weight: bold;
            text-align: center;
        }

        .product-table td {
            border: 0.6px solid #999;
            padding: 7px;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .summary-label {
            font-weight: bold;
            background: #fafafa;
            width: 60%;
        }

        .summary-amount {
            width: 40%;
            text-align: right;
        }

        .grand-total {
            background: #f3f3f3;
            font-weight: bold;
            font-size: 13px;
        }

        .grand-total td {
            border-top: 1.5px solid #444;
        }

        .remark {
            height: 120px;
            vertical-align: top;
        }
    </style>

</head>

<body>

    <div class="company">

        <h2>YOUR PHARMACY NAME</h2>

        <p>House #10, Road #05, Dhaka, Bangladesh</p>

        <p>Phone : 017XXXXXXXX</p>

        <p>Email : info@yourpharmacy.com</p>

    </div>


    <table class="info">

        <tr>

            <td width="60%">

                <strong>Invoice No :</strong>
                <?= esc($invoice_info[0]['sales_invoice']) ?>

                <br><br>

                <strong>Customer :</strong>
                <?= esc($invoice_info[0]['customer_name']) ?>

                <?php if ($invoice_info[0]['customer_name'] != 'Walk-In-Customer'): ?>

                    <br>

                    <strong>Phone :</strong>
                    <?= esc($invoice_info[0]['cus_phone']) ?>

                    <br>

                    <strong>Address :</strong>
                    <?= esc($invoice_info[0]['cus_address']) ?>

                <?php endif; ?>

            </td>

            <td align="right">

                <strong>Date :</strong>

                <?= date('d-m-Y', strtotime($invoice_info[0]['sales_date'])) ?>

                <br><br>

                <strong>Time :</strong>

                <?= date('h:i A', strtotime($invoice_info[0]['sales_date'])) ?>

                <br><br>

                <strong>Payment :</strong>

                <?= esc($invoice_info[0]['payment_type']) ?>

            </td>

        </tr>

    </table>


    <table class="product-table">

        <thead>

            <tr>

                <th width="6%">SL</th>

                <th>Medicine Name</th>

                <th width="10%">Qty</th>

                <th width="18%">Price</th>

                <th width="18%">Total Amt (TK)</th>

            </tr>

        </thead>

        <tbody>

            <?php

            $sl = 1;
            $subTotal = 0;

            foreach ($product_info as $row):

                $subTotal += $row['total_sale_price'];

                ?>

                <tr>

                    <td class="text-center">

                        <?= $sl++ ?>

                    </td>

                    <td>

                        <?= esc($row['product_name']) ?>

                    </td>

                    <td class="text-center">

                        <?= $row['product_quantity_sold'] ?>

                    </td>

                    <td class="text-right">

                        <?= number_format($row['unit_price'], 2) ?>

                    </td>

                    <td class="text-right">

                        <?= number_format($row['total_sale_price'], 2) ?>

                    </td>

                </tr>

            <?php endforeach; ?>

        </tbody>

        <tfoot>

            <?php

            $rowCount = count($product_info);
            $summaryRows = 8;

            $remarkRowspan = ($summaryRows > $rowCount) ? $summaryRows : $rowCount;

            ?>

            <tr>

                <td colspan="3" rowspan="<?= $remarkRowspan ?>" class="remark">

                    <b>Remarks</b><br><br>

                    Thank you for your purchase.<br>
                    Medicine once sold cannot be returned.<br>
                    Please keep this invoice for future reference.

                </td>

                <td class="summary-label">Sub Total</td>

                <td class="text-right">

                    <?= number_format($subTotal, 2) ?>

                </td>

            </tr>

            <!-- <tr>

                <td>Product VAT</td>

                <td class="text-right">

                    <?//= number_format($invoice_info[0]['product_vat'], 2) ?>

                </td>

            </tr> -->

            <tr>

                <td>Discount</td>

                <td class="text-right">

                    <?= number_format($invoice_info[0]['product_discount'], 2) ?>

                </td>

            </tr>


            <tr>

                <td>Other Charge</td>

                <td class="text-right">

                    <?= number_format($invoice_info[0]['other_charge_on_all'], 2) ?>

                </td>

            </tr>

            <tr class="grand-total">

                <td>Grand Total</td>

                <td class="text-right">

                    <?= number_format($invoice_info[0]['total_amount'], 2) ?>

                </td>

            </tr>

            <tr>

                <td>Paid</td>

                <td class="text-right">

                    <?= number_format($invoice_info[0]['paid_amount'], 2) ?>

                </td>

            </tr>

            <tr>

                <td>Due</td>

                <td class="text-right">

                    <?= number_format($invoice_info[0]['due_amount'], 2) ?>

                </td>

            </tr>

        </tfoot>

    </table>

    <table style="width:100%;margin-top:55px">

        <tr>

            <td width="40%" align="center">

                _________________________

                <br>

                Customer Signature

            </td>

            <td width="20%"></td>

            <td width="40%" align="center">

                _________________________

                <br>

                Authorized Signature

            </td>

        </tr>

    </table>


    <div class="footer">

        <strong>Thank You For Your Purchase</strong>

        <br>

        Medicine once sold cannot be returned except according to company policy.

    </div>

</body>

</html>