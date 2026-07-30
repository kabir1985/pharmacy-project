<?php

/**
 * ------------------------------------------------------------------
 * Product Management
 * ------------------------------------------------------------------
 *
 * Displays:
 * - Product List
 * - Add Product
 * - Edit Product
 * - Delete Product
 *
 * Author  : Your Name
 * Version : 1.0.0
 *
 * ------------------------------------------------------------------
 */

?>

<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<div class='app-title'>
    <div>
        <h1><i class='fa fa-th-list'></i> Product List , Edit, Delete & Add Section</h1>
        <!-- <p>Table to display analytical data effectively</p> -->
    </div>

    <!-- Button trigger modal -->
    <button type='button' class='btn btn-primary btn-sm' data-toggle='modal' data-target='#AddNewProduct'>
        <i class='fa fa-plus'></i>
        Add Product
    </button>
</div>

<!-- ==========================================================
     PRODUCT LIST TABLE
=========================================================== -->
<div class="row">
    <div class="col-md-12">
        <div class="tile collapseable show animate__animated animate__fadeInUp">
            <div class="tile-body">
                <div class="table-responsive">

                    <table class="table table-bordered table-sm dt-responsive nowrap" id="sampleTable" width="100%">

                        <thead>
                            <tr>
                                <th>Image</th>
                                <th>Product Name</th>
                                <th>Category</th>
                                <th>Opening Stock</th>
                                <th>Price Without VAT</th>
                                <th>Tax %</th>
                                <th>Tax Amount</th>
                                <th>Purchase Price</th>
                                <th>Profit Margin %</th>
                                <th>Selling Price</th>
                                <th width="100">Action</th>
                            </tr>
                        </thead>

                        <tbody>

                            <?php if (!empty($product_show)) : ?>

                                <?php foreach ($product_show as $product) : ?>

                                    <tr>

                                        <td width="70">

                                            <?php if (!empty($product['product_image'])) : ?>

                                                <img src="<?= base_url('public/uploads/' . $product['product_image']) ?>"
                                                    alt="<?= esc($product['product_name']) ?>"
                                                    class="img-thumbnail product-thumb"
                                                    style="width:60px;height:60px;object-fit:cover;">

                                            <?php else : ?>

                                                <img src="<?= base_url('public/uploads/no-image.png') ?>"
                                                    class="img-thumbnail product-thumb"
                                                    style="width:60px;height:60px;object-fit:cover;">

                                            <?php endif; ?>

                                        </td>

                                        <td class="product-name">
                                            <?= esc($product['product_name']) ?>
                                        </td>

                                        <td>
                                            <?= esc($product['category_name']) ?>
                                        </td>

                                        <td class="text-end">
                                            <?= number_format($product['opening_stock'], 2) ?>
                                        </td>

                                        <td class="text-end">
                                            <?= number_format($product['cost_without_vat'], 2) ?>
                                        </td>

                                        <td class="text-end">
                                            <?= number_format($product['tax_percentage'], 2) ?>%
                                        </td>

                                        <td class="text-end">
                                            <?= number_format($product['tax_amount'], 2) ?>
                                        </td>

                                        <td class="text-end">
                                            <?= number_format($product['purchase_price'], 2) ?>
                                        </td>

                                        <td class="text-end">
                                            <?= number_format($product['profit_margin_percent'], 2) ?>%
                                        </td>

                                        <td class="text-end">
                                            <?= number_format($product['selling_price'], 2) ?>
                                        </td>

                                        <td>

                                            <div class="btn-group btn-group-sm">

                                                <a href="#"
                                                    class="btn btn-primary btn-edit"

                                                    data-product_id="<?= esc($product['product_id']) ?>"

                                                    data-product_name="<?= esc($product['product_name']) ?>"

                                                    data-product_category="<?= esc($product['product_category']) ?>"

                                                    data-product_brand="<?= esc($product['product_brand']) ?>"

                                                    data-product_group="<?= esc($product['product_group']) ?>"

                                                    data-product_strength="<?= esc($product['product_strength']) ?>"

                                                    data-product_unit="<?= esc($product['product_unit']) ?>"

                                                    data-barcode="<?= esc($product['barcode']) ?>"

                                                    data-base_price="<?= esc($product['base_price']) ?>"

                                                    data-cost_without_vat="<?= esc($product['cost_without_vat']) ?>"

                                                    data-tax_type="<?= esc($product['tax_type']) ?>"

                                                    data-tax_id="<?= esc($product['tax_id']) ?>"

                                                    data-tax_percentage="<?= esc($product['tax_percentage']) ?>"

                                                    data-tax_amount="<?= esc($product['tax_amount']) ?>"

                                                    data-purchase_price="<?= esc($product['purchase_price']) ?>"

                                                    data-profit_margin_percent="<?= esc($product['profit_margin_percent']) ?>"

                                                    data-selling_price="<?= esc($product['selling_price']) ?>"

                                                    data-alert_quantity="<?= esc($product['alert_quantity']) ?>"

                                                    data-opening_stock="<?= esc($product['opening_stock']) ?>">

                                                    <i class="fa fa-edit"></i>

                                                </a>

                                                <a href="#"
                                                    class="btn btn-danger btn-delete"
                                                    data-delete_id="<?= esc($product['product_id']) ?>">

                                                    <i class="fa fa-trash"></i>

                                                </a>

                                            </div>

                                        </td>

                                    </tr>

                                <?php endforeach; ?>

                            <?php else : ?>

                                <tr>

                                    <td colspan="11" class="text-center text-muted">

                                        No Products Found.

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
<!-- ==========================================================
     ADD PRODUCT MODAL
