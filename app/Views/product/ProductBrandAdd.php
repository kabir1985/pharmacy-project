<?php
echo $this->extend('layout');
echo $this->section('content');
?>

<div class="app-title">
    <div>
        <h1>
            <i class="fa fa-th-list"></i>
            Product Brand List, Edit, Delete & Add Section
        </h1>
    </div>

    <!-- Add Brand Button -->
    <button type="button"
        class="btn btn-primary btn-sm"
        data-toggle="modal"
        data-target="#BrandAdd">

        <i class="fa fa-plus"></i>
        Brand Add

    </button>
</div>


<!-- ================= SUCCESS MESSAGE ================= -->

<?php if (session()->getFlashdata('success')): ?>

<div class="alert alert-success alert-dismissible fade show" role="alert">

    <i class="fa fa-check-circle"></i>

    <?= esc(session()->getFlashdata('success')) ?>

    <button type="button"
        class="close"
        data-dismiss="alert"
        aria-label="Close">

        <span aria-hidden="true">&times;</span>

    </button>

</div>

<?php endif; ?>


<!-- ================= ERROR MESSAGE ================= -->

<?php if (session()->getFlashdata('error')): ?>

<div class="alert alert-danger alert-dismissible fade show" role="alert">

    <i class="fa fa-exclamation-circle"></i>

    <?= esc(session()->getFlashdata('error')) ?>

    <button type="button"
        class="close"
        data-dismiss="alert"
        aria-label="Close">

        <span aria-hidden="true">&times;</span>

    </button>

</div>

<?php endif; ?>

<!---------------Data Table start Here----..............................................--------------------------->
<div class='row'>
    <div class='col-md-12'>
        <div class='tile collapseable show animate__animated animate__fadeInUp'>

            <div class='tile-body'>

                <div class='table-responsive'>

                    <table class='table table-hover table-bordered' id='sampleTable'>

                        <thead>
                            <tr>
                                <th width="80">SL</th>
                                <th>Brand Name</th>
                                <th width="150">Action</th>
                            </tr>
                        </thead>

                        <tbody>

                            <?php $sl = 1; ?>

                            <?php foreach ($product_brand_show as $row): ?>

                            <tr>

                                <td>
                                    <?= $sl++ ?>
                                </td>

                                <td>
                                    <?= esc($row['product_brand_name']) ?>
                                </td>

                                <td>

                                    <a href="javascript:void(0)"
                                        class="btn btn-primary btn-sm btn-edit"
                                        data-brand_id="<?= $row['brand_id'] ?>"
                                        data-product_brand_name="<?= esc($row['product_brand_name']) ?>">

                                        <i class="fa fa-edit"></i>
                                    </a>


                                    <a href="javascript:void(0)"
                                        class="btn btn-danger btn-sm btn-delete"
                                        data-delete_id="<?= $row['brand_id'] ?>">

                                        <i class="fa fa-trash-o"></i>
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
<!---------------Data Table End Here-----------...................------------------>



<!---------------------------Modal Brand Add---------------------------------------->
<form method="post" action="<?= site_url('brands/create') ?>">

    <div class="modal fade"
        id="BrandAdd"
        tabindex="-1"
        role="dialog"
        aria-labelledby="BrandAdd"
        aria-hidden="true">

        <div class="modal-dialog modal-dialog-centered" role="document">

            <div class="modal-content">

                <!-- ================= HEADER ================= -->

                <div class="modal-header">

                    <h5 class="modal-title">
                        <i class="fa fa-plus-circle"></i>
                        Add Product Brand
                    </h5>

                    <button type="button"
                        class="close"
                        data-dismiss="modal"
                        aria-label="Close">

                        <span aria-hidden="true">&times;</span>

                    </button>

                </div>


                <!-- ================= BODY ================= -->

                <div class="modal-body">

                    <div class="form-group">

                        <label for="product_brand_name">
                            Brand Name
                            <span class="text-danger">*</span>
                        </label>

                    <input
    type="text"
    id="add_product_brand_name"
    name="product_brand_name"
    class="form-control"
    placeholder="Enter Brand Name"
    maxlength="50"
    autocomplete="off"
    required>

                    </div>

                </div>


                <!-- ================= FOOTER ================= -->

                <div class="modal-footer">

                    <button type="button"
                        class="btn btn-secondary"
                        data-dismiss="modal">

                        <i class="fa fa-times"></i>
                        Close

                    </button>

                    <button type="submit"
                        class="btn btn-primary">

                        <i class="fa fa-save"></i>
                        Save Brand

                    </button>

                </div>

            </div>

        </div>

    </div>

</form>
<!----------------------Modal Brand add End------------------------------------------>





<!---------------------------Modal Brand Edit Start---------------------------------------->
<!-- ===================== Edit Brand Modal ===================== -->

