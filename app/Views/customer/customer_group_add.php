<?php
echo $this->extend('layout');
echo $this->section('content');
?>

<div class='app-title'>
    <div>
        <h1><i class='fa fa-th-list'></i> Customer Group List, Edit, Delete & Add Section</h1>
    </div>

    <!-- Button trigger modal -->
    <button type='button' class='btn btn-primary btn-sm' data-toggle='modal' data-target='#CustomerGroupAdd'>
        <i class='fa fa-user-plus'></i>
        Customer Group Add
    </button>
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
                                <th>Group Name</th>
                                <th>Due Limit</th>
								<th>Discount Amount</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>

                                <?php
                                foreach ($customer_group_show as $row) {
                                ?>
								<tr>
								   <td><?php echo $row['cus_group_name'];?></td>
                                   <td><?php echo $row['cus_due_limit'];?></td>
								   <td><?php echo $row['discount_percent'];?></td>
                                        <td>
                                            <!-- Button to invoke the modal -->
                                            <a href="#" class="btn btn-primary btn-sm btn-edit" data-customer_group_id="<?php echo $row['customer_group_id'] ?>" data-cus_group_name="<?php echo $row['cus_group_name'] ?>" data-cus_due_limit="<?php echo $row['cus_due_limit'] ?>" data-discount_percent="<?php echo $row['discount_percent'] ?>" ><i class="fa fa-edit"></i></a>

                                            <a href="#" class="btn btn-danger btn-sm btn-delete" data-delete_id="<?php echo $row['customer_group_id'] ?>"><i class="fa fa-trash-o"></i></a>

                                        </td>
								</tr>
								
                                <?php
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



<!---------------------------Modal Form for entry Load Start---------------------------------------->
<!-- Modal -->
<div class='modal fade' id='CustomerGroupAdd' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>
    <div class='modal-dialog modal-dialog-centered' role='document'>
        <div class='modal-content'>
        <form id="CustomerGroupAdd_Form" method='post' action="<?= site_url('customer-group/create') ?>">
            <div class='modal-header'>
                <h5 class='modal-title' id='exampleModalLabel'>Please Enter Customer Group</h5>
                <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                    <span aria-hidden='true'>&times;
                    </span>
                </button>
            </div>
                <div class='modal-body'>

                    <div class='form-row'>
                        <div class='form-group col-md-6'>
                            <label>Group Name</label>
                            <input required type='text' required class='form-control' name='cus_group_name' placeholder='Group Name' >
                        </div>
                        <div class='form-group col-md-6'>
                            <label>Due Limit</label>
                            <input required type='text' required class='form-control' name='cus_due_limit' placeholder='Due Limit' onkeypress="return accept_digit_only(event)">
                        </div>
                    </div>
					   <div class='form-row'>
                        <div class='form-group col-md-12'>
                            <label>Discount %</label>
                            <input type='text' class='form-control' name='discount_percent' placeholder='Discount Percentage' onkeypress="return accept_digit_only(event)">
                        </div>
                    </div>
                </div>
                <div class='modal-footer'>
                    <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
                    <button type='submit' class='btn btn-primary'>Save changes</button>
                </div>
            </form>
        </div>
        
    </div>
</div>
<!----------------------Modal Form End------------------------------------------>

<!-- Modal Delete Product-->
<!-- 
<div id="DeleteProductModal"> Hello</div> -->

<!-- End Modal Delete Product-->



<!---------------------------Modal Form for Edit Section Load Start---------------------------------------->
<!-- Modal -->
    <div class='modal fade' id='customer_group_edit_modal' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>
        <div class='modal-dialog  modal-dialog-centered' role='document'>
            <div class='modal-content'>
                <form id="customer_group_edit_submit" method='post' action="<?= site_url('customer-group/update') ?>">
                <div class='modal-header'>
                    <h5 class='modal-title' id='#'>Please Edit Customer Group  Details</h5>
                    <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                        <span aria-hidden='true'>&times;
                        </span>
                    </button>
                </div>
                <div class='modal-body' id="#">
                    <input type='hidden' required class='form-control' name='customer_group_id' id='customer_group_id'>
                    <div class='form-row'>
                        <div class='form-group col-md-6'>
                            <label>Group Name Edit</label>
                            <input type='text' required class='form-control' name='cus_group_name' id='cus_group_name'>
                        </div>
                        <div class='form-group col-md-6'>
                            <label>Due Limit Edit</label>
                            <input type='text' class='form-control' name='cus_due_limit' id='cus_due_limit'>
                        </div>
                    </div>
                    <div class='form-row'>
                        <div class='form-group col-md-12'>
                            <label>Discount Percentage</label>
                            <input type='text' required class='form-control' name='discount_percent' id='discount_percent'>
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

<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Delete Customer</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <h4>Are you sure want to delete this Customer?</h4>

            </div>
            <form action="<?= site_url('customer-group/delete') ?>" method="post">
                <div class="modal-footer">
                    <input type="hidden" required class='form-control' name="delete_id" id="delete_id">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                    <button type="submit" class="btn btn-primary">Yes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- End Modal Delete Product-->




<?php
echo $this->endSection();
?>

<?php
echo $this->section('scripts');
?>

<script type='text/javascript'>
    $(document).ready(function() {

        $('#sampleTable').DataTable();

        ////-------------------Product Entry Form-------------------------//
        var allowSubmit = true;

        $('#CustomerGroupAdd_Form').submit(function(event) {
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


        //////Product Edit submit into database start/////////////////////////////////

        $('#customer_group_edit_submit').submit(function(event) {
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
                            parentMOdal.modal('toggle');
                            //page refresh after submission
                            location.reload();
                    });

            }
        });

        /////////Product Edit Submit inot database end here//////////////////////



        //...................JQuery for Modal Edit & Delete option...................................



        // get Edit Product
        $('.btn-edit').on('click', function() {
            // get data from button edit
            const customer_group_id = $(this).data('customer_group_id');
            const cus_group_name = $(this).data('cus_group_name');
            const cus_due_limit = $(this).data('cus_due_limit');
            const discount_percent = $(this).data('discount_percent');


            // Set data to Form Edit
            $('#customer_group_id').val(customer_group_id);
            $('#cus_group_name').val(cus_group_name);
            $('#cus_due_limit').val(cus_due_limit);
            $('#discount_percent').val(discount_percent);

            // Call Modal Edit
            $('#customer_group_edit_modal').modal('show');

        });





        // get Delete Product
        $('.btn-delete').on('click', function() {
            // get data from button edit
            const delete_id = $(this).data('delete_id');
            alert(delete_id);
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