=========================================================== -->
<div class="modal fade" id='AddNewProduct' role='dialog' aria-labelledby='AddNewProduct' aria-hidden='true'>
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
        <div class='modal-content'>
            <!-----for image upload------------------->
            <?php if (session('msg')): ?>
            <div class="alert alert-success alert-dismissible">
                <?=session('msg')?>
                <button type="button" class="close" data-dismiss="alert"><span>×</span></button>
            </div>
            <?php endif?>
            <!-----for image upload------------------->
            <form id="NewProductAdd_Form" method='post' action="<?= site_url('products/create') ?>"
                accept-charset="utf-8" enctype="multipart/form-data">
                <?= csrf_field() ?>
                <!---------------------------Header------------------------------------>
                <div class="modal-header bg-primary text-white">

                    <h5 class="modal-title">
                        <i class="fa fa-cube"></i>
                        Add New Product
                    </h5>
                    <img id="preview" src="" style="width:40px; display:block; margin:auto; display:none;">
                    <button class="close text-white" data-dismiss="modal">
                        &times;
                    </button>

                </div>
                <!------------------------------------------------------------------------------------------->

                <div class="modal-body">

                    <!-- ================= Product Information ================= -->

                    <div class="card shadow-sm mb-3">

                        <div class="card-header bg-primary text-white">
                            <i class="fa fa-cube"></i> Product Information
                        </div>

                        <div class="card-body">

                            <!-- Product Name, Category, Brand -->

                            <div class='form-row'>
                                <div class='form-group col-md-4'>
                                    <label>Product Name</label>
                                    <input type='text' required class="form-control" name='product_name'
                                        placeholder='Product Name'>
                                </div>
                                <!-----------------------Product Category Select Start------------------------------>
                                <div class="form-group col-md-4">
                                    <label>Category / Dosage Form</label>

                                    <div class="input-group">

                                        <select id="product_category" name="product_category" class="form-control"
                                            required>

                                            <option value="">Select Category</option>

                                            <?php foreach ($category_show as $category): ?>

                                            <option value="<?=$category['product_category_id']?>">
                                                <?=$category['category_name']?>
                                            </option>

                                            <?php endforeach; ?>

                                        </select>

                                        <div class="input-group-append">

                                            <button class="btn btn-success" id="btnAddCategory" type="button"
                                                title="Add Category">

                                                <i class="fa fa-plus"></i>

                                            </button>

                                        </div>

                                    </div>

                                </div>
                                <!-----------------------Product Category Select End------------------------------>


                                <div class='form-group col-md-4'>
                                    <label for="inputState">Brand</label>
                                    <div class="input-group">

                                        <select id="product_brand" name="product_brand" class="form-control" required>
                                        </select>

                                        <div class="input-group-append">

                                            <button class="btn btn-success" id="btnAddBrand" type="button"
                                                title="Add Brand">

                                                <i class="fa fa-plus"></i>

                                            </button>

                                        </div>

                                    </div>
                                </div>


                            </div>


                            <!-- Group, Strength, Unit -->
                            <div class='form-row'>
                                <!-------------------------------------Product Group /Generic Name--------------------------------->
                                <div class="form-group col-md-4">
                                    <label>Generic Name (Group)</label>

                                    <div class="input-group">

                                        <select id="product_group" name="product_group" class="form-control" required>
                                            <option value="">Select Group </option>
                                            <?php foreach ($group_show as $group) : ?>
                                            <option value="<?= esc($group['product_group_id']) ?>">
                                                <?= esc($group['group_name']) ?>
                                            </option>
                                            <?php endforeach; ?>
                                        </select>

                                        <div class="input-group-append">

                                            <button class="btn btn-success" id="btnAddGroup" type="button"
                                                title="Add Generic/Group">

                                                <i class="fa fa-plus"></i>

                                            </button>

                                        </div>

                                    </div>

                                </div>

                                <!--------------------product Strenght----------------------------------->
                                <div class="form-group col-md-4">
                                    <label>Strength</label>

                                    <div class="input-group">

                                        <select id="strength" name="strength" class="form-control" required>
                                            <option value="">Select Strength </option>
                                            <?php foreach ($strength_show as $strength) :?>
                                            <option value="<?= esc($strength['strength_id']) ?>">
                                                <?= esc($strength['strength_name']) ?>
                                            </option>

                                            <?php endforeach; ?>
                                        </select>


                                        <div class="input-group-append">

                                            <button class="btn btn-success" id="btnAddStrength" type="button"
                                                title="Add Strength">

                                                <i class="fa fa-plus"></i>

                                            </button>

                                        </div>

                                    </div>

                                </div>

                                <!----------------------------------Product Unit----------------------------------------------------->
                                <div class="form-group col-md-4">
                                    <label>Product Unit</label>

                                    <div class="input-group">

                                        <select id="product_unit" name="product_unit" class="form-control" required>
                                            <option value="">Select Unit </option>
                                            <?php foreach ($unit_show as $unit) : ?>
                                            <option value="<?= esc($unit['product_unit_id']) ?>">
                                                <?= esc($unit['product_unit_name']) ?>
                                            </option>

                                            <?php endforeach;?>
                                        </select>

                                        <div class="input-group-append">

                                            <button class="btn btn-success" id="btnAddUnit" type="button"
                                                title="Add Unit">

                                                <i class="fa fa-plus"></i>

                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <!------------------------------------------------------------------------------------------->
                            </div>
                        </div>
                    </div>
                    <!-- ================= Purchase & Pricing ================= -->

                    <div class="card shadow-sm mb-3">

                        <div class="card-header bg-success text-white">
                            <i class="fa fa-money"></i> Purchase & Pricing
                        </div>

                        <div class="card-body">

                            <!-- Base Price, VAT, Purchase Price, Tax Type, Profit margin, Sales price -->

                            <div class='form-row'>
                                <div class='form-group col-md-4'>
                                    <label>Base Price/Purchase Price (Without VAT)</label>
                                    <input type='text' required class="form-control" name='base_price' id="base_price"
                                        onkeypress="return accept_digit_only(event)" placeholder='Base Price' required>
                                </div>

                                <!--------------------------Purchase VAT/Tax------------------------------------------------------>
                                <div class="form-group col-md-4">
                                    <label>Purchase (VAT/TAX) %</label>

                                    <div class="input-group">

                                        <select id="tax_id" name="tax_id" class="form-control" required>
                                            <option value="">Select Tax</option>
                                            <?php foreach ($tax_show as $tax): ?>
                                            <option value="<?=$tax['tax_id'];?>"
                                                data-percent="<?=$tax['tax_percentage'];?>">
                                                <?=$tax['tax_name'];?> (
                                                <?=$tax['tax_percentage'];?>%)
                                            </option>
                                            <?php endforeach; ?>
                                        </select>

                                        <div class="input-group-append">

                                            <button class="btn btn-success" id="btnAddVatTax" type="button"
                                                title="Add VAT/TAX">

                                                <i class="fa fa-plus"></i>

                                            </button>

                                        </div>

                                    </div>

                                </div>

                                <!---------------------------------------------------------------------------------------------------->

                                <div class='form-group col-md-4'>
                                    <label>Purchase Price (Per Product-With VAT)</label>
                                    <input type='text' required class="form-control" id="purchase_price"
                                        name='purchase_price' onkeypress="return accept_digit_only(event)"
                                        placeholder='Unit Price' readonly>
                                </div>
                            </div>

                            <div class='form-row'>
                                <div class='form-group col-md-4'>
                                    <label>Tax Type</label>
                                    <select class="form-control" id="tax_type" name="tax_type" required>
                                        <option value="without_tax" selected>Without Tax (Exclusive)</option>
                                        <option value="with_tax">With Tax (Inclusive)</option>
                                    </select>
                                </div>
                                <div class='form-group col-md-4'>
                                    <label>Profit Margin(%)</label>
                                    <input type='text' required class="form-control" id="profit_margin"
                                        name='profit_margin' onkeypress="return accept_digit_only(event)"
                                        placeholder="Selling Price">
                                </div>
                                <div class='form-group col-md-4'>
                                    <label>Sales Price(vat/tax সহ)</label>
                                    <input type='text' required class="form-control" id="sales_price" name='sales_price'
                                        onkeypress="return accept_digit_only(event)" placeholder="Selling Price">
                                </div>
                            </div>

                        </div>

                    </div>


                    <!-- ================= Inventory ================= -->

                    <div class="card shadow-sm mb-3">

                        <div class="card-header bg-warning text-dark">
                            <i class="fa fa-archive"></i>
                            Inventory Information
                        </div>

                        <div class="card-body">

                            <!-- Opening Qty, SKU, Barcode -->
                            <div class='form-row'>

                                <div class='form-group col-md-4'>
                                    <label>Opening /Initial Quantity</label>
                                    <input type='text' required class="form-control" name='productinitial_quantity'
                                        onkeypress="return accept_digit_only(event)" placeholder='Product Quantity'>
                                </div>

                                <div class='form-group col-md-4'>
                                    <label>SKU(Stock Keeping Unit)</label>
                                    <input type="text" class="form-control" name="sku" placeholder="SKU Code">
                                </div>
                                <div class='form-group col-md-4'>
                                    <label>Barcode</label>
                                    <input type='text' required class="form-control" name='codefor_barcode'
                                        placeholder='Code for Barcode'>
                                </div>
                            </div>



                            <div class="form-row">
                                <div class='form-group col-md-4'>
                                    <label>Alert Quantity</label>
                                    <input type="number" class="form-control" name="alert_quantity" min="0" required>
                                </div>

                                <div class="form-group col-md-8">
                                    <label>Product Image</label>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="file" name="file">
                                        <label class="custom-file-label">
                                            Choose Product Image
                                        </label>
                                    </div>
                                </div>
                            </div>

                        </div>


                    </div> <!-- END modal-body -->
                    <!-------------------------------------------------------------------------------------------->

                </div>

                <div class="modal-footer">

                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="fa fa-times"></i> Close
                    </button>


                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-save"></i> Save Product
                    </button>


                </div>


            </form>
        </div>
    </div>
