<?php
$this->extend('layout');
$this->section('content');
?>

<style>
/* =========================================================
   PAGE
========================================================= */

.account-statement-page {
    padding-bottom: 30px;
}

/* =========================================================
   HEADER
========================================================= */

.statement-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 15px;
    margin-bottom: 20px;
}

.statement-title {
    margin: 0;
    font-size: 22px;
    font-weight: 600;
}

.statement-title i {
    margin-right: 8px;
}

/* =========================================================
   CUSTOMER SELECT CARD
========================================================= */

.customer-select-card {
    background: #fff;
    border-radius: 8px;
    padding: 20px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.06);
    margin-bottom: 20px;
}

.customer-select-card label {
    font-weight: 600;
    margin-bottom: 7px;
}

.customer-select-card .form-control {
    height: 42px;
}

/* =========================================================
   CUSTOMER INFO
========================================================= */

.customer-info-card {
    display: none;
    background: #fff;
    border-radius: 8px;
    padding: 18px 20px;
    margin-bottom: 20px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.06);
}

.customer-info-card.show {
    display: block;
}

.customer-name {
    font-size: 20px;
    font-weight: 600;
    margin-bottom: 5px;
}

.customer-info-item {
    color: #666;
    font-size: 14px;
    margin-right: 20px;
}

.customer-info-item i {
    margin-right: 5px;
}

/* =========================================================
   SUMMARY CARDS
========================================================= */

.summary-wrapper {
    display: none;
    margin-bottom: 20px;
}

.summary-wrapper.show {
    display: block;
}

.summary-card {
    background: #fff;
    border-radius: 8px;
    padding: 18px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.06);
    height: 100%;
    position: relative;
    overflow: hidden;
}

.summary-card .summary-label {
    color: #777;
    font-size: 13px;
    margin-bottom: 5px;
}

.summary-card .summary-value {
    font-size: 24px;
    font-weight: 700;
}

.summary-card .summary-icon {
    position: absolute;
    right: 18px;
    top: 18px;
    font-size: 30px;
    opacity: 0.15;
}

/* =========================================================
   STATEMENT CARD
========================================================= */

.statement-card {
    display: none;
    background: #fff;
    border-radius: 8px;
    padding: 20px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.06);
}

.statement-card.show {
    display: block;
}

.statement-card-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 15px;
    gap: 10px;
}

.statement-card-header h5 {
    margin: 0;
    font-weight: 600;
}

/* =========================================================
   TABLE
========================================================= */

.statement-table th {
    white-space: nowrap;
    vertical-align: middle !important;
}

.statement-table td {
    vertical-align: middle !important;
}

.amount {
    text-align: right;
    font-weight: 500;
}

.due-amount {
    color: #dc3545;
}

.paid-amount {
    color: #198754;
}

.remaining-amount {
    color: #dc3545;
    font-weight: 700;
}

.balance-zero {
    color: #198754;
    font-weight: 600;
}

.table-total-row {
    background: #f8f9fa;
    font-weight: 700;
}

.table-total-row td {
    border-top: 2px solid #dee2e6 !important;
}

/* =========================================================
   EMPTY STATE
========================================================= */

.empty-statement {
    display: none;
    text-align: center;
    padding: 50px 20px;
    color: #777;
}

.empty-statement.show {
    display: block;
}

.empty-statement i {
    font-size: 50px;
    margin-bottom: 15px;
    opacity: 0.3;
}

/* =========================================================
   LOADING
========================================================= */

.statement-loading {
    display: none;
    text-align: center;
    padding: 40px;
}

.statement-loading.show {
    display: block;
}

/* =========================================================
   PRINT
========================================================= */

@media print {

    body * {
        visibility: hidden;
    }

    #printStatement,
    #printStatement * {
        visibility: visible;
    }

    #printStatement {
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
    }

    .no-print {
        display: none !important;
    }

    .statement-card {
        box-shadow: none !important;
        padding: 0 !important;
    }

    .summary-card {
        box-shadow: none !important;
        border: 1px solid #ddd;
    }

    .customer-info-card {
        box-shadow: none !important;
        border: 1px solid #ddd;
    }
}

/* =========================================================
   MOBILE
========================================================= */

@media (max-width: 768px) {

    .statement-header {
        flex-direction: column;
        align-items: flex-start;
    }

    .statement-card-header {
        flex-direction: column;
        align-items: flex-start;
    }

    .summary-card {
        margin-bottom: 15px;
    }

}
</style>


