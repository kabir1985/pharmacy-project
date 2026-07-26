<?php
echo $this->extend('layout');
echo $this->section('content');
?>

<div class="app-title">
    <div>
        <h1><i class="fa fa-money"></i> Customer Due Collection</h1>
    </div>
</div>

<div class="tile">
    <div class="tile-body">

        <table class="table table-bordered table-striped" id="sampleTable">
            <thead>
                <tr>
                    <th>Invoice</th>
                    <th>Customer</th>
                    <th>Total</th>
                    <th>Paid</th>
                    <th>Due</th>
                    <th width="120">Action</th>
                </tr>
            </thead>

            <tbody>

            <?php foreach ($due_list as $row): ?>

                <tr>

                    <td><?= esc($row['sales_invoice']) ?></td>

                    <td><?= esc($row['customer_name']) ?></td>

                    <td class="text-end"><?= number_format($row['total_amount'], 2) ?></td>

                    <td class="text-end"><?= number_format($row['paid_amount'], 2) ?></td>

                    <td class="text-end text-danger">
                        <?= number_format($row['due_amount'], 2) ?>
                    </td>

                    <td>

                        <a href="<?= site_url('payment/collect/' . $row['due_id']) ?>"
                           class="btn btn-success btn-sm">

                            <i class="fa fa-money"></i> Collect

                        </a>

                    </td>

                </tr>

            <?php endforeach; ?>

            </tbody>

        </table>

    </div>
</div>

<?php
echo $this->endSection();
?>