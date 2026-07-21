<?=$this->extend('layout')?>
<?=$this->section('content')?>

<div class="app-title">
    <div>
        <h1><i class='fa fa-th-list'></i> Product Unit List, Edit, Delete & Add Section</h1>
    </div>

    <!-- Button trigger modal -->
    <button type='button' class='btn btn-primary btn-sm' data-toggle='modal' data-target='#unitAddModal'>
        <i class='fa fa-plus'></i>
        Unit Add
    </button>
</div>


<!-- Validation Errors -->
<?php if (session()->has('errors')): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong><i class="fa fa-exclamation-circle"></i> Validation Error!</strong>

        <ul class="mb-0 mt-2">
            <?php foreach (session('errors') as $error): ?>
                <li><?= esc($error) ?></li>
            <?php endforeach; ?>
        </ul>

        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span>&times;</span>
        </button>
    </div>
<?php endif; ?>

<!-- Success Message -->
<?php if (session()->has('success')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fa fa-check-circle"></i>
        <?= esc(session('success')) ?>

        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span>&times;</span>
        </button>
    </div>
<?php endif; ?>

<!-- Error Message -->
<?php if (session()->has('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fa fa-times-circle"></i>
        <?= esc(session('error')) ?>

        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span>&times;</span>
        </button>
    </div>
<?php endif; ?>

<!-- Product Unit Table -->
<div class='row'>
    <div class='col-md-12'>
        <div class='tile collapseable show animate__animated  animate__fadeInUp'>
            <div class='tile-body'>
                <div class='table-responsive'>
                    <table class='table table-hover table-bordered' id='sampleTable'>
                        <thead>
                            <tr>
                                <th>Unit Name</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php if (! empty($unit_show)): ?>
                            <?php foreach ($unit_show as $row): ?>
                            <tr>
                                <td><?=esc($row['product_unit_name'])?></td>
                                <td>
                                    <!-- Button to invoke the modal -->
                                    <button type="button" class="btn btn-primary btn-sm btn-edit"
                                        data-id="<?=$row['product_unit_id']?>"
                                        data-name="<?=esc($row['product_unit_name'])?>">
                                        <i class="fa fa-edit"></i></button>

                                    <button type="button" class="btn btn-danger btn-sm btn-delete"
                                        data-id="<?=$row['product_unit_id']?>">
                                        <i class="fa fa-trash-o"></i></button>

                                </td>
                            </tr>

                            <?php endforeach; ?>
                            <?php else: ?>
                            <tr>
                                <td colspan="2" class="text-center">
                                    No product units found.
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
<!-- Product Unit Table -->



<!---Modal Form unitAdd Start---->
<div class="modal fade" id='unitAddModal' tabindex='-1' role='dialog' aria-labelledby='unitAddModalLabel'
    aria-hidden='true'>
    <div class='modal-dialog  modal-dialog-centered' role='document'>
        <div class='modal-content'>
            <form method='post' action="<?=site_url('units/create')?>">
                <?=csrf_field()?>
                <div class='modal-header'>
                    <h5 class="modal-title" id="unitAddModalLabel">Please Enter Product Unit</h5>
                    <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                        <span aria-hidden='true'>&times;
                        </span>
                    </button>
                </div>
                <div class='modal-body'>
                    <div class='form-row'>
                        <div class='form-group col-md-12'>
                            <label>Product Unit</label>
                            <input type="text" class="form-control" name="product_unit" placeholder="Product Unit"
                                value="<?= old('product_unit') ?>" required>
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
<!---Modal Form unitAdd End---->

<!-----Modal Form Unit Edit Start------->
<div class="modal fade" id='unitEditModal' tabindex='-1' role='dialog' aria-labelledby='unitEditModalLabel'
    aria-hidden='true'>
    <div class='modal-dialog  modal-dialog-centered' role='document'>
        <div class='modal-content'>
            <form method='post' action="<?=site_url('units/update')?>">
                <?=csrf_field()?>
                <div class='modal-header'>
                    <h5 class='modal-title' id='unitEditModalLabel'>Product Unit Update</h5>
                    <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                        <span aria-hidden='true'>&times;
                        </span>
                    </button>
                </div>
                <div class='modal-body'>
                    <input type='hidden' class='form-control' name='product_unit_id' id='product_unit_id' required>
                    <div class='form-row'>
                        <div class='form-group col-md-12'>
                            <label>Product Unit</label>
                            <input type='text' class='form-control' name='product_unit_name' id='product_unit_name'
                                required>
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
<!-------Modal Form Edit Section  End----->

<!-- Modal Delete Product-->

<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Delete Product Unit</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <h4>Are you sure you want to delete this product unit?</h4>

            </div>
            <form action="<?=site_url('units/delete')?>" method="post">
                <?=csrf_field()?>
                <div class="modal-footer">
                    <input type="hidden" class='form-control' name="delete_id" id="delete_id" required>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                    <button type="submit" class="btn btn-primary">Yes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- End Modal Delete Product-->


<?=$this->endSection()?>


<?=$this->section('scripts')?>

<script type='text/javascript'>
$(document).ready(function() {

    $('#sampleTable').DataTable({
    responsive: true,
    processing: true,
    pageLength: 10,
    lengthMenu: [
        [10,25,50,100,-1],
        [10,25,50,100,"All"]
    ],
    order: [[0,'asc']],
    autoWidth: false,
    language: {
        search: "Search Unit:",
        lengthMenu: "Show _MENU_ entries",
        zeroRecords: "No matching units found",
        info: "Showing _START_ to _END_ of _TOTAL_ units",
        infoEmpty: "No units available",
        infoFiltered: "(filtered from _MAX_ total units)"
    },
    columnDefs: [{
        targets: 1,
        orderable: false,
        searchable: false,
        width: "120px"
    }]
});

    // get Edit Product
    $(document).on('click', '.btn-edit', function() {
        const id = $(this).data('id');
        const name = $(this).data('name');
        $('#product_unit_id').val(id);
        $('#product_unit_name').val(name);
        $('#unitEditModal').modal('show');

    });


    // get Delete Product
    $(document).on('click', '.btn-delete', function() {
        const id = $(this).data('id');
        $('#delete_id').val(id);
        $('#deleteModal').modal('show');
    });

    setTimeout(function () {
    $('.alert').slideUp(300, function () {
        $(this).remove();
    });
}, 3000);

});
</script>


<?=$this->endSection()?>