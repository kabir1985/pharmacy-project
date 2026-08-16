<?php
echo $this->extend('layout');
echo $this->section('content');
?>

<div class="app-title">
    <div>
        <h1>
            <i class="fa fa-undo"></i>
            Sales Return List
        </h1>
    </div>
</div>

<div class="row">
    <div class="col-md-12">

        <div class="tile collapseable show animate__animated animate__fadeInUp">

            <div class="tile-body">

                <div class="table-responsive">

                    <table
                        class="table table-hover table-bordered"
                        id="sampleTable"
                        style="width:100%;"
                    >

                        <thead>
                            <tr>
                                <th>Sales Date</th>
                                <th>Invoice</th>
                                <th>Customer</th>
                                <th>Total Sale</th>
                                <th>VAT</th>
                                <th>Discount</th>
                                <th>Other Charge</th>
                                <th>Paid</th>
                                <th>Due</th>
                                <th>Status</th>
                            </tr>
                        </thead>

                        <tbody>

                            <?php if (!empty($saleReturnList)): ?>

                                <?php foreach ($saleReturnList as $row): ?>

                                    <tr>

                                        <!-- Sales Date -->
                                        <td>
                                            <?php
                                            if (!empty($row['sales_date'])) {
                                                echo esc(
                                                    date(
                                                        'd-m-Y',
                                                        strtotime($row['sales_date'])
                                                    )
                                                );
                                            } else {
                                                echo '-';
                                            }
                                            ?>
                                        </td>

                                        <!-- Invoice -->
                                        <td>
                                            <strong>
                                                <?= esc($row['sales_invoice'] ?? '-') ?>
                                            </strong>
                                        </td>

                                        <!-- Customer -->
                                        <td>
                                            <?= esc(
                                                !empty($row['customer_name'])
                                                    ? $row['customer_name']
                                                    : 'Walk-In Customer'
                                            ) ?>
                                        </td>

                                        <!-- Total Sale -->
                                        <td class="text-end">
                                            <?= number_format(
                                                (float) ($row['total_sale'] ?? 0),
                                                2
                                            ) ?>
                                        </td>

                                        <!-- VAT -->
                                        <td class="text-end">
                                            <?= number_format(
                                                (float) ($row['product_vat'] ?? 0),
                                                2
                                            ) ?>
                                        </td>

                                        <!-- Discount -->
                                        <td class="text-end">
                                            <?= number_format(
                                                (float) ($row['product_discount'] ?? 0),
                                                2
                                            ) ?>
                                        </td>

                                        <!-- Other Charge -->
                                        <td class="text-end">
                                            <?= number_format(
                                                (float) ($row['other_charge_on_all'] ?? 0),
                                                2
                                            ) ?>
                                        </td>

                                        <!-- Paid -->
                                        <td class="text-end">
                                            <?= number_format(
                                                (float) ($row['total_paid'] ?? 0),
                                                2
                                            ) ?>
                                        </td>

                                        <!-- Due -->
                                        <td class="text-end">
                                            <?= number_format(
                                                (float) ($row['customer_due'] ?? 0),
                                                2
                                            ) ?>
                                        </td>

                                        <!-- Payment Status -->
                                        <td class="text-center">

                                            <?php if (
                                                ($row['payment_status'] ?? '') === 'Fully Paid'
                                            ): ?>

                                                <span class="badge bg-success text-white">
                                                    Fully Paid
                                                </span>

                                            <?php else: ?>

                                                <span class="badge bg-danger text-white">
                                                    Partially Paid
                                                </span>

                                            <?php endif; ?>

                                        </td>

                                    </tr>

                                <?php endforeach; ?>

                            <?php else: ?>

                                <tr>
                                    <td
                                        colspan="10"
                                        class="text-center text-muted"
                                    >
                                        No sales available for return.
                                    </td>
                                </tr>

                            <?php endif; ?>

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
        pageLength: 25,
        order: [[0, 'desc']],
        responsive: true,
        autoWidth: false
    });

});
</script>

<?php
echo $this->endSection();
?>