<div class="modal fade"
    id="product_brand_edit_modal"
    tabindex="-1"
    role="dialog"
    aria-labelledby="product_brand_edit_modal"
    aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered" role="document">

        <div class="modal-content">

            <form method="post" action="<?= site_url('brands/update') ?>">

                <!-- HEADER -->
                <div class="modal-header">

                    <h5 class="modal-title">
                        <i class="fa fa-edit"></i>
                        Update Brand Details
                    </h5>

                    <button type="button"
                        class="close"
                        data-dismiss="modal"
                        aria-label="Close">

                        <span aria-hidden="true">&times;</span>

                    </button>

                </div>


                <!-- BODY -->
                <div class="modal-body">

                    <!-- IMPORTANT: Brand ID -->
                    <input
                        type="hidden"
                        name="product_brand_id"
                        id="product_brand_id">


                    <!-- Brand Name -->
                    <div class="form-group">

                        <label for="edit_product_brand_name">

                            Brand Name

                            <span class="text-danger">*</span>

                        </label>

                        <input
                            type="text"
                            class="form-control"
                            name="product_brand_name"
                            id="edit_product_brand_name"
                            placeholder="Enter Brand Name"
                            maxlength="50"
                            autocomplete="off"
                            required>

                    </div>

                </div>


                <!-- FOOTER -->
                <div class="modal-footer">

                    <button type="button"
                        class="btn btn-secondary"
                        data-dismiss="modal">

                        <i class="fa fa-times"></i>
                        Close

                    </button>

                    <button type="submit"
                        class="btn btn-primary">

                        <i class="fa fa-save"></i>
                        Update Brand

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

<!-- ===================== Edit Brand Modal End ===================== -->
<!----------------------Modal Form Edit Section  End------------------------------------------>
<!-- ===================== Delete Brand Modal ===================== -->

<div class="modal fade"
    id="deleteModal"
    tabindex="-1"
    role="dialog"
    aria-labelledby="deleteBrandModalLabel"
    aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered" role="document">

        <div class="modal-content">

            <!-- Header -->
            <div class="modal-header">

                <h5 class="modal-title" id="deleteBrandModalLabel">
                    <i class="fa fa-trash"></i>
                    Delete Brand
                </h5>

                <button type="button"
                    class="close"
                    data-dismiss="modal"
                    aria-label="Close">

                    <span aria-hidden="true">&times;</span>

                </button>

            </div>


            <!-- Body -->
            <div class="modal-body text-center">

                <div style="font-size:50px; color:#dc3545; margin-bottom:15px;">
                    <i class="fa fa-exclamation-triangle"></i>
                </div>

                <h5>
                    Are you sure you want to delete this brand?
                </h5>

                <p class="text-muted mb-0">
                    This action cannot be undone.
                </p>

            </div>


            <!-- Form -->
            <form action="<?= site_url('brands/delete') ?>" method="post">

                <div class="modal-footer">

                    <input type="hidden"
                        name="delete_id"
                        id="delete_id">

                    <button type="button"
                        class="btn btn-secondary"
                        data-dismiss="modal">

                        <i class="fa fa-times"></i>
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

<!-- ===================== Delete Brand Modal End ===================== -->
<!-- End Modal Delete Product-->


<?php
echo $this->endSection();
?>

<?php
echo $this->section('scripts');
?>

<script type="text/javascript">

$(document).ready(function () {

    // ==========================================================
    // DATA TABLE
    // ==========================================================

    $('#sampleTable').DataTable({
        responsive: true,
        autoWidth: false,
        pageLength: 25
    });


    // ==========================================================
    // EDIT BRAND
    // ==========================================================

    $('.btn-edit').on('click', function (e) {

        e.preventDefault();

        const brandId = $(this).data('brand_id');
        const brandName = $(this).data('product_brand_name');

        // Set brand ID
        $('#product_brand_id').val(brandId);

        // Set brand name
        $('#edit_product_brand_name').val(brandName);

        // Show edit modal
        $('#product_brand_edit_modal').modal('show');

    });


    // ==========================================================
    // DELETE BRAND
    // ==========================================================

    $('.btn-delete').on('click', function (e) {

        e.preventDefault();

        const deleteId = $(this).data('delete_id');

        // Set delete ID
        $('#delete_id').val(deleteId);

        // Show delete modal
        $('#deleteModal').modal('show');

    });

    // ==========================================================
    // ENTER KEY - ADD BRAND
    // ==========================================================

    $('#add_product_brand_name').on('keydown', function (e) {

        if (e.key === 'Enter') {

            e.preventDefault();

            $('#BrandAdd form').trigger('submit');

        }

    });


    // ==========================================================
    // ENTER KEY - EDIT BRAND
    // ==========================================================

    $('#edit_product_brand_name').on('keydown', function (e) {

        if (e.key === 'Enter') {

            e.preventDefault();

            $('#product_brand_edit_modal form').trigger('submit');

        }

    });

});

</script>

<?php
echo $this->endSection();
?>