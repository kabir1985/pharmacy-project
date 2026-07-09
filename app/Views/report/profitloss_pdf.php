<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Profit & Loss Statement</title>

    <style>
body {
    font-family: DejaVu Sans, sans-serif;
    font-size: 12px;
    margin: 25px;
    color: #222;
}

h2 {
    text-align: center;
    margin: 0;
    font-size: 20px;
    color: #1F4E79;
}

h4 {
    text-align: center;
    margin: 5px 0 25px;
    font-weight: normal;
    color: #555;
}

table {
    width: 100%;
    border-collapse: collapse;
}

.dotted-table {
    width: 100%;
    border-collapse: collapse;
}

.dotted-table td,
.dotted-table th {
    border: 1px dotted #666;
    padding: 8px;
}

td {
    padding: 8px 10px;
}

.title {
    font-weight: bold;
    color: #1F4E79;
    background: #D9EAF7;
    border-top: 1px solid #A9C7E3;
    border-bottom: 1px solid #A9C7E3;
}

.particular {
    width: 75%;
}

.amount {
    width: 25%;
    text-align: right;
}

.indent {
    padding-left: 25px;
}

.line td {
    border-bottom: 1px dashed #bbb;
}

.profit {
    background: #E8F5E9;
    font-weight: bold;
    color: #2E7D32;
}

.double td {
    background: #2E7D32;
    color: #fff;
    font-weight: bold;
    font-size: 13px;
    border-top: 2px solid #1B5E20;
    border-bottom: 2px solid #1B5E20;
}

.negative {
    color: #C62828;
}

.space td {
    padding: 6px;
}

.footer {
    margin-top: 30px;
    text-align: center;
    font-size: 11px;
    color: #777;
}
    </style>

</head>

<body>

<div style="text-align:center; margin-bottom:20px;">
    <h2>PROFIT & LOSS STATEMENT</h2>
    <div style="font-size:13px;color:#555;">
        For the Period From
        <strong><?= date('d M, Y', strtotime($start_date)); ?></strong>
        To
        <strong><?= date('d M, Y', strtotime($end_date)); ?></strong>
    </div>
</div>


<!-- <table style="margin-bottom:20px;">
    <tr style="background:#1F4E79;color:#fff;">
        <td><strong>Gross Sales</strong></td>
        <td align="right"><strong><?= number_format($gross_sales,2) ?></strong></td>

        <td><strong>Gross Profit</strong></td>
        <td align="right"><strong><?= number_format($gross_profit,2) ?></strong></td>
    </tr>

    <tr style="background:#E8F5E9;">
        <td><strong>Net Sales</strong></td>
        <td align="right"><strong><?= number_format($net_sales,2) ?></strong></td>

        <td><strong>Net Profit</strong></td>
        <td align="right"><strong><?= number_format($net_profit,2) ?></strong></td>
    </tr>
</table> -->



<table class="dotted-table">

<tr class="title">
    <td colspan="2">Revenue</td>
</tr>

<tr>
    <td class="particular indent">Gross Sales</td>
    <td class="amount"><?= number_format($gross_sales,2) ?></td>
</tr>

<tr>
    <td class="particular indent">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Less : Product Discount</td>
    <td class="amount negative">(<?= number_format($product_discount,2) ?>)</td>
</tr>

<tr>
    <td class="particular indent">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Less : Invoice Discount</td>
    <td class="amount negative">(<?= number_format($invoice_discount,2) ?>)</td>
</tr>

<tr>
    <td class="particular indent">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Less : VAT</td>
    <td class="amount negative">(<?= number_format($vat,2) ?>)</td>
</tr>

<tr>
    <td class="particular indent">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Less : Sales Return</td>
    <td class="amount negative">(<?= number_format($return_sales,2) ?>)</td>
</tr>

<tr>
    <td class="particular indent">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Add : Other Charges</td>
    <td class="amount"><?= number_format($other_charge,2) ?></td>
</tr>

<tr class="line">
    <td colspan="2"></td>
</tr>

<tr class="profit">
    <td>NET SALES</td>
    <td class="amount"><?= number_format($net_sales,2) ?></td>
</tr>

<tr class="space"><td colspan="2"></td></tr>

<tr class="title">
    <td colspan="2">Cost of Sales</td>
</tr>

<tr>
    <td class="particular indent">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Cost of Goods Sold</td>
    <td class="amount"><?= number_format($total_cogs,2) ?></td>
</tr>

<tr>
    <td class="particular indent">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Less : Return Cost</td>
    <td class="amount negative">(<?= number_format($return_cost,2) ?>)</td>
</tr>

<tr class="line">
    <td colspan="2"></td>
</tr>

<tr class="profit">
    <td>NET COST OF GOODS SOLD</td>
    <td class="amount"><?= number_format($net_cogs,2) ?></td>
</tr>

<tr class="double">
    <td>GROSS PROFIT</td>
    <td class="amount"><?= number_format($gross_profit,2) ?></td>
</tr>

<tr class="space"><td colspan="2"></td></tr>

<tr class="title">
    <td colspan="2">Operating Expenses</td>
</tr>

<tr>
    <td class="particular indent">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Operating Expenses</td>
    <td class="amount negative">(<?= number_format($expense,2) ?>)</td>
</tr>

<tr class="line">
    <td colspan="2"></td>
</tr>

<tr class="profit">
    <td>OPERATING PROFIT</td>
    <td class="amount"><?= number_format($operating_profit,2) ?></td>
</tr>

<tr class="space"><td colspan="2"></td></tr>

<tr class="title">
    <td colspan="2">Other Income / Expenses</td>
</tr>

<tr>
    <td class="particular indent">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Other Income</td>
    <td class="amount"><?= number_format($other_income,2) ?></td>
</tr>

<tr>
    <td class="particular indent">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Financial Cost</td>
    <td class="amount negative">(<?= number_format($financial_cost,2) ?>)</td>
</tr>

<tr class="double">
    <td>NET PROFIT</td>
    <td class="amount"><?= number_format($net_profit,2) ?></td>
</tr>

</table>

<div class="footer">
    Generated on <?= date('d M Y h:i A'); ?>
</div>

</body>

</html>