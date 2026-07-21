<?php
echo $this->extend('layout');
echo $this->section('content');
?>

<div class='app-title'>
    <div>
        <h1><i class='fa fa-th-list'></i>Product Currency List, Edit, Delete & Add Section</h1>
    </div>

    <!-- Button trigger modal -->
    <button type='button' class='btn btn-primary btn-sm' data-toggle='modal' data-target='#currencyAdd'>
        <i class='fa fa-plus'></i>
        Currency Add
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
                                <th>Currency Code</th>
                                <th>Currency Name</th>
                                <th>Currency Symbol</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            foreach ($currency_show as $row) {
                            ?>
                                <tr>
                                    <td><?php echo $row['currency_code'] ?></td>
                                    <td><?php echo $row['currency_name'] ?></td>
                                    <td><?php echo $row['currency_symbol'] ?></td>
                                    <td>
                                        <!-- Button to invoke the modal -->
                                        <a href="#" class="btn btn-primary btn-sm btn-edit" data-currency_id="<?php echo $row['id'] ?>" data-currency_code="<?php echo $row['currency_code'] ?>" data-currency_name="<?php echo $row['currency_name'] ?>" data-currency_symbol="<?php echo $row['currency_symbol'] ?>">
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

<div class='modal fade' id='currencyAdd' tabindex='-1' role='dialog' aria-labelledby='currencyAdd' aria-hidden='true'>
    <div class='modal-dialog  modal-dialog-centered' role='document'>
        <div class='modal-content'>
            <form id="currency_add_form" method='post' action="<?= site_url('currency/create') ?>">
                <div class='modal-header'>
                    <h5 class='modal-title' id='exampleModalLabel'>Please Enter Currency Details</h5>
                    <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                        <span aria-hidden='true'>&times;
                        </span>
                    </button>
                </div>
                <div class='modal-body'>
                    <div class='form-row'>
                        <div class='form-group col-md-12'>
                            <label>Currency Code</label>
                            <input required type='text' required class='form-control' name='currency_code' id='currency_code' placeholder='Currency Code'>
                        </div>
                    </div>
                    <div class='form-row'>
                        <div class='form-group col-md-12'>
                            <label>Currency Name</label>
                            <input required type='text' required class='form-control' name='currency_name' id='currency_name' placeholder='Currency Code'>
                        </div>
                    </div>
                    <div class='form-row'>
                        <div class='form-group col-md-12'>
                            <label>Currency Symbol</label>
                            <input required type='text' required class='form-control' name='currency_symbol' id='currency_symbol' placeholder='Currency Code'>
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
<!-- Modal -->

<div class='modal fade' id='CurrencyEditModel' tabindex='-1' role='dialog' aria-labelledby='CurrencyEditModel' aria-hidden='true'>
    <div class='modal-dialog  modal-dialog-centered' role='document'>
        <div class='modal-content'>
            <form id="currency_update_submission" method='post' action="<?= site_url('currency/update') ?>">
                <div class='modal-header'>
                    <h5 class='modal-title' id='#'>Udate Currency Details</h5>
                    <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                        <span aria-hidden='true'>&times;
                        </span>
                    </button>
                </div>
                <div class='modal-body' id="#">
                    <input type='hidden' required class='form-control currency_id' name='currency_id'>
                    <div class='form-row'>
                        <div class='form-group col-md-12'>
                            <label>Currency Code</label>
                            <input type='text' required class='form-control currency_code' name='currency_code'>
                        </div>
                    </div>
                    <div class='form-row'>
                        <div class='form-group col-md-12'>
                            <label>Currency Name</label>
                            <input type='text' required class='form-control currency_name' name='currency_name'>
                        </div>
                    </div>
                    <div class='form-row'>
                        <div class='form-group col-md-12'>
                            <label>Currency Symbol</label>
                            <input type='text' required class='form-control currency_symbol' name='currency_symbol'>
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
            <form action="<?= site_url('currency/delete') ?>" method="post">
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

<!-- Google analytics script-->
<script type='text/javascript'>
    $(document).ready(function() {
        $('#sampleTable').DataTable();

        ////-------------------Product Category Entry Form-------------------------//
        var allowSubmit = true;

        $('#currency_add_form').submit(function(event) {
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


        //////Category Edit submit into database start/////////////////////////////////

        $('#currency_update_submission').submit(function(event) {
            event.preventDefault();

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

        });

        /////////Category Edit Submit inot database end here//////////////////////


        //...................JQuery for Modal Edit & Delete option...................................

        // get Edit Product
        $('.btn-edit').on('click', function() {
            // get data from button edit
            var currency_id = $(this).data('currency_id');

            var currency_code = $(this).data('currency_code');
            var currency_name = $(this).data('currency_name');
            var currency_symbol = $(this).data('currency_symbol');
            // Set data to Form Edit
            $('.currency_id').val(currency_id);
            $('.currency_code').val(currency_code);
            $('.currency_name').val(currency_name);
            $('.currency_symbol').val(currency_symbol);

            // Call Modal Edit
            $('#CurrencyEditModel').modal('show');

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