<div class="account-statement-page">

    <!-- =====================================================
         PAGE HEADER
    ====================================================== -->

    <div class="statement-header">

        <div>
            <h3 class="statement-title">
                <i class="fa fa-file-text-o"></i>
                Customer Account Statement
            </h3>

            <small class="text-muted">
                View customer due, payment and outstanding balance
            </small>
        </div>

        <div class="no-print">

            <button
                type="button"
                id="btnPrintStatement"
                class="btn btn-primary"
                style="display:none;"
            >
                <i class="fa fa-print"></i>
                Print Statement
            </button>

        </div>

    </div>


    <!-- =====================================================
         CUSTOMER SELECT
    ====================================================== -->

    <div class="customer-select-card no-print">

        <div class="row">

            <div class="col-md-8">

                <label for="customer_id">
                    Select Customer
                </label>

                <select
                    name="customer_id"
                    id="customer_id"
                    class="form-control"
                >

                    <option value="">
                        -- Select Customer --
                    </option>

                    <?php if (!empty($customer_show)): ?>

                        <?php foreach ($customer_show as $customer): ?>

                            <option
                                value="<?= esc($customer['customer_id']); ?>"
                                data-name="<?= esc($customer['customer_name']); ?>"
                                data-phone="<?= esc($customer['phone'] ?? ''); ?>"
                                data-address="<?= esc($customer['address'] ?? ''); ?>"
                            >

                                <?= esc($customer['customer_name']); ?>

                                <?php if (!empty($customer['phone'])): ?>
                                    - <?= esc($customer['phone']); ?>
                                <?php endif; ?>

                            </option>

                        <?php endforeach; ?>

                    <?php endif; ?>

                </select>

            </div>


            <div class="col-md-4 d-flex align-items-end">

                <button
                    type="button"
                    id="btnLoadStatement"
                    class="btn btn-success w-100"
                    style="height:42px;"
                >
                    <i class="fa fa-search"></i>
                    View Statement
                </button>

            </div>

        </div>

    </div>


    <!-- =====================================================
         PRINT AREA
    ====================================================== -->

    <div id="printStatement">


        <!-- =================================================
             CUSTOMER INFORMATION
        ================================================== -->

        <div
            id="customerInfoCard"
            class="customer-info-card"
        >

            <div class="customer-name" id="statementCustomerName">
                -
            </div>

            <div>

                <span
                    class="customer-info-item"
                    id="statementCustomerPhone"
                >
                    <i class="fa fa-phone"></i>
                    -
                </span>

                <span
                    class="customer-info-item"
                    id="statementCustomerAddress"
                >
                    <i class="fa fa-map-marker"></i>
                    -
                </span>

            </div>

        </div>


        <!-- =================================================
             SUMMARY
        ================================================== -->

        <div
            id="summaryWrapper"
            class="summary-wrapper"
        >

            <div class="row">

                <!-- Total Due -->

                <div class="col-md-4">

                    <div class="summary-card">

                        <div class="summary-label">
                            Total Due
                        </div>

                        <div
                            class="summary-value text-danger"
                            id="totalDue"
                        >
                            0.00
                        </div>

                        <i class="fa fa-file-text-o summary-icon"></i>

                    </div>

                </div>


                <!-- Total Paid -->

                <div class="col-md-4">

                    <div class="summary-card">

                        <div class="summary-label">
                            Total Paid
                        </div>

                        <div
                            class="summary-value text-success"
                            id="totalPaid"
                        >
                            0.00
                        </div>

                        <i class="fa fa-money summary-icon"></i>

                    </div>

                </div>


                <!-- Outstanding -->

                <div class="col-md-4">

                    <div class="summary-card">

                        <div class="summary-label">
                            Outstanding Due
                        </div>

                        <div
                            class="summary-value text-danger"
                            id="totalOutstanding"
                        >
                            0.00
                        </div>

                        <i class="fa fa-exclamation-circle summary-icon"></i>

                    </div>

                </div>

            </div>

        </div>


        <!-- =================================================
             LOADING
        ================================================== -->

        <div
            id="statementLoading"
            class="statement-loading"
        >

            <i class="fa fa-spinner fa-spin fa-2x"></i>

            <div class="mt-2">
                Loading account statement...
            </div>

        </div>


        <!-- =================================================
             STATEMENT
        ================================================== -->

        <div
            id="statementCard"
            class="statement-card"
        >

            <div class="statement-card-header">

                <h5>
                    <i class="fa fa-list"></i>
                    Account Statement
                </h5>

                <small
                    class="text-muted"
                    id="statementCount"
                >
                    0 transactions
                </small>

            </div>


            <div class="table-responsive">

                <table
                    id="statementTable"
                    class="table table-bordered table-striped statement-table"
                    style="width:100%;"
                >

                    <thead>

                        <tr>

                            <th width="50">
                                #
                            </th>

                            <th>
                                Date
                            </th>

                            <th>
                                Invoice No
                            </th>

                            <th class="text-right">
                                Due Amount
                            </th>

                            <th class="text-right">
                                Paid Amount
                            </th>

                            <th class="text-right">
                                Remaining Due
                            </th>

                        </tr>

                    </thead>

                    <tbody id="statementBody">
                    </tbody>

                    <tfoot>

                        <tr class="table-total-row">

                            <td colspan="3" class="text-right">
                                Total:
                            </td>

                            <td
                                class="text-right"
                                id="footerDue"
                            >
                                0.00
                            </td>

                            <td
                                class="text-right"
                                id="footerPaid"
                            >
                                0.00
                            </td>

                            <td
                                class="text-right"
                                id="footerRemaining"
                            >
                                0.00
                            </td>

                        </tr>

                    </tfoot>

                </table>

            </div>

        </div>


        <!-- =================================================
             EMPTY
        ================================================== -->

        <div
            id="emptyStatement"
            class="empty-statement"
        >

            <i class="fa fa-folder-open-o"></i>

            <h5>
                No Account Statement Found
            </h5>

            <p>
                This customer currently has no due transactions.
            </p>

        </div>

    </div>

