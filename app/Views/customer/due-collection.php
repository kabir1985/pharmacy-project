<form action="<?= base_url('due-collection/save') ?>" method="post">

    <?= csrf_field() ?>

    <input type="hidden" name="due_id" value="<?= $due['due_id'] ?>">
    <input type="hidden" name="sales_id" value="<?= $due['sales_id'] ?>">
    <input type="hidden" name="customer_id" value="<?= $due['customer_id'] ?>">

    <div class="row">

        <div class="col-md-6">

            <div class="form-group">
                <label>Invoice No</label>
                <input type="text"
                       class="form-control"
                       value="<?= $due['sales_invoice'] ?>"
                       readonly>
            </div>

        </div>

        <div class="col-md-6">

            <div class="form-group">
                <label>Customer</label>
                <input type="text"
                       class="form-control"
                       value="<?= $due['customer_name'] ?>"
                       readonly>
            </div>

        </div>

    </div>

    <div class="row">

        <div class="col-md-4">

            <div class="form-group">
                <label>Grand Total</label>
                <input type="text"
                       class="form-control text-right"
                       value="<?= number_format($due['total_amount'],2) ?>"
                       readonly>
            </div>

        </div>

        <div class="col-md-4">

            <div class="form-group">
                <label>Already Paid</label>
                <input type="text"
                       class="form-control text-right"
                       value="<?= number_format($due['paid_amount'],2) ?>"
                       readonly>
            </div>

        </div>

        <div class="col-md-4">

            <div class="form-group">
                <label>Current Due</label>
                <input type="text"
                       class="form-control text-danger text-right font-weight-bold"
                       id="current_due"
                       value="<?= number_format($due['due_amount'],2) ?>"
                       readonly>
            </div>

        </div>

    </div>

    <div class="form-group">
        <label>Collection Date</label>
        <input type="date"
               class="form-control"
               name="payment_date"
               value="<?= date('Y-m-d') ?>">
    </div>

    <div class="form-group">
        <label>Collection Amount <span class="text-danger">*</span></label>

        <input type="number"
               class="form-control"
               id="payment_amount"
               name="payment_amount"
               min="0.01"
               max="<?= $due['due_amount'] ?>"
               step="0.01"
               required>
    </div>

    <div class="form-group">

        <label>Payment Method</label>

        <select class="form-control" name="payment_method">

            <option>Cash</option>
            <option>Bkash</option>
            <option>Nagad</option>
            <option>Rocket</option>
            <option>Card</option>
            <option>Bank</option>
            <option>Cheque</option>

        </select>

    </div>

    <div class="form-group">
        <label>Reference No</label>
        <input type="text"
               class="form-control"
               name="reference_no">
    </div>

    <div class="form-group">
        <label>Note</label>
        <textarea class="form-control"
                  rows="3"
                  name="note"></textarea>
    </div>

    <button class="btn btn-success">
        <i class="fa fa-save"></i>
        Save Payment
    </button>

</form>