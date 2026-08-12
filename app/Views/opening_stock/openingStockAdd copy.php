<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<div class="card shadow-sm">

    <div class="card-header bg-primary text-white">
        <h5 class="mb-0">
            <i class="fa fa-cubes"></i>
            Opening Stock Entry
        </h5>
    </div>

    <div class="card-body">

        <form action="<?= site_url('opening-stock/store') ?>" method="post">

            <?= csrf_field() ?>

            <!-- ================= Product Information ================= -->

            <div class="card mb-3">

                <div class="card-header bg-light">
                    <strong>Product Information</strong>
                </div>

                <div class="card-body">

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Product <span class="text-danger">*</span></label>
                            <select name="product_id" class="form-control select2" required>
                                <option value="">Select Product</option>
                                <?php foreach ($products as $row): ?>

                                    <option value="<?= $row['product_id'] ?>">
                                        <?= esc(
                                            $row['product_name']
                                            . ' | ' . $row['category_name']
                                            . ' | ' . $row['product_brand_name']
                                            . ' | ' . $row['group_name']
                                            . ' | ' . $row['product_unit_name']
                                        ) ?>
                                    </option>

                                <?php endforeach; ?>

                            </select>
                        </div>


                        <div class="form-group col-md-3">

                            <label>Supplier</label>

                            <select name="supplier_id" class="form-control">
                                <option value="">Own Stock / No Supplier</option>

                                <?php foreach ($suppliers as $supplier): ?>
                                    <option value="<?= $supplier['supplier_id'] ?>">
                                        <?= esc($supplier['supplier_name']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>

                        </div>


                        <div class="form-group col-md-3">

                            <label>Stock Date</label>
                            <input type="date" name="stock_date" id="stock_date" class="form-control"
                                value="<?= old('stock_date', date('Y-m-d')) ?>">
                        </div>


                    </div>

                </div>

            </div>

            <!-- ================= Stock Information ================= -->

            <div class="card mb-3">

                <div class="card-header bg-light">
                    <strong>Stock Information</strong>
                </div>

                <div class="card-body">

                    <div class="form-row">

                        <div class="form-group col-md-4">

                            <label>Quantity</label>

                            <input type="number" step="0.01" id="quantity" name="quantity" class="form-control"
                                required>

                        </div>

                        <div class="form-group col-md-4">

                            <label>Bonus Quantity</label>

                            <input type="number" step="0.01" id="bonus_quantity" name="bonus_quantity" value="0"
                                class="form-control">

                        </div>

                        <div class="form-group col-md-4">
                            <label>Total Quantity</label>
                            <input type="number" step="0.01" id="total_quantity"
                                class="form-control bg-light font-weight-bold" readonly>
                        </div>

                    </div>

                </div>

            </div>

            <!-- ================= Pricing ================= -->

            <div class="card mb-3">

                <div class="card-header bg-light">
                    <strong>Pricing</strong>
                </div>

                <div class="card-body">


                    <!-- row start -->

                    <div class="form-row">
                        <div class='form-group col-md-3'>
                            <label>Tax Type</label>
                            <select class="form-control" id="tax_type" name="tax_type" required>
                                <option value="without_tax" selected>Without Tax (Exclusive)</option>
                                <!-- <option value="with_tax">With Tax (Inclusive)</option> -->
                            </select>
                        </div>

                        <div class="form-group col-md-3">

                            <label>Purchase Price (Without VAT)</label>

                            <input type="number" step="0.01" id="purchase_without_vat" name="purchase_price_without_vat"
                                class="form-control" required>

                        </div>

                        <div class="form-group col-md-3">
                            <label>VAT/TAX %</label>

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

                                    <button class="btn btn-success" id="btnAddVatTax" type="button" title="Add VAT/TAX">

                                        <i class="fa fa-plus"></i>

                                    </button>

                                </div>

                                <input type="hidden" id="tax_percentage" name="tax_percentage">

                                <input type="hidden" id="tax_amount" name="tax_amount">

                            </div>

                        </div>


                        <div class="form-group col-md-3">

                            <label>Purchase Price (With VAT)</label>

                            <input type="number" step="0.01" id="purchase_price_with_vat" name="purchase_price_with_vat"
                                readonly class="form-control">

                        </div>

                    </div>

                    <!-- row end -->





                    <!-- row start -->

                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label>Profit Margin (%)</label>
                            <input type="number" step="0.01" id="profit_margin_percent" name="profit_margin_percent"
                                class="form-control">
                        </div>

                        <div class="form-group col-md-4">

                            <label>MRP/Selling Price</label>

                            <input type="number" step="0.01" name="selling_price" id="selling_price"
                                class="form-control">

                        </div>

                        <div class="form-group col-md-4">

                            <label>Total Cost</label>

                            <input type="number" step="0.01" id="total_cost" readonly class="form-control">

                        </div>



                    </div>

                    <!-- row end -->


                </div>

            </div>

            <!-- ================= Remarks ================= -->

            <div class="card mb-3">

                <div class="card-header bg-light">
                    <strong>Remarks</strong>
                </div>

                <div class="card-body">

                    <textarea class="form-control" name="remarks" rows="3"></textarea>

                </div>

            </div>

            <button class="btn btn-success">

                <i class="fa fa-save"></i>

                Save Opening Stock

            </button>

        </form>

    </div>

</div>



<?= $this->endSection() ?>



<?= $this->section('scripts') ?>

<script>
    $(document).ready(function () {

        calculateAll();

        //===========================
        // Auto Calculate Events
        //===========================

        $('#quantity, #bonus_quantity, #purchase_without_vat, #profit_margin_percent')
            .on('input', function () {
                calculateAll();
            });

        $('#tax_type, #tax_id').on('change', function () {
            calculateAll();
        });

        $('#selling_price').on('input', function () {
            calculateMargin();
        });



        //===========================
        // Main Function
        //===========================

        function calculateAll() {

            calculateTotalQuantity();

            calculatePurchasePrice();

            calculateSellingPrice();

            calculateTotalCost();

        }

        //===========================
        // Total Quantity
        //===========================

        function calculateTotalQuantity() {

            let qty = parseFloat($('#quantity').val()) || 0;

            let bonus = parseFloat($('#bonus_quantity').val()) || 0;

            $('#total_quantity').val((qty + bonus).toFixed(2));
        }

        //===========================
        // Purchase Price With VAT
        //===========================

        function calculatePurchasePrice() {

            let purchase = parseFloat($('#purchase_without_vat').val()) || 0;

            let taxPercent = parseFloat($('#tax_id option:selected').data('percent')) || 0;

            let taxType = $('#tax_type').val();

            let taxAmount = 0;

            let purchaseWithVat = purchase;

            if (taxType === 'without_tax') {

                taxAmount = purchase * taxPercent / 100;

                purchaseWithVat = purchase + taxAmount;

            } else {

                purchaseWithVat = purchase;

                taxAmount = purchaseWithVat - (purchaseWithVat / (1 + taxPercent / 100));

            }

            $('#tax_percentage').val(taxPercent.toFixed(2));

            $('#tax_amount').val(taxAmount.toFixed(2));

            $('#purchase_price_with_vat').val(purchaseWithVat.toFixed(2));
        }

        //===========================
        // Selling Price
        //===========================

        function calculateSellingPrice() {

            let purchase = parseFloat($('#purchase_price_with_vat').val()) || 0;

            let margin = parseFloat($('#profit_margin_percent').val()) || 0;

            let selling = purchase + ((purchase * margin) / 100);

            $('#selling_price').val(selling.toFixed(2));
        }

        //===========================
        // Margin Calculation
        //===========================

        function calculateMargin() {

            let purchase = parseFloat($('#purchase_price_with_vat').val()) || 0;

            let selling = parseFloat($('#selling_price').val()) || 0;

            if (purchase <= 0) {

                $('#profit_margin_percent').val('0.00');

                return;
            }

            let margin = ((selling - purchase) / purchase) * 100;

            $('#profit_margin_percent').val(margin.toFixed(2));
        }

        //===========================
        // Total Cost
        //===========================

        function calculateTotalCost() {

            let totalQty = parseFloat($('#total_quantity').val()) || 0;

            let purchase = parseFloat($('#purchase_price_with_vat').val()) || 0;

            let totalCost = totalQty * purchase;

            $('#total_cost').val(totalCost.toFixed(2));
        }


    });
</script>

<?= $this->endSection() ?>