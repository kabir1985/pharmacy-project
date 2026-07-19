
<?php
echo $this->extend('layout');
echo $this->section('content');
?>

<div class="container mt-4">

    <div class="card">

        <div class="card-header bg-primary text-white">
            Stock Adjustment Details
        </div>

        <div class="card-body">

            <table class="table table-bordered">

                <tr>
                    <th width="200">Adjustment No</th>
                    <td><?= $adjustment['adjustment_no']; ?></td>
                </tr>

                <tr>
                    <th>Date</th>
                    <td><?= $adjustment['adjustment_date']; ?></td>
                </tr>

                <tr>
                    <th>Type</th>
                    <td><?= ucfirst($adjustment['adjustment_type']); ?></td>
                </tr>

                <tr>
                    <th>Reason</th>
                    <td><?= $adjustment['reason']; ?></td>
                </tr>

                <tr>
                    <th>Reference No</th>
                    <td><?= $adjustment['reference_no']; ?></td>
                </tr>

                <tr>
                    <th>Remarks</th>
                    <td><?= $adjustment['remarks']; ?></td>
                </tr>

            </table>

            <a href="<?= site_url('stockAdjustment') ?>" class="btn btn-secondary">
                Back
            </a>

        </div>

    </div>

</div>


<?php
echo $this->endSection();
?>