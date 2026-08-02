<?php
echo $this->extend('layout');
echo $this->section('content');
?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12 col-lg-9">
            <div class="d-flex align-items-center">
                <!-- Product Select (Left Column) -->
                <div class="flex-grow-1 mr-2">
                    <select id="item" class="form-control select2" style="width:100%">
                        <option value="0">Select Product</option>
                        <?php foreach ($product_show_for_sale as $row): ?>
                        <option value="<?=$row['product_id']?>">
                            <?=$row['product_name'] . "&nbsp;|&nbsp;" . $row['category_name'] . "&nbsp;|&nbsp;" . $row['group_name'] . "&nbsp;|&nbsp;" . $row['strength_name']?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <!-- Add Button (Right Column) -->
                <div>
                    <button type='button' class='btn btn-primary btn-sm' data-toggle='modal'
                        data-target='#AddNewProduct'>
                        <i class='fa fa-plus-circle'></i>
                        Opening Stock
                    </button>
                </div>
            </div>
            <!-- Cart Table -->
            <div class="table-responsive mt-3">
                <table class="table table-striped">
                    <thead>
                       <tr class="table-info">
                            <th>Product</th>
                            <th>Stock</th>
                            <th>QtyPerBox</th>
                            <th>BoxQty</th>
                            <th>UnitPrice</th>
                            <th>TP/Box</th>
                            <th>Free Qty</th>
                            <th class="vat-column-header">P.Vat%</th>
                            <th>V.Amt</th>
                            <th>S.Price</th>
                            <th id="discountHeader">Dis%</th>
                            <th class="text-end">SubTotal</th>
                            <th></th>
                        </tr>

                    </thead>
                    <tbody id="cartTableBody"></tbody>
                </table>
            </div>
        </div>
        <div class="col-12 col-lg-3 mb-2">
            <div class="card text-dark bg-light mb-3">
                <div class="card-header">
                    <select id="supplier_id" class="form-control select2 w-100" required>
                        <option value="">Select Supplier</option>
                        <?php foreach ($supplier_show as $row): ?>
                        <option value="<?=$row['supplier_id']?>"><?=$row['supplier_name']?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="card-body">
                    <table class="table table-striped mb-0">
                        <tfoot>
                            <tr class="table-light">
                                <td colspan="4"></td>
                                <td class="text-end pe-0">Total Price</td>
                                <td id="totalPrice" class="text-end">0.00</td>
                            </tr>
                            <tr>
                                <td colspan="4"></td>
                                <td class="text-end p-0 m-0">Discount on Total</td>
                                <td class="text-end p-0 m-0">
                                    <span id="discount_on_total_price" class="badge bg-light">0.00</span>Tk.
                                </td>
                            </tr>

                            <tr>
                                <td colspan="4"></td>
                                <td class="text-end p-0 m-0">VAT Amt on Total</td>
                                <td class="text-end p-0 m-0">
                                    <span id="vat_amt_on_total" class="badge bg-light">0.00 </span>Tk.
                                </td>
                            </tr>
                            <tr class="table-warning">
                                <td colspan="4"></td>
                                <td class="text-end pe-0">Net Total</td>
                                <td class="text-end" id="netTotalPrice"><strong>0.00</strong></td>
                            </tr>
                            <tr class="table-secondary">
                                <td colspan="6">
                                    <div class="d-flex flex-column flex-md-row bg-secondary text-white gap-2">

                                        <button type="button" class="btn btn-primary flex-fill" data-toggle="modal"
                                            data-target="#discountOnTotalModal">
                                            Discount
                                        </button>

                                        <button type="button" class="btn btn-danger flex-fill" id="openVatModal"
                                            data-toggle="modal" data-target="#vatModal">
                                            VAT %
                                        </button>
                                    </div>

                                    <div class="text-muted">
                                        <button class="btn btn-info text-uppercase w-100" disabled
                                            id="productPurchase">Purchase</button>
                                    </div>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12 col-lg-9"> SubTotal = ( মূল প্রাইজ - ডিসকাউন্ট ) + ভ্যাট</div>
    </div>
</div>


