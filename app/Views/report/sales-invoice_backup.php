<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Invoice</title>
  <style>
    table {
      border-collapse: collapse;
      border-spacing: 0;
      width: 100%;
      border: 1px solid #ddd;
    }

    th, td {
      text-align: left;
      padding: 8px;
      border: 1px solid #ddd;
    }

    tr:nth-child(even) {
      background-color: #f2f2f2;
    }
  </style>
</head>
<body>

<!-- Company and Invoice Header -->
<div style="overflow-x:auto;">
  <table>
    <tr>
      <th>BdPoshak.com</th>
      <th>Invoice</th>
    </tr>
    <tr>
      <td>Dhaka, Bangladesh</td>
      <td></td>
    </tr>
    <tr>
      <th colspan="2">Bill To</th>
    </tr>
    <?php
      foreach($invoice_info as $invoice_row) {
        $sales_invoice = $invoice_row['sales_invoice'];
        $sales_date = $invoice_row['sales_date'];
        $discountOnTotalPrice = $invoice_row['discountOnTotalPrice'];
        $vatOnTotalPrice = $invoice_row['vatOnTotalPrice'];
        $paid_amount = $invoice_row['paid_amount'];
      }
    ?>
    <tr>
      <td>
        Md Sumonor Rahman123<br>
        Aftabnagar, Dhaka<br>
        Mobile: 019123688547
      </td>
      <td>
        Invoice #: <strong><?= $sales_invoice; ?></strong><br>
        Date: <?= date("d-m-Y", strtotime($sales_date)); ?>
      </td>
    </tr>
  </table>
</div>

<br>

<!-- Product Table -->
<div style="overflow-x:auto;">
  <table>
    <thead>
      <tr>
        <th>Product</th>
        <th>Price</th>
        <th>Quantity</th>
        <th>Tax</th>
        <th>Total</th>
      </tr>
    </thead>
    <tbody>
      <?php
        $subtotal = 0;
        foreach ($product_info as $row) {
          $qty = $row['product_quantity_sold'];
          $price = $row['unit_price'];
          $tax = ($qty * $price) * ($row['tax_perchantage'] / 100);
          $line_total = ($qty * $price) + $tax;
          $subtotal += $line_total;
      ?>
      <tr>
        <td><?= $row['product_name']; ?></td>
        <td><?= number_format($price, 2); ?></td>
        <td><?= $qty; ?></td>
        <td><?= number_format($tax, 2); ?></td>
        <td><?= number_format($line_total, 2); ?></td>
      </tr>
      <?php } ?>

      <!-- Summary Section -->
      <tr>
        <td colspan="4" style="text-align: right;"><strong>Subtotal:</strong></td>
        <td><strong><?= number_format($subtotal, 2); ?></strong></td>
      </tr>
      <tr>
        <td colspan="4" style="text-align: right;">Discount:</td>
        <td><?= number_format($discountOnTotalPrice, 2); ?></td>
      </tr>
      <tr>
        <td colspan="4" style="text-align: right;">Subtotal Less Discount:</td>
        <td>
          <?php
            $subtotal_less_discount = $subtotal - $discountOnTotalPrice;
            echo number_format($subtotal_less_discount, 2);
          ?>
        </td>
      </tr>
      <tr>
        <td colspan="4" style="text-align: right;">Other Cost:</td>
        <td><?= number_format($vatOnTotalPrice, 2); ?></td>
      </tr>
      <tr>
        <td colspan="4" style="text-align: right;">Due:</td>
        <td>
          <?php
            $customer_due = $subtotal_less_discount + $vatOnTotalPrice;
            echo number_format($customer_due, 2);
          ?>
        </td>
      </tr>
      <tr>
        <td colspan="4" style="text-align: right;">Paid:</td>
        <td><?= number_format($paid_amount, 2); ?></td>
      </tr>
      <tr>
        <td colspan="4" style="text-align: right;"><strong>Final Due:</strong></td>
        <td><strong><?= number_format($customer_due - $paid_amount, 2); ?></strong></td>
      </tr>
    </tbody>
  </table>
</div>

</body>
</html>
