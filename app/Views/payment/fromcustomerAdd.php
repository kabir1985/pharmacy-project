<?php
echo $this->extend('layout');
echo $this->section('content');
?>

<div class='app-title'>
    <div>
        <h1><i class='fa fa-th-list'></i>Receive Payment From Customer</h1>
    </div>

    <!-- Button trigger modal -->
    <!-- <button type='button' class='btn btn-primary btn-sm' data-toggle='modal' data-target='#UnitAdd'>
        <i class='fa fa-plus'></i>
        Unit Add
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
                                <th>Name</th>
                                <th>Phone</th>
                                <th>Company</th>
                                <th>Due</th>
                                <th>Paid</th>
                                <th>Current Due</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            foreach ($customer_due_show as $row)
                             {
                                $current_due = $row['Total_Customer_due'] - $row['Customer_total_paid'];
                              
                                if($current_due!=0)
                                 {
                            ?>
                                <tr>
                                    <td><?php echo $row['cus_first_name']; ?></td>
                                    <td><?php echo $row['cus_phone']; ?></td>
                                    <td><?php echo $row['cus_company']; ?></td>
                                    <td><?php echo $row['Total_Customer_due']; ?></td>
                                    <td><?php echo $row['Customer_total_paid']; ?></td>
                                    <td>
                                    <?php
                                     echo $current_due;
                                     ?>
                                     </td>
                                  
                                    <td>
                                            <button type="button" class="btn btn-primary text-white btn-edit" data-due_id="<?php echo $row['due_id']?>" data-customer_id="<?php echo $row['customer_id']?>" data-customer_name="<?php echo $row['cus_first_name']?>" data-total_customer_due="<?php echo $current_due;?>" data-due_invoice_no="<?php echo $row['due_invoice_no']?>">Receive Payment</button>
                                    </td>
                                </tr>

                               <?php
                                  }
                               }
                               ?>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!---------------Data Table End Here-----------............................................-------------------->

<!---------------------------Modal Form for Edit Section Load Start---------------------------------------->
<!-- Modal -->
<div class='modal fade' id='customerPaymentModal' tabindex='-1' role='dialog' aria-labelledby='customerPaymentModal' aria-hidden='true'>
    <div class='modal-dialog  modal-dialog' role='document'>
        <div class='modal-content'>
            <form id="customer_payment_receive_submit" method='post' action="<?= site_url('customer_received') ?>">
                <div class='modal-header'>
                    <h5 class='modal-title' id='#'>Receive Due From Customer</h5>
                    <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                        <span aria-hidden='true'>&times;
                        </span>
                    </button>
                </div>
                <div class='modal-body' id="#">
                    <input type='hidden' required class='form-control' name='customer_id' id='customer_id'>
                    <input type='hidden' required class='form-control' name='due_invoice_no' id='due_invoice_no'>                   
                    <div class='form-row'>
                        <div class='form-group col-md-12'>
                            <label>Customer Name</label>
                            <input type='text' required class='form-control' name='customer_name' id='customer_name'>
                        </div>
                        <div class='form-group col-md-12'>
                            <label>Due Amount</label>
                            <input type='text' required class='form-control' name='total_customer_due' id='total_customer_due'>
                        </div>
                        <div class='form-group col-md-12'>
                            <label>Paid Now</label>
                            <input type='text' required class='form-control' name='paid_now' id='paid_now'>
                        </div>
                        <div class='form-group col-md-12'>
                            <label>Amount Receivable</label>
                            <input type='text' required class='form-control' name='amount_receivable' id='amount_receivable'>
                        </div>
                    </div>
                </div>
                <div class='modal-footer'>
                    <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
                    <button type='submit' class='btn btn-primary'>Save Edit</button>
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

<!-- Data table plugin-->
<script type='text/javascript' src="<?php echo base_url('assets/js/plugins/jquery.dataTables.min.js') ?>"></script>
<script type='text/javascript' src="<?php echo base_url('assets/js/plugins/dataTables.bootstrap.min.js') ?>"></script>

<script type='text/javascript'>
    $(document).ready(function() {
        $('#sampleTable').DataTable();

        $("#paid_now").on('keyup', function() {

            var total_customer_due = $("#total_customer_due").val();
			if (total_customer_due != "") {
				total_customer_due = parseFloat((Number.isNaN(total_customer_due)) ? 0 : total_customer_due);
			} else {
				total_customer_due = 0;
			}

            var paid_amount = $(this).val();
			if (paid_amount != "") {
				paid_amount = parseFloat((Number.isNaN(paid_amount)) ? 0 : paid_amount);
			} else {
				paid_amount = 0;
			}

            var amount_receivable = total_customer_due - paid_amount;
           
           $('#amount_receivable').val(amount_receivable);

		});
        
        allowSubmit = true;
        // ///...............Unit Edit submit into database..............................//
        $('#customer_payment_receive_submit').submit(function(event) {
            event.preventDefault();

            if (allowSubmit) {
                allowSubmit = false;
                var parentMOdal = $(this).closest('.modal');
                var postData = new FormData(this);
                $.ajax({
                        //alert("ddd");
                        type: $(this).attr("method"),
                        url: $(this).attr("action"),
                        // alert(;
                        data: postData,
                        //dataType: 'json',
                        encode: true,
                        processData: false,
                        contentType: false,
                    })
                    // using the done promise callback
                    .done(function(data) {
                        // alert(data);
                        if (data == 1) {
                            parentMOdal.modal('toggle');
                            //page refresh after submission
                            location.reload();
                            // alert("Success");
                        }
                    });

            }
        });

        // get Edit Product
        $('.btn-edit').on('click', function() {
            // get data from button edit
            var customer_due_id = $(this).data('due_id');
            var customer_id = $(this).data('customer_id');
            var customer_name = $(this).data('customer_name');
            var total_customer_due = $(this).data('total_customer_due');
            var due_invoice_no = $(this).data('due_invoice_no');
           // due_invoice_no

            // Set data to Form Edit
            $('#customer_due_id').val(customer_due_id);
            $('#customer_id').val(customer_id);
            $('#customer_name').val(customer_name);
            $('#total_customer_due').val(total_customer_due);
            $('#due_invoice_no').val(due_invoice_no);
            // Call Modal Edit
            $('#customerPaymentModal').modal('show');

        });

        // get Delete Product
        $('.btn-delete').on('click', function() {
            // get data from button edit
            const delete_id = $(this).data('delete_id');
            //alert(delete_id);
            // Set data to Form Edit
            $('#delete_id').val(delete_id);
            // Call Modal Edit
            $('#deleteModal').modal('show');
        });


        //................ JQuery modal Edit & Delete end here........................................
        // ...............For Date Show.............................
        $('.datePicker').datepicker({
            format: "dd/mm/yyyy",
            autoclose: true,
            todayHighlight: true
        });
        //.................For Date show end........................ 

    });
</script>

<!-- For Calendar start -->

<!-- For Calendar End -->

<?php
echo $this->endSection();
?>