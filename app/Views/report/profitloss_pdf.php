<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Profit & Loss Statement</title>

    <style>

        body{
            font-family: DejaVu Sans, sans-serif;
            color:#333;
            background:#fff;
        }

        .header{
            text-align:center;
            margin-top:20px;
        }

        h2{
            color:#2c3e50;
            margin-bottom:5px;
        }

        p{
            font-size:13px;
            color:#555;
        }

        table{
            width:90%;
            margin:25px auto;
            border-collapse:collapse;
            font-size:13px;
        }

        td{
            border:1px solid #ccc;
            padding:10px;
        }

        .section{
            background:#f1f5f9;
            font-weight:bold;
            color:#0f172a;
        }

        .income{
            color:#166534;
            font-weight:bold;
        }

        .expense{
            color:#b91c1c;
            font-weight:bold;
        }

        .profit{
            background:#dbeafe;
            font-weight:bold;
            font-size:15px;
        }

        .positive{
            color:#15803d;
            font-weight:bold;
        }

        .negative{
            color:#dc2626;
            font-weight:bold;
        }

        .amount{
            text-align:right;
        }

        .signature-line{
            border-top:1px dotted #000;
            width:150px;
            margin:auto;
            margin-top:70px;
        }

    </style>

</head>

<body>

<div class="header">

    <h2>Profit & Loss Statement</h2>

    <p>
        Period:
        <?= date('d M Y', strtotime($start_date)) ?>
        to
        <?= date('d M Y', strtotime($end_date)) ?>
    </p>

</div>

<table>

    <!-- ===================== -->
    <!-- SALES SECTION -->
    <!-- ===================== -->

    <tr class="section">
        <td colspan="2">Sales Information</td>
    </tr>

    <tr>
        <td>Gross Sales</td>
        <td class="amount">
            <?= number_format($gross_sales,2) ?>
        </td>
    </tr>

    <tr>
        <td>Less: Discounts</td>
        <td class="amount">
            <?= number_format($discount,2) ?>
        </td>
    </tr>

    <tr>
        <td>Less: Sales Return</td>
        <td class="amount">
            <?= number_format($return_sales,2) ?>
        </td>
    </tr>

    <tr class="income">
        <td>Net Sales</td>
        <td class="amount">
            <?= number_format($net_sales,2) ?>
        </td>
    </tr>

    <!-- ===================== -->
    <!-- COGS -->
    <!-- ===================== -->

    <tr>
        <td>Cost of Goods Sold (COGS)</td>
        <td class="amount">
            <?= number_format($total_cogs,2) ?>
        </td>
    </tr>

    <tr class="income">
        <td>Gross Profit</td>
        <td class="amount">
            <?= number_format($gross_profit,2) ?>
        </td>
    </tr>

    <!-- ===================== -->
    <!-- EXPENSE -->
    <!-- ===================== -->

    <tr class="section">
        <td colspan="2">Operating Expenses</td>
    </tr>

    <tr>
        <td>General Expenses</td>
        <td class="amount">
            <?= number_format($expense,2) ?>
        </td>
    </tr>

    <!-- VAT -->
    <tr>
        <td>VAT Collected (Liability)</td>
        <td class="amount">
            <?= number_format($vat,2) ?>
        </td>
    </tr>

    <tr class="expense">
        <td>Total Operating Expenses</td>
        <td class="amount">
            <?= number_format($expense,2) ?>
        </td>
    </tr>

    <!-- ===================== -->
    <!-- NET PROFIT -->
    <!-- ===================== -->

    <tr class="profit">

        <td>Net Profit</td>

        <td class="amount <?= ($net_profit >= 0) ? 'positive' : 'negative' ?>">

            <?= number_format($net_profit,2) ?>

        </td>

    </tr>

</table>

<!-- ===================== -->
<!-- SIGNATURE -->
<!-- ===================== -->

<table style="width:100%; border:none; margin-top:50px;">

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