<?php
echo $this->extend('layout');
echo $this->section('content');
?>

<div class="app-title">

    <div>
        <h1>
            <i class="fa fa-th-list"></i>
            Stock Adjustment List
        </h1>
    </div>

    <button
        type="button"
        class="btn btn-primary"
        data-toggle="modal"
        data-target="#StockAdjustmentModal">

        <i class="fa fa-plus"></i>
        New Adjustment

    </button>

</div>


<!-- =========================================================
     DATA TABLE
========================================================= -->

<div class="row">

    <div class="col-md-12">

        <div class="tile">

            <div class="tile-body">

                <div class="table-responsive">

                    <table
                        class="table table-bordered table-hover table-striped"
                        id="sampleTable">

                        <thead class="thead-dark">

                            <tr>

                                <th width="50">#</th>

                                <th>Date</th>

                                <th>Adjustment No</th>

                                <th>Product</th>

                                <th>Type</th>

                                <th class="text-center">
                                    Previous Stock
                                </th>

                                <th class="text-center">
                                    Adjustment Qty
                                </th>

                                <th class="text-center">
                                    Current Stock
                                </th>

                                <th>Reason</th>

                                <th>User</th>

                                <th width="150" class="text-center">
                                    Action
                                </th>

                            </tr>

                        </thead>

                        <tbody>

                            <?php if (!empty($adjustments)): ?>

                                <?php $sl = 1; ?>

                                <?php foreach ($adjustments as $row): ?>

                                    <tr>

                                        <td>
                                            <?= $sl++; ?>
                                        </td>

                                        <td>
                                            <?= date(
                                                'd-M-Y',
                                                strtotime($row['adjustment_date'])
                                            ); ?>
                                        </td>

                                        <td>
                                            <?= esc($row['adjustment_no']); ?>
                                        </td>

                                        <td>
                                            <?= esc($row['product_name']); ?>
                                        </td>

                                        <td class="text-center">

                                            <?php if ($row['adjustment_type'] == 'STOCK_IN'): ?>

                                                <span class="badge badge-success">
                                                    Stock In
                                                </span>

                                            <?php elseif ($row['adjustment_type'] == 'STOCK_OUT'): ?>

                                                <span class="badge badge-danger">
                                                    Stock Out
                                                </span>

                                            <?php else: ?>

                                                <span class="badge badge-secondary">
                                                    <?= esc($row['adjustment_type']); ?>
                                                </span>

                                            <?php endif; ?>

                                        </td>

                                        <td class="text-center">
                                            <?= number_format(
                                                (float) $row['previous_stock'],
                                                2
                                            ); ?>
                                        </td>

                                        <td class="text-center">
                                            <?= number_format(
                                                (float) $row['adjustment_qty'],
                                                2
                                            ); ?>
                                        </td>

                                        <td class="text-center">
                                            <?= number_format(
                                                (float) $row['current_stock'],
                                                2
                                            ); ?>
                                        </td>

                                        <td>
                                            <?= esc($row['reason']); ?>
                                        </td>

                                        <td>
                                            <?= esc($row['user_name']); ?>
                                        </td>

                                        <td class="text-center">

                                       


                                            <a
                                                href="<?= site_url(
                                                    'stock-adjustment/view/' .
                                                    $row['adjustment_id']
                                                ); ?>"
                                                class="btn btn-primary btn-sm"
                                                title="View">

                                                <!-- <i class="fa fa-edit"></i> -->
                                                <i class="fa fa-eye"></i>

                                            </a>


                                            <!-- <a
                                                href="<?= site_url(
                                                    'stock-adjustment/delete/' .
                                                    $row['adjustment_id']
                                                ); ?>"
                                                class="btn btn-danger btn-sm"
                                                title="Delete"
                                                onclick="return confirm('Are you sure you want to delete this adjustment?');">

                                                <i class="fa fa-trash"></i>

                                            </a> -->

                                        </td>

                                    </tr>

                                <?php endforeach; ?>

                            <?php endif; ?>

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>

</div>


<!-- =========================================================
     STOCK ADJUSTMENT MODAL
========================================================= -->

