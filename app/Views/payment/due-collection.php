<?php
echo $this->extend('layout');
echo $this->section('content');
?>

<div class='app-title'>
    <div>
        <h1><i class='fa fa-th-list'></i>Receive Payment From Customer</h1>
    </div>
</div>

<!---------------Data Table start Here----..............................................--------------------------->
<div class="row">
    <div class="col-md-12">

        <div class="tile collapseable show animate__animated animate__fadeInUp">

            <div class="tile-header d-flex justify-content-between align-items-center mb-3">
                <h5 class="mb-0">
                    <i class="fa fa-list"></i> Customer Due List
                </h5>
            </div>

            <div class="tile-body">

                <div class="table-responsive">

                    <table class="table table-bordered table-hover table-striped" id="sampleTable" width="100%">

                        <thead class="thead-dark">
                            <tr>
                                <th width="60">SL</th>
                                <th>Invoice No</th>
                                <th>Customer</th>
                                <th class="text-right">Grand Total</th>
                                <th class="text-right">Paid</th>
                                <th class="text-right">Due</th>
                                <th width="120" class="text-center">Action</th>
                            </tr>
                        </thead>

                        <tbody>

                            <?php if (!empty($due_list)): ?>

                            <?php $sl = 1; ?>

                            <?php foreach ($due_list as $row): ?>

                            <tr>

                                <td><?=$sl++?></td>

                                <td><?=esc($row['sales_invoice'])?></td>

                                <td><?=esc($row['customer_name'])?></td>

                                <td class="text-end">
                                    <?=number_format($row['grand_total'], 2)?>
                                </td>

                                <td class="text-end text-success">
                                    <?=number_format($row['total_paid'], 2)?>
                                </td>

                                <td class="text-end">
                                    <span class="badge bg-danger">
                                        <?=number_format($row['current_due'], 2)?>
                                    </span>
                                </td>

                                <td class="text-center">

                                    <button type="button" class="btn btn-success btn-sm btn-edit"
                                        data-due_id="<?=$row['due_id']?>" data-sales_id="<?=$row['sales_id']?>"
                                        data-customer_id="<?=$row['customer_id']?>"
                                        data-sales_invoice="<?=esc($row['sales_invoice'])?>"
                                        data-customer_name="<?=esc($row['customer_name'])?>"
                                        data-grand_total="<?=$row['grand_total']?>"
                                        data-total_paid="<?=$row['total_paid']?>"
                                        data-current_due="<?=$row['current_due']?>">

                                        <i class="fa fa-money"></i>
                                        Collect

                                    </button>

                                </td>

                            </tr>

                            <?php endforeach; ?>

                            <?php else: ?>

                            <tr>
                                <td colspan="7" class="text-center text-danger">
                                    <i class="fa fa-exclamation-circle"></i>
                                    No Due Records Found.
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
<!---------------Data Table End Here-----------............................................-------------------->

<!---------------------------Modal Form for Edit Section Load Start---------------------------------------->
<!-- Customer Payment Modal -->
<div class="modal fade" id="customerPaymentModal" tabindex="-1" role="dialog"
    aria-labelledby="customerPaymentModalLabel" aria-hidden="true">

    <div class="modal-dialog modal-lg" role="document">

        <div class="modal-content">

            <form id="customer_payment_receive_submit" action="<?=base_url('payment/collection-save')?>" method="post">

                <?=csrf_field();?>

                <!-- Hidden Fields -->
                <input type="hidden" id="due_id" name="due_id">
                <input type="hidden" id="sales_id" name="sales_id">
                <input type="hidden" id="customer_id" name="customer_id">

                <!-- Header -->
                <div class="modal-header bg-success text-white">

                    <h5 class="modal-title" id="customerPaymentModalLabel">
                        <i class="fa fa-money"></i> Customer Due Collection
                    </h5>

                    <button type="button" class="close text-white" data-dismiss="modal">
                        <span>&times;</span>
                    </button>

                </div>

                <!-- Body -->
                <div class="modal-body">

                    <div class="row">

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Invoice No</label>
                                <input type="text" id="sales_invoice" class="form-control" readonly>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Customer</label>
                                <input type="text" id="customer_name" class="form-control" readonly>
                            </div>
                        </div>

                    </div>

                    <div class="row">

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Grand Total</label>
                                <input type="text" id="grand_total" class="form-control text-right" readonly>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Total Paid</label>
                                <input type="text" id="total_paid" class="form-control text-right" readonly>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Current Due</label>
                                <input type="text" id="current_due"
                                    class="form-control text-right text-danger font-weight-bold" readonly>
                            </div>
                        </div>

                    </div>

                    <div class="form-group">
                        <label>Collection Date</label>
                        <input type="date" class="form-control" name="payment_date" value="<?=date('Y-m-d');?>"
                            required>
                    </div>

                    <div class="form-group">
                        <label>
                            Collection Amount
                            <span class="text-danger">*</span>
                        </label>

                        <input type="number" id="payment_amount" name="payment_amount" class="form-control" min="0.01"
                            step="0.01" required>
                    </div>

                    <div class="form-group">

                        <label>Payment Method</label>

                        <select class="form-control" name="payment_method">

                            <option value="Cash">Cash</option>
                            <option value="Bkash">Bkash</option>
                            <option value="Nagad">Nagad</option>
                            <option value="Rocket">Rocket</option>
                            <option value="Card">Card</option>
                            <option value="Bank">Bank</option>
                            <option value="Cheque">Cheque</option>

                        </select>

                    </div>

                    <div class="form-group">
                        <label>Reference No</label>
                        <input type="text" name="reference_no" class="form-control">
                    </div>

                    <div class="form-group">
                        <label>Note</label>
                        <textarea name="note" rows="3" class="form-control"></textarea>
                    </div>

                </div>

                <!-- Footer -->
                <div class="modal-footer">

                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        Close
                    </button>

                    <button type="submit" class="btn btn-success">

                        <i class="fa fa-save"></i>
                        Save Payment

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>
<!----------------------Modal Form Edit Section  End------------------------------------------>

