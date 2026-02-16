<?php
echo $this->extend('layout');
echo $this->section('content');
?>

<div class='app-title'>
    <div>
        <h1><i class='fa fa-th-list'></i> General Settings Section</h1>
    </div>

    <!-- Button trigger modal -->
    <button type='button' class='btn btn-primary btn-sm' data-toggle='modal' data-target='#SystemSettingsAdd'>
        <i class='fa fa-plus'></i>
        Add General Settings
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
                                <th>Country</th>
                                <th>Currency</th>
                                <th>Company</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Address</th>
                                <th>Logo</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($system_settings_show as $row) {
                            ?>
                                <tr>
                                    <td><?php echo $row['country'] ?></td>
                                    <td><?php echo $row['currency_id'] ?></td>
                                    <td><?php echo $row['company_name'] ?></td>
                                    <td><?php echo $row['company_email'] ?></td>
                                    <td><?php echo $row['company_phone'] ?></td>
                                    <td><?php echo $row['company_address'] ?></td>
                                    <td><?php echo $row['company_logo'] ?></td>
                                    <td>
                                        <!-- Button to invoke the modal -->
                                        <a href="#" class="btn btn-primary btn-sm btn-edit" data-system_settings_id="<?php echo $row['id'] ?>" data-company_name="<?php echo $row['company_name'] ?>" data-company_email="<?php echo $row['company_email'] ?>" data-company_phone="<?php echo $row['company_phone']?>" data-company_address="<?php echo $row['company_address']?>" data-company_logo="<?php echo $row['company_logo']?>" data-country="<?php echo $row['country']?>" data-currency_id="<?php echo $row['currency_id']?>">
                                            <i class="fa fa-edit"></i></a>

                                        <a href="#" class="btn btn-danger btn-sm btn-delete" data-delete_id="<?php echo $row['id'] ?>"><i class="fa fa-trash-o"></i></a>

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
<div class='modal fade' id='SystemSettingsAdd' tabindex='-1' role='dialog' aria-labelledby='SystemSettingsAdd' aria-hidden='true'>
    <div class='modal-dialog  modal-dialog-centered' role='document'>
        <div class='modal-content'>
            <form id="system_settings_submit_form" method='post' action="<?= site_url('generalsettingsAdd') ?>">
                <div class='modal-header'>
                    <h5 class='modal-title' id='exampleModalLabel'>Please Enter Company Info</h5>
                    <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                        <span aria-hidden='true'>&times;
                        </span>
                    </button>
                </div>
                <div class='modal-body'>
                    <div class='form-row'>
                        <div class='form-group col-md-6'>
                            <label>Company Name</label>
                            <input required type='text' required class='form-control' name='company_name' placeholder='Company Name'>
                        </div>
                        <div class='form-group col-md-6'>
                            <label>Company Email</label>
                            <input required type='email' required class='form-control' name='company_email' placeholder='Company Email'>
                        </div>
                    </div>
                    <div class='form-row'>
                        <div class='form-group col-md-6'>
                            <label>Country</label>
                            <input required type='text' required class='form-control' name='country' placeholder='Country'>
                        </div>
                        <div class='form-group col-md-6'>
                            <label>Currency</label>
                            <select id="currency_id" name="currency_id" class="form-control" required>
                            <option value="">Select Currency</option>
                                <?php
                                foreach ($currency_show as $row) {
                                ?>
                                    <option value="<?php echo $row['id'] ?>"><?php echo $row['currency_name'] ?></option>

                                <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class='form-row'>
                        <div class='form-group col-md-6'>
                            <label>Phone</label>
                            <input required type='text' required class='form-control' name='company_phone' placeholder='Phone'>
                        </div>
                        <div class='form-group col-md-6'>
                            <label>Company Logo</label>
                            <input class="form-control" id="company_logo" name="company_logo" type="file" />                
                        </div>
                    </div>

                    <div class='form-row'>
                        <div class='form-group col-md-12'>
                            <label>Company Address</label>
                            <textarea class="form-control" id="company_address" name="company_address" placeholder='Address' rows="2"></textarea>
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

<!---------------------------Modal Form for Edit Section Load Start---------------------------------------->

<div class='modal fade' id='system_setting_edit_modal' tabindex='-1' role='dialog' aria-labelledby='system_setting_edit_modal' aria-hidden='true'>
    <div class='modal-dialog  modal-dialog-centered' role='document'>
        <div class='modal-content'>
            <form id="systemSettings_edit_submit_form" method='post' action="<?= site_url('generalsettingsUpdate') ?>">
                <div class='modal-header'>
                    <h5 class='modal-title' id='#'>System Settings Update</h5>
                    <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                        <span aria-hidden='true'>&times;
                        </span>
                    </button>
                </div>
                <div class='modal-body' id="#">
                    <input type='hidden' required class='form-control system_settings_id' name='system_settings_id'>
                    <div class='form-row'>
                        <div class='form-group col-md-6'>
                            <label>Company Name</label>
                            <input type='text' required class='form-control company_name' name='company_name' >
                        </div>
                        <div class='form-group col-md-6'>
                            <label>Company Email</label>
                            <input type='text' required class='form-control company_email' name='company_email'>
                        </div>
                    </div>
                    <div class='form-row'>
                        <div class='form-group col-md-6'>
                            <label>country</label>
                            <input type='text' required class='form-control country' name='country' >
                        </div>
                        <div class='form-group col-md-6'>
                            <label>Currency</label>
                            <input type='text' required class='form-control currency_id' name='currency_id' >
                        </div>
                    </div>
                    <div class='form-row'>
                        <div class='form-group col-md-6'>
                            <label>company_phone</label>
                            <input type='text' required class='form-control company_phone' name='company_phone' >
                        </div>
                        <div class='form-group col-md-6'>
                            <label>company_address</label>
                            <input type='text' required class='form-control company_address' name='company_address' >
                        </div>
                    </div>
                    <div class='form-row'>
                        <div class='form-group col-md-12'>
                            <label>company_logo</label>
                            <input class="form-control" id="company_logo" name="company_logo" type="file" />                
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


<!-- Modal -->


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
            <form action="<?= site_url('generalsettingsDelete') ?>" method="post">
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
    $(document).ready(function() {

        $('#sampleTable').DataTable();

        ////-------------------Product Group Entry Form-------------------------//
        var allowSubmit = true;

        //product_group_edit_form

        $('#system_settings_submit_form').submit(function(event) {
 
            //alert("kabir");
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
                    .done(function(data) {
                        if (data == 1) {
                            //Modal Remove after submission
                            parentMOdal.modal('toggle');
                            //page refresh after submission
                            location.reload();
                        }
                    });
            }

        });

        //.........................................................................

        $('#systemSettings_edit_submit_form').submit(function(event) {
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
                    .done(function(data) {
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
        $('.btn-edit').on('click', function() {
            // get data from button edit
            const system_settings_id = $(this).data('system_settings_id');
            //alert(system_settings_id);
            const company_name = $(this).data('company_name');
            const company_email = $(this).data('company_email');

            const company_phone = $(this).data('company_phone');
            const company_address = $(this).data('company_address');
            const company_logo = $(this).data('company_logo');

            const country = $(this).data('country');
            const currency_id = $(this).data('currency_id');

            // Set data to Form Edit
            $('.system_settings_id').val(system_settings_id);
             $('.company_name').val(company_name);
             $('.company_email').val(company_email);

             $('.company_phone').val(company_phone);
             $('.company_address').val(company_address);
             $('.company_logo').val(company_logo);
             $('.country').val(country);
             $('.currency_id').val(currency_id);

            // Call Modal Edit
            $('#system_setting_edit_modal').modal('show');

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
            format: "dd-mm-yyyy",
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