<div
    class="modal fade"
    id="StockAdjustmentModal"
    tabindex="-1"
    role="dialog"
    aria-hidden="true">

    <div
        class="modal-dialog modal-lg modal-dialog-centered"
        role="document">

        <div class="modal-content">

            <form
                action="#"
                method="post"
                id="stockAdjustmentForm">

                <!-- HEADER -->

                <div class="modal-header bg-primary text-white">

                    <h5 class="modal-title">

                        <i class="fa fa-exchange"></i>

                        Stock Adjustment

                    </h5>

                    <button
                        type="button"
                        class="close text-white"
                        data-dismiss="modal">

                        <span>&times;</span>

                    </button>

                </div>


                <!-- BODY -->

                <div class="modal-body">

                    <!-- DATE + TYPE -->

                    <div class="form-row">

                        <div class="form-group col-md-6">

                            <label>
                                Adjustment Date
                            </label>

                            <input
                                type="date"
                                class="form-control"
                                name="adjustment_date"
                                value="<?= date('Y-m-d'); ?>"
                                required>

                        </div>


                        <div class="form-group col-md-6">

                            <label>
                                Adjustment Type
                            </label>

                            <select
                                name="adjustment_type"
                                id="adjustment_type"
                                class="form-control"
                                required>

                                <option value="">
                                    Select Type
                                </option>

                                <option value="STOCK_IN">
                                    Stock In
                                </option>

                                <option value="STOCK_OUT">
                                    Stock Out
                                </option>

                            </select>

                        </div>

                    </div>


                    <!-- PRODUCT -->

                    <div class="form-group">

                        <label>
                            Product
                        </label>

                        <select
                            class="form-control"
                            name="product_id"
                            id="product_id"
                            required>

                            <option value="">
                                Select Product
                            </option>

                            <?php if (!empty($product_show_for_sale)): ?>

                                <?php foreach (
                                    $product_show_for_sale
                                    as $row
                                ): ?>

                                    <option
                                        value="<?= $row['product_id']; ?>"
                                        data-total-stock="<?= $row['total_stock']; ?>">

                                        <?= esc($row['product_name']); ?>

                                        (Stock :
                                        <?= number_format(
                                            (float) $row['total_stock'],
                                            2
                                        ); ?>
                                        )

                                    </option>

                                <?php endforeach; ?>

                            <?php endif; ?>

                        </select>

                    </div>


                    <!-- STOCK CALCULATION -->

                    <div class="form-row">

                        <!-- Previous -->

                        <div class="form-group col-md-4">

                            <label>
                                Previous Stock
                            </label>

                            <input
                                type="number"
                                class="form-control"
                                id="previous_stock"
                                name="previous_stock"
                                value=""
                                step="0.01"
                                readonly>

                        </div>


                        <!-- Current -->

                        <div class="form-group col-md-4">

                            <label>
                                Current Stock / New Stock will
                            </label>

                            <input
                                type="number"
                                class="form-control"
                                id="current_stock"
                                name="current_stock"
                                value=""
                                min="0"
                                step="0.01"
                                required>

                        </div>


                        <!-- Adjustment -->

                        <div class="form-group col-md-4">

                            <label>
                                Adjustment Qty
                            </label>

                            <input
                                type="number"
                                class="form-control"
                                id="adjustment_qty"
                                name="adjustment_qty"
                                value="0.00"
                                step="0.01"
                                readonly>

                        </div>

                    </div>


                    <!-- REASON + REFERENCE -->

                    <div class="form-row">

                        <div class="form-group col-md-6">

                            <label>
                                Reason
                            </label>

                            <select
                                class="form-control"
                                name="reason">

                                <option value="">
                                    Select Reason
                                </option>

                                <option value="Expired">
                                    Expired
                                </option>

                                <option value="Damaged">
                                    Damaged
                                </option>

                                <option value="Lost">
                                    Lost
                                </option>

                                <option value="Physical Count">
                                    Physical Count
                                </option>

                                <option value="Stock Correction">
                                    Stock Correction
                                </option>

                                <option value="Supplier Return">
                                    Supplier Return
                                </option>

                                <option value="Other">
                                    Other
                                </option>

                            </select>

                        </div>


                        <div class="form-group col-md-6">

                            <label>
                                Reference No
                            </label>

                            <input
                                type="text"
                                class="form-control"
                                name="reference_no"
                                placeholder="Reference Number">

                        </div>

                    </div>


                    <!-- REMARKS -->

                    <div class="form-group">

                        <label>
                            Remarks
                        </label>

                        <textarea
                            class="form-control"
                            rows="3"
                            name="remarks"
                            placeholder="Remarks (Optional)"></textarea>

                    </div>

                </div>


                <!-- FOOTER -->

                <div class="modal-footer">

                    <button
                        type="button"
                        class="btn btn-secondary"
                        data-dismiss="modal">

                        Close

                    </button>


                    <button
                        type="submit"
                        class="btn btn-success"
                        id="btnSaveAdjustment">

                        <i class="fa fa-save"></i>

                        Save Adjustment

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>


