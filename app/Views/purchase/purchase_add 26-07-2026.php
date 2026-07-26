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
                            <option value="<?= $row['product_id'] ?>">
                                <?= $row['product_name'] . "&nbsp;|&nbsp;" . $row['category_name'] . "&nbsp;|&nbsp;" . $row['group_name'] . "&nbsp;|&nbsp;" . $row['strength_name'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <!-- Add Button (Right Column) -->
                <div>
                    <!-- <button type="button" class="btn btn-primary btn-sm" >
                        <i class="fa fa-plus"></i> Opening Stock
                    </button> -->

                    <!-- <a href="<?= base_url('product') ?>" class="btn btn-primary btn-sm">
                         Opening Stock  &nbsp; <i class="fa fa-arrow-right"></i></a> -->

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
                            <option value="<?= $row['supplier_id'] ?>"><?= $row['supplier_name'] ?></option>
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
                <?= session('msg') ?>
                <button type="button" class="close" data-dismiss="alert"><span>×</span></button>
            </div>
            <?php endif ?>
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
                                            <?php foreach ($group_show as $group): ?>
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
                                            <?php foreach ($strength_show as $strength): ?>
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
                                            <?php foreach ($unit_show as $unit): ?>
                                            <option value="<?= esc($unit['product_unit_id']) ?>">
                                                <?= esc($unit['product_unit_name']) ?>
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
                                                <option value="<?= $tax['tax_id']; ?>"
                                                    data-percent="<?= $tax['tax_percentage']; ?>">
                                                    <?= $tax['tax_name']; ?> (
                                                    <?= $tax['tax_percentage']; ?>%)
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

<!--=============== For Opening Stock -->

<?= $this->section('css') ?>
<link rel="stylesheet" href="<?= base_url('assets/css/product.css') ?>">
<?= $this->endSection() ?>
<!--=============== For Opening Stock -->

<?php
echo $this->section('scripts');
?>
<script src="<?= base_url('assets/js/jquery.mycart.js') ?>"></script>

<!--=============== For Opening Stock -->
<script>
    window.APP_URLS = {
        categoryCreate: "<?= site_url('categories/category-create-ajax') ?>",
        initialbrand: "<?= site_url('brands/initial-product-brand') ?>",
        brandCreate: "<?= site_url('brands/brand-create-ajax') ?>",
        getCategory: "<?= site_url('categories/get-category-list') ?>",
        categoryList: "<?= site_url('get-category-list') ?>",
        groupCreate: "<?= site_url('groups/group-create-ajax') ?>",
        unitCreate: "<?= site_url('units/unit-create-ajax') ?>",
        strengthCreate: "<?= site_url('ajax/strength') ?>",
        taxCreate: "<?= site_url('tax/vatTax-create-ajax') ?>"
    };
</script>

<script src="<?= base_url('assets/js/product-opening-stock.js') ?>"></script>

<!-- ===================For Opening Stock -->


<script>
    var productsList = <?= json_encode($product_show_for_sale, JSON_PRETTY_PRINT) ?>;

    //console.log(productsList);

    //alert(productsList);

    $(document).ready(function () {

        $("body").addClass("sidenav-toggled");

        var itemsInCart = [];
        var totalPrice = 0;

        // ================= Purchase Button Enable when Supplier and product selected ================= //
        function enableButton() {
            var supplier = $("#supplier_id").val();
            var hasItems = itemsInCart.length > 0;

            $("#productPurchase").prop("disabled", !(supplier && hasItems));
        }

        // ✅ ADD HERE 👇
        $("#supplier_id").on("change", enableButton);

        // ================= Purchase Button Enable when Supplier and product selected ================= //

        /////////////////////////////////////////////////////////

        ///////////////////////////////////////////////////////////////

        // ================= DRAW TABLE ================= //
        function drawTable() {

            // totalPrice = 0;
            //let totalVat = 0;

            const tbody = $("#cartTableBody");
            tbody.empty();

            //  totalPrice = 0;
            let rows = "";

            $.each(itemsInCart, function (key, item) {

                var qtyPerPack = Number(item.quantity_per_pack) || 0;
                var Boxqty = Number(item.box_quantity) || 1;
                var UnitPrice = Number(item.cost_without_vat) || 0;
                // var cost_without_vat = Number(item.cost_without_vat) || 0;
                //var vatPercent = Number(item.tax_percentage) || 0;
                //  var discountPercent = Number(item.discount_percent) || 0;

                //var taxType = item.tax_type;

                // alert(cost_without_vat);

                // var PricePerBox = qtyPerPack * basePrice;
                // var PricePerBox = qtyPerPack * basePrice;

                // 👉 Total quantity
                // var totalQty = qtyPerPack * Boxqty;
                //var totalQty = qty;

                var Trade_Price_Per_Box = qtyPerPack * 1 * UnitPrice;

                // 👉 Base total price
                // var purchaseTotal = totalQty * UnitPrice;
                // var productDiscountAmt = 0;
                // var vatAfterDiscount = 0;
                // var rowTotal = 0;

                // productDiscountAmt = purchaseTotal * (discountPercent / 100);

                // var discountedBase = purchaseTotal - productDiscountAmt;

                // vatAfterDiscount = discountedBase * (vatPercent / 100);

                // rowTotal = discountedBase + vatAfterDiscount;


                let calc = calculateRow(item);

                //let purchaseTotal = calc.purchaseTotal;
                let vatAfterDiscount = calc.vat;
                let rowTotal = calc.subtotal;

                //totalPrice += calc.subtotal;
                //totalVat += calc.vat;

                // 👉 Grand total
                // totalPrice += rowTotal;
                // totalVat += vatAfterDiscount;

                rows += `<tr data-index="${key}">
                <td>${item.product_name}</td>
                <td>${item.total_stock}</td>

        <!---------- QtyPerBox----------------------->
        <td>
            <input
                data-id="${key}"
                class="product_quantity_change form-control form-control-sm w-100"
                type="number"
                step="any"
                value="${item.quantity_per_pack || 1}">
        </td>
<!--------------------BoxQty-------------------------------->
        <td>
            <input
                data-id="${key}"
                class="product_boxqty_change form-control form-control-sm"
                type="number"
                min="1"
                step="any"
                value="${item.box_quantity}">
        </td>


<!---------------- Unit Price------------------------------>
        <td>
            <input
                type="text"
                class="buying_price form-control form-control-sm w-100"
                value="${item.cost_without_vat}"
                min="1"
                data-id="${key}" readonly>
        </td>


<!----------------Trade Price Per Box-------------------------------------->
        <td style="min-width:70px;">
        <input
            type="text"
            class="trade_price_per_box form-control form-control-sm text-end"
            value="${parseFloat(Trade_Price_Per_Box).toFixed(2)}"
            data-id="${key}">
        </td>

        <!----------------Free Qty-------------------------------------->
        <td>
            <input style="min-width: 50px;"
            type="number"
            class="free_qty form-control form-control-sm"
            data-id="${key}"
            min="0"
            value="${item.free_qty || 0}">
         </td>


        <td>
            <input
                type="text"
                class="vat-input form-control form-control-sm"
                min="0"
                value="${item.tax_percentage}"
                data-id="${key}">
        </td>

        <td class="vatAmount"> ${vatAfterDiscount.toFixed(2)}</td>

        <td>
            <input
                type="text"
                class="sale_price form-control form-control-sm"
                value="${item.sales_price_for_customer}"
                data-id="${key}"
                disabled>
        </td>

        <td>
            <input
                type="text"
                class="discount_percent form-control form-control-sm"
                value="${item.discount_percent || 0}"
                data-id="${key}">
        </td>

    <td class="text-end rowTotal">
    ${rowTotal.toFixed(2)}
</td>

        <td>
            <button
                data-index="${key}"
                class="btn btn-sm btn-danger btn_item_delete">
                ×
            </button>
        </td>

            </tr>`;
            });

            // tbody.html(rows);

            // totalCalculation();
            // enableButton();


            tbody.html(rows);



            updateGrandTotal();
            enableButton();
        }



        //-- -- -- -- -- -- -- -- -- -- --For Subtotal Update Automatically-- -- -- -- -- -- -- -- -- -- -- -- -- --

        function calculateRow(item) {

            let qty = (Number(item.quantity_per_pack) || 0) *
                (Number(item.box_quantity) || 1);

            let unitPrice = Number(item.cost_without_vat) || 0;

            let purchaseTotal = qty * unitPrice;

            // Product Discount
            let discount = 0;

            if (item.discount_type === "fixed") {
                discount = Number(item.discount_fixed) || 0;
            } else {
                discount = purchaseTotal * (Number(item.discount_percent) || 0) / 100;
            }

            let taxable = Math.max(0, purchaseTotal - discount);

            // Product VAT
            let vat = taxable * (Number(item.tax_percentage) || 0) / 100;

            let subtotal = taxable + vat;

            return {
                purchaseTotal,
                discount,
                taxable,
                vat,
                subtotal,
                tradePrice: unitPrice * (Number(item.quantity_per_pack) || 0)
            };
        }


        // function updateGrandTotal() {

        //     totalPrice = 0;
        //     totalVat = 0;

        //     itemsInCart.forEach(function(item){

        //         let calc = calculateRow(item);

        //         totalPrice += calc.rowTotal;
        //         totalVat += calc.vatAmount;

        //     });

        //     $("#totalPrice").text(totalPrice.toFixed(2));
        //     $("#vat_amt_on_total").text(totalVat.toFixed(2));
        //     $("#netTotalPrice").html("<strong>"+totalPrice.toFixed(2)+"</strong>");
        // }

        function updateGrandTotal() {

            let totalPrice = 0;      // Without VAT & Discount
            let totalVat = 0;

            itemsInCart.forEach(function (item) {

                let c = calculateRow(item);

                totalPrice += c.purchaseTotal;
                totalVat += c.vat;

            });

            $("#totalPrice")
                .data("value", totalPrice)
                .text(totalPrice.toFixed(2));

            $("#vat_amt_on_total")
                .data("value", totalVat)
                .text(totalVat.toFixed(2));

            recalcNetTotal();
        }




        function updateRow(index, skipTradePrice = false) {

            let item = itemsInCart[index];

            let calc = calculateRow(item);

            let row = $("#cartTableBody tr[data-index='" + index + "']");

            // Update Buying Price
            row.find(".buying_price")
                .val(parseFloat(item.cost_without_vat).toFixed(2));

            // Update Trade Price (unless currently typing in it)
            if (!skipTradePrice) {
                row.find(".trade_price_per_box")
                    .val(calc.tradePrice.toFixed(2));
            }

            // // Update VAT Amount
            // row.find(".vatAmount")
            //     .text(calc.vatAmount.toFixed(2));

            // // Update Subtotal
            // row.find(".rowTotal")
            //     .text(calc.rowTotal.toFixed(2));

            row.find(".vatAmount")
                .text(calc.vat.toFixed(2));

            row.find(".rowTotal")
                .text(calc.subtotal.toFixed(2));


            // Update Grand Total
            updateGrandTotal();
        }

        //-- -- -- -- -- -- -- -- -- -- -- -- -- --For automatically subtotal update End-- -- -- -- -- -- -- -- -- --

function recalcNetTotal(){

    let totalPrice =
        parseFloat($("#totalPrice").data("value")) || 0;

    let discount =
        parseFloat($("#discount_on_total_price").data("value")) || 0;

    let vatPercent =
        parseFloat($("#vatInput").val()) || 0;

    let taxable = totalPrice - discount;

    if (taxable < 0) {
        taxable = 0;
    }

    let vat = taxable * vatPercent / 100;

    let netTotal = taxable + vat;

    $("#taxableAmount").text(taxable.toFixed(2));

    $("#vat_amt_on_total")
        .data("value", vat)
        .text(vat.toFixed(2));

    $("#netTotalPrice")
        .html("<strong>" + netTotal.toFixed(2) + "</strong>");
}

        function totalCalculation() {

            $("#totalPrice")
                .data("value", totalPrice) // ✅ store raw number
                .text(totalPrice.toFixed(2)); // display only

            updateLivePreview();
            recalcNetTotal();
        }

        // ================= EVENTS ================= //

        $(document).on("input", ".product_quantity_change", function () {

            let index = $(this).data("id");

            let qty = parseFloat($(this).val()) || 1;

            // Save new Qty Per Box
            itemsInCart[index].quantity_per_pack = qty;

            // Read current Trade Price Per Box from the row
            let tradePrice = parseFloat(
                $("#cartTableBody tr[data-index='" + index + "']")
                    .find(".trade_price_per_box")
                    .val()
            ) || 0;

            // Buying Price = Trade Price / Qty Per Box
            itemsInCart[index].cost_without_vat = tradePrice / qty;

            updateRow(index);

        });

        $(document).on("input", ".product_boxqty_change", function () {

            let index = $(this).data("id");

            itemsInCart[index].box_quantity = Number($(this).val()) || 0;

            updateRow(index);

        });

        $(document).on("input", ".trade_price_per_box", function () {

            let index = $(this).data("id");

            let tradePrice = Number($(this).val()) || 0;

            let qty = Number(itemsInCart[index].quantity_per_pack) || 1;

            itemsInCart[index].cost_without_vat = tradePrice / qty;

            updateRow(index, true);

        });



        $(document).on("input", ".buying_price", function () {
            var index = $(this).closest("tr").data("index");
            var newPrice = Number($(this).val()) || 0;

            // itemsInCart[index].cost_without_vat = newPrice;

            // drawTable();

            itemsInCart[index].cost_without_vat = newPrice;

            updateRow(index);
        });

        $(document).on("input", ".free_qty", function () {
            const index = $(this).data("id");

            itemsInCart[index].free_qty = Number($(this).val()) || 0;

            console.log(itemsInCart);

            updateRow(index); // or updateRow(index)
        });



        $(document).on("input", ".vat-input", function () {

            let index = $(this).data("id");

            itemsInCart[index].tax_percentage = Number($(this).val()) || 0;

            updateRow(index);

        });

        $(document).on("input", ".discount_percent", function () {

            let index = $(this).data("id");

            itemsInCart[index].discount_percent = Number($(this).val()) || 0;

            updateRow(index);

        });

        $(document).on("click", ".btn_item_delete", function () {
            var index = $(this).data("index");
            itemsInCart.splice(index, 1);
            drawTable();
        });

        // ================= VAT on total price MODAL ================= //

        $("#openVatModal").on("click", function () {
            var currentVat = $("#vat_amt_on_total").data("value", vatPercent).text(vatPercent.toFixed(
                2));
            //parseFloat($("#vat_amt_on_total").text()) || 0;
            $("#vatInput").val(currentVat);
        });

        // $("#saveVatBtn").on("click", function () {
        //     var vatPercent = parseFloat($("#vatInput").val()) || 0;
        //     $("#vat_amt_on_total").data("value", vatPercent).text(vatPercent.toFixed(2));
        //     recalcNetTotal();
        //     $("#vatModal").modal("hide");
        // });

        $("#saveVatBtn").on("click", function () {

            let vatPercent = parseFloat($("#vatInput").val()) || 0;

            // Update summary
            $("#vat_amt_on_total")
                .data("value", vatPercent)
                .text(vatPercent.toFixed(2));

            // Apply to every product
            itemsInCart.forEach(function (item) {
                item.tax_percentage = vatPercent;
            });

            drawTable();

            $("#vatModal").modal("hide");
        });




        $("#vatInput").on("input", function () {
            var vatPercent = parseFloat($(this).val()) || 0;
            $("#vat_amt_on_total").data("value", vatPercent).text(vatPercent.toFixed(2));
            recalcNetTotal();
        });

        // ========================= DISCOUNT on total price Modal Start =========================== //

        function updateLivePreview() {

            var total = parseFloat($("#totalPrice").data("value")) || 0;
            var discountValue = 0;

            // if ($("#fixedType").is(":checked")) {

            //     discountValue = parseFloat($("#fixedAmount").val()) || 0;

            // } 
            // 
            if ($("#fixedType").is(":checked")) {

                let fixed = parseFloat($("#fixedAmount").val()) || 0;

                // Total discount = fixed amount × number of products
                discountValue = fixed * itemsInCart.length;

            }
            else {

                var percent = parseFloat($("#percentAmount").val()) || 0;

                discountValue = (total * percent) / 100;
            }

            $("#discount_on_total_price")
                .data("value", discountValue)
                .text(discountValue.toFixed(2));

            recalcNetTotal();
        }

        // Live update when typing
        $("#fixedAmount").on("input", updateLivePreview);
        $("#percentAmount").on("input", updateLivePreview);


        // Show/Hide Fixed & Percent Input
        $("input[name='discountType']").on("change", function () {

            if ($("#fixedType").is(":checked")) {
                $("#fixedInput").removeClass("d-none");
                $("#percentInput").addClass("d-none");
            } else {
                $("#fixedInput").addClass("d-none");
                $("#percentInput").removeClass("d-none");
            }

            updateLivePreview();
        });


        // $("#discountOnTotalModal .btn-primary").on("click", function () {
        //     updateLivePreview();
        //     $("#discountOnTotalModal").modal("hide");
        // });


        $("#discountOnTotalModal .btn-primary").on("click", function () {

            if ($("#percentType").is(":checked")) {

                let discountPercent = parseFloat($("#percentAmount").val()) || 0;

                $("#discountHeader").text("Dis%");

                itemsInCart.forEach(function (item) {
                    item.discount_type = "percent";
                    item.discount_percent = discountPercent;
                    item.discount_fixed = 0;
                });

            } else {

                let fixed = parseFloat($("#fixedAmount").val()) || 0;

                $("#discountHeader").text("Disc");

                itemsInCart.forEach(function (item) {
                    item.discount_type = "fixed";
                    item.discount_fixed = fixed;      // 10 Tk for EVERY product
                    item.discount_percent = fixed;    // Display 10 in the Disc column
                });
            }

            drawTable();
            updateGrandTotal();
            $("#discountOnTotalModal").modal("hide");

        });
        // ========================= DISCOUNT on total price Modal End =========================== //


        // ================= ADD PRODUCT ================= //

        $("#item").on('change', function () {
            var product_id = $(this).val();
            if (product_id > 0) addProductToCart(product_id);
            $(this).val("0");
        });

        function addProductToCart(product_id) {

            var found = false;

            $.each(itemsInCart, function (key, item) {
                if (item.product_id == product_id) {
                    item.quantity_per_pack += 1;
                    found = true;
                    return false;
                }
            });

            if (!found) {
                $.each(productsList, function (key, product) {
                    if (product.product_id == product_id) {

                        product.quantity_per_pack = 1;
                        product.discount_percent = 0;
                        //  product.tax_percentage = 0;
                        product.box_quantity = 1;

                        // itemsInCart.push(product);
                        itemsInCart.push({
                            ...product,
                            quantity_per_pack: 1,
                            discount_percent: 0,
                            box_quantity: 1,
                            free_qty: 0      // ✅ Add this
                        });
                        return false;
                    }
                });
            }

            drawTable();
        }


        // ================= PURCHASE ================= //

        $("#productPurchase").on("click", function () {

            var supplier_id = $("#supplier_id").val();

            if (!supplier_id) {
                alert("Please Select Supplier");
                return;
            }

            if (itemsInCart.length === 0) {
                alert("Cart is empty!");
                return;
            }

            $(this).prop("disabled", true).text("Processing...");

            $.ajax({
                url: "<?= site_url('purchase/product') ?>",
                type: "POST",
                data: {
                    cart_data: JSON.stringify(itemsInCart),
                    discount_on_total_price: $("#discount_on_total_price").text(),
                    vat_amt_on_total: $("#vat_amt_on_total").text(),
                    supplier_id: supplier_id
                },
                success: function () {

                    alert("Purchase Successful");

                    // ✅ FIXED BUG
                    itemsInCart = [];

                    location.reload();
                },
                error: function () {
                    alert("Error!");
                    $("#productPurchase").prop("disabled", false).text("Purchase");
                }
            });
        });

        drawTable();
    });
</script>


<style>
    .trade_price_per_box,
    .product_quantity_change,
    .product_boxqty_change,
    .discount_percent,
    .sale_price {
        /* min-width:90px;*/
        text-align: center;
    }

    /* Your existing styles for cols */
    .col-1,
    .col-2,
    .col-3,
    .col-4,
    .col-5,
    .col-6,
    .col-7,
    .col-8,
    .col-9,
    .col-10,
    .col-11,
    .col-12,
    .col,
    .col-auto,
    .col-sm-1,
    .col-sm-2,
    .col-sm-3,
    .col-sm-4,
    .col-sm-5,
    .col-sm-6,
    .col-sm-7,
    .col-sm-8,
    .col-sm-9,
    .col-sm-10,
    .col-sm-11,
    .col-sm-12,
    .col-sm,
    .col-sm-auto,
    .col-md-1,
    .col-md-2,
    .col-md-3,
    .col-md-4,
    .col-md-5,
    .col-md-6,
    .col-md-7,
    .col-md-8,
    .col-md-9,
    .col-md-10,
    .col-md-11,
    .col-md-12,
    .col-md,
    .col-md-auto,
    .col-lg-1,
    .col-lg-2,
    .col-lg-3,
    .col-lg-4,
    .col-lg-5,
    .col-lg-6,
    .col-lg-7,
    .col-lg-8,
    .col-lg-9,
    .col-lg-10,
    .col-lg-11,
    .col-lg-12,
    .col-lg,
    .col-lg-auto,
    .col-xl-1,
    .col-xl-2,
    .col-xl-3,
    .col-xl-4,
    .col-xl-5,
    .col-xl-6,
    .col-xl-7,
    .col-xl-8,
    .col-xl-9,
    .col-xl-10,
    .col-xl-11,
    .col-xl-12,
    .col-xl,
    .col-xl-auto {
        position: relative;
        width: 100%;
        padding-right: 6px !important;
        padding-left: 7px !important;
    }

    /* Toggle switch styling */
    .switch {
        position: relative;
        display: inline-block;
        width: 50px;
        height: 20px;
        vertical-align: middle;
        margin-right: 8px;
    }

    .switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        transition: 0.4s;
        border-radius: 20px;
    }

    .slider:before {
        position: absolute;
        content: "";
        height: 14px;
        width: 14px;
        left: 3px;
        bottom: 3px;
        background-color: white;
        transition: 0.4s;
        border-radius: 50%;
    }

    input:checked+.slider {
        background-color: #17a2b8;
    }

    input:checked+.slider:before {
        transform: translateX(30px);
    }

    .slider.round {
        border-radius: 20px;
    }

    /* Hide elements with this class */
    .hide {
        display: none !important;
    }

    .blur-field {
        background-color: #f5f5f5;
        /* light gray background */
        opacity: 0.7;
        /* slightly transparent */
        color: #000;
        /* keep text fully visible */
    }

    .modal-body input {
        height: 45px;
        font-size: 16px;
    }


    /* ============================= */
    /* MOBILE RESPONSIVE IMPROVEMENT */
    /* ============================= */

    @media (max-width: 768px) {

        /* Make table font smaller */
        table {
            font-size: 12px;
        }

        /* Reduce padding inside table */
        .table td,
        .table th {
            padding: 4px !important;
        }

        /* Input fields smaller */
        .table input {
            min-width: 70px;
            font-size: 12px;
        }

        /* Make summary card sticky bottom */
        .card {
            margin-top: 15px;
        }

        /* Buttons full width on mobile */
        .btn {
            font-size: 13px;
        }

        /* Reduce select height */
        .select2-container .select2-selection--single {
            height: 34px !important;
        }

        /* Cart scroll fix */
        .table-responsive {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }
    }
</style>

<?php
echo $this->endSection();
?>