</div>
<?php
echo $this->endSection();
?>

<?php
echo $this->section('scripts');
?>

<script>

$(document).ready(function () {

    let statementTable = null;


    /* =====================================================
       FORMAT MONEY
    ===================================================== */

    function money(value) {

        value = parseFloat(value || 0);

        return value.toLocaleString('en-US', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        });
    }


    /* =====================================================
       ESCAPE HTML
    ===================================================== */

    function escapeHtml(value) {

        if (value === null || value === undefined) {
            return '';
        }

        return $('<div>')
            .text(value)
            .html();
    }


    /* =====================================================
       CUSTOMER CHANGE
    ===================================================== */

    $('#customer_id').on('change', function () {

        const customerId = $(this).val();

        if (!customerId) {

            $('#customerInfoCard')
                .removeClass('show');

            $('#summaryWrapper')
                .removeClass('show');

            $('#statementCard')
                .removeClass('show');

            $('#emptyStatement')
                .removeClass('show');

            $('#btnPrintStatement')
                .hide();

            return;
        }


        const option = $(this)
            .find('option:selected');


        const name = option.data('name') || '';
        const phone = option.data('phone') || '';
        const address = option.data('address') || '';


        $('#statementCustomerName')
            .text(name);


        $('#statementCustomerPhone')
            .html(
                '<i class="fa fa-phone"></i> ' +
                escapeHtml(phone || 'N/A')
            );


        $('#statementCustomerAddress')
            .html(
                '<i class="fa fa-map-marker"></i> ' +
                escapeHtml(address || 'N/A')
            );


        $('#customerInfoCard')
            .addClass('show');

    });


    /* =====================================================
       LOAD STATEMENT
    ===================================================== */

    $('#btnLoadStatement').on('click', function () {

        const customerId = $('#customer_id').val();


        if (!customerId) {

            alert('Please select a customer.');

            $('#customer_id').focus();

            return;
        }


        loadCustomerStatement(customerId);

    });


    /* =====================================================
       LOAD CUSTOMER STATEMENT
    ===================================================== */

    function loadCustomerStatement(customerId) {

        $('#statementCard')
            .removeClass('show');

        $('#emptyStatement')
            .removeClass('show');

        $('#summaryWrapper')
            .removeClass('show');

        $('#btnPrintStatement')
            .hide();


        $('#statementLoading')
            .addClass('show');


        $.ajax({

            url: "<?= base_url('customer/account-statement-data'); ?>",

            type: "POST",

            data: {
                customer_id: customerId
            },

            dataType: "json",

            success: function (response) {

                $('#statementLoading')
                    .removeClass('show');


                if (!response || response.status !== true) {

                    $('#emptyStatement')
                        .addClass('show');

                    return;
                }


                const statements =
                    response.data || [];


                /* =========================================
                   CUSTOMER INFO
                ========================================= */

                if (response.customer) {

                    $('#statementCustomerName')
                        .text(
                            response.customer.customer_name || ''
                        );


                    $('#statementCustomerPhone')
                        .html(
                            '<i class="fa fa-phone"></i> ' +
                            escapeHtml(
                                response.customer.phone || 'N/A'
                            )
                        );


                    $('#statementCustomerAddress')
                        .html(
                            '<i class="fa fa-map-marker"></i> ' +
                            escapeHtml(
                                response.customer.address || 'N/A'
                            )
                        );

                }


                $('#customerInfoCard')
                    .addClass('show');


                /* =========================================
                   NO DATA
                ========================================= */

                if (statements.length === 0) {

                    $('#totalDue')
                        .text('0.00');

                    $('#totalPaid')
                        .text('0.00');

                    $('#totalOutstanding')
                        .text('0.00');


                    $('#footerDue')
                        .text('0.00');

                    $('#footerPaid')
                        .text('0.00');

                    $('#footerRemaining')
                        .text('0.00');


                    $('#emptyStatement')
                        .addClass('show');

                    return;
                }


                /* =========================================
                   DESTROY DATATABLE
                ========================================= */

                if ($.fn.DataTable.isDataTable('#statementTable')) {

                    $('#statementTable')
                        .DataTable()
                        .destroy();

                }


                $('#statementBody')
                    .empty();


                let totalDue = 0;
                let totalPaid = 0;
                let totalRemaining = 0;


                /* =========================================
                   BUILD TABLE
                ========================================= */

                $.each(
                    statements,
                    function (index, row) {

                        const due =
                            parseFloat(
                                row.due_amount || 0
                            );

                        const paid =
                            parseFloat(
                                row.paid_amount || 0
                            );

                        const remaining =
                            parseFloat(
                                row.remaining_due || 0
                            );


                        totalDue += due;
                        totalPaid += paid;
                        totalRemaining += remaining;


                        let date = row.sales_date || '';


                        if (date) {

                            const dateObj =
                                new Date(
                                    date.replace(' ', 'T')
                                );

                            if (!isNaN(dateObj.getTime())) {

                                date =
                                    dateObj.toLocaleDateString(
                                        'en-GB',
                                        {
                                            day: '2-digit',
                                            month: '2-digit',
                                            year: 'numeric'
                                        }
                                    );

                            }

                        }


                        const remainingClass =
                            remaining > 0
                                ? 'remaining-amount'
                                : 'balance-zero';


                        const tr = `

                            <tr>

                                <td>
                                    ${index + 1}
                                </td>

                                <td>
                                    ${escapeHtml(date)}
                                </td>

                                <td>
                                    ${escapeHtml(
                                        row.sales_invoice || '-'
                                    )}
                                </td>

                                <td class="amount due-amount">
                                    ${money(due)}
                                </td>

                                <td class="amount paid-amount">
                                    ${money(paid)}
                                </td>

                                <td class="amount ${remainingClass}">
                                    ${money(remaining)}
                                </td>

                            </tr>

                        `;


                        $('#statementBody')
                            .append(tr);

                    }
                );


                /* =========================================
                   SUMMARY
                ========================================= */

                $('#totalDue')
                    .text(money(totalDue));


                $('#totalPaid')
                    .text(money(totalPaid));


                $('#totalOutstanding')
                    .text(money(totalRemaining));


                $('#footerDue')
                    .text(money(totalDue));


                $('#footerPaid')
                    .text(money(totalPaid));


                $('#footerRemaining')
                    .text(money(totalRemaining));


                $('#summaryWrapper')
                    .addClass('show');


                $('#statementCard')
                    .addClass('show');


                $('#btnPrintStatement')
                    .show();


                $('#statementCount')
                    .text(
                        statements.length +
                        (
                            statements.length === 1
                                ? ' transaction'
                                : ' transactions'
                        )
                    );


                /* =========================================
                   DATATABLE
                ========================================= */

                statementTable =
                    $('#statementTable').DataTable({

                        pageLength: 25,

                        responsive: true,

                        ordering: true,

                        searching: true,

                        lengthChange: true,

                        order: [
                            [1, 'asc']
                        ],

                        columnDefs: [

                            {
                                targets: [3, 4, 5],
                                className: 'text-right'
                            }

                        ],

                        language: {

                            emptyTable:
                                'No account statement found',

                            search:
                                'Search:',

                            lengthMenu:
                                'Show _MENU_ entries',

                            info:
                                'Showing _START_ to _END_ of _TOTAL_ entries'

                        }

                    });

            },


            error: function (xhr) {

                $('#statementLoading')
                    .removeClass('show');


                console.error(
                    'Account Statement Error:',
                    xhr.responseText
                );


                $('#emptyStatement')
                    .addClass('show');


                alert(
                    'Unable to load customer account statement.'
                );

            }

        });

    }


    /* =====================================================
       PRINT
    ===================================================== */

    $('#btnPrintStatement').on('click', function () {

        window.print();

    });


    /* =====================================================
       ENTER KEY
    ===================================================== */

    $('#customer_id').on('keydown', function (e) {

        if (e.key === 'Enter') {

            e.preventDefault();

            $('#btnLoadStatement').trigger('click');

        }

    });

});

</script>

<?php
echo $this->endSection();
?>