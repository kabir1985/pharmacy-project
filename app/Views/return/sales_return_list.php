<?= $this->extend('layout') ?>

<?= $this->section('content') ?>

<!-- =========================================================
     PAGE TITLE
========================================================= -->

<div class="app-title">

    <div>
        <h1>
            <i class="fa fa-th-list"></i>
            &nbsp;&nbsp; Sales List for Sales-Return
        </h1>
    </div>

</div>


<!-- =========================================================
     SALES RETURN LIST
========================================================= -->

<div class="row">

    <div class="col-md-12">

        <div class="tile collapseable show animate__animated animate__fadeInUp">

            <div class="tile-body">

                <div class="table-responsive">

                    <table
                        class="table table-hover table-bordered"
                        id="sampleTable"
                    >

                        <thead>

                            <tr>

                                <th>
                                    Sales Date
                                </th>

                                <th>
                                    Invoice
                                </th>

                                <th>
                                    Customer
                                </th>

                                <th class="text-end">
                                    Total Sale
                                </th>

                                <th class="text-end">
                                    Tax
                                </th>

                                <th class="text-end">
                                    Discount
                                </th>

                                <th class="text-end">
                                    Other Cost
                                </th>

                                <th class="text-end">
                                    Paid
                                </th>

                                <th class="text-end">
                                    Due
                                </th>

                                <th class="text-center">
                                    Status
                                </th>

                                <th class="text-center">
                                    Return
                                </th>

                            </tr>

                        </thead>


                        <tbody>

                            <?php if (!empty($saleReturnList)): ?>

                                <?php foreach ($saleReturnList as $row): ?>

                                    <tr>

                                        <!-- =========================
                                             SALES DATE
                                        ========================== -->

                                        <td>
                                            <?= esc($row['sales_date']) ?>
                                        </td>


                                        <!-- =========================
                                             INVOICE
                                        ========================== -->

                                        <td>

                                            <strong>
                                                <?= esc($row['sales_invoice']) ?>
                                            </strong>

                                        </td>


                                        <!-- =========================
                                             CUSTOMER
                                        ========================== -->

                                        <td>

                                            <?= esc(
                                                $row['customer_name']
                                                ?: 'Walk-In Customer'
                                            ) ?>

                                        </td>


                                        <!-- =========================
                                             TOTAL SALE
                                        ========================== -->

                                        <td class="text-end">

                                            <?= number_format(
                                                (float) ($row['total_sale'] ?? 0),
                                                2
                                            ) ?>

                                        </td>


                                        <!-- =========================
                                             VAT
                                        ========================== -->

                                        <td class="text-end">

                                            <?= number_format(
                                                (float) ($row['product_vat'] ?? 0),
                                                2
                                            ) ?>

                                        </td>


                                        <!-- =========================
                                             DISCOUNT
                                        ========================== -->

                                        <td class="text-end">

                                            <?= number_format(
                                                (float) ($row['product_discount'] ?? 0),
                                                2
                                            ) ?>

                                        </td>


                                        <!-- =========================
                                             OTHER COST
                                        ========================== -->

                                        <td class="text-end">

                                            <?= number_format(
                                                (float) ($row['other_charge_on_all'] ?? 0),
                                                2
                                            ) ?>

                                        </td>


                                        <!-- =========================
                                             PAID
                                        ========================== -->

                                        <td class="text-end text-success">

                                            <?= number_format(
                                                (float) ($row['total_paid'] ?? 0),
                                                2
                                            ) ?>

                                        </td>


                                        <!-- =========================
                                             DUE
                                        ========================== -->

                                        <td class="text-end text-danger">

                                            <?= number_format(
                                                (float) ($row['customer_due'] ?? 0),
                                                2
                                            ) ?>

                                        </td>


                                        <!-- =========================
                                             PAYMENT STATUS
                                        ========================== -->

                                        <td class="text-center">

                                            <?php if (
                                                ($row['payment_status'] ?? '') ===
                                                'Fully Paid'
                                            ): ?>

                                                <span class="badge bg-success text-white">
                                                    Fully Paid
                                                </span>

                                            <?php else: ?>

                                                <span class="badge bg-danger text-white">
                                                    Partially Paid
                                                </span>

                                            <?php endif; ?>

                                        </td>


                                        <!-- =========================
                                             RETURN BUTTON
                                        ========================== -->

                                        <td class="text-center">

                                            <button
                                                type="button"
                                                class="btn btn-primary btn-sm btn-return"
                                                data-sales-id="<?= esc($row['sales_id']) ?>"
                                                data-sales-invoice="<?= esc($row['sales_invoice']) ?>"
                                            >

                                                <i class="fa fa-undo"></i>

                                                Return

                                            </button>

                                        </td>

                                    </tr>

                                <?php endforeach; ?>

                            <?php else: ?>

                                <tr>

                                    <td
                                        colspan="11"
                                        class="text-center text-muted"
                                    >

                                        No sales available for return.

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


