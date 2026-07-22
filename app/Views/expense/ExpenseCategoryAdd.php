<?php
echo $this->extend('layout');
echo $this->section('content');
?>

<div class='app-title'>
    <div>
        <h1><i class='fa fa-th-list'></i> Expense Category Section</h1>
        <!-- <p>Table to display analytical data effectively</p> -->
    </div>

    <!-- Button trigger modal -->
    <button type='button' class='btn btn-primary btn-sm' data-toggle='modal' data-target='#CategoryAdd'>
        <i class='fa fa-plus'></i>
        Add
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
                                <th>Name</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            foreach ($expense_category_show as $row) {
                            ?>
                                <tr>
                                    <td><?php echo $row['expense_category_name']; ?></td>
                                    <td>
                                        <!-- Button to invoke the modal -->
                                        <a href="#" class="btn btn-primary btn-sm btn-edit" data-expense_category_id="<?php echo $row['expense_category_id'] ?>" data-expense_category_name="<?php echo $row['expense_category_name'] ?>">
                                            <i class="fa fa-edit"></i></a>

                                        <a href="#" class="btn btn-danger btn-sm btn-delete" data-delete_id="<?php echo $row['expense_category_id'] ?>"><i class="fa fa-trash-o"></i></a>

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

<div class='modal fade' id='CategoryAdd' tabindex='-1' role='dialog' aria-labelledby='CategoryAdd' aria-hidden='true'>
    <div class='modal-dialog  modal-dialog-centered' role='document'>
        <div class='modal-content'>
            <form id="expense_category_add_form" method='post' action="<?= site_url('expense-category/create') ?>">
                <div class='modal-header'>
                    <h5 class='modal-title' id='exampleModalLabel'>Please Enter Expense Category</h5>
                    <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                        <span aria-hidden='true'>&times;
                        </span>
                    </button>
                </div>
                <div class='modal-body'>
                    <div class='form-row'>
                        <div class='form-group col-md-12'>
                            <label>Expense Category</label>
                            <input required type='text' required class='form-control' name='expense_category_name' id='expense_category_name' placeholder='Expense Category Name'>
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

<div class='modal fade' id='ExpenseCategoryEditModal' tabindex='-1' role='dialog' aria-labelledby='ExpenseCategoryEditModal' aria-hidden='true'>
    <div class='modal-dialog  modal-dialog-centered' role='document'>
        <div class='modal-content'>
            <form id="expense_category_edit_form" method='post' action="<?= site_url('expense-category/update') ?>">
                <div class='modal-header'>
                    <h5 class='modal-title' id='#'>Udate Expense Category Details</h5>
                    <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                        <span aria-hidden='true'>&times;
                        </span>
                    </button>
                </div>
                <div class='modal-body' id="#">
                    <input type='hidden' required class='form-control' id='expense_category_id' name='expense_category_id'>
                    <div class='form-row'>
                        <div class='form-group col-md-12'>
                            <label>Category Edit</label>
                            <input type='text' required class='form-control' id='expense_category_name_update' name='expense_category_name_update'>
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
            <form action="<?php echo site_url('expense-category/delete') ?>" method="post">
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

        ////-------------------Product Category Entry Form-------------------------//
        var allowSubmit = true;

        $('#expense_category_add_form').submit(function(event) {
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

        $('#expense_category_edit_form').submit(function(event) {
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
                    parentMOdal.modal('toggle');
                    //page refresh after submission
                    location.reload();
                    // alert("Success");
                });

        });

        /////////Category Edit Submit inot database end here//////////////////////


        //...................JQuery for Modal Edit & Delete option...................................

        // get Edit Product
        $('.btn-edit').on('click', function() {
            // get data from button edit
            var expense_category_id = $(this).data('expense_category_id');
            var expense_category_name = $(this).data('expense_category_name');

            //alert(expense_category_name);


            // Set data to Form Edit
            $('#expense_category_id').val(expense_category_id);
            $('#expense_category_name_update').val(expense_category_name);

            // Call Modal Edit
            $('#ExpenseCategoryEditModal').modal('show');

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