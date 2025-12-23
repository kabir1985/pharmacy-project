<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Profit & Loss Statement</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            color: #333;
            background: #fff;
        }

        .header {
            text-align: center;
            margin-top: 20px;
        }

        .header img {
            max-height: 80px;
        }

        h2 {
            margin-bottom: 5px;
            color: #2c3e50;
        }

        p {
            text-align: center;
            margin-top: 0;
            font-size: 14px;
            color: #555;
        }

        table {
            width: 85%;
            margin: 30px auto;
            border-collapse: collapse;
            font-size: 14px;
            border: 0.5px solid #ccc;
        }

        td {
            padding: 10px 14px;
            border: 0.5px solid #ccc;
        }

        .label {
            font-weight: bold;
        }

        .highlight-income {
            background-color: #d4edda;
            font-weight: bold;
            color: #155724;
        }

        .highlight-expense {
            background-color: #f8d7da;
            font-weight: bold;
            color: #721c24;
        }

        .highlight-netprofit {
            background-color: #cce5ff;
            font-weight: bold;
            color: #004085;
        }

        .negative {
            color: #dc3545;
            font-weight: bold;
        }

        .positive {
            color: #28a745;
            font-weight: bold;
        }

        .signature-box {
            width: 100%;
            padding: 20px;
        }

        .signature-line {
            border-top: 1px dotted #000;
            width: 150px;
            margin: 0 auto 5px auto;
            height: 1px;
        }

        .signature-label {
            /* font-weight: bold; */
            margin-top: 5px;
        }
    </style>
</head>

<body>

    <div class="header">
        <!-- <img src="<?//= base_url('public/uploads/company_logo.png') ?>" alt="Company Logo"> -->
        <h2>Profit & Loss Statement</h2>
        <p>Period: <?= date('d M Y', strtotime($start_date)) ?> to <?= date('d M Y', strtotime($end_date)) ?></p>
    </div>

    <table>
        <tr>
            <td class="label">Total Income (Sales)</td>
            <td><?= number_format($total_sales, 2) ?></td>
        </tr>
        <tr>
            <td class="label">Total Credit Sales (Unpaid)</td>
            <td><?= number_format($total_credit_sales, 2) ?></td>
        </tr>
        <tr>
            <td class="label">Cost of Goods Sold (COGS)</td>
            <td><?= number_format($total_cogs, 2) ?></td>
        </tr>
        <tr class="highlight-income">
            <td class="label">Gross Profit</td>
            <td><?= number_format($gross_profit, 2) ?></td>
        </tr>
        <tr>
            <td class="label">Discounts</td>
            <td><?= number_format($total_discount, 2) ?></td>
        </tr>
        <tr>
            <td class="label">Other Costs</td>
            <td><?= number_format($total_others_cost, 2) ?></td>
        </tr>
        <tr>
            <td class="label">General Expenses</td>
            <td><?= number_format($general_expense, 2) ?></td>
        </tr>
        <tr class="highlight-expense">
            <td class="label">Total Expenses</td>
            <td><?= number_format($total_discount + $total_others_cost + $general_expense, 2) ?></td>
        </tr>
        <tr class="highlight-netprofit">
            <td class="label">Net Profit</td>
            <td class="<?= $net_profit >= 0 ? 'positive' : 'negative' ?>">
                <?= number_format($net_profit, 2) ?>
            </td>
        </tr>
    </table>




    <table style="width: 100%; border-collapse: collapse; border: none; margin-top: 80px;">
        <tr>
            <td style="border: none; text-align: center;">
                <div class="signature-box">
                    <div class="signature-line"></div>
                    <div class="signature-label">Prepared By</div>
                </div>
            </td>
            <td style="border: none; text-align: center;">
                <div class="signature-box">
                    <div class="signature-line"></div>
                    <div class="signature-label">Checked By</div>
                </div>
            </td>
            <td style="border: none; text-align: center;">
                <div class="signature-box">
                    <div class="signature-line"></div>
                    <div class="signature-label">Approved By</div>
                </div>
            </td>
        </tr>
    </table>



</body>

</html>