<!------------------- Modal for discount start----------------------- --->
<!-- Modal -->
<div class="modal fade" id="discountOnTotalModal" tabindex="-1" role="dialog"
    aria-labelledby="discountOnTotalModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="discountOnTotalModalLabel">Discount</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container mt-1">
                    <form>
                        <!-- Discount Type -->
                        <div class="mb-3">
                            <label class="form-label fw-bold">Discount Type</label>
                            <div class="btn-group" role="group" aria-label="Discount Type">
                                <input type="radio" class="btn-check" name="discountType" id="fixedType" value="fixed"
                                    checked>
                                <label class="btn btn-outline-primary" for="fixedType">Fixed</label>

                                <input type="radio" class="btn-check" name="discountType" id="percentType"
                                    value="percent">
                                <label class="btn btn-outline-primary" for="percentType">Percent</label>
                            </div>
                        </div>

                        <!-- Fixed Amount -->
                        <div class="mb-3" id="fixedInput">
                            <label for="fixedAmount" class="form-label">Fixed</label>
                            <input type="number" class="form-control" id="fixedAmount" placeholder="Fixed amount">
                        </div>

                        <!-- Percent Amount -->
                        <div class="mb-3 d-none" id="percentInput">
                            <label for="percentAmount" class="form-label">Percent (%)</label>
                            <input type="number" class="form-control" id="percentAmount" placeholder="Enter percent">
                        </div>
                    </form>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Ok</button>
            </div>
        </div>
    </div>
</div>
<!---------------------- Modal for discount end ------------------------->

<!------------------------Modal for VAT Start---------------------------->

<div class="modal fade" id="vatModal" tabindex="-1" aria-labelledby="vatModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="vatModalLabel">VAT %</h5>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="number" class="form-control" id="vatInput" placeholder="Enter VAT %" min="0" step="0.01">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="saveVatBtn">Apply VAT</button>
            </div>
        </div>
    </div>
</div>





<!-- ==========================================================
     ADD PRODUCT /Opening Stock MODAL
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
            <form id="NewProductAdd_Form" method='post' action="<?=site_url('products/create')?>" accept-charset="utf-8"
                enctype="multipart/form-data">
                <?=csrf_field()?>
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
                                            <?php foreach ($group_show as $group): ?>
                                            <option value="<?=esc($group['product_group_id'])?>">
                                                <?=esc($group['group_name'])?>
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
                                            <?php foreach ($strength_show as $strength): ?>
                                            <option value="<?=esc($strength['strength_id'])?>">
                                                <?=esc($strength['strength_name'])?>
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
                                            <?php foreach ($unit_show as $unit): ?>
                                            <option value="<?=esc($unit['product_unit_id'])?>">
                                                <?=esc($unit['product_unit_name'])?>
                                            </option>

                                            <?php endforeach; ?>
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

<?php
echo $this->endSection();
?>

<!--=============== For Opening Stock  & Product-Purchae CSS start============== -->

<?=$this->section('css')?>
<link rel="stylesheet" href="<?=base_url('assets/css/product.css')?>">
<link rel="stylesheet" href="<?=base_url('assets/css/product-purchase.css')?>">
<?=$this->endSection()?>
<!--=============== For Opening Stock  & Product-Purchae CSS start============== -->

<?php
echo $this->section('scripts');
?>

<!-- Plugin -->
<script src="<?= base_url('assets/js/jquery.mycart.js') ?>"></script>

<!-- Global Configuration -->
<script>
window.APP_URLS = {

    // ================= Category =================
    categoryCreate: "<?= site_url('categories/category-create-ajax') ?>",
    getCategory: "<?= site_url('categories/get-category-list') ?>",
    categoryList: "<?= site_url('get-category-list') ?>",

    // ================= Brand =================
    initialBrand: "<?= site_url('brands/initial-product-brand') ?>",
    brandCreate: "<?= site_url('brands/brand-create-ajax') ?>",

    // ================= Group =================
    groupCreate: "<?= site_url('groups/group-create-ajax') ?>",

    // ================= Unit =================
    unitCreate: "<?= site_url('units/unit-create-ajax') ?>",

    // ================= Strength =================
    strengthCreate: "<?= site_url('ajax/strength') ?>",

    // ================= Tax =================
    taxCreate: "<?= site_url('tax/vatTax-create-ajax') ?>",

    // ================= Purchase =================
    purchaseProduct: "<?= site_url('purchase/product') ?>"
};

window.APP = {

    data: {
        productsList: <?= json_encode($product_show_for_sale, JSON_PRETTY_PRINT) ?>
    }

};
</script>

<!-- Application Scripts -->
<script src="<?= base_url('assets/js/product-opening-stock.js') ?>"></script>
<script src="<?= base_url('assets/js/product-purchase.js') ?>"></script>

<?php
echo $this->endSection();
?>