<?php
echo $this->endSection();
?>


<?php
echo $this->section('scripts');
?>


<script type="text/javascript">

$(document).ready(function () {


    // =========================================================
    // DataTable
    // =========================================================

    $('#sampleTable').DataTable({

        responsive: true,

        autoWidth: false,

        pageLength: 10,

        order: [
            [0, 'asc']
        ],

        language: {

            emptyTable: "No stock adjustment found."

        }

    });


    // =========================================================
    // Calculate Adjustment
    // =========================================================

    function calculateAdjustment() {

        let previousStock =
            parseFloat($('#previous_stock').val()) || 0;

        let currentStock =
            parseFloat($('#current_stock').val()) || 0;

        let type =
            $('#adjustment_type').val();

        let adjustmentQty = 0;


        // STOCK IN
        // Current Stock must increase

        if (type === 'STOCK_IN') {

            if (currentStock >= previousStock) {

                adjustmentQty =
                    currentStock - previousStock;

            }

        }


        // STOCK OUT
        // Current Stock must decrease

        else if (type === 'STOCK_OUT') {

            if (currentStock <= previousStock) {

                adjustmentQty =
                    previousStock - currentStock;

            }

        }


        $('#adjustment_qty').val(
            adjustmentQty.toFixed(2)
        );

    }


    // =========================================================
    // PRODUCT CHANGE
    // =========================================================

    $('#product_id').on('change', function () {

        let selectedOption =
            $(this).find('option:selected');


        // IMPORTANT:
        // HTML uses data-total-stock
        // So we use attr('data-total-stock')

        let stock =
            parseFloat(
                selectedOption.attr('data-total-stock')
            ) || 0;


        console.log(
            'Selected Product Stock:',
            stock
        );


        // Previous Stock

        $('#previous_stock').val(
            stock.toFixed(2)
        );


        // Current Stock

        $('#current_stock').val(
            stock.toFixed(2)
        );


        // Adjustment Qty

        $('#adjustment_qty').val(
            '0.00'
        );


        // Recalculate

        calculateAdjustment();

    });


    // =========================================================
    // ADJUSTMENT TYPE CHANGE
    // =========================================================

    $('#adjustment_type').on('change', function () {

        calculateAdjustment();

    });


    // =========================================================
    // CURRENT STOCK INPUT
    // =========================================================

    $('#current_stock').on('input', function () {

        let previousStock =
            parseFloat(
                $('#previous_stock').val()
            ) || 0;

        let currentStock =
            parseFloat(
                $(this).val()
            ) || 0;

        let type =
            $('#adjustment_type').val();


        // Cannot be negative

        if (currentStock < 0) {

            $(this).val('0');

            currentStock = 0;

        }


        // STOCK IN

        if (type === 'STOCK_IN') {

            if (currentStock < previousStock) {

                $('#adjustment_qty').val('0.00');

                return;

            }

        }


        // STOCK OUT

        if (type === 'STOCK_OUT') {

            if (currentStock > previousStock) {

                $('#adjustment_qty').val('0.00');

                return;

            }

        }


        calculateAdjustment();

    });


    // =========================================================
    // CURRENT STOCK BLUR
    // =========================================================

    $('#current_stock').on('blur', function () {

        let previousStock =
            parseFloat(
                $('#previous_stock').val()
            ) || 0;

        let currentStock =
            parseFloat(
                $(this).val()
            ) || 0;

        let type =
            $('#adjustment_type').val();


        // Negative

        if (currentStock < 0) {

            currentStock = 0;

            $(this).val(
                '0.00'
            );

        }


        // STOCK IN

        if (
            type === 'STOCK_IN' &&
            currentStock < previousStock
        ) {

            alert(
                'Current Stock cannot be less than Previous Stock.'
            );

            currentStock = previousStock;

            $(this).val(
                previousStock.toFixed(2)
            );

        }


        // STOCK OUT

        if (
            type === 'STOCK_OUT' &&
            currentStock > previousStock
        ) {

            alert(
                'Current Stock cannot be greater than Previous Stock.'
            );

            currentStock = previousStock;

            $(this).val(
                previousStock.toFixed(2)
            );

        }


        calculateAdjustment();

    });


    // =========================================================
    // SAVE STOCK ADJUSTMENT
    // =========================================================

    $('#stockAdjustmentForm').on(
        'submit',
        function (e) {

            e.preventDefault();


            let form =
                $(this);

            let button =
                $('#btnSaveAdjustment');


            // Product validation

            if (!$('#product_id').val()) {

                alert(
                    'Please select a product.'
                );

                return;

            }


            // Type validation

            if (!$('#adjustment_type').val()) {

                alert(
                    'Please select adjustment type.'
                );

                return;

            }


            // Calculate one final time

            calculateAdjustment();


            let previousStock =
                parseFloat(
                    $('#previous_stock').val()
                ) || 0;

            let currentStock =
                parseFloat(
                    $('#current_stock').val()
                ) || 0;

            let type =
                $('#adjustment_type').val();


            // STOCK IN validation

            if (
                type === 'STOCK_IN' &&
                currentStock < previousStock
            ) {

                alert(
                    'Current Stock cannot be less than Previous Stock.'
                );

                return;

            }


            // STOCK OUT validation

            if (
                type === 'STOCK_OUT' &&
                currentStock > previousStock
            ) {

                alert(
                    'Current Stock cannot be greater than Previous Stock.'
                );

                return;

            }


            // Disable button

            button.prop(
                'disabled',
                true
            );


            // AJAX

            $.ajax({

                url:
                    "<?= site_url(
                        'stock-adjustment/create'
                    ); ?>",

                type:
                    "POST",

                data:
                    form.serialize(),

                dataType:
                    "json",


                success: function (response) {


                    if (
                        response.status ===
                        "success"
                    ) {

                        alert(
                            response.message
                        );


                        // Close modal

                        $('#StockAdjustmentModal')
                            .modal('hide');


                        // Reset form

                        form[0].reset();


                        // Reset fields

                        $('#previous_stock')
                            .val('');

                        $('#current_stock')
                            .val('');

                        $('#adjustment_qty')
                            .val('0.00');


                        // Reload page

                        setTimeout(
                            function () {

                                location.reload();

                            },
                            300
                        );

                    }

                    else {

                        alert(
                            response.message ||
                            'Failed to save adjustment.'
                        );

                        button.prop(
                            'disabled',
                            false
                        );

                    }

                },


                error: function (xhr) {

                    button.prop(
                        'disabled',
                        false
                    );


                    console.log(
                        xhr.responseText
                    );


                    alert(
                        'Something went wrong while saving adjustment.'
                    );

                }

            });

        }
    );


    // =========================================================
    // RESET MODAL
    // =========================================================

    $('#StockAdjustmentModal').on(
        'hidden.bs.modal',
        function () {


            $('#stockAdjustmentForm')[0]
                .reset();


            $('#previous_stock')
                .val('');


            $('#current_stock')
                .val('');


            $('#adjustment_qty')
                .val('0.00');


            $('#btnSaveAdjustment')
                .prop(
                    'disabled',
                    false
                );

        }
    );


});

</script>


<?php
echo $this->endSection();
?>