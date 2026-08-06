<!DOCTYPE html>
<html>

<head>
<meta charset="UTF-8">

<title>Profit & Loss Statement</title>

<style>

body{
    font-family: DejaVu Sans,sans-serif;
    font-size:12px;
    margin:25px;
    color:#222;
}

h2{
    text-align:center;
    margin:0;
    color:#1F4E79;
}

.subtitle{
    text-align:center;
    margin-bottom:25px;
    color:#666;
}

table{
    width:100%;
    border-collapse:collapse;
}

td{
    padding:8px;
}

th{
    padding:8px;
}

.border td,
.border th{
    border:1px dotted #777;
}

.section{
    background:#dbeeff;
    font-weight:bold;
    color:#1F4E79;
}

.amount{
    text-align:right;
    width:180px;
}

.indent{
    padding-left:25px;
}

.total{
    background:#edf7ed;
    font-weight:bold;
}

.final{
    background:#2e7d32;
    color:#fff;
    font-weight:bold;
    font-size:13px;
}

.negative{
    color:#c62828;
}

.footer{
    margin-top:25px;
    text-align:center;
    font-size:11px;
    color:#777;
}

</style>

</head>

<body>

<h2>PROFIT & LOSS STATEMENT</h2>

<div class="subtitle">
For the Period From

<b><?= date('d M Y',strtotime($start_date)); ?></b>

To

<b><?= date('d M Y',strtotime($end_date)); ?></b>

</div>


<table class="border">

<tr class="section">
    <td colspan="2">REVENUE</td>
</tr>

<tr>
    <td class="indent">Gross Sales</td>
    <td class="amount"><?= number_format($gross_sales,2) ?></td>
</tr>

<tr>
    <td class="indent">Sales Return</td>
    <td class="amount negative">(<?= number_format($return_sales,2) ?>)</td>
</tr>

<tr class="total">
    <td>NET SALES</td>
    <td class="amount"><?= number_format($net_sales,2) ?></td>
</tr>


<tr><td colspan="2">&nbsp;</td></tr>


<tr class="section">
    <td colspan="2">COST OF GOODS SOLD</td>
</tr>

<tr>
    <td class="indent">Cost of Goods Sold</td>
    <td class="amount"><?= number_format($total_cogs,2) ?></td>
</tr>

<tr>
    <td class="indent">Less : Return Cost</td>
    <td class="amount negative">(<?= number_format($return_cost,2) ?>)</td>
</tr>

<tr class="total">
    <td>NET COST OF GOODS SOLD</td>
    <td class="amount"><?= number_format($net_cogs,2) ?></td>
</tr>


<tr class="final">
    <td>GROSS PROFIT</td>
    <td class="amount"><?= number_format($gross_profit,2) ?></td>
</tr>


<tr><td colspan="2">&nbsp;</td></tr>


<tr class="section">
    <td colspan="2">OPERATING EXPENSES</td>
</tr>

<tr>
    <td class="indent">Operating Expenses</td>
    <td class="amount negative">(<?= number_format($expense,2) ?>)</td>
</tr>

<tr class="total">
    <td>OPERATING PROFIT</td>
    <td class="amount"><?= number_format($operating_profit,2) ?></td>
</tr>


<tr><td colspan="2">&nbsp;</td></tr>


<tr class="section">
    <td colspan="2">OTHER INCOME / EXPENSE</td>
</tr>

<tr>
    <td class="indent">Other Income</td>
    <td class="amount"><?= number_format($other_income,2) ?></td>
</tr>

<tr>
    <td class="indent">Financial Cost</td>
    <td class="amount negative">(<?= number_format($financial_cost,2) ?>)</td>
</tr>

<tr class="final">
    <td>NET PROFIT</td>
    <td class="amount"><?= number_format($net_profit,2) ?></td>
</tr>

</table>

<br><br>

<table class="border">

<tr class="section">
    <td colspan="2">SALES INFORMATION</td>
</tr>

<tr>
    <td>Product Discount</td>
    <td class="amount"><?= number_format($product_discount,2) ?></td>
</tr>

<tr>
    <td>Product VAT</td>
    <td class="amount"><?= number_format($vat,2) ?></td>
</tr>

<tr>
    <td>Other Charge</td>
    <td class="amount"><?= number_format($other_charge,2) ?></td>
</tr>

</table>

<div class="footer">

Generated on <?= date('d M Y h:i A'); ?>

</div>

</body>

</html>