<!-- Modal Delete Product-->

<!-- End Modal Delete Product-->


<?php
echo $this->endSection();
?>




<?php
echo $this->section('scripts');
?>

<script type='text/javascript'>
$(document).ready(function() {
    if ($.fn.DataTable.isDataTable('#sampleTable')) {
        $('#sampleTable').DataTable().destroy();
    }

    $('#sampleTable').DataTable({
        responsive: true,
        autoWidth: false,
        pageLength: 10,
        ordering: true,
        searching: true,
        lengthChange: true,
        info: true,
        language: {
            emptyTable: "No due records found."
        }
    });

    $(document).on('click', '.btn-edit', function() {

let button = $(this);

// Hidden Fields
$('#due_id').val(button.data('due_id'));
$('#sales_id').val(button.data('sales_id'));
$('#customer_id').val(button.data('customer_id'));

// Display Fields
$('#sales_invoice').val(button.data('sales_invoice'));
$('#customer_name').val(button.data('customer_name'));

$('#grand_total').val(
    parseFloat(button.data('grand_total') || 0).toFixed(2)
);

$('#total_paid').val(
    parseFloat(button.data('total_paid') || 0).toFixed(2)
);

let currentDue = parseFloat(button.data('current_due')) || 0;

$('#current_due').val(
    currentDue.toFixed(2)
);


// Default Collection Amount
$('#payment_amount')
    .val(currentDue.toFixed(2))
    .attr('max', currentDue.toFixed(2))
    .data('max_due', currentDue);


// Show Modal
$('#customerPaymentModal').modal('show');

});


let allowSubmit = true;

$('#customer_payment_receive_submit').on('submit', function(e) {

    e.preventDefault();

    // Prevent double submit
    if (!allowSubmit) {
        return;
    }


    // Validate
    let due_amount = parseFloat($('#current_due').val()) || 0;
    let paymentAmount = parseFloat($('#payment_amount').val()) || 0;


    if (paymentAmount <= 0) {

        alert('Please enter a valid payment amount.');
        $('#payment_amount').focus();
        return;

    }


    if (paymentAmount > due_amount) {

        alert('Payment amount cannot exceed due amount.');
        $('#payment_amount').focus().select();
        return;

    }


    allowSubmit = false;


    let form = $(this);
    let submitBtn = form.find('button[type="submit"]');


    submitBtn
        .prop('disabled', true)
        .html('<i class="fa fa-spinner fa-spin"></i> Saving...');


    $.ajax({

        url: form.attr('action'),
        type: form.attr('method'),
        data: new FormData(this),
        processData: false,
        contentType: false,
        dataType: 'json',

        success: function(response) {

            if (response.status) {


                $('#customerPaymentModal').modal('hide');

                alert(response.message);

                location.reload();


            } else {

                alert(response.message);

            }

        },


        error: function(xhr) {

            let message = 'Server Error';


            if (xhr.responseJSON && xhr.responseJSON.message) {

                message = xhr.responseJSON.message;

            }


            alert(message);

        },


        complete: function() {


            allowSubmit = true;


            submitBtn
                .prop('disabled', false)
                .html('<i class="fa fa-save"></i> Save Payment');


        }

    });

});




});
</script>


<?php
echo $this->endSection();
?>