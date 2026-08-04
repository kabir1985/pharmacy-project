<?php
echo $this->extend('layout');
echo $this->section('content');
?>

<div class='app-title'>
    <div>
        <h1><i class='fa fa-th-list'></i> Expense Section</h1>
        <!-- <p>Table to display analytical data effectively</p> -->
    </div>

    <!-- Button trigger modal -->
    <button type='button' class='btn btn-primary btn-sm' data-toggle='modal' data-target='#ExpenseAdd'>
        <i class='fa fa-plus'></i>
        Expense Add
    </button>
</div>



<!---------------Data Table start Here----..............................................--------------------------->
<div class="row">
    <div class="col-md-12">
        <div class="tile collapseable show animate__animated animate__fadeInUp">
            <div class="tile-body">
                <div class="table-responsive">

                    <table class="table table-hover table-bordered" id="sampleTable">

                        <thead>
                            <tr>
                                <th>Ref.</th>
                                <th>Category</th>
                                <th>Sub Category</th>
                                <th>What For</th>
                                <th>Amount</th>
                                <th>Note</th>
                                <th>Date</th>
                                <th width="120">Action</th>
                            </tr>
                        </thead>

                        <tbody>

                            <?php if (!empty($expense_category_sub_category_show)) : ?>

                                <?php foreach ($expense_category_sub_category_show as $rows) : ?>

                                    <tr>

                                        <td><?= esc($rows['expense_ref_no']) ?></td>

                                        <td><?= esc($rows['expense_category_name']) ?></td>

                                        <td><?= esc($rows['expense_sub_category_name']) ?></td>

                                        <td><?= esc($rows['expense_what_for']) ?></td>

                                        <td class="text-right">
                                            <?= number_format($rows['expense_amount'],2) ?>
                                        </td>

                                        <td><?= esc($rows['expense_note']) ?></td>

                                        <td><?= esc($rows['expense_date']) ?></td>

                                        <td>

                                            <a href="#"
                                               class="btn btn-primary btn-sm btn-edit"

                                               data-expense_id="<?= $rows['expense_id'] ?>"

                                               data-expense_ref_no="<?= esc($rows['expense_ref_no']) ?>"

                                               data-expense_category_id="<?= $rows['expense_category'] ?>"

                                               data-expense_sub_category_id="<?= $rows['expense_sub_category'] ?>"

                                               data-expense_what_for="<?= esc($rows['expense_what_for']) ?>"

                                               data-expense_amount="<?= $rows['expense_amount'] ?>"

                                               data-expense_note="<?= esc($rows['expense_note']) ?>"

                                               data-expense_date="<?= $rows['expense_date'] ?>">

                                                <i class="fa fa-edit"></i>

                                            </a>

                                            <a href="#"
                                               class="btn btn-danger btn-sm btn-delete"
                                               data-delete_id="<?= $rows['expense_id'] ?>">

                                                <i class="fa fa-trash"></i>

                                            </a>

                                        </td>

                                    </tr>

                                <?php endforeach; ?>

                            <?php else : ?>

                                <tr>
                                    <td colspan="8" class="text-center">
                                        No data found.
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