<!-- =========================================================
     SALES RETURN MODAL
========================================================= -->

<div
    class="modal fade"
    id="returnModal"
    tabindex="-1"
    aria-hidden="true"
>

    <div class="modal-dialog modal-xl">

        <form
            id="returnForm"
            class="modal-content"
        >

            <!-- =================================================
                 MODAL HEADER
            ================================================== -->

            <div class="modal-header">

                <div
                    class="d-flex justify-content-between align-items-center w-100"
                >

                    <h5 class="modal-title mb-0">

                        <i class="fa fa-undo"></i>

                        Sales Return

                    </h5>


                    <div class="fw-bold text-primary">

                        Sales Invoice:

                        <span id="invoice_text"></span>

                    </div>


                    <!-- SALES ID -->

                    <input
                        type="hidden"
                        id="sales_id"
                        name="sales_id"
                    >

                </div>


                <button
                    type="button"
                    class="btn btn-secondary text-white ms-2"
                    data-dismiss="modal"
                >

                    X

                </button>

            </div>


            <!-- =================================================
                 MODAL BODY
            ================================================== -->

            <div class="modal-body">


                <!-- =========================
                     RETURN REASON
                ========================== -->

                <div class="mb-3">

                    <label
                        for="reason"
                        class="form-label"
                    >

                        Reason

                    </label>


                    <textarea
                        name="reason"
                        id="reason"
                        class="form-control"
                        rows="2"
                        placeholder="Enter return reason..."
                        required
                    ></textarea>

                </div>


                <!-- =========================
                     PRODUCTS TABLE
                ========================== -->

                <div class="table-responsive">

                    <table
                        class="table table-bordered table-hover align-middle"
                        id="returnProductsTable"
                    >

                        <thead>

                            <tr>

                                <th>
                                    Product
                                </th>

                                <th class="text-end">
                                    Sold
                                </th>

                                <th class="text-end">
                                    Returned
                                </th>

                                <th class="text-end">
                                    Available
                                </th>

                                <th class="text-end">
                                    Unit Price
                                </th>

                                <th class="text-end">
                                    Buy Price
                                </th>

                                <th class="text-end">
                                    Sale Price
                                </th>

                                <th class="text-center">
                                    Return Status
                                </th>

                                <th
                                    class="text-center"
                                    style="width:130px;"
                                >
                                    Return Qty
                                </th>

                            </tr>

                        </thead>


                        <tbody>

                            <tr>

                                <td
                                    colspan="9"
                                    class="text-center text-muted"
                                >

                                    Select a sale to load products.

                                </td>

                            </tr>

                        </tbody>

                    </table>

                </div>

            </div>


            <!-- =================================================
                 MODAL FOOTER
            ================================================== -->

            <div class="modal-footer">

                <button
                    type="submit"
                    class="btn btn-primary"
                    id="processReturnBtn"
                >

                    <i class="fa fa-check"></i>

                    Process Return

                </button>


                <button
                    type="button"
                    class="btn btn-secondary text-white"
                    data-dismiss="modal"
                >

                    Cancel

                </button>

            </div>

        </form>

    </div>

</div>


<?= $this->endSection() ?>


<!-- =========================================================
     SCRIPTS
========================================================= -->

<?= $this->section('scripts') ?>

<script>

