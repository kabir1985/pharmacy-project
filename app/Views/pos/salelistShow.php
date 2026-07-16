<?php
echo $this->extend('layout');
echo $this->section('content');
?>

<div class='app-title'>
    <div>
        <h1><i class='fa fa-th-list'></i> See All Sales List</h1>
        <!-- <p>Table to display analytical data effectively</p> -->
    </div>

    <!-- Button trigger modal -->
    <!-- <button type='button' class='btn btn-primary btn-sm' data-toggle='modal' data-target='#'>
        <i class='fa fa-plus'></i>
        Button
    </button> -->
</div>
<!---------------Data Table start Here----..............................................--------------------------->
<div class='row'>
    <div class='col-md-12'>
        <div class='tile collapseable show animate__animated  animate__fadeInUp'>
            <div class='tile-body'>
                <div class='table-responsive'>
                    <table class='table table-hover table-bordered' id='sampleTable'>
                    <thead>
    <tr>
        <th>Sales Date</th>
        <th>Invoice</th>
        <th>Customer</th>
        <th>Sub Total</th>
        <th>VAT</th>
        <th>Other Cost</th>
        <th>Grand Total</th>
        <th>Paid</th>
        <th>Due</th>
        <th>Sale By</th>
        <th>Status</th>
    </tr>
</thead>

<tbody>
<?php foreach ($saleList as $row): ?>
<tr>

    <td><?= date('d-m-Y', strtotime($row['sales_date'])) ?></td>

    <td><?= esc($row['sales_invoice']) ?></td>

    <td><?= esc($row['customer_name']) ?></td>

    <td class="text-end">
        <?= number_format($row['total_sale'],2) ?>
    </td>

    <td class="text-end">
        <?= number_format($row['product_vat'],2) ?>
    </td>

    <td class="text-end">
        <?= number_format($row['other_charge_on_all'],2) ?>
    </td>

    <td class="text-end">
        <strong><?= number_format($row['grand_total'],2) ?></strong>
    </td>

    <td class="text-end text-success">
        <?= number_format($row['total_paid'],2) ?>
    </td>

    <td class="text-end text-danger">
        <?= number_format($row['customer_due'],2) ?>
    </td>

    <td><?= esc($row['seller_name']) ?></td>

    <td class="text-center">
        <?php if($row['payment_status']=='Fully Paid'): ?>

            <span class="badge bg-success">
                Fully Paid
            </span>

        <?php else: ?>

            <span class="badge bg-warning text-dark">
                Partially Paid
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
<!---------------Data Table End Here-----------............................................-------------------->
<?php
echo $this->endSection();
?>

<?php
echo $this->section('scripts');
?>

<!-- Data table plugin-->
<script type='text/javascript' src="<?php echo base_url('assets/js/plugins/jquery.dataTables.min.js') ?>"></script>
<script type='text/javascript' src="<?php echo base_url('assets/js/plugins/dataTables.bootstrap.min.js') ?>"></script>

<!-- Google analytics script-->
<script type='text/javascript'>
  $('#sampleTable').DataTable({
    order: [[0, 'desc']],
    pageLength: 25,
    responsive: true,
    autoWidth: false
});

    // ...............For Date Show.............................
    $('.datePicker').datepicker({
        format: "dd-mm-yyyy",
        autoclose: true,
        todayHighlight: true
    });
    //.................For Date show end........................ 
</script>

<!-- For Calendar start -->

<!-- For Calendar End -->

<?php
echo $this->endSection();
?>