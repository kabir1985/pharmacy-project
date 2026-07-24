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
                                <th>Discount Amount</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>

                            <?php
                            foreach ($customer_group_show as $row) {
                                ?>
                            <tr>
                                <td>
                                    <?= esc($row['group_name']) ?>
                                </td>
                                <td>
                                    <?= esc($row['discount_percent']) ?>
                                </td>
                                <td>
                                    <!-- Button to invoke the modal -->
                                        <a href="#" class="btn btn-primary btn-sm btn-edit"
                                            data-customer_group_id="<?= esc($row['customer_group_id']) ?>"
                                            data-group_name="<?= esc($row['group_name']) ?>"
                                            data-discount_percent="<?= esc($row['discount_percent']) ?>"><i
                                                class="fa fa-edit"></i></a>

                                        <a href="#" class="btn btn-danger btn-sm btn-delete"
                                            data-delete_id="<?= esc($row['customer_group_id']) ?>"><i
                                                class="fa fa-trash-o"></i></a>

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
<div class='modal fade' id='CustomerGroupAdd' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel'
    aria-hidden='true'>
    <div class='modal-dialog modal-dialog-centered' role='document'>
        <div class='modal-content'>
            <form id="CustomerGroupAdd_Form" method="post" action="<?= site_url('customer-group/create') ?>">
                <?= csrf_field() ?>
                <div class='modal-header'>
                    <h5 class='modal-title' id='exampleModalLabel'>Please Enter Customer Group</h5>
                    <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                        <span aria-hidden='true'>&times;
                        </span>
                    </button>
                </div>
                <div class='modal-body'>

                    <div class='form-row'>
                        <div class='form-group col-md-12'>
                            <label>Group Name</label>
                            <input type='text' class='form-control' name='group_name' placeholder='Group Name' required>
                        </div>

                    </div>
                    <div class='form-row'>
                        <div class='form-group col-md-12'>
                            <label>Discount %</label>
                            <input type="number" class="form-control" name="discount_percent" min="0" max="100"
                                step="0.01">
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
<div class="modal fade" id="customer_group_edit_modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">

            <form id="customer_group_edit_submit"
                  method="post"
                  action="<?= site_url('customer-group/update') ?>">

                <?= csrf_field() ?>

                <div class="modal-header">
                    <h5 class="modal-title">Please Edit Customer Group Details</h5>

                    <button type="button"
                            class="close"
                            data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>

                <div class="modal-body">

                    <input type="hidden"
                           name="customer_group_id"
                           id="customer_group_id">

                    <div class="form-group">
                        <label>Group Name</label>

                        <input type="text"
                               class="form-control"
                               name="group_name"
                               id="group_name"
                               required>
                    </div>

                    <div class="form-group">
                        <label>Discount Percentage</label>

                        <input type="number"
                               class="form-control"
                               name="discount_percent"
                               id="discount_percent"
                               min="0"
                               max="100"
                               step="0.01"
                               required>
                    </div>

                </div>

                <div class="modal-footer">

                    <button type="button"
                            class="btn btn-secondary"
                            data-dismiss="modal">
                        Close
                    </button>

                    <button type="submit"
                            class="btn btn-primary">
                        Save Changes
                    </button>

                </div>

            </form>

        </div>
    </div>
</div>

<!----------------------Modal Form Edit Section  End------------------------------------------>

<!-- Modal Delete Product-->

<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">
                    Delete Customer Group
                </h5>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form id="customer_group_delete_form"
                  action="<?= site_url('customer-group/delete') ?>"
                  method="post">

                <?= csrf_field() ?>

                <div class="modal-body">

                    <input type="hidden"
                           name="delete_id"
                           id="delete_id">

                    <h5 class="text-danger">
                        <i class="fa fa-exclamation-triangle"></i>
                        Are you sure you want to delete this Customer Group?
                    </h5>

                </div>

                <div class="modal-footer">

                    <button type="button"
                            class="btn btn-secondary"
                            data-dismiss="modal">
                        No
                    </button>

                    <button type="submit"
                            class="btn btn-danger">
                        <i class="fa fa-trash"></i>
                        Yes, Delete
                    </button>

                </div>

            </form>

        </div>
    </div>
</div>

<!-- End Modal Delete Product-->

<?= $this->endSection(); ?>

<?= $this->section('scripts'); ?>

<script type="text/javascript">
$(document).ready(function () {

    // ===================== DataTable =====================
    $('#sampleTable').DataTable({
        responsive: true,
        autoWidth: false
    });

    let allowSubmit = true;

    // ===================== Add Customer Group =====================
    $('#CustomerGroupAdd_Form').on('submit', function (event) {

        event.preventDefault();

        if (!allowSubmit) return;

        allowSubmit = false;

        const parentModal = $(this).closest('.modal');
        const postData = new FormData(this);

        $.ajax({
            type: $(this).attr('method'),
            url: $(this).attr('action'),
            data: postData,
            dataType: 'json',
            processData: false,
            contentType: false,
            cache: false
        })
        .done(function (response) {

            if (response.status) {

                parentModal.modal('hide');

                alert(response.message);

                location.reload();

            } else {

                alert(response.message);

            }

        })
        .fail(function (xhr) {

            alert('Something went wrong.');

            console.log(xhr.responseText);

        })
        .always(function () {

            allowSubmit = true;

        });

    });

    // ===================== Edit Customer Group =====================
    $('#customer_group_edit_submit').on('submit', function (event) {

        event.preventDefault();

        if (!allowSubmit) return;

        allowSubmit = false;

        const parentModal = $(this).closest('.modal');
        const postData = new FormData(this);

        $.ajax({
            type: $(this).attr('method'),
            url: $(this).attr('action'),
            data: postData,
            dataType: 'json',
            processData: false,
            contentType: false,
            cache: false
        })
        .done(function (response) {

            if (response.status) {

                parentModal.modal('hide');

                alert(response.message);

                location.reload();

            } else {

                alert(response.message);

            }

        })
        .fail(function (xhr) {

            alert('Something went wrong.');

            console.log(xhr.responseText);

        })
        .always(function () {

            allowSubmit = true;

        });

    });

    // ===================== Edit Button =====================
    $(document).on('click', '.btn-edit', function () {

        $('#customer_group_id').val($(this).data('customer_group_id'));
        $('#group_name').val($(this).data('group_name'));
        $('#discount_percent').val($(this).data('discount_percent'));

        $('#customer_group_edit_modal').modal('show');

    });

   // Open Delete Modal
$(document).on('click', '.btn-delete', function () {

    let delete_id = $(this).data('delete_id');

    $('#delete_id').val(delete_id);

    $('#deleteModal').modal('show');

});

// Delete Form Submit
$('#customer_group_delete_form').on('submit', function (e) {

    e.preventDefault();

    if (!allowSubmit) return;

    allowSubmit = false;

    const postData = new FormData(this);

    $.ajax({
        type: $(this).attr('method'),
        url: $(this).attr('action'),
        data: postData,
        dataType: 'json',
        processData: false,
        contentType: false
    })
    .done(function (response) {

        if (response.status) {

            $('#deleteModal').modal('hide');

            alert(response.message);

            location.reload();

        } else {

            alert(response.message);

        }

    })
    .fail(function (xhr) {

        alert('Something went wrong.');
        console.log(xhr.responseText);

    })
    .always(function () {

        allowSubmit = true;

    });

});

});
</script>

<!-- For Calendar start -->

<!-- For Calendar End -->

<?= $this->endSection(); ?>