</div>

<!-- ==========================================================
     EDIT PRODUCT MODAL
=========================================================== -->
<div class="modal fade" id='EditProductModal' tabindex='-1' role='dialog' aria-labelledby='EditProductModalLabel'
    aria-hidden='true'>
    <div class='modal-dialog modal-lg modal-dialog-centered' role='document'>
        <div class='modal-content'>
            <form id="ProductEdit_submit_form" method='post' action="<?= base_url('products/update') ?>">
                <?= csrf_field() ?>
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="EditProductModalLabel">
                        <i class="fa fa-edit"></i> Edit Product
                    </h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class='modal-body'>
                    <input type='hidden' name='product_id' id='product_id'>
                    <div class='form-row'>
                        <div class='form-group col-md-4'>
                            <label for="product_name">Product Name</label>
                            <input type='text' name='product_name' id='product_name' class="form-control" required>
                        </div>
                        <div class='form-group col-md-4'>
                            <label>Category Name</label>
                            <select id="product_category12" name="product_category12" class="form-control">
                                <?php foreach ($category_show as $category) :?>
                                <option value="<?= esc($category['product_category_id']) ?>">
                                    <?= esc($category['category_name']) ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class='form-group col-md-4'>
                            <label>Brand</label>
                            <select id="product_brand12" name="product_brand12" class="form-control">
                                <?php foreach ($brand_show as $brand) :?>
                                <option value="<?= esc($brand['brand_id']) ?>"><?= esc($brand['product_brand_name']) ?>
                                </option>
                                <?php endforeach;?>
                            </select>
                        </div>
                    </div>
                    <div class='form-row'>
                        <div class='form-group col-md-4'>
                            <label>Group</label>
                            <select id="product_group12" name="product_group12" class="form-control">
                                <?php foreach ($group_show as $group) :?>
                                <option value="<?= esc($group['product_group_id']) ?>"><?= esc($group['group_name']) ?>
                                </option>
                                <?php endforeach;?>
                            </select>
                        </div>
                        <div class='form-group col-md-4'>
                            <label>Unit</label>
                            <select id="product_unit12" name="product_unit12" class="form-control">
                                <?php foreach ($unit_show as $unit) :?>
                                <option value="<?= esc($unit['product_unit_id']) ?>">
                                    <?= esc($unit['product_unit_name']) ?>
                                </option>
                                <?php endforeach;?>
                            </select>
                        </div>
                        <div class='form-group col-md-4'>
                            <label>TAX</label>
                            <select id="tax_percentage12" name="tax_percentage12" class="form-control">
                                <?php foreach ($tax_show as $tax) :?>
                                <option value="<?= esc($tax['tax_percentage']) ?>"><?= esc($tax['tax_name']) ?>
                                </option>
                                <?php endforeach;?>
                            </select>
                        </div>
                    </div>

                    <div class='form-row'>
                        <div class='form-group col-md-4'>
                            <label>Initial Quantity</label>
                            <input type="number" class="form-control" id="productinitial_quantity"
                                name="productinitial_quantity" min="0" required placeholder="Opening Quantity">
                        </div>
                        <div class='form-group col-md-4'>
                            <label>Barcode</label>
                            <input type='text' class="form-control" name='codefor_barcode' id='codefor_barcode'>
                        </div>
                        <div class='form-group col-md-4'>
                            <label>Alert Quantity</label>
                            <input type='text' class="form-control" name='alert_quantity' id='alert_quantity'
                                onkeypress="return accept_digit_only(event)">
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
<!-- ==========================================================
     DELETE PRODUCT MODAL
