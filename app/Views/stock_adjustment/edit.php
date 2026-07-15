<?php
echo $this->extend('layout');
echo $this->section('content');
?>
<div class="container mt-4">

<div class="card">

<div class="card-header bg-primary text-white">
Edit Stock Adjustment
</div>

<div class="card-body">

<form method="post" action="<?= site_url('stockAdjustmentUpdate/'.$adjustment['adjustment_id']) ?>">

<div class="row">

<div class="col-md-6">

<label>Date</label>

<input type="date"
       name="adjustment_date"
       class="form-control"
       value="<?= $adjustment['adjustment_date']; ?>">

</div>

<div class="col-md-6">

<label>Type</label>

<select name="adjustment_type" class="form-control">

<option value="stock_in"
<?= $adjustment['adjustment_type']=='stock_in'?'selected':'' ?>>
Stock In
</option>

<option value="stock_out"
<?= $adjustment['adjustment_type']=='stock_out'?'selected':'' ?>>
Stock Out
</option>

</select>

</div>

</div>

<br>

<label>Reason</label>

<input type="text"
       name="reason"
       class="form-control"
       value="<?= $adjustment['reason']; ?>">

<br>

<label>Reference No</label>

<input type="text"
       name="reference_no"
       class="form-control"
       value="<?= $adjustment['reference_no']; ?>">

<br>

<label>Remarks</label>

<textarea
name="remarks"
class="form-control"><?= $adjustment['remarks']; ?></textarea>

<br>

<button class="btn btn-success">
Update
</button>

<a href="<?= site_url('stockAdjustment') ?>" class="btn btn-secondary">
Cancel
</a>

</form>

</div>

</div>

</div>

<?php
echo $this->endSection();
?>