<!---------------------------Modal Form for Add Expense Information---------------------------------------->
<!-- Modal -->
<div class='modal fade' id='ExpenseAdd' tabindex='-1' role='dialog' aria-labelledby='ExpenseAdd' aria-hidden='true'>
    <div class='modal-dialog  modal-dialog-centered' role='document'>
        <div class='modal-content'>
            <form id="Expense_add_submit_form" method='post' action="<?= site_url('expense/create') ?>">
                <div class='modal-header'>
                    <h5 class='modal-title' id='exampleModalLabel'>Please Enter Expense Info</h5>
                    <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                        <span aria-hidden='true'>&times;
                        </span>
                    </button>
                </div>
                <div class='modal-body'>
                    <div class='form-row'>
                        <div class='form-group col-md-6'>
                            <label>Ref.No</label>
                            <input required type='text' required class='form-control' name='expense_ref_no'
                                placeholder='Re. No  '>
                        </div>

                        <div class='form-group col-md-6'>
                            <label>Category</label>
                            <select  id="expense_category_add" name="expense_category" class="expense_category form-control" required>
                                <option value="">Select Category</option>
                                <?php
                                foreach ($expense_category_show as $row) {
                                    ?>
                                    <option value="<?php echo $row['expense_category_id'] ?>">
                                        <?php echo $row['expense_category_name'] ?>
                                    </option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class='form-group col-md-6'>
                            <label>Expense Sub Category</label>
                            <select
id="expense_sub_category_add"
name="expense_sub_category_add"
class="form-control"
required>

<option value="">Select Category First</option>

</select>
                        </div>

                        <div class='form-group col-md-6'>
                            <label>What For</label>
                            <input required type='text' required class='form-control' name='expense_what_for'
                                placeholder='Expense What For '>
                        </div>
                    </div>
                    <div class='form-row'>
                        <div class='form-group col-md-6'>
                            <label>Amount</label>
                            <input required type='text' required class='form-control'
                                onkeypress="return accept_digit_only(event)" name='expense_amount'
                                placeholder='Expense Amount'>
                        </div>
                        <div class='form-group col-md-6'>
                            <label>Note</label>
                            <input required type='text' required class='form-control' name='expense_note'
                                placeholder='Expense Note'>
                        </div>
                    </div>
                    <div class='form-row'>
                        <div class='form-group col-md-12'>
                            <label>Date</label>
                            <input required type='text' required class='form-control datePicker' name='expense_date'
                                placeholder='<?php echo date("d-m-Y"); ?>'>
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
<!---------------------------Modal Form for Edit Section Load Start---------------------------------------->
<!-- Modal -->
<div class='modal fade' id='ExpenseEditModal' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel'
    aria-hidden='true'>
    <div class='modal-dialog  modal-dialog-centered' role='document'>
        <div class='modal-content'>
            <form id="expense_update_submit_form" method='post' action="<?= site_url('expense/update') ?>">
                <div class='modal-header'>
                    <h5 class='modal-title' id='#'>Please Update Expense Details</h5>
                    <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                        <span aria-hidden='true'>&times;
                        </span>
                    </button>
                </div>
                <div class='modal-body' id="#">
                    <input type='hidden' required class='form-control' name='expense_id' id='expense_id'>
                    <div class='form-row'>
                        <div class='form-group col-md-6'>
                            <label>Ref. No Edit</label>
                            <input type='text' required class='form-control' name='expense_ref_no' id='expense_ref_no'>
                        </div>
                        <div class='form-group col-md-6'>
                                <label>Category</label>
                            <select  id="expense_category_edit" name="expense_category" class=" expense_category form-control" required>
                                <option value="">Select Category</option>
                                <?php
                                foreach ($expense_category_show as $row) {
                                    ?>
                                    <option value="<?php echo $row['expense_category_id'] ?>">
                                        <?php echo $row['expense_category_name'] ?>
                                    </option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class='form-row'>
                        <div class='form-group col-md-6'>
                          <label>Expense Sub Category</label>
                            <select id="expense_sub_category_edit"  name="expense_sub_category_edit" class="form-control" required>
                                <option value="">Select Sub Category</option>
                            </select>

                        </div>
                        <div class='form-group col-md-6'>
                            <label>What For</label>
                            <input type='text' class='form-control' required name='expense_what_for'
                                id="expense_what_for">
                        </div>
                    </div>

                    <div class='form-row'>
                        <div class='form-group col-md-6'>
                            <label>Expense Amount</label>
                            <input type='text' required class='form-control'
                                onkeypress="return accept_digit_only(event)" name='expense_amount' id="expense_amount">
                        </div>
                        <div class='form-group col-md-6'>
                            <label>Expense Note</label>
                            <input type='text' class='form-control' required name='expense_note' id="expense_note">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class='form-group col-md-12'>
                            <label>Expense Date</label>
                            <input type='text' class='form-control datePicker' required name='expense_date'
                                id="expense_date" autocomplete="off">
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
                <h5 class="modal-title" id="exampleModalLabel">Delete Supplier</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <h4>Are you sure want to delete this Expense?</h4>

            </div>
            <form action="<?= site_url('expense/delete') ?>" method="post">
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
<script>
$(document).ready(function () {

    //====================================
    // DataTable
    //====================================
    $('#sampleTable').DataTable({
        responsive: true,
        destroy: true
    });

    //====================================
    // DatePicker
    //====================================
    $('.datePicker').datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        todayHighlight: true,
        container: 'body'
    });

    var allowSubmit = true;

    //====================================
    // Load Sub Category
    //====================================
    function loadSubCategory(categoryId, targetSelect, selectedId = '') {

        if (categoryId == '') {

            $(targetSelect).html('<option value="">Select Category First</option>');
            return;
        }

        $.ajax({

            url: "<?= site_url('expense/getSubCategory') ?>",
            type: "POST",
            dataType: "json",
            data: {
                expense_category_id: categoryId
            },

            beforeSend: function () {

                $(targetSelect).html('<option>Loading...</option>');

            },

            success: function (response) {

                console.log(response);

                var html = '<option value="">Select Sub Category</option>';

                $.each(response, function (i, row) {

                    var selected = '';

                    if (selectedId == row.expense_sub_category_id) {
                        selected = 'selected';
                    }

                    html += '<option value="' +
                        row.expense_sub_category_id +
                        '" ' + selected + '>' +
                        row.expense_sub_category_name +
                        '</option>';

                });

                $(targetSelect).html(html);

            },

            error: function () {

                $(targetSelect).html('<option value="">No Sub Category Found</option>');

            }

        });

    }

    //====================================
    // Add Category Change
    //====================================
    $(document).on('change', '#expense_category_add', function () {

console.log('Category Changed');

var categoryId = $(this).val();

console.log(categoryId);

});

    //====================================
    // Edit Category Change
    //====================================
    $('#expense_category_edit').change(function () {

        var categoryId = $(this).val();

        loadSubCategory(
            categoryId,
            '#expense_sub_category_edit'
        );

    });

    //====================================
    // Add Expense
    //====================================
    $('#Expense_add_submit_form').submit(function (e) {

        e.preventDefault();

        if (!allowSubmit) return;

        allowSubmit = false;

        var form = this;

        $.ajax({

            url: $(form).attr('action'),
            type: $(form).attr('method'),
            data: new FormData(form),
            processData: false,
            contentType: false,
            dataType: 'json',

            success: function (response) {

                allowSubmit = true;

                if (response.status) {

                    $('#ExpenseAdd').modal('hide');

                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: response.message,
                        timer: 1500,
                        showConfirmButton: false
                    }).then(function () {

                        location.reload();

                    });

                } else {

                    var msg = '';

                    $.each(response.errors, function (k, v) {

                        msg += v + '<br>';

                    });

                    Swal.fire({
                        icon: 'error',
                        title: 'Validation Error',
                        html: msg
                    });

                }

            },

            error: function () {

                allowSubmit = true;

                Swal.fire(
                    'Error',
                    'Something went wrong.',
                    'error'
                );

            }

        });

    });

    //====================================
    // Update Expense
    //====================================
    $('#expense_update_submit_form').submit(function (e) {

        e.preventDefault();

        if (!allowSubmit) return;

        allowSubmit = false;

        var form = this;

        $.ajax({

            url: $(form).attr('action'),
            type: $(form).attr('method'),
            data: new FormData(form),
            processData: false,
            contentType: false,
            dataType: 'json',

            success: function (response) {

                allowSubmit = true;

                if (response.status) {

                    $('#ExpenseEditModal').modal('hide');

                    Swal.fire({
                        icon: 'success',
                        title: 'Updated',
                        text: response.message,
                        timer: 1500,
                        showConfirmButton: false
                    }).then(function () {

                        location.reload();

                    });

                } else {

                    var msg = '';

                    $.each(response.errors, function (k, v) {

                        msg += v + '<br>';

                    });

                    Swal.fire({
                        icon: 'error',
                        title: 'Validation Error',
                        html: msg
                    });

                }

            },

            error: function () {

                allowSubmit = true;

                Swal.fire(
                    'Error',
                    'Something went wrong.',
                    'error'
                );

            }

        });

    });

    //====================================
    // Edit Button
    //====================================
    $('.btn-edit').click(function () {

        $('#expense_id').val($(this).data('expense_id'));
        $('#expense_ref_no').val($(this).data('expense_ref_no'));
        $('#expense_what_for').val($(this).data('expense_what_for'));
        $('#expense_amount').val($(this).data('expense_amount'));
        $('#expense_note').val($(this).data('expense_note'));
        $('#expense_date').val($(this).data('expense_date'));

        var categoryId = $(this).data('expense_category_id');
        var subCategoryId = $(this).data('expense_sub_category_id');

        $('#expense_category_edit').val(categoryId);

        loadSubCategory(
            categoryId,
            '#expense_sub_category_edit',
            subCategoryId
        );

        $('#ExpenseEditModal').modal('show');

    });

    //====================================
    // Delete Button
    //====================================
    $('.btn-delete').click(function () {

        $('#delete_id').val($(this).data('delete_id'));

        $('#deleteModal').modal('show');

    });

});
</script>

<!-- For Calendar start -->

<!-- For Calendar End -->

<?php
echo $this->endSection();
?>