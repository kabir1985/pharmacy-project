<?php
echo $this->extend('layout');
echo $this->section('content');
?>
<style>
    #sampleTable {
        font-size: 12px;
    }

    .modal-content,
    .form-control,
    label,
    option {
        font-size: 12px;
    }

    #sampleTable td,
    #sampleTable th {
        white-space: nowrap;
    }

    #sampleTable th,
    #sampleTable td {
        padding: 4px 6px;
        vertical-align: middle;
    }

    .product-name {
        max-width: 150px;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    #btnAddCategory {
        padding: 0.15rem 0.35rem;
        min-width: 24px;
        height: 38px;
        /* form-control এর height এর সাথে মিলিয়ে */
    }

    #btnAddCategory i {
        font-size: 9px !important;
        line-height: 1;
    }

    @media (max-width: 1366px) {

        #sampleTable th:nth-child(4),
        #sampleTable td:nth-child(4),
        #sampleTable th:nth-child(7),
        #sampleTable td:nth-child(7) {
            display: none;
        }
    }


    .swal2-container {
        z-index: 999999 !important;
    }

    .swal2-input {
        pointer-events: auto !important;
    }

    .modal-body {
        padding: 20px;
    }

    .form-group {
        margin-bottom: 15px;
    }

    .form-group label {
        font-size: 13px;
        font-weight: 600;
        margin-bottom: 4px;
    }

    .form-control {
        height: 38px;
        font-size: 13px;
    }

    .input-group .btn {
        height: 38px;
        width: 38px;
        padding: 0;
    }

    .input-group .btn i {
        font-size: 12px;
    }

    .custom-file-label {
        height: 38px;
        line-height: 24px;
        font-size: 13px;
    }

    .modal-footer {
        padding: 12px 20px;
    }

    .modal-header {
        padding: 12px 20px;
    }


    .card {
        border: none;
        border-radius: 10px;
    }

    .card-header {
        font-weight: 600;
        padding: 10px 15px;
    }

    .modal-body {
        background: #f8f9fa;
    }

    .form-group label {
        font-weight: 600;
        font-size: 14px;
        margin-bottom: 5px;
    }



    .modal-title {
        font-weight: bold;
    }

    .swal2-popup {
        border-radius: 12px;
    }

    .swal2-title {
        padding-bottom: 10px;
    }

    .custom-input {
        width: 100% !important;
        margin: 0 !important;
        height: 42px !important;
        border: 1px solid #ced4da !important;
        border-radius: 6px !important;
        padding: 8px 12px !important;
        font-size: 14px !important;
        box-sizing: border-box;
    }

    .custom-input:focus {
        border-color: #0d6efd !important;
        box-shadow: 0 0 0 .2rem rgba(13, 110, 253, .25) !important;
    }

    .swal2-actions {
        margin-top: 20px !important;
    }
</style>

<div class='app-title'>
    <div>
        <h1><i class='fa fa-th-list'></i> Product List , Edit, Delete & Add Section</h1>
        <!-- <p>Table to display analytical data effectively</p> -->
    </div>

    <!-- Button trigger modal -->
    <button type='button' class='btn btn-primary btn-sm' data-toggle='modal' data-target='#AddNewProduct'>
        <i class='fa fa-plus'></i>
        Opening Stock/Product
    </button>
</div>

<!---------------Data Table start Here----..............................................--------------------------->
<div class='row'>
    <div class='col-md-12'>
        <div class='tile collapseable show animate__animated  animate__fadeInUp'>
            <div class='tile-body'>
                <div class='table-responsive'>
                    <table class="table table-bordered table-sm dt-responsive nowrap" id="sampleTable" width="100%">

                        <thead>

                            <tr>
                                <th>img</th>
                                <th>Name</th>
                                <th>Category</th>
                                <th>Open.Stock</th>

                                <th>Price-Without-VAT</th>
                                <th>Tax%</th>
                                <th>Tax.Amt</th>

                                <th>Pur.Price</th>
                                <th>profit-margin%</th>
                                <th>Sales/Cus Price</th>
                                <div class="btn-group btn-group-sm">
                                    <th>Action</th>
                                </div>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            // print_r($product_show);