=========================================================== -->
<div class="modal fade" id="DeleteProductModal" tabindex="-1" role="dialog" aria-labelledby="DeleteProductModalLabel"
    aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered" role="document">

        <div class="modal-content">

            <form method="post" action="<?= site_url('products/delete') ?>">

                <?= csrf_field() ?>

                <div class="modal-header bg-danger text-white">

                    <h5 class="modal-title" id="DeleteProductModalLabel">
                        <i class="fa fa-trash"></i> Delete Product
                    </h5>

                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">

                        <span aria-hidden="true">&times;</span>

                    </button>

                </div>

                <div class="modal-body text-center">

                    <i class="fa fa-exclamation-triangle fa-3x text-warning mb-3"></i>

                    <p class="mb-0">
                        Are you sure you want to delete this product?
                    </p>

                    <small class="text-muted">
                        This action cannot be undone.
                    </small>

                </div>

                <div class="modal-footer">

                    <input type="hidden" id="delete_id" name="delete_id">

                    <button type="button" class="btn btn-secondary" data-dismiss="modal">

                        <i class="fa fa-times"></i> Cancel

                    </button>

                    <button type="submit" class="btn btn-danger">

                        <i class="fa fa-trash"></i> Delete

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>
<?= $this->endSection()?>


<?= $this->section('css') ?>
<link rel="stylesheet" href="<?= base_url('assets/css/product.css') ?>">
<?= $this->endSection() ?>


<?= $this->section('scripts') ?>

<script>
window.APP_URLS = {
    categoryCreate: "<?= site_url('categories/category-create-ajax') ?>",
    initialbrand: "<?=site_url('brands/initial-product-brand')?>",
    brandCreate: "<?= site_url('brands/brand-create-ajax') ?>",
    getCategory: "<?=site_url('categories/get-category-list')?>",
    categoryList: "<?=site_url('get-category-list')?>",
    groupCreate: "<?= site_url('groups/group-create-ajax') ?>",
    unitCreate: "<?= site_url('units/unit-create-ajax') ?>",
    strengthCreate: "<?= site_url('ajax/strength') ?>",
    taxCreate: "<?= site_url('tax/vatTax-create-ajax') ?>"
};
</script>

<script src="<?= base_url('assets/js/product-opening-stock.js') ?>"></script>
<?= $this->endSection() ?>