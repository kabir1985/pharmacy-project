<?php
echo $this->extend('layout');
echo $this->section('content');
?>

<div class='app-title'>
    <div>
        <h1><i class='fa fa-th-list'></i> Customer List, Edit, Delete & Add Section</h1>
    </div>

    <!-- Button trigger modal -->
    <button type='button' class='btn btn-primary btn-sm' data-toggle='modal' data-target='#CustomerAdd'>
        <i class='fa fa-user-plus'></i>
        Customer Add
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
                                <th>First Name</th>
                                <th>Last</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Address</th>
                                <th>TIN</th>
                                <th>Company</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            if (count($customer_show) > 0) {
                                foreach ($customer_show as $row) {
                                    ?>
                            <tr>
                                <td>
                                    <?php echo $row['cus_first_name'] ?>
                                </td>
                                <td>
                                    <?php echo $row['cus_last_name'] ?>
                                </td>
                                <td>
                                    <?php echo $row['cus_email'] ?>
                                </td>
                                <td>
                                    <?php echo $row['cus_phone'] ?>
                                </td>
                                <td>
                                    <?php echo $row['cus_address'] ?>
                                </td>
                                <td>
                                    <?php echo $row['cus_tin'] ?>
                                </td>
                                <td>
                                    <?php echo $row['cus_company'] ?>
                                </td>
                                <td>
                                    <!-- Button to invoke the modal -->
                                            <a href="#" class="btn btn-primary btn-sm btn-edit"
                                                data-customer_id="<?php echo $row['customer_id'] ?>"
                                                data-cus_first_name="<?php echo $row['cus_first_name'] ?>"
                                                data-cus_last_name="<?php echo $row['cus_last_name'] ?>"
                                                data-cus_email="<?php echo $row['cus_email'] ?>"
                                                data-cus_phone="<?php echo $row['cus_phone'] ?>"
                                                data-cus_address="<?php echo $row['cus_address'] ?>"
                                                data-cus_tin="<?php echo $row['cus_tin'] ?>"
                                                data-cus_company="<?php echo $row['cus_company'] ?>"><i
                                                    class="fa fa-edit"></i></a>

                                            <a href="#" class="btn btn-danger btn-sm btn-delete"
                                                data-delete_id="<?php echo $row['customer_id'] ?>"><i
                                                    class="fa fa-trash-o"></i></a>

                                        </td>
                                    </tr>
                                    <?php
                                }
                            } else {
                                ?>
                                <tr>
                                    <td colspan="7">No data found.</td>
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
<form id="CustomerModalEntry_Form" method='post' action="<?= site_url('customerAdd') ?>">
    <div class='modal fade' id='CustomerAdd' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel'
        aria-hidden='true'>
        <div class='modal-dialog modal-lg modal-dialog-centered' role='document'>
            <div class='modal-content'>
                <div class='modal-header'>
                    <h5 class='modal-title' id='exampleModalLabel'>Please Enter Customer Details</h5>
                    <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                        <span aria-hidden='true'>&times;
                        </span>
                    </button>
                </div>
                <div class='modal-body'>

                    <div class='form-row'>
                        <div class='form-group col-md-4'>
                            <label>First Name</label>
                            <input required type='text' required class='form-control' name='cus_first_name'
                                placeholder='First Name'>
                        </div>
                        <div class='form-group col-md-4'>
                            <label>Last Name</label>
                            <input type='text' class='form-control' name='cus_last_name' placeholder='Last Name'>
                        </div>
                        <div class='form-group col-md-4'>
                            <label>Email</label>
                            <input type='email' class='form-control' name='cus_email' placeholder='Email'>
                        </div>
                    </div>
                    <div class='form-row'>
                        <div class='form-group col-md-4'>
                            <label> Phone Number</label>
                            <input type='text' pattern="\d{1,13}" class='form-control' name='cus_phone'
                                placeholder='Phone'>
                        </div>
                        <div class='form-group col-md-4'>
                            <label> Address</label>
                            <input type='text' class='form-control' name='cus_address' placeholder='Address'>
                        </div>
                        <div class='form-group col-md-4'>
                            <label> TIN</label>
                            <input type='text' class='form-control ' name='cus_tin'
                                placeholder='Tax Identification Number'>
                        </div>
                    </div>

                    <div class='form-row'>
                        <div class='form-group col-md-4'>
                            <label>Company</label>
                            <input type='text' class='form-control' name='cus_company' placeholder='Company'>
                        </div>
                        <div class='form-group col-md-4'>
                            <label for="inputState">Customer Type</label>
                            <select id="CustomerType" name="cus_type" class="form-control">

                                <option value="general">General</option>
                                <option value="special">Special</option>
                            </select>
                        </div>
                        <div class='form-group col-md-4'>
                            <label>Date</label>
                            <input type='text' class='form-control datePicker' name='cus_creation_date'
                                placeholder='Creation Date'>
                        </div>
                    </div>
                </div>
                <div class='modal-footer'>
                    <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
                    <button type='submit' class='btn btn-primary'>Save changes</button>
                </div>
            </div>
        </div>
    </div>
</form>
<!----------------------Modal Form End------------------------------------------>





<!---------------------------Modal Form for Edit Section Load Start---------------------------------------->
<!-- Modal -->
<div class='modal fade' id='customer_edit_modal' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel'
    aria-hidden='true'>
    <div class='modal-dialog  modal-dialog-centered' role='document'>
        <div class='modal-content'>
            <form id="customer_edit_submit_form" method='post' action="<?php echo site_url('customerUpdate') ?>">
                <div class='modal-header'>
                    <h5 class='modal-title' id='#'>Please Enter Customer Edit Details</h5>
                    <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                        <span aria-hidden='true'>&times;
                        </span>
                    </button>
                </div>
                <div class='modal-body' id="#">
                    <input type='hidden' required class='form-control' name='customer_id' id='customer_id'>
                    <div class='form-row'>
                        <div class='form-group col-md-6'>
                            <label>First Name </label>
                            <input type='text' required class='form-control' name='cus_first_name' id='cus_first_name'>
                        </div>
                        <div class='form-group col-md-6'>
                            <label>Last Name </label>
                            <input type='text' class='form-control' name='cus_last_name' id='cus_last_name'>
                        </div>
                    </div>
                    <div class='form-row'>
                        <div class='form-group col-md-6'>
                            <label>Email</label>
                            <input type='text' required class='form-control' name='cus_email' id='cus_email'>
                        </div>
                        <div class='form-group col-md-6'>
                            <label>Phone</label>
                            <input type='text' class='form-control' name='cus_phone' id='cus_phone'>
                        </div>
                    </div>

                    <div class='form-row'>
                        <div class='form-group col-md-4'>
                            <label>Address</label>
                            <input type='text' required class='form-control' name='cus_address' id='cus_address'>
                        </div>
                        <div class='form-group col-md-4'>
                            <label>TIN</label>
                            <input type='text' class='form-control ' name='cus_tin' id='cus_tin'>
                        </div>
                        <div class='form-group col-md-4'>
                            <label>Company</label>
                            <input type='text' class='form-control ' name='cus_company' id='cus_company'>
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

<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
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
            <form action="<?= site_url('customerDelete') ?>" method="post">
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

<!-- Data table plugin-->
<script type='text/javascript' src="<?php echo base_url('assets/js/plugins/jquery.dataTables.min.js') ?>"></script>
<script type='text/javascript' src="<?php echo base_url('assets/js/plugins/dataTables.bootstrap.min.js') ?>"></script>

<script type='text/javascript'>

    $(document).ready(function () {

        $('#sampleTable').DataTable();

        var allowSubmit = true;

        //product_group_edit_form

        $('#CustomerModalEntry_Form').submit(function (event) {
            // stop the form from submitting the normal way and refreshing the page
            event.preventDefault();

            if (allowSubmit) {
                allowSubmit = false;
                //for modal close variable after submit
                var parentMOdal = $(this).closest('.modal');
                var postData = new FormData(this);
                $.ajax({
                    type: $(this).attr("method"),
                    url: $(this).attr("action"),
                    data: postData,
                    encode: true,
                    processData: false,
                    contentType: false,
                })
                    .done(function (data) {

                        if (data == 1) {
                            parentMOdal.modal('toggle');
                            location.reload();
                        }
                        else if (data == "duplicate") {
                            alert("Customer already exists with same Phone or Email");
                        }

                    });
            }

        });

        //.........................................................................

        $('#customer_edit_submit_form').submit(function (event) {
            // stop the form from submitting the normal way and refreshing the page
            event.preventDefault();

            if (allowSubmit) {
                allowSubmit = false;
                //for modal close variable after submit
                var parentMOdal = $(this).closest('.modal');
                var postData = new FormData(this);
                $.ajax({
                    type: $(this).attr("method"),
                    url: $(this).attr("action"),
                    data: postData,
                    encode: true,
                    processData: false,
                    contentType: false,
                })
                    .done(function (data) {
                        if (data == 1) {
                            //Modal Remove after submission
                            parentMOdal.modal('toggle');
                            //page refresh after submission
                            location.reload();
                        }


                    });
            }

        });


        //...................JQuery for Modal Edit & Delete option...................................

        // get Edit Product
        $('.btn-edit').on('click', function () {
            // get data from button edit
            const customer_id = $(this).data('customer_id');
            const cus_first_name = $(this).data('cus_first_name');
            const cus_last_name = $(this).data('cus_last_name');

            const cus_email = $(this).data('cus_email');
            const cus_phone = $(this).data('cus_phone');
            const cus_address = $(this).data('cus_address');
            const cus_tin = $(this).data('cus_tin');
            const cus_company = $(this).data('cus_company');

            // Set data to Form Edit
            $('#customer_id').val(customer_id);
            $('#cus_first_name').val(cus_first_name);
            $('#cus_last_name').val(cus_last_name);

            $('#cus_email').val(cus_email);
            $('#cus_phone').val(cus_phone);
            $('#cus_address').val(cus_address);
            $('#cus_tin').val(cus_tin);
            $('#cus_company').val(cus_company);
            // Call Modal Edit
            $('#customer_edit_modal').modal('show');

        });

        // get Delete Product
        $('.btn-delete').on('click', function () {
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