// exit();
                            if (count($product_show) > 0) {
                                foreach ($product_show as $row11) {
                                    ?>
                            <tr>
                                <td><img src="<?= base_url() ?>/public/uploads/<?= $row11["product_image"] ?>"
                                        class="img-thumbnail" style="width:40px;height:35px;"></td>
                                <!-- <td><?php //echo $row11['codefor_barcode'] ?></td> -->
                                        <td class="product-name"><?php echo $row11['product_name']; ?></td>
                                        <td><?php echo $row11['category_name'] ?></td>
                                        <!-- <td><?php //echo $row11['product_brand_name'] ?></td> -->

                                        <td><?php echo $row11['productinitial_quantity'] ?></td>
                                        <td><?php echo $row11['cost_without_vat'] ?></td>

                                        <td><?php echo $row11['tax_percentage'] ?>%</td>
                                        <td><?php echo $row11['tax_amount'] ?></td>

                                        <td><?php echo $row11['purchase_price'] ?></td>
                                        <td><?php echo $row11['profit_margin_%'] ?></td>


                                        <td><?php echo $row11['sales_price_for_customer'] ?></td>
                                        <!-- <td><?php //echo $row11['final_price'] ?></td> -->

                                        <td>
                                            <div class="btn-group" role="group" aria-label="Basic example">
                                                <a href="#" class="btn btn-primary btn-sm btn-edit"
                                                    data-product_id="<?php echo $row11['product_id']; ?>"
                                                    data-product_name="<?php echo $row11['product_name']; ?>"
                                                    data-product_category="<?php echo $row11['product_category']; ?>"
                                                    data-product_brand="<?php echo $row11['product_brand'] ?>"
                                                    data-product_group="<?php echo $row11['product_group'] ?>"
                                                    data-product_unit="<?php echo $row11['product_unit'] ?>"
                                                    data-tax_percentage="<?php echo $row11['tax_percentage'] ?>"
                                                    data-productinitial_quantity="<?php echo $row11['productinitial_quantity'] ?>"
                                                    data-base_price="<?php echo $row11['base_price'] ?>"
                                                    data-codefor_barcode="<?php echo $row11['codefor_barcode'] ?>"
                                                    data-alert_quantity="<?php echo $row11['alert_quantity'] ?>">
                                                    <i class="fa fa-edit"></i></a>
                                                <a href="#" class="btn btn-danger btn-sm btn-delete"
                                                    data-delete_id="<?php echo $row11['product_id'] ?>"><i
                                                        class="fa fa-trash-o"></i></a>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php
                                }
                            } else {
                                echo "Data not Found";
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




<!---------------------------Modal Form for Opening Stock/Product Start---------------------------------------->
<!-- Modal -->
<div class='modal fade' id='AddNewProduct' role='dialog' aria-labelledby='AddNewProduct' aria-hidden='true'>
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
        <div class='modal-content'>
            <!-----for image upload------------------->
            <?php if (session('msg')): ?>
            <div class="alert alert-success alert-dismissible">
                <?= session('msg') ?>
                <button type="button" class="close" data-dismiss="alert"><span>×</span></button>
            </div>
            <?php endif ?>
            <!-----for image upload------------------->
            <form id="NewProductAdd_Form" method='post' action="<?php echo site_url('products/create') ?>"
                accept-charset="utf-8" enctype="multipart/form-data">
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
                                    <input required type='text' required class='form-control' name='product_name'
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

                                                <option value="<?= $category['product_category_id'] ?>">
                                                    <?= $category['category_name'] ?>
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
                                            <?php
                                            foreach ($group_show as $group) {
                                                ?>
                                            <option value="<?php echo $group['product_group_id'] ?>">
                                                <?php echo $group['group_name'] ?>
                                            </option>
                                            <?php
                                            }
                                            ?>
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

                                        <!-- <input required type='text' required class='form-control' id="strength" name='strength'
                                 placeholder='Product Strength'> -->

                                        <select id="strength" name="strength" class="form-control" required>
                                            <option value="">Select Strength </option>
                                            <?php
                                            foreach ($strength_show as $row) {
                                                ?>
                                                <option value="<?php echo $row['strength_id'] ?>">
                                                    <?php echo $row['strength_name'] ?>
                                                </option>

                                                <?php
                                            }
                                            ?>
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
                                            <?php
                                            foreach ($unit_show as $unit) {
                                                ?>
                                            <option value="<?php echo $unit['product_unit_id'] ?>">
                                                <?php echo $unit['product_unit_name'] ?>
                                            </option>

                                            <?php
                                            }
                                            ?>
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
                                    <input required type='text' required class='form-control' name='base_price'
                                        id="base_price" onkeypress="return accept_digit_only(event)"
                                        placeholder='Base Price'>
                                </div>

                                <!--------------------------Purchase VAT/Tax------------------------------------------------------>
                                <!-- <div class='form-group col-md-4'>
                            <label>Purchase (VAT/TAX) %</label>
                        
                            <input type="hidden" name="tax_percentage" id="tax_percentage">
                        </div> -->

                                <div class="form-group col-md-4">
                                    <label>Purchase (VAT/TAX) %</label>

                                    <div class="input-group">

                                        <select id="tax_id" name="tax_id" class="form-control" required>
                                            <option value="">Select Tax</option>
                                            <?php foreach ($tax_show as $row): ?>
                                                <option value="<?= $row['tax_id']; ?>"
                                                    data-percent="<?= $row['tax_percentage']; ?>">
                                                    <?= $row['tax_name']; ?> (
                                                    <?= $row['tax_percentage']; ?>%)
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
                                    <input required type='text' required class='form-control' id="purchase_price"
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
                                    <input required type='text' required class='form-control' id="profit_margin"
                                        name='profit_margin' onkeypress="return accept_digit_only(event)"
                                        placeholder="Selling Price">
                                </div>
                                <div class='form-group col-md-4'>
                                    <label>Sales Price(vat/tax সহ)</label>
                                    <input required type='text' required class='form-control' id="sales_price"
                                        name='sales_price' onkeypress="return accept_digit_only(event)"
                                        placeholder="Selling Price">
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
                                    <input required type='text' required class='form-control'
                                        name='productinitial_quantity' onkeypress="return accept_digit_only(event)"
                                        placeholder='Product Quantity'>
                                </div>

                                <div class='form-group col-md-4'>
                                    <label>SKU(Stock Keeping Unit)</label>
                                    <input type="text" class="form-control" name="sku" placeholder="SKU Code">
                                </div>
                                <div class='form-group col-md-4'>
                                    <label>Barcode</label>
                                    <input required type='text' required class='form-control' name='codefor_barcode'
                                        placeholder='Code for Barcode'>
                                </div>

                                <!-- <div class='form-group col-md-4'>
                            <label>Alert Quantity</label>
                            <input type="number" class="form-control" name="alert_quantity" min="0" required>
                        </div> -->
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

<!----------------------Modal Form New Product Add End------------------------------------------>



<!---------------------------Modal Form for Edit Section Load Start---------------------------------------->
<!-- Modal -->
<div class='modal fade' id='EditProductModal' tabindex='-1' role='dialog' aria-labelledby='EditProductModalLabel'
    aria-hidden='true'>
    <div class='modal-dialog modal-lg modal-dialog-centered' role='document'>
        <div class='modal-content'>
            <form id="ProductEdit_submit_form" method='post' action="<?php echo base_url('products/update') ?>">
                <div class='modal-header'>
                    <h5 class='modal-title' id='EditProductModalLabel'>Please Update Product</h5>
                    <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                        <span aria-hidden='true'>&times;</span>
                    </button>
                </div>
                <div class='modal-body'>
                    <input type='hidden' required class='form-control' name='product_id' id='product_id'>
                    <div class='form-row'>
                        <div class='form-group col-md-4'>
                            <label>Product Name</label>
                            <input type='text' required class='form-control' name='product_name' id='product_name'>
                        </div>
                        <div class='form-group col-md-4'>
                            <label>Category Name</label>
                            <select id="product_category12" name="product_category12" class="form-control">
                                <?php foreach ($category_show as $row22) { ?>
                                    <option value="<?php echo $row22['product_category_id'] ?>">
                                        <?php echo $row22['category_name'] ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class='form-group col-md-4'>
                            <label>Brand</label>
                            <select id="product_brand12" name="product_brand12" class="form-control">
                                <?php foreach ($brand_show as $row) { ?>
                                    <option value="<?php echo $row['brand_id'] ?>"><?php echo $row['product_brand_name'] ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class='form-row'>
                        <div class='form-group col-md-4'>
                            <label>Group</label>
                            <select id="product_group12" name="product_group12" class="form-control">
                                <?php foreach ($group_show as $row) { ?>
                                    <option value="<?php echo $row['product_group_id'] ?>"><?php echo $row['group_name'] ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class='form-group col-md-4'>
                            <label>Unit</label>
                            <select id="product_unit12" name="product_unit12" class="form-control">
                                <?php foreach ($unit_show as $row) { ?>
                                    <option value="<?php echo $row['product_unit_id'] ?>">
                                        <?php echo $row['product_unit_name'] ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class='form-group col-md-4'>
                            <label>TAX</label>
                            <select id="tax_percentage12" name="tax_percentage12" class="form-control">
                                <?php foreach ($tax_show as $row) { ?>
                                    <option value="<?php echo $row['tax_percentage'] ?>"><?php echo $row['tax_name'] ?>
                                    </option>
                                <?php } ?>
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
                            <input type='text' class='form-control' name='codefor_barcode' id='codefor_barcode'>
                        </div>
                        <div class='form-group col-md-4'>
                            <label>Alert Quantity</label>
                            <input type='text' class='form-control' name='alert_quantity' id='alert_quantity'
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


<!----------------------Modal Form Edit Section  End------------------------------------------>

<!-- Modal Delete Product-->

<div class="modal fade" id="DeleteProductModal" tabindex="-1" role="dialog" aria-labelledby="DeleteProductModal"
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
            <form method="post" action="<?php echo site_url('products/delete') ?>">
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
<link rel="stylesheet" href="<?php echo base_url('assets/css/dataTables.responsive.min.css') ?>">
<script type='text/javascript' src="<?php echo base_url('assets/js/plugins/jquery.dataTables.min.js') ?>"></script>
<script type='text/javascript' src="<?php echo base_url('assets/js/plugins/dataTables.bootstrap.min.js') ?>"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script type='text/javascript'>
    // Fix modal close buttons
    $('.modal .btn-secondary[data-dismiss="modal"], .modal .close').on('click', function () {
        $(this).closest('.modal').modal('hide');
    });


    $(document).ready(function () {

        $.fn.modal.Constructor.prototype.enforceFocus = function () { };


        /////////////////Product Final Price Calculation start//////////////////////////////////////////////////////////////////////
        function getTaxPercent() {
            return parseFloat($('#tax_id option:selected').data('percent')) || 0;
        }

        // MAIN CALCULATION
        function calculatePrice(fromSales = false) {

            let basePrice = parseFloat($('#base_price').val()) || 0;
            let margin = parseFloat($('#profit_margin').val()) || 0;
            let taxPercent = getTaxPercent();
            let taxType = $('#tax_type').val();

            let purchasePrice = 0;
            let salesPrice = parseFloat($('#sales_price').val()) || 0;

            // PURCHASE PRICE
            if (taxType === 'with_tax') {
                purchasePrice = basePrice;
            } else {
                purchasePrice = basePrice + (basePrice * taxPercent / 100);
            }

            // যদি sales price থেকে margin calculate করতে চান
            if (fromSales) {

                if (purchasePrice > 0) {
                    margin = ((salesPrice - purchasePrice) / purchasePrice) * 100;
                } else {
                    margin = 0;
                }

                $('#profit_margin').val(margin.toFixed(2));

            } else {

                // margin থেকে sales price calculate
                salesPrice = purchasePrice * (1 + margin / 100);

                $('#sales_price').val(salesPrice.toFixed(2));
            }

            $('#purchase_price').val(purchasePrice.toFixed(2));
        }


        // EVENTS

        // base price / margin change হলে sales price auto calculate
        $('#base_price, #profit_margin').on('input', function () {
            calculatePrice(false);
        });

        // sales price change হলে margin auto calculate
        $('#sales_price').on('input', function () {
            calculatePrice(true);
        });

        // tax change হলে recalculation
        $('#tax_type, #tax_id').on('change', function () {
            calculatePrice(false);
        });
        //////////////Product Final Price Calculation End///////////////////////////////////////////////////////////////////////////////////

        // $("#product_category").on("change", function() {
        //     var categoryId = this.value;

        //     var brand_call_url = "<?= site_url('/initial-product-brand') ?>";
        //     $.ajax({
        //         url: brand_call_url,
        //         type: "POST",
        //         data: "categoryId=" + categoryId,
        //         success: function(response) {
        //             console.log(response);
        //             $("#product_brand").html(response);
        //         },
        //     });

        // });
        $("#product_category").on("change", function () {
            var categoryId = this.value;

            $.ajax({
                url: "<?= site_url('brands/initial-product-brand') ?>",
                type: "POST",
                data: {
                    categoryId: categoryId
                },
                success: function (response) {

                    $("#product_brand").html(response);

                    // এখানে এই অংশ যোগ করুন
                    let selectedBrand = $("#product_brand").data("selected_brand");

                    if (selectedBrand) {
                        $("#product_brand").val(selectedBrand);
                        $("#product_brand").removeData("selected_brand");
                    }

                    $("#product_brand").trigger("change");
                }
            });
        });



        $('#sampleTable').DataTable({
            responsive: true,
            autoWidth: false,
            pageLength: 25
        });

        ////-------------------Product Entry Form-------------------------//

        $('#tax_id').on('change', function () {

            var tax_percentage = $(this).find(':selected').data('percent');

            $('#tax_percentage').val(tax_percentage);

        });



        var allowSubmit = true;

        $('#NewProductAdd_Form').submit(function (event) {
            event.preventDefault();

            if (allowSubmit) {
                allowSubmit = false;
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
                    .done(function (data) {
                        if (data == 1) {
                            parentMOdal.modal('toggle');
                            //     //page refresh after submission
                            location.reload();
                            //     // alert("Success");
                        }

                        // alert(data);
                    });

            }
        });


        //////Product Edit submit into database start/////////////////////////////////


        $('#ProductEdit_submit_form').submit(function (event) {
            event.preventDefault();

            if (allowSubmit) {
                allowSubmit = false;
                var parentMOdal = $(this).closest('.modal');
                var postData = new FormData(this);

                $.ajax({
                    type: $(this).attr("method"),
                    url: $(this).attr("action"),
                    data: postData,
                    processData: false,
                    contentType: false,
                })
                    .done(function (data) {
                        allowSubmit = true; // ✅ allow future submissions
                        if (data == 1) {
                            parentMOdal.modal('hide'); // ✅ hide modal
                            location.reload(); // refresh page to show updates
                        } else {
                            alert('Failed to update product.'); // handle failure
                        }
                    })
                    .fail(function () {
                        allowSubmit = true;
                        alert('Something went wrong. Please try again.');
                    });
            }

        });

        /////////Product Edit Submit inot database end here//////////////////////



        //...................JQuery for Modal Edit & Delete option...................................



        // get Edit Product
        $('.btn-edit').on('click', function () {
            // get data from button edit
            const product_id = $(this).data('product_id');
            const product_name = $(this).data('product_name');

            // alert(product_category);


            //const product_group = $(this).data('product_group');
            //const product_unit = $(this).data('product_unit');

            //const tax_percentage = $(this).data('tax_percentage');
            const productinitial_quantity = $(this).data('productinitial_quantity');
            const base_price = $(this).data('base_price');
            // const final_price = $(this).data('final_price');
            const codefor_barcode = $(this).data('codefor_barcode');
            const alert_quantity = $(this).data('alert_quantity');



            // Set data to Form Edit
            $('#product_id').val(product_id);
            $('#product_name').val(product_name);

            //$('#product_category').val(product_category);

            ///Category auto selected/////////////////////////////////////////////
            //var expense_category_id = $(this).data('expense_category_id');
            var product_category_id = $(this).data('product_category');
            $("#product_category12 option[value=product_category_id]").attr('selected', 'selected');
            $("#product_category12").val(product_category_id);
            //////////////////////////////////////////////////////////

            var product_brand_id = $(this).data('product_brand');
            $("#product_brand12 option[value=product_brand_id]").attr('selected', 'selected');
            $("#product_brand12").val(product_brand_id);

            var product_group_id = $(this).data('product_group');
            $("#product_group12 option[value=product_group_id]").attr('selected', 'selected');
            $("#product_group12").val(product_group_id);


            // $('#product_unit').val(product_unit);
            var product_unit_id = $(this).data('product_unit');
            $("#product_unit12 option[value=product_unit_id]").attr('selected', 'selected');
            $("#product_unit12").val(product_unit_id);

            //$('#tax_percentage').val(tax_percentage);
            var tax_perchange_id = $(this).data('tax_percentage');
            $("#tax_percentage12 option[value=tax_perchange_id]").attr('selected', 'selected');
            $("#tax_percentage12").val(tax_perchange_id);

            $('#productinitial_quantity').val(productinitial_quantity);
            $('#base_price').val(base_price);
            // $('#final_price').val(final_price);
            $('#codefor_barcode').val(codefor_barcode);
            $('#alert_quantity').val(alert_quantity);
            // Call Modal Edit
            $('#EditProductModal').modal('show');
        });

        // get Delete Product
        $('.btn-delete').on('click', function () {
            // get data from button edit
            const delete_id = $(this).data('delete_id');
            // Set data to Form Edit
            $('#delete_id').val(delete_id);
            // Call Modal Edit
            $('#DeleteProductModal').modal('show');
        });

        //................ JQuery modal Edit & Delete end here........................................
        // ...............For Date Show.............................
        $('.datePicker').datepicker({
            format: "dd/mm/yyyy",
            autoclose: true,
            todayHighlight: true
        });
        //.................For Date show end........................

        ///////////////////product image upload issue//////////////////////////////////
        $('.custom-file-input').on('change', function () {
            var fileName = $(this).val().split('\\').pop();
            $(this).next('.custom-file-label').html(fileName);
        });



        document.getElementById("file").onchange = function (evt) {
            const [file] = this.files;
            if (file) {
                document.getElementById("preview").src = URL.createObjectURL(file);
                document.getElementById("preview").style.display = "block";
            }
        }
        ////////////////////////////////////////////////////////

        //=================================== Category Add dynamically ==================================

        $("#btnAddCategory").click(function () {

            $('#AddNewProduct').modal('hide');

            setTimeout(function () {

                Swal.fire({
                    title: "Add Product Category",
                    input: "text",
                    inputPlaceholder: "Enter Category Name",
                    allowOutsideClick: false,
                    showCancelButton: true,
                    confirmButtonText: "Save"
                }).then((result) => {

                    $('#AddNewProduct').modal('show');

                    if (result.isConfirmed) {

                        $.ajax({
                            url: "<?= site_url('categories/category-create-ajax') ?>",
                            type: "POST",
                            dataType: "json",
                            data: {
                                category_name: result.value
                            },
                            success: function (response) {

                                if (response.status) {

                                    $("#product_category").append(
                                        '<option value="' + response.id +
                                        '" selected>' + response.name +
                                        '</option>'
                                    );

                                    $("#product_category").trigger('change');

                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Category Added'
                                    });
                                }
                            }
                        });

                    }

                });

            }, 300);

        });
        //===================================================================================================


        //=================================== Brand Add dynamically ==================================

        $("#btnAddBrand").click(function () {

            // alert("kabir")

            $('#AddNewProduct').modal('hide');

            setTimeout(function () {

                $.ajax({
                    url: "<?= site_url('categories/get-category-list') ?>",
                    type: "GET",
                    dataType: "json",
                    success: function (categories) {

                        //alert(categories)

                        let option = '';

                        $.each(categories, function (i, row) {
                            option += '<option value="' + row
                                .product_category_id + '">' + row
                                    .category_name + '</option>';
                        });

                        Swal.fire({
                            title: '<span style="font-size:22px;font-weight:600;">Add Brand</span>',
                            width: '500px',
                            html: `
        <div style="text-align:left">

            <div class="mb-3">
                <label for="swal_category" style="font-weight:600;margin-bottom:6px;display:block;">
                    Category
                </label>
                <select id="swal_category" class="swal2-select custom-input">
                    ${option}
                </select>
            </div>

            <div class="mt-3">
                <label for="swal_brand" style="font-weight:600;margin-bottom:6px;display:block;">
                    Brand Name
                </label>
                <input
                    id="swal_brand"
                    type="text"
                    class="swal2-input custom-input"
                    placeholder="Enter Brand Name">
            </div>

        </div>
    `,
                            showCancelButton: true,
                            confirmButtonText: '<i class="fa fa-save"></i> Save',
                            cancelButtonText: 'Cancel',
                            confirmButtonColor: '#0d6efd',
                            cancelButtonColor: '#6c757d',
                            focusConfirm: false,

                            // preConfirm: () => {

                            //     let category = $('#swal_category').val();
                            //     let brand = $('#swal_brand').val();

                            //     if (brand.trim() == '') {
                            //         Swal.showValidationMessage(
                            //             'Please enter Brand Name');
                            //         return false;
                            //     }

                            //     return {
                            //         category: category,
                            //         brand: brand
                            //     };
                            // }


                            /////////////////////////////////////////
                            preConfirm: () => {

                                return {
                                    category: $("#swal_category").val(),
                                    brand: $("#swal_brand").val()
                                };

                            }
                            ////////////////////////////////////////////////


                        }).then((result) => {

                            $('#AddNewProduct').modal('show');

                            if (result.isConfirmed) {

                                $.ajax({
                                    url: "<?= site_url('brands/brand-create-ajax') ?>",
                                    type: "POST",
                                    dataType: "json",
                                    data: {
                                        category_id: result.value
                                            .category,
                                        product_brand_name: result.value
                                            .brand
                                    },
                                    success: function (response) {

                                        if (response.status) {

                                            loadCategory(
                                                result.value
                                                    .category,
                                                response.id
                                            );

                                            Swal.fire({
                                                icon: 'success',
                                                title: 'Brand Added Successfully'
                                            });

                                            // Swal.fire({
                                            //     icon: 'success',
                                            //     title: 'Brand Added Successfully'
                                            // });

                                        } else {

                                            Swal.fire({
                                                icon: 'error',
                                                title: response
                                                    .message
                                            });

                                        }

                                    }
                                });

                            }

                        });

                    }
                });

            }, 300);

        });


        function loadCategory(selected_category = null, selected_brand = null) {
            $.ajax({
                url: "<?= site_url('get-category-list') ?>",
                type: "GET",
                dataType: "json",
                success: function (response) {

                    $("#product_category").empty();

                    $.each(response, function (i, row) {

                        $("#product_category").append(
                            '<option value="' + row.product_category_id + '">' +
                            row.category_name +
                            '</option>'
                        );

                    });

                    if (selected_category) {
                        $("#product_category").val(selected_category);
                    }

                    // Brand ID Store করুন
                    $("#product_brand").data("selected_brand", selected_brand);

                    $("#product_category").trigger("change");
                }
            });
        }

        //===================================================================================================

        //========================Product Group / Generic Name====================================================

        $("#btnAddGroup").click(function () {

            $('#AddNewProduct').modal('hide');

            setTimeout(function () {

                Swal.fire({
                    title: "Add Product Group/Generic",
                    input: "text",
                    inputPlaceholder: "Enter Generic Name",
                    allowOutsideClick: false,
                    showCancelButton: true,
                    confirmButtonText: "Save"
                }).then((result) => {

                    $('#AddNewProduct').modal('show');

                    if (result.isConfirmed) {

                        $.ajax({
                            url: "<?= site_url('groups/group-create-ajax') ?>",
                            type: "POST",
                            dataType: "json",
                            data: {
                                group_name: result.value
                            },
                            success: function (response) {

                                if (response.status) {

                                    $("#product_group").append(
                                        '<option value="' + response.id +
                                        '" selected>' + response.name +
                                        '</option>'
                                    );

                                    $("#product_group").trigger('change');

                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Group/Generic Added'
                                    });
                                }
                            }
                        });

                    }

                });

            }, 300);

        });

        //===============================================================================================================

        //===============================Product Unit===============================================

        $("#btnAddUnit").click(function () {

            $('#AddNewProduct').modal('hide');

            setTimeout(function () {

                Swal.fire({
                    title: "Add Product Unit",
                    input: "text",
                    inputPlaceholder: "Enter Unit Name",
                    allowOutsideClick: false,
                    showCancelButton: true,
                    confirmButtonText: "Save"

                }).then((result) => {

                    $('#AddNewProduct').modal('show');

                    if (result.isConfirmed) {

                        $.ajax({
                            url: "<?= site_url('units/unit-create-ajax') ?>",
                            type: "POST",
                            dataType: "json",
                            data: {
                                product_unit: result.value
                            },
                            success: function (response) {

                                if (response.status) {

                                    $("#product_unit").append(
                                        '<option value="' + response.id +
                                        '" selected>' + response.name +
                                        '</option>'
                                    );

                                    $("#product_unit").trigger('change');

                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Product Unit Added'
                                    });
                                }
                            }
                        });

                    }

                });

            }, 300);

        });


        //====================Strength add======================================================================

        $("#btnAddStrength").click(function () {

            $('#AddNewProduct').modal('hide');

            setTimeout(function () {

                Swal.fire({
                    title: "Add Product Strength",
                    input: "text",
                    inputPlaceholder: "Enter Strength (e.g. 500 mg)",
                    allowOutsideClick: false,
                    showCancelButton: true,
                    confirmButtonText: "Save"
                }).then((result) => {

                    $('#AddNewProduct').modal('show');

                    if (result.isConfirmed && result.value.trim() != "") {

                        $.ajax({
                            url: "<?= site_url('strengthCreateAjax') ?>",
                            type: "POST",
                            dataType: "json",
                            data: {
                                strength: result.value
                            },
                            success: function (response) {

                                if (response.status) {

                                    // শুধু input-এ value সেট করুন
                                    // $("#strength").val(response.name);


                                    $("#strength").append(
                                        '<option value="' + response.id +
                                        '" selected>' + response.name +
                                        '</option>'
                                    );

                                    $("#strength").trigger('change');


                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Product Strength Added'
                                    });

                                } else {
                                    Swal.fire({
                                        icon: 'error',
                                        title: response.message
                                    });
                                }

                            }
                        });

                    }

                });

            }, 300);

        });
        //===============================================================================

        $("#btnAddVatTax").click(function () {

            $('#AddNewProduct').modal('hide');

            setTimeout(function () {

                Swal.fire({
                    title: "Add VAT/TAX",
                    html: `
                <input id="tax_name" class="swal2-input" placeholder="Tax Name">
                <input id="tax_percentage" type="number" class="swal2-input" placeholder="Tax Percentage">
            `,
                    focusConfirm: false,
                    showCancelButton: true,
                    confirmButtonText: "Save",

                    preConfirm: () => {

                        return {
                            tax_name: $("#tax_name").val(),
                            tax_percentage: $("#tax_percentage").val()
                        };

                    }

                }).then((result) => {

                    $('#AddNewProduct').modal('show');

                    if (!result.isConfirmed) return;

                    $.ajax({

                        url: "<?= site_url('tax/vatTax-create-ajax') ?>",
                        type: "POST",
                        dataType: "json",
                        data: result.value,

                        success: function (response) {

                            if (response.status) {

                                $("#tax_id").append(
                                    '<option value="' + response.id +
                                    '" data-percent="' + response.tax_percentage +
                                    '" selected>' +
                                    response.tax_name + ' (' +
                                    response.tax_percentage + '%)</option>'
                                );

                                $("#tax_id").trigger("change");

                                Swal.fire({
                                    icon: "success",
                                    title: "VAT/TAX Added Successfully"
                                });

                            } else {

                                Swal.fire({
                                    icon: "error",
                                    title: response.message
                                });

                            }

                        }

                    });

                });

            }, 300);

        });
        //=========================================================================================

    });
</script>

<!-- For Calendar start -->

<!-- For Calendar End -->

<?php
echo $this->endSection();
?>