$(document).ready(function () {


    /* ========================================================
       DATATABLE
    ======================================================== */

    $('#sampleTable').DataTable({

        responsive: true,

        pageLength: 15,

        order: [
            [0, 'desc']
        ]

    });


    /* ========================================================
       OPEN RETURN MODAL
    ======================================================== */

    $('body').on('click', '.btn-return', function () {

        const sales_id =
            $(this).data('sales-id');

        const sales_invoice =
            $(this).data('sales-invoice');


        console.log('Sales ID:', sales_id);

        console.log('Sales Invoice:', sales_invoice);


        /* ==========================================
           SET SALES ID
        ========================================== */

        $('#sales_id').val(sales_id);


        /* ==========================================
           SHOW INVOICE
        ========================================== */

        $('#invoice_text').text(
            sales_invoice
        );


        /* ==========================================
           CLEAR OLD REASON
        ========================================== */

        $('#reason').val('');


        /* ==========================================
           CLEAR OLD PRODUCTS
        ========================================== */

        $('#returnProductsTable tbody').html(`

            <tr>

                <td
                    colspan="9"
                    class="text-center"
                >

                    <i class="fa fa-spinner fa-spin"></i>

                    Loading products...

                </td>

            </tr>

        `);


        /* ==========================================
           SHOW MODAL
        ========================================== */

        $('#returnModal').modal('show');


        /* ==========================================
           LOAD SALE PRODUCTS
        ========================================== */

        $.ajax({

            url: '<?= base_url("return/products") ?>',

            method: 'POST',

            data: {

                sales_id: sales_id

            },

            dataType: 'json',


            success: function (products) {

                console.log(
                    'Return Products:',
                    products
                );


                let html = '';


                /* =====================================
                   NO PRODUCTS
                ===================================== */

                if (
                    !products ||
                    products.length === 0
                ) {

                    html = `

                        <tr>

                            <td
                                colspan="9"
                                class="text-center text-muted"
                            >

                                No products available for return.

                            </td>

                        </tr>

                    `;

                }

                else {


                    /* =================================
                       PRODUCTS
                    ================================= */

                    products.forEach(function (p) {


                        const soldQty =
                            parseFloat(
                                p.sold_qty
                            ) || 0;


                        const returnQty =
                            parseFloat(
                                p.return_qty
                            ) || 0;


                        const remainingQty =
                            parseFloat(
                                p.remaining_qty
                            ) || 0;


                        const unitPrice =
                            parseFloat(
                                p.unit_price
                            ) || 0;


                        const buyPrice =
                            parseFloat(
                                p.total_buy_price
                            ) || 0;


                        const salePrice =
                            parseFloat(
                                p.total_sale_price
                            ) || 0;


                        /* =================================
                           RETURN STATUS
                        ================================= */

                        let statusClass =
                            'bg-secondary';


                        if (
                            p.return_status ===
                            'ACTIVE'
                        ) {

                            statusClass =
                                'bg-success';

                        }
                        else if (
                            p.return_status ===
                            'PARTIAL'
                        ) {

                            statusClass =
                                'bg-warning text-dark';

                        }
                        else if (
                            p.return_status ===
                            'FULL'
                        ) {

                            statusClass =
                                'bg-danger';

                        }


                        /* =================================
                           RETURN INPUT
                        ================================= */

                        let returnInput = '';


                        if (
                            remainingQty > 0
                        ) {

                            returnInput = `

                                <input
                                    type="number"
                                    name="return_qty[${p.sales_details_id}]"
                                    class="form-control form-control-sm text-center return-qty"
                                    min="0"
                                    max="${remainingQty}"
                                    value="0"
                                    step="1"
                                    data-sales-details-id="${p.sales_details_id}"
                                    data-product-id="${p.product_id}"
                                >

                            `;

                        }
                        else {

                            returnInput = `

                                <input
                                    type="number"
                                    class="form-control form-control-sm text-center"
                                    value="0"
                                    readonly
                                    disabled
                                >

                            `;

                        }


                        /* =================================
                           ROW
                        ================================= */

                        html += `

                            <tr>

                                <!-- PRODUCT -->

                                <td>

                                    <strong>
                                        ${p.product_name}
                                    </strong>


                                    <input
                                        type="hidden"
                                        name="sales_details_id[]"
                                        value="${p.sales_details_id}"
                                    >


                                    <input
                                        type="hidden"
                                        name="product_id[]"
                                        value="${p.product_id}"
                                    >

                                </td>


                                <!-- SOLD -->

                                <td class="text-end">

                                    ${soldQty.toFixed(2)}

                                </td>


                                <!-- RETURNED -->

                                <td class="text-end text-danger">

                                    ${returnQty.toFixed(2)}

                                </td>


                                <!-- AVAILABLE -->

                                <td class="text-end text-success">

                                    ${remainingQty.toFixed(2)}

                                </td>


                                <!-- UNIT PRICE -->

                                <td class="text-end">

                                    ${unitPrice.toFixed(2)}

                                </td>


                                <!-- BUY PRICE -->

                                <td class="text-end">

                                    ${buyPrice.toFixed(2)}

                                </td>


                                <!-- SALE PRICE -->

                                <td class="text-end">

                                    ${salePrice.toFixed(2)}

                                </td>


                                <!-- RETURN STATUS -->

                                <td class="text-center">

                                    <span
                                        class="badge ${statusClass}"
                                    >

                                        ${p.return_status || 'ACTIVE'}

                                    </span>

                                </td>


                                <!-- RETURN QTY -->

                                <td>

                                    ${returnInput}

                                </td>

                            </tr>

                        `;

                    });

                }


                /* =========================================
                   INSERT PRODUCTS
                ========================================== */

                $('#returnProductsTable tbody')
                    .html(html);

            },


            /* =========================================
               AJAX ERROR
            ========================================== */

            error: function (xhr) {

                console.error(
                    xhr.responseText
                );


                $('#returnProductsTable tbody')
                    .html(`

                        <tr>

                            <td
                                colspan="9"
                                class="text-center text-danger"
                            >

                                Unable to load sale products.

                            </td>

                        </tr>

                    `);


                alert(
                    'Error fetching products. Please try again.'
                );

            }

        });

    });


    /* ========================================================
       VALIDATE RETURN QUANTITY
    ======================================================== */

    $(document).on(
        'input',
        '.return-qty',
        function () {

            const max =
                parseFloat(
                    $(this).attr('max')
                ) || 0;


            let value =
                parseFloat(
                    $(this).val()
                ) || 0;


            if (value < 0) {

                value = 0;

            }


            if (value > max) {

                value = max;

                $(this).val(
                    max
                );


                alert(
                    'Return quantity cannot exceed available quantity.'
                );

            }

        }
    );


    /* ========================================================
       PROCESS RETURN
    ======================================================== */

    $('#returnForm').on(
        'submit',
        function (e) {

            e.preventDefault();


            const form =
                $(this);


            /* =========================================
               SALES ID VALIDATION
            ========================================== */

            const sales_id =
                $('#sales_id').val();


            if (!sales_id) {

                alert(
                    'Sales ID is missing.'
                );

                return;

            }


            /* =========================================
               REASON VALIDATION
            ========================================== */

            const reason =
                $.trim(
                    $('#reason').val()
                );


            if (!reason) {

                alert(
                    'Please enter return reason.'
                );

                $('#reason').focus();

                return;

            }


            /* =========================================
               RETURN QUANTITY VALIDATION
            ========================================== */

            let hasReturnQty =
                false;


            let invalidQty =
                false;


            $('.return-qty').each(
                function () {

                    const qty =
                        parseFloat(
                            $(this).val()
                        ) || 0;


                    const max =
                        parseFloat(
                            $(this).attr('max')
                        ) || 0;


                    if (qty > 0) {

                        hasReturnQty =
                            true;

                    }


                    if (
                        qty < 0 ||
                        qty > max
                    ) {

                        invalidQty =
                            true;

                    }

                }
            );


            if (!hasReturnQty) {

                alert(
                    'Please enter at least one Return Quantity greater than 0.'
                );

                return;

            }


            if (invalidQty) {

                alert(
                    'One or more return quantities are invalid.'
                );

                return;

            }


            /* =========================================
               CONFIRM
            ========================================== */

            if (
                !confirm(
                    'Are you sure you want to process this sale return?'
                )
            ) {

                return;

            }


            /* =========================================
               SUBMIT
            ========================================== */

            $.ajax({

                url:
                    '<?= base_url("return/process") ?>',

                type:
                    'POST',

                data:
                    form.serialize(),

                dataType:
                    'json',


                beforeSend:
                    function () {

                        $('#processReturnBtn')
                            .prop(
                                'disabled',
                                true
                            )
                            .html(`

                                <i class="fa fa-spinner fa-spin"></i>

                                Processing...

                            `);

                    },


                success:
                    function (res) {

                        console.log(
                            'Return Response:',
                            res
                        );


                        if (
                            res.status ===
                            'success'
                        ) {

                            alert(
                                res.message ||
                                'Sale return processed successfully.'
                            );


                            $('#returnModal')
                                .modal('hide');


                            form[0].reset();


                            $('#returnProductsTable tbody')
                                .empty();


                            /*
                             * Refresh sales return list
                             */

                            setTimeout(
                                function () {

                                    location.reload();

                                },
                                500
                            );

                        }

                        else {

                            alert(
                                res.message ||
                                'Return processing failed.'
                            );

                        }

                    },


                error:
                    function (xhr) {

                        console.error(
                            'Return Error:',
                            xhr.responseText
                        );


                        let message =
                            'Server Error!';


                        /*
                         * Try to read JSON error
                         */

                        try {

                            const response =
                                JSON.parse(
                                    xhr.responseText
                                );


                            if (
                                response.message
                            ) {

                                message =
                                    response.message;

                            }

                        }
                        catch (e) {

                            console.error(
                                e
                            );

                        }


                        alert(
                            message
                        );

                    },


                complete:
                    function () {

                        $('#processReturnBtn')
                            .prop(
                                'disabled',
                                false
                            )
                            .html(`

                                <i class="fa fa-check"></i>

                                Process Return

                            `);

                    }

            });

        }

    );


});

</script>


<?= $this->endSection() ?>