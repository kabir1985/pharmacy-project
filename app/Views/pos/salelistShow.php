<?php
echo $this->extend('layout');
echo $this->section('content');
?>

<div class="app-title">
    <div>
        <h1><i class="fa fa-shopping-cart"></i> Sales List</h1>
    </div>
</div>

<div class="row">
    <div class="col-md-12">

        <div class="tile collapseable show animate__animated animate__fadeInUp">

            <div class="tile-body">

                <div class="table-responsive">

                    <table class="table table-bordered table-hover" id="sampleTable">

                        <thead class="thead-light">
                            <tr>
                                <th width="110">Date</th>
                                <th width="140">Invoice</th>
                                <th>Customer</th>
                                <th class="text-end">Sub Total</th>
                                <th class="text-end">Discount</th>
                                <th class="text-end">VAT</th>
                                <th class="text-end">Other Cost</th>
                                <th class="text-end">Grand Total</th>
                                <th class="text-end">Paid</th>
                                <th class="text-end">Due</th>
                                <th>Sale By</th>
                                <th width="120">Status</th>
                            </tr>
                        </thead>

                        <tbody>

                            <?php foreach ($saleList as $row): ?>

                                <?php
                                    $subTotal =
                                        $row['grand_total']
                                        + $row['product_discount']
                                        - $row['product_vat']
                                        - $row['other_charge_on_all'];

                                    $due = max(0, (float) ($row['due_balance'] ?? 0));
                                ?>

                                <tr>

                                    <td>
                                        <?= date('d-m-Y', strtotime($row['sales_date'])) ?>
                                    </td>

                                    <td>
                                        <strong><?= esc($row['sales_invoice']) ?></strong>
                                    </td>

                                    <td>
                                        <?= esc($row['customer_name'] ?? 'Walk-In Customer') ?>
                                    </td>

                                    <td class="text-end">
                                        <?= number_format($subTotal, 2) ?>
                                    </td>

                                    <td class="text-end text-danger">
                                        <?= number_format($row['product_discount'], 2) ?>
                                    </td>

                                    <td class="text-end">
                                        <?= number_format($row['product_vat'], 2) ?>
                                    </td>

                                    <td class="text-end">
                                        <?= number_format($row['other_charge_on_all'], 2) ?>
                                    </td>

                                    <td class="text-end">
                                        <strong><?= number_format($row['grand_total'], 2) ?></strong>
                                    </td>

                                    <td class="text-end text-success">
                                        <?= number_format($row['paid_amount'], 2) ?>
                                    </td>

                                    <td class="text-end text-danger">
                                        <?= number_format($due, 2) ?>
                                    </td>

                                    <td>
                                        <?= esc($row['seller_name']) ?>
                                    </td>

                                    <td class="text-center">

                                        <?php if ($row['payment_status'] == 'Fully Paid'): ?>

                                            <span class="badge bg-success">
                                                Fully Paid
                                            </span>

                                        <?php elseif ($row['payment_status'] == 'Unpaid'): ?>

                                            <span class="badge bg-danger">
                                                Unpaid
                                            </span>

                                        <?php else: ?>

                                            <span class="badge bg-warning text-dark">
                                                Partial
                                            </span>

                                        <?php endif; ?>

                                    </td>

                                </tr>

                            <?php endforeach; ?>

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>
</div>

<?php
echo $this->endSection();
?>

<?php
echo $this->section('scripts');
?>

<script>
$(document).ready(function () {

    $('#sampleTable').DataTable({

        order: [[0, 'desc']],

        pageLength: 10,

        responsive: true,

        autoWidth: false,

        columnDefs: [
            {
                targets: [3,4,5,6,7,8,9],
                className: "text-end"
            },
            {
                targets: [11],
                className: "text-center"
            }
        ]

    });

});
</script>

<?php
echo $this->endSection();
?>