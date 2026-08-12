<?=$this->extend('layout')?>
<?=$this->section('content')?>




<div class="opening-stock-page">

    <div class="card shadow-sm opening-stock-card">


        <!-- =====================================================
             HEADER
        ====================================================== -->

        <div class="card-header opening-header text-white">

            <div class="d-flex align-items-center">

                <div class="mr-3">
                    <i class="fa fa-cubes fa-lg"></i>
                </div>

                <div>

                    <h5>
                        Opening Stock Entry
                    </h5>

                    <small>
                        Add initial inventory quantity, purchase cost and selling price
                    </small>

                </div>

            </div>

        </div>


        <div class="card-body">

            <form action="<?=site_url('opening-stock/store')?>" method="post">

                <?=csrf_field()?>


                <!-- =====================================================
                     PRODUCT INFORMATION
                ====================================================== -->

                <div class="smart-section">

                    <div class="section-header">

                        <div class="section-icon">
                            <i class="fa fa-cube"></i>
                        </div>

                        <div>

                            <div class="section-title">
                                Product Information
                            </div>

                            <div class="section-subtitle">
                                Select product and stock source
                            </div>

                        </div>

                    </div>


                    <div class="section-body">

                        <div class="product-info-row">


                            <!-- PRODUCT -->

                            <div class="form-group product-field">

                                <label class="form-label-smart">

                                    Product

                                    <span class="required">*</span>

                                </label>


                                <div class="product-select-wrapper">

                                    <i class="fa fa-search product-icon"></i>


                                    <select name="product_id" id="product_id" class="form-control product-select"
                                        required>

                                        <option value="">
                                            Select Product
                                        </option>


                                        <?php foreach ($products as $row): ?>

                                        <option value="<?=$row['product_id']?>">

                                            <?=esc(
    $row['product_name']
    . ' | '
    . $row['category_name']
    . ' | '
    . $row['product_brand_name']
    . ' | '
    . $row['group_name']
    . ' | '
    . $row['product_unit_name']
)?>

                                        </option>

                                        <?php endforeach; ?>

                                    </select>

                                </div>

                            </div>


                            <!-- SUPPLIER -->

                            <div class="form-group">

                                <label class="form-label-smart">
                                    Supplier
                                </label>


                                <select name="supplier_id" class="form-control">

                                    <option value="">
                                        Own Stock / No Supplier
                                    </option>


                                    <?php foreach ($suppliers as $supplier): ?>

                                    <option value="<?=$supplier['supplier_id']?>">

                                        <?=esc(
    $supplier['supplier_name']
)?>

                                    </option>

                                    <?php endforeach; ?>

                                </select>

                            </div>


                            <!-- STOCK DATE -->

                            <div class="form-group">

                                <label class="form-label-smart">
                                    Stock Date
                                </label>


                                <input type="date" name="stock_date" id="stock_date" class="form-control" value="<?=old(
    'stock_date',
    date('Y-m-d')
)?>">

                            </div>


                        </div>

                    </div>

                </div>


                <!-- =====================================================
                     STOCK INFORMATION
                ====================================================== -->

                <div class="smart-section">

                    <div class="section-header">

                        <div class="section-icon">
                            <i class="fa fa-cubes"></i>
                        </div>

                        <div>

                            <div class="section-title">
                                Stock Information
                            </div>

                            <div class="section-subtitle">
                                Enter opening quantity and bonus quantity
                            </div>

                        </div>

                    </div>


                    <div class="section-body">

                        <div class="form-row stock-info-row">


                            <!-- QUANTITY -->

                            <div class="form-group col-md-4">

                                <label class="form-label-smart">

                                    Quantity

                                    <span class="required">*</span>

                                </label>


                                <input type="number" step="0.01" min="0" id="quantity" name="quantity"
                                    class="form-control" placeholder="0.00" required>

                            </div>


                            <!-- BONUS -->

                            <div class="form-group col-md-4">

                                <label class="form-label-smart">
                                    Bonus Quantity
                                </label>


                                <input type="number" step="0.01" min="0" id="bonus_quantity" name="bonus_quantity"
                                    value="0" class="form-control" placeholder="0.00">

                            </div>


                            <!-- TOTAL -->

                            <div class="form-group col-md-4">

                                <div class="quantity-summary">

                                    <div>

                                        <div class="summary-label">
                                            TOTAL STOCK
                                        </div>

                                        <div class="summary-value" id="total_quantity_display">

                                            0.00

                                        </div>

                                        <div class="summary-unit">
                                            Quantity + Bonus
                                        </div>

                                    </div>


                                    <div>

                                        <i class="fa fa-cubes fa-2x text-success">
                                        </i>

                                    </div>

                                </div>


                                <input type="hidden" id="total_quantity" name="total_quantity">

                            </div>

                        </div>

                    </div>

                </div>


                <!-- =====================================================
                     PRICING
                ====================================================== -->

                <div class="smart-section">

                    <div class="section-header">

                        <div class="section-icon">
                            <i class="fa fa-money"></i>
                        </div>

                        <div>

                            <div class="section-title">
                                Pricing & Cost
                            </div>

                            <div class="section-subtitle">
                                Set purchase cost, VAT and selling price
                            </div>

                        </div>

                    </div>


                    <div class="section-body">


                        <!-- PURCHASE / TAX -->

                        <div class="form-row pricing-main-row">


                            <!-- TAX TYPE -->

                            <div class="form-group col-md-3">

                                <label class="form-label-smart">
                                    Tax Type
                                </label>


                                <select class="form-control" id="tax_type" name="tax_type" required>

                                    <option value="without_tax" selected>

                                        Without Tax (Exclusive)

                                    </option>

                                </select>

                            </div>


                            <!-- PURCHASE WITHOUT VAT -->

                            <div class="form-group col-md-3">

                                <label class="form-label-smart">

                                    Purchase Price

                                    <small class="text-muted">
                                        (Without VAT)
                                    </small>

                                </label>


                                <div class="input-group">

                                    <div class="input-group-prepend">

                                        <span class="input-group-text">
                                            ৳
                                        </span>

                                    </div>


                                    <input type="number" step="0.01" min="0" id="purchase_without_vat"
                                        name="purchase_price_without_vat" class="form-control" placeholder="0.00"
                                        required>

                                </div>

                            </div>


                            <!-- TAX -->

                            <div class="form-group col-md-3">

                                <label class="form-label-smart">
                                    VAT / TAX
                                </label>


                                <div class="input-group">

                                    <select id="tax_id" name="tax_id" class="form-control" required>

                                        <option value="">
                                            Select Tax
                                        </option>


                                        <?php foreach ($tax_show as $tax): ?>

                                        <option value="<?=$tax['tax_id'];?>"
                                            data-percent="<?=$tax['tax_percentage'];?>">

                                            <?=esc(
    $tax['tax_name']
);?>

                                            (
                                            <?=esc(
    $tax['tax_percentage']
);?>%
                                            )

                                        </option>

                                        <?php endforeach; ?>

                                    </select>


                                    <div class="input-group-append">

                                        <button class="btn btn-success btn-add-tax" id="btnAddVatTax" type="button"
                                            title="Add VAT/TAX">

                                            <i class="fa fa-plus"></i>

                                        </button>

                                    </div>

                                </div>


                                <input type="hidden" id="tax_percentage" name="tax_percentage">


                                <input type="hidden" id="tax_amount" name="tax_amount">

                            </div>


                            <!-- WITH VAT -->

                            <div class="form-group col-md-3">

                                <label class="form-label-smart">

                                    Purchase Price

                                    <small class="text-muted">
                                        (With VAT)
                                    </small>

                                </label>


                                <div class="input-group">

                                    <div class="input-group-prepend">

                                        <span class="input-group-text">
                                            ৳
                                        </span>

                                    </div>


                                    <input type="number" step="0.01" id="purchase_price_with_vat"
                                        name="purchase_price_with_vat" readonly class="form-control bg-light"
                                        placeholder="0.00">

                                </div>

                            </div>


                        </div>


                        <!-- =================================================
                             SELLING PRICE
                        ================================================== -->

                        <div class="row mt-2 selling-price-row">


                            <!-- PROFIT / SELLING -->

                            <div class="col-md-8">

                                <div class="profit-box">


                                    <div class="profit-box-title">

                                        <i class="fa fa-line-chart mr-1">
                                        </i>

                                        SELLING PRICE & PROFIT

                                    </div>


                                    <div class="form-row">


                                        <!-- PROFIT -->

                                        <div class="form-group col-md-6 mb-0">

                                            <label class="form-label-smart">

                                                Profit Margin (%)

                                            </label>


                                            <div class="input-group">

                                                <input type="number" step="0.01" min="0" id="profit_margin_percent"
                                                    name="profit_margin_percent" class="form-control"
                                                    placeholder="0.00">


                                                <div class="input-group-append">

                                                    <span class="input-group-text">
                                                        %
                                                    </span>

                                                </div>

                                            </div>

                                        </div>


                                        <!-- SELLING -->

                                        <div class="form-group col-md-6 mb-0">

                                            <label class="form-label-smart">

                                                MRP / Selling Price

                                            </label>


                                            <div class="input-group">

                                                <div class="input-group-prepend">

                                                    <span class="input-group-text">
                                                        ৳
                                                    </span>

                                                </div>


                                                <input type="number" step="0.01" min="0" name="selling_price"
                                                    id="selling_price" class="form-control" placeholder="0.00">

                                            </div>

                                        </div>


                                    </div>

                                </div>

                            </div>


                            <!-- TOTAL COST -->

                            <div class="col-md-4">

                                <div class="total-cost-box">

                                    <label class="form-label-smart">

                                        <i class="fa fa-calculator mr-1">
                                        </i>

                                        TOTAL COST

                                    </label>


                                    <div class="input-group">

                                        <div class="input-group-prepend">

                                            <span class="input-group-text bg-transparent border-0 pl-0">

                                                ৳

                                            </span>

                                        </div>


                                        <input type="number" step="0.01" id="total_cost" name="total_cost" readonly
                                            class="form-control">

                                    </div>

                                </div>

                            </div>


                        </div>

                    </div>

                </div>


                <!-- =====================================================
                     REMARKS
                ====================================================== -->

                <div class="smart-section remarks">


                    <div class="section-header">

                        <div class="section-icon">
                            <i class="fa fa-comment"></i>
                        </div>

                        <div>

                            <div class="section-title">
                                Remarks
                            </div>

                            <div class="section-subtitle">
                                Optional notes for this opening stock
                            </div>

                            <div class="card-body">

                                <textarea class="form-control" name="remarks" rows="2"></textarea>

                            </div>

                        </div>

                        <button class="btn btn-success">

                            <i class="fa fa-save"></i>

                            Save Opening Stock

                        </button>

            </form>

        </div>

    </div>

    <?=$this->endSection()?>




    <?=$this->section('css')?>
    <link rel="stylesheet" href="<?=base_url('assets/css/opening-stock.css')?>">
    <?=$this->endSection()?>


    <?=$this->section('scripts')?>

    <script>
    $(document).ready(function() {


        /* =========================================================
           SELECT2 PRODUCT
        ========================================================= */

        $('#product_id').select2({

            width: '100%',

            placeholder: 'Select Product',

            allowClear: true

        });


        /* =========================================================
           TOTAL QUANTITY
        ========================================================= */

        function calculateTotalQuantity() {

            let quantity =
                parseFloat($('#quantity').val()) || 0;

            let bonus =
                parseFloat($('#bonus_quantity').val()) || 0;

            let total =
                quantity + bonus;


            $('#total_quantity')
                .val(total.toFixed(2));


            $('#total_quantity_display')
                .text(total.toFixed(2));

        }


        $('#quantity, #bonus_quantity')
            .on('input', function() {

                calculateTotalQuantity();

                calculateTotalCost();

            });


        /* =========================================================
           TAX PERCENTAGE
        ========================================================= */

        $('#tax_id').on('change', function() {


            let percentage =
                parseFloat(
                    $(this)
                    .find(':selected')
                    .data('percent')
                ) || 0;


            $('#tax_percentage')
                .val(percentage);


            calculateTax();

            calculateSellingPrice();

        });


        /* =========================================================
           TAX CALCULATION
        ========================================================= */

        function calculateTax() {


            let purchase =
                parseFloat(
                    $('#purchase_without_vat').val()
                ) || 0;


            let taxPercentage =
                parseFloat(
                    $('#tax_percentage').val()
                ) || 0;


            let taxAmount =
                purchase *
                taxPercentage /
                100;


            let priceWithTax =
                purchase +
                taxAmount;


            $('#tax_amount')
                .val(taxAmount.toFixed(2));


            $('#purchase_price_with_vat')
                .val(priceWithTax.toFixed(2));


            calculateTotalCost();

        }


        /* =========================================================
           PURCHASE PRICE
        ========================================================= */

        $('#purchase_without_vat')
            .on('input', function() {

                calculateTax();

                calculateSellingPrice();

            });


        /* =========================================================
           TOTAL COST
        ========================================================= */

        function calculateTotalCost() {


            let quantity =
                parseFloat(
                    $('#quantity').val()
                ) || 0;


            let purchasePrice =
                parseFloat(
                    $('#purchase_price_with_vat').val()
                ) || 0;


            let totalCost =
                quantity *
                purchasePrice;


            $('#total_cost')
                .val(totalCost.toFixed(2));

        }


        /* =========================================================
           PROFIT MARGIN -> SELLING PRICE
        ========================================================= */

        $('#profit_margin_percent')
            .on('input', function() {

                calculateSellingPrice();

            });


        function calculateSellingPrice() {


            let purchasePrice =
                parseFloat(
                    $('#purchase_price_with_vat').val()
                ) || 0;


            let margin =
                parseFloat(
                    $('#profit_margin_percent').val()
                ) || 0;


            if (purchasePrice <= 0) {

                return;

            }


            let sellingPrice =
                purchasePrice +
                (
                    purchasePrice *
                    margin /
                    100
                );


            $('#selling_price')
                .val(sellingPrice.toFixed(2));

        }


        /* =========================================================
           SELLING PRICE -> PROFIT MARGIN
        ========================================================= */

        $('#selling_price')
            .on('input', function() {


                let purchasePrice =
                    parseFloat(
                        $('#purchase_price_with_vat').val()
                    ) || 0;


                let sellingPrice =
                    parseFloat(
                        $(this).val()
                    ) || 0;


                if (
                    purchasePrice > 0 &&
                    sellingPrice >= purchasePrice
                ) {


                    let margin =
                        (
                            (
                                sellingPrice -
                                purchasePrice
                            ) /
                            purchasePrice
                        ) *
                        100;


                    $('#profit_margin_percent')
                        .val(margin.toFixed(2));

                }

            });


        /* =========================================================
           INITIAL CALCULATION
        ========================================================= */

        calculateTotalQuantity();

        calculateTax();

        calculateTotalCost();





// For sweetalert messge 

        <?php if (session()->getFlashdata('success')): ?>

        Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'success',
            title: <?=json_encode(session()->getFlashdata('success'))?>,
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true
        });

        <?php endif; ?>


        <?php if (session()->getFlashdata('error')): ?>

        Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'error',
            title: <?=json_encode(session()->getFlashdata('error'))?>,
            showConfirmButton: false,
            timer: 4000,
            timerProgressBar: true
        });

        <?php endif; ?>


    });
    </script>

    <?=$this->endSection()?>