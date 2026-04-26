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

        h2 {
            color: #2c3e50;
            margin-bottom: 5px;
        }

        p {
            font-size: 14px;
            color: #555;
        }

        table {
            width: 85%;
            margin: 30px auto;
            border-collapse: collapse;
            font-size: 14px;
            border: 1px solid #ccc;
        }

        td {
            padding: 10px 14px;
            border: 1px solid #ddd;
        }

        .label {
            font-weight: bold;
        }

        .income {
            background: #e8f5e9;
            font-weight: bold;
            color: #1b5e20;
        }

        .expense {
            background: #ffebee;
            font-weight: bold;
            color: #b71c1c;
        }

        .netprofit {
            background: #e3f2fd;
            font-weight: bold;
            color: #0d47a1;
        }

        .positive {
            color: #28a745;
            font-weight: bold;
        }

        .negative {
            color: #dc3545;
            font-weight: bold;
        }

        .signature-line {
            border-top: 1px dotted #000;
            width: 150px;
            margin: 0 auto 5px auto;
        }

        .signature-label {
            text-align: center;
        }
    </style>
</head>

<body>

<div class="header">
    <h2>Profit & Loss Statement</h2>
    <p>
        Period: <?= date('d M Y', strtotime($start_date)) ?> 
        to <?= date('d M Y', strtotime($end_date)) ?>
    </p>
</div>

<table>

    <!-- ===================== -->
    <!-- REVENUE SECTION -->
    <!-- ===================== -->
    <tr class="income">
        <td class="label">Total Sales Revenue</td>
        <td><?= number_format($total_sales, 2) ?></td>
    </tr>

    <tr>
        <td class="label">Cost of Goods Sold (COGS)</td>
        <td><?= number_format($total_cogs, 2) ?></td>
    </tr>

    <tr class="income">
        <td class="label">Gross Profit</td>
        <td><?= number_format($gross_profit, 2) ?></td>
    </tr>

    <!-- ===================== -->
    <!-- EXPENSE SECTION -->
    <!-- ===================== -->
    <tr>
        <td class="label">Discounts Given</td>
        <td><?= number_format($discountOnTotalPrice, 2) ?></td>
    </tr>

    <tr>
        <td class="label">General Expenses</td>
        <td><?= number_format($expense, 2) ?></td>
    </tr>

    <!-- VAT FIXED (NOT EXPENSE) -->
    <tr>
        <td class="label">VAT Collected (Liability)</td>
        <td><?= number_format($vatOnTotalPrice, 2) ?></td>
    </tr>

    <tr class="expense">
        <td class="label">Total Operating Expenses</td>
        <td>
            <?= number_format($discountOnTotalPrice + $expense, 2) ?>
        </td>
    </tr>

    <!-- ===================== -->
    <!-- NET PROFIT -->
    <!-- ===================== -->
    <tr class="netprofit">
        <td class="label">Net Profit</td>
        <td class="<?= $net_profit >= 0 ? 'positive' : 'negative' ?>">
            <?= number_format($net_profit, 2) ?>
        </td>
    </tr>

</table>

<!-- ===================== -->
<!-- SIGNATURE -->
<!-- ===================== -->
<table style="width:100%; border:none; margin-top:80px;">
    <tr>
        <td style="border:none; text-align:center;">
            <div class="signature-line"></div>
            Prepared By
        </td>
        <td style="border:none; text-align:center;">
            <div class="signature-line"></div>
            Checked By
        </td>
        <td style="border:none; text-align:center;">
            <div class="signature-line"></div>
            Approved By
        </td>
    </tr>
</table>

</body>
</html>