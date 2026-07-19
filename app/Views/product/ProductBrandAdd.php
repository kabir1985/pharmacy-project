<?php
echo $this->extend('layout');
echo $this->section('content');
?>

<div class='app-title'>
    <div>
        <h1><i class='fa fa-th-list'></i> Product Brand List, Edit, Delete & Add Section </h1>
    </div>

    <!-- Button trigger modal -->
    <button type='button' text-align:right; class='btn btn-primary btn-sm' data-toggle='modal' data-target='#BrandAdd'>
        <i class='fa fa-plus'></i>
        Brand Add
    </button>
</div>

<?php if (session()->getFlashdata('success')): ?>
<div class="alert alert-success alert-dismissible fade show">
    <?=session()->getFlashdata('success')?>
    <button type="button" class="close" data-dismiss="alert">&times;</button>
</div>
<?php endif; ?>

<?php if (session()->getFlashdata('error')): ?>
<div class="alert alert-danger alert-dismissible fade show">
    <?=session()->getFlashdata('error')?>
    <button type="button" class="close" data-dismiss="alert">&times;</button>
</div>
<?php endif; ?>

<!---------------Data Table start Here----..............................................--------------------------->
<div class='row'>
    <div class='col-md-12'>
        <div class='tile collapseable show animate__animated  animate__fadeInUp'>
            <div class='tile-body'>
                <div class='table-responsive'>
                    <table class='table table-hover table-bordered' id='sampleTable'>
                        <thead>
                            <tr>
                                <th>Category</th>
                                <th>Name</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
foreach ($product_brand_show as $row) {
    ?>
                            <tr>
                                <td><?=esc($row['category_name'])?></td>
                                <td><?=esc($row['product_brand_name'])?></td>
                                <td>
                                    <!-- Button to invoke the modal -->
                                    <a href="javascript:void(0)" class="btn btn-primary btn-edit"
                                        data-brand_id="<?=$row['brand_id']?>"
                                        data-product_brand_name="<?=esc($row['product_brand_name'])?>"
                                        data-product_category_id="<?=$row['product_category_id']?>">
                                        <i class="fa fa-edit"></i>
                                    </a>

                                    <a href="#" class="btn btn-danger btn-sm btn-delete"
                                        data-delete_id="<?=$row['brand_id']?>">
                                        <i class="fa fa-trash-o"></i></a>

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

<!---------------Data Table End Here-----------...................------------------>



<!---------------------------Modal Brand Add---------------------------------------->
<form method='post' action="<?php echo site_url('/productbrandAdd') ?>">
    <div class='modal fade' id='BrandAdd' tabindex='-1' role='dialog' aria-labelledby='BrandAdd' aria-hidden='true'>
        <div class='modal-dialog  modal-dialog-centered' role='document'>
            <div class='modal-content'>
                <div class='modal-header'>
                    <h5 class='modal-title' id='exampleModalLabel'>Please Enter Product Brands</h5>
                    <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                        <span aria-hidden='true'>&times;
                        </span>
                    </button>
                </div>
                <div class='modal-body'>
                    <div class='form-row'>
                        <div class='form-group col-md-12'>
                            <label>Category Name</label>
                            <select id="product_category_id" name="product_category_id" class="form-control" required>
                                <option value="">Select Category </option>
                                <?php
foreach ($category_show as $row) {
    ?>
                                <option value="<?php echo $row['product_category_id'] ?>">
                                    <?php echo $row['category_name'] ?></option>

                                <?php
}
?>
                            </select>
                        </div>
                    </div>
                    <div class='form-row'>
                        <div class='form-group col-md-12'>
                            <label>Brands Name</label>
                            <input required type='text' required class='form-control' name='product_brand_name'
                                placeholder='Brand Name'>
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
<!----------------------Modal Brand add End------------------------------------------>





<!---------------------------Modal Brand Edit Start---------------------------------------->
<div class="modal fade" id="product_brand_edit_modal" tabindex="-1" role="dialog"
    aria-labelledby="product_brand_edit_modal" aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered" role="document">

        <div class="modal-content">

            <form method="post" action="<?=site_url('/productbrandUpdate')?>">

                <div class="modal-header">
                    <h5 class="modal-title">Update Brand Details</h5>

                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>

                <div class="modal-body">

                    <input type="hidden" name="product_brand_id" id="product_brand_id">

                    <div class="form-group">
                        <label>Category</label>

                        <select class="form-control" name="product_category_id" id="edit_product_category_id" required>

                            <option value="">Select Category</option>

                            <?php foreach ($category_show as $row): ?>

                            <option value="<?=$row['product_category_id'];?>">
                                <?=esc($row['category_name']);?>
                            </option>

                            <?php endforeach; ?>

                        </select>
                    </div>

                    <div class="form-group">
                        <label>Brand Name</label>

                        <input type="text" class="form-control" name="product_brand_name" id="product_brand_name"
                            required>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        Close
                    </button>

                    <button type="submit" class="btn btn-primary">
                        Update
                    </button>
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
            <form action="<?php echo site_url('/productbrandDelete') ?>" method="post">
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


    //...................JQuery for Modal Edit & Delete option...................................

    // get Edit Product
    $('.btn-edit').click(function() {

        $('#product_brand_id').val($(this).data('brand_id'));
        $('#product_brand_name').val($(this).data('product_brand_name'));
        $('#edit_product_category_id').val($(this).data('product_category_id'));

        $('#product_brand_edit_modal').modal('show');
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