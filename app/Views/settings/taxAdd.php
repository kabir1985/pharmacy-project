<?php
echo $this->extend('layout');
echo $this->section('content');
?>

<div class='app-title'>
    <div>
        <h1><i class='fa fa-th-list'></i> Tax Section</h1>
    </div>

    <!-- Button trigger modal -->
    <button type='button' class='btn btn-primary btn-sm' data-toggle='modal' data-target='#taxAdd'>
        <i class='fa fa-plus'></i>
        Tax Add
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
                                <th>Tax Name</th>
                                <th>Tax Percentage</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($tax_show as $row) {
                            ?>
                                <tr>
                                    <td><?php echo $row['tax_name'] ?></td>
                                    <td><?php echo $row['tax_percentage'] ?></td>
                                    <td>
                                        <!-- Button to invoke the modal -->
                                        <a href="#" class="btn btn-primary btn-sm btn-edit" data-tax_id="<?php echo $row['tax_id'] ?>" data-tax_name="<?php echo $row['tax_name'] ?>" data-tax_percentage="<?php echo $row['tax_percentage'] ?>">
                                            <i class="fa fa-edit"></i></a>

                                        <a href="#" class="btn btn-danger btn-sm btn-delete" data-delete_id="<?php echo $row['tax_id'] ?>"><i class="fa fa-trash-o"></i></a>

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
<div class='modal fade' id='taxAdd' tabindex='-1' role='dialog' aria-labelledby='taxAdd' aria-hidden='true'>
    <div class='modal-dialog  modal-dialog-centered' role='document'>
        <div class='modal-content'>
            <form id="tax_submit_form" method='post' action="<?= site_url('taxAdd') ?>">
                <div class='modal-header'>
                    <h5 class='modal-title' id='exampleModalLabel'>Please Enter Tax Info</h5>
                    <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                        <span aria-hidden='true'>&times;
                        </span>
                    </button>
                </div>
                <div class='modal-body'>
                    <div class='form-row'>
                        <div class='form-group col-md-12'>
                            <label>Tax Name</label>
                            <input required type='text' required class='form-control' name='tax_name' placeholder='Tax Name'>
                        </div>
                    </div>
                    <div class='form-row'>
                        <div class='form-group col-md-12'>
                            <label>Percentage</label>
                            <input required type='text' required class='form-control' name='tax_percentage' placeholder='Tax Percentage'>
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


<div class='modal fade' id='tax_edit_form' tabindex='-1' role='dialog' aria-labelledby='tax_edit_form' aria-hidden='true'>
    <div class='modal-dialog  modal-dialog-centered' role='document'>
        <div class='modal-content'>
            <form id="tax_edit_submit_form" method='post' action="<?= site_url('taxUpdate') ?>">
                <div class='modal-header'>
                    <h5 class='modal-title' id='#'>Udate Tax Details</h5>
                    <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                        <span aria-hidden='true'>&times;
                        </span>
                    </button>
                </div>
                <div class='modal-body' id="#">
                    <input type='hidden' required class='form-control' name='tax_id' id='tax_id'>
                    <div class='form-row'>
                        <div class='form-group col-md-12'>
                            <label>Name Edit</label>
                            <input type='text' required class='form-control' name='tax_name' id='tax_name'>
                        </div>
                    </div>
                    <div class='form-row'>
                        <div class='form-group col-md-12'>
                            <label>Percentage Edit</label>
                            <input type='text' required class='form-control' name='tax_percentage' id='tax_percentage'>
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
            <form action="<?= site_url('taxDelete') ?>" method="post">
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

        $('#tax_submit_form').submit(function(event) {
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

        $('#tax_edit_submit_form').submit(function(event) {
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
            const tax_id = $(this).data('tax_id');
            const tax_name = $(this).data('tax_name');
            const tax_percentage = $(this).data('tax_percentage');

            // Set data to Form Edit
            $('#tax_id').val(tax_id);
            $('#tax_name').val(tax_name);
            $('#tax_percentage').val(tax_percentage);

            // Call Modal Edit
            $('#tax_edit_form').modal('show');

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