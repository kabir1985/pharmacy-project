<?php
echo $this->extend('layout');
echo $this->section('content');
?>

<div class="app-title">
    <div>
        <h1><i class="fa fa-th-list"></i> Product Category List, Edit, Delete & Add</h1>
    </div>
    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#CategoryAdd">
        <i class="fa fa-plus"></i> Category Add
    </button>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="tile">
            <div class="tile-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover" id="sampleTable">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th width="120">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($category_show as $row): ?>
                            <tr>
                                <td><?= esc($row['category_name']) ?></td>
                                <td>
                                    <a href="javascript:void(0)"
                                       class="btn btn-primary btn-sm btn-edit"
                                       data-product_category_id="<?= $row['product_category_id'] ?>"
                                       data-category_name="<?= esc($row['category_name']) ?>">
                                        <i class="fa fa-edit"></i>
                                    </a>

                                    <a href="javascript:void(0)"
                                       class="btn btn-danger btn-sm btn-delete"
                                       data-delete_id="<?= $row['product_category_id'] ?>">
                                        <i class="fa fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ADD MODAL -->
<div class="modal fade" id="CategoryAdd" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form
                  method="post"
                  action="<?= site_url('/productcategoryAdd') ?>">

                <div class="modal-header">
                    <h5 class="modal-title">Add Product Category</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    <label>Product Category</label>
                    <input type="text"
                           class="form-control"
                           name="product_category_name"
                           id="product_category_name"
                           placeholder="Product Category Name"
                           required>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- EDIT MODAL -->
<div class="modal fade" id="CategoryEditModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form
                  method="post"
                  action="<?= site_url('/productcategoryUpdate') ?>">

                <div class="modal-header">
                    <h5 class="modal-title">Edit Category</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    <input type="hidden" name="product_category_id" id="product_category_id">
                    <label>Category Name</label>
                    <input type="text"
                           class="form-control"
                           name="category_name"
                           id="category_name"
                           required>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- DELETE MODAL -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form method="post" action="<?= site_url('/productcategoryDelete') ?>">
                <div class="modal-header">
                    <h5 class="modal-title">Confirm Delete</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this category?
                    <input type="hidden" name="delete_id" id="delete_id">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                    <button type="submit" class="btn btn-danger">Yes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php
echo $this->endSection();
echo $this->section('scripts');
?>

<script src="<?= base_url('assets/js/plugins/jquery.dataTables.min.js') ?>"></script>
<script src="<?= base_url('assets/js/plugins/dataTables.bootstrap.min.js') ?>"></script>

<script>
$(function () {

    $('#sampleTable').DataTable();

    // EDIT
    $(document).on('click', '.btn-edit', function () {
        $('#product_category_id').val($(this).data('product_category_id'));
        $('#category_name').val($(this).data('category_name'));
        $('#CategoryEditModal').modal('show');
    });


    // DELETE
    $(document).on('click', '.btn-delete', function () {
        $('#delete_id').val($(this).data('delete_id'));
        $('#deleteModal').modal('show');
    });

});
</script>

<?php
echo $this->endSection();
?>
