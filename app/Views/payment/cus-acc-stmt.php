<?php
echo $this->extend('layout');

echo $this->section('content');
?>

<style>

/* =========================================================
   CUSTOMER ACCOUNT STATEMENT
========================================================= */

.statement-page {
    background: #f5f7fb;
    min-height: 100vh;
    padding: 15px;
}

/* =========================================================
   HEADER
========================================================= */

.statement-header {
    background: linear-gradient(135deg, #374151, #1f2937);
    color: #fff;
    border-radius: 12px;
    padding: 18px 22px;
    margin-bottom: 18px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, .08);
}

.statement-header h4 {
    margin: 0;
    font-size: 19px;
    font-weight: 600;
}

.statement-header small {
    opacity: .75;
    font-size: 12px;
}

.statement-header-icon {
    width: 42px;
    height: 42px;
    border-radius: 10px;
    background: rgba(255,255,255,.12);
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 12px;
}

/* =========================================================
   FILTER CARD
========================================================= */

.filter-card {
    background: #fff;
    border: 1px solid #e5e7eb;
    border-radius: 12px;
    margin-bottom: 18px;
    box-shadow: 0 2px 10px rgba(0,0,0,.04);
}

.filter-card-header {
    padding: 13px 17px;
    background: #f8fafc;
    border-bottom: 1px solid #e5e7eb;
    border-radius: 12px 12px 0 0;
    font-size: 14px;
    font-weight: 700;
    color: #374151;
}

.filter-card-body {
    padding: 18px;
}

/* =========================================================
   FORM
========================================================= */

.form-label-smart {
    font-size: 12px;
    font-weight: 600;
    color: #374151;
    margin-bottom: 6px;
}

.form-control,
.custom-select,
.select2-container--default .select2-selection--single {
    min-height: 40px;
    border: 1px solid #dbe1e8;
    border-radius: 7px;
    font-size: 13px;
    box-shadow: none !important;
}

.form-control:focus {
    border-color: #9ca3af;
}

.select2-container {
    width: 100% !important;
}

.select2-container--default
.select2-selection--single {
    height: 40px;
    padding: 6px 10px;
}

.select2-container--default
.select2-selection--single
.select2-selection__rendered {
    line-height: 26px;
    font-size: 13px;
}

.select2-container--default
.select2-selection--single
.select2-selection__arrow {
    height: 38px;
}

/* =========================================================
   CUSTOMER INFORMATION
========================================================= */

.customer-card {
    background: #fff;
    border: 1px solid #e5e7eb;
    border-radius: 12px;
    margin-bottom: 18px;
    box-shadow: 0 2px 10px rgba(0,0,0,.04);
}

.customer-card-body {
    padding: 18px;
}

.customer-avatar {
    width: 48px;
    height: 48px;
    border-radius: 50%;
    background: #f3f4f6;
    color: #374151;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    margin-right: 12px;
}

.customer-name {
    font-size: 17px;
    font-weight: 700;
    color: #111827;
}

.customer-meta {
    font-size: 12px;
    color: #6b7280;
    margin-top: 3px;
}

.statement-period {
    text-align: right;
}

.statement-period-label {
    font-size: 11px;
    color: #9ca3af;
}

.statement-period-value {
    font-size: 13px;
    font-weight: 600;
    color: #374151;
}

/* =========================================================
   SUMMARY CARDS
========================================================= */

.summary-card {
    background: #fff;
    border: 1px solid #e5e7eb;
    border-radius: 11px;
    padding: 16px;
    height: 100%;
    box-shadow: 0 2px 10px rgba(0,0,0,.04);
}

.summary-label {
    font-size: 11px;
    color: #6b7280;
    font-weight: 600;
    text-transform: uppercase;
}

.summary-value {
    font-size: 20px;
    font-weight: 700;
    margin-top: 5px;
}

.summary-icon {
    width: 36px;
    height: 36px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.summary-opening .summary-icon {
    background: #f3f4f6;
    color: #374151;
}

.summary-debit .summary-icon {
    background: #fef2f2;
    color: #dc2626;
}

.summary-credit .summary-icon {
    background: #f0fdf4;
    color: #16a34a;
}

.summary-closing .summary-icon {
    background: #eff6ff;
    color: #2563eb;
}

.summary-opening .summary-value {
    color: #374151;
}

.summary-debit .summary-value {
    color: #dc2626;
}

.summary-credit .summary-value {
    color: #16a34a;
}

.summary-closing .summary-value {
    color: #2563eb;
}

/* =========================================================
   STATEMENT CARD
========================================================= */

.statement-card {
    background: #fff;
    border: 1px solid #e5e7eb;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 2px 12px rgba(0,0,0,.05);
}

.statement-card-header {
    padding: 14px 18px;
    background: #374151;
    color: #fff;
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.statement-card-title {
    font-size: 14px;
    font-weight: 600;
}

.statement-card-title i {
    margin-right: 7px;
}

/* =========================================================
   TABLE
========================================================= */

.statement-table {
    margin-bottom: 0;
    min-width: 850px;
}

.statement-table thead th {
    background: #f8fafc;
    border-top: 0;
    border-bottom: 1px solid #dfe3e8;
    color: #4b5563;
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
    padding: 12px 10px;
    white-space: nowrap;
}

.statement-table tbody td {
    font-size: 12px;
    padding: 11px 10px;
    vertical-align: middle;
    border-color: #edf0f2;
}

.statement-table tbody tr:hover {
    background: #fafafa;
}

/* =========================================================
   OPENING ROW
========================================================= */

.opening-row {
    background: #f9fafb !important;
}

.opening-row td {
    font-weight: 600;
}

/* =========================================================
   TRANSACTION TYPES
========================================================= */

.transaction-date {
    white-space: nowrap;
    color: #374151;
    font-weight: 500;
}

.reference {
    font-weight: 600;
    color: #374151;
}

.description {
    color: #6b7280;
}

.debit {
    color: #dc2626;
    font-weight: 600;
}

.credit {
    color: #16a34a;
    font-weight: 600;
}

.balance {
    color: #111827;
    font-weight: 700;
}

/* =========================================================
   BADGES
========================================================= */

.transaction-badge {
    display: inline-block;
    padding: 4px 7px;
    border-radius: 5px;
    font-size: 10px;
    font-weight: 600;
}

.badge-sale {
    background: #fef2f2;
    color: #dc2626;
}

.badge-payment {
    background: #f0fdf4;
    color: #16a34a;
}

/* =========================================================
   FOOTER
========================================================= */

.statement-table tfoot td {
    background: #f8fafc;
    border-top: 2px solid #d1d5db;
    padding: 13px 10px;
    font-size: 12px;
    font-weight: 700;
}

/* =========================================================
   PRINT
========================================================= */

.print-btn {
    border-radius: 6px;
    font-size: 12px;
}

/* =========================================================
   MOBILE
========================================================= */

@media (max-width: 768px) {

    .statement-page {
        padding: 8px;
    }

    .statement-header {
        padding: 15px;
    }

    .statement-header h4 {
        font-size: 16px;
    }

    .statement-period {
        text-align: left;
        margin-top: 12px;
    }

    .customer-card-body {
        padding: 15px;
    }

    .summary-card {
        margin-bottom: 10px;
    }

    .filter-card-body {
        padding: 15px;
    }

    .statement-card-header {
        padding: 12px 14px;
    }

}

/* =========================================================
   PRINT MEDIA
========================================================= */

@media print {

    body {
        background: #fff !important;
    }

    .statement-page {
        padding: 0 !important;
        background: #fff !important;
    }

    .filter-card,
    .print-btn {
        display: none !important;
    }

    .statement-header {
        background: #fff !important;
        color: #000 !important;
        box-shadow: none !important;
        border: 1px solid #ddd;
    }

    .statement-header small {
        color: #666 !important;
    }

    .statement-card,
    .customer-card,
    .summary-card {
        box-shadow: none !important;
    }

    .statement-card-header {
        background: #fff !important;
        color: #000 !important;
        border-bottom: 1px solid #ddd;
    }

    .table-responsive {
        overflow: visible !important;
    }

}

</style>


<div class="statement-page">

    <!-- =====================================================
         PAGE HEADER
    ====================================================== -->

    <div class="statement-header">

        <div class="d-flex align-items-center">

            <div class="statement-header-icon">

                <i class="fa fa-file-text-o fa-lg"></i>

            </div>

            <div>

                <h4>
                    Customer Account Statement
                </h4>

                <small>
                    Customer ledger and transaction history
                </small>

            </div>

        </div>

    </div>


    <!-- =====================================================
         FILTER
    ====================================================== -->

    <div class="filter-card">

        <div class="filter-card-header">

            <i class="fa fa-filter mr-1"></i>

            Statement Filter

        </div>


        <div class="filter-card-body">

            <form method="get"
                  action="<?= site_url('customer-statement') ?>">

                <div class="form-row">

                    <!-- CUSTOMER -->

                    <div class="form-group col-md-5">

                        <label class="form-label-smart">

                            Customer

                            <span class="text-danger">*</span>

                        </label>


                        <select name="customer_id"
                                id="customer_id"
                                class="form-control select2">

                            <option value="">
                                Select Customer
                            </option>

                            <!-- DUMMY CUSTOMERS -->

                            <option value="13" selected>
                                Karim Ahmed - 01711000002
                            </option>

                            <option value="15">
                                Fouzia Begum - 01711000004
                            </option>

                            <option value="20">
                                Jahid Hasan - 01711000009
                            </option>

                            <option value="21">
                                kona123 - 0191835567
                            </option>

                            <option value="23">
                                Ayan - 011764434
                            </option>

                        </select>

                    </div>


                    <!-- FROM DATE -->

                    <div class="form-group col-md-3">

                        <label class="form-label-smart">

                            From Date

                        </label>

                        <input type="date"
                               name="from_date"
                               class="form-control"
                               value="2026-08-01">

                    </div>


                    <!-- TO DATE -->

                    <div class="form-group col-md-3">

                        <label class="form-label-smart">

                            To Date

                        </label>

                        <input type="date"
                               name="to_date"
                               class="form-control"
                               value="2026-08-12">

                    </div>


                    <!-- SEARCH -->

                    <div class="form-group col-md-1 d-flex align-items-end">

                        <button type="submit"
                                class="btn btn-dark btn-block">

                            <i class="fa fa-search"></i>

                        </button>

                    </div>

                </div>

            </form>

        </div>

    </div>


    <!-- =====================================================
         CUSTOMER INFORMATION
    ====================================================== -->

    <div class="customer-card">

        <div class="customer-card-body">

            <div class="row align-items-center">

                <div class="col-md-7">

                    <div class="d-flex align-items-center">

                        <div class="customer-avatar">

                            <i class="fa fa-user"></i>

                        </div>


                        <div>

                            <div class="customer-name">

                                Karim Ahmed

                            </div>

                            <div class="customer-meta">

                                <i class="fa fa-phone mr-1"></i>
                                01711000002

                                <span class="mx-2">|</span>

                                <i class="fa fa-map-marker mr-1"></i>
                                Gazipur

                            </div>

                        </div>

                    </div>

                </div>


                <div class="col-md-5">

                    <div class="statement-period">

                        <div class="statement-period-label">

                            STATEMENT PERIOD

                        </div>

                        <div class="statement-period-value">

                            01 Aug 2026
                            -
                            12 Aug 2026

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>


    <!-- =====================================================
         SUMMARY
    ====================================================== -->

    <div class="row mb-3">

        <!-- OPENING -->

        <div class="col-md-3 col-sm-6 mb-3">

            <div class="summary-card summary-opening">

                <div class="d-flex justify-content-between">

                    <div>

                        <div class="summary-label">

                            Opening Balance

                        </div>

                        <div class="summary-value">

                            ৳ 500.00

                        </div>

                    </div>


                    <div class="summary-icon">

                        <i class="fa fa-history"></i>

                    </div>

                </div>

            </div>

        </div>


        <!-- DEBIT -->

        <div class="col-md-3 col-sm-6 mb-3">

            <div class="summary-card summary-debit">

                <div class="d-flex justify-content-between">

                    <div>

                        <div class="summary-label">

                            Total Debit

                        </div>

                        <div class="summary-value">

                            ৳ 1,500.00

                        </div>

                    </div>


                    <div class="summary-icon">

                        <i class="fa fa-arrow-down"></i>

                    </div>

                </div>

            </div>

        </div>


        <!-- CREDIT -->

        <div class="col-md-3 col-sm-6 mb-3">

            <div class="summary-card summary-credit">

                <div class="d-flex justify-content-between">

                    <div>

                        <div class="summary-label">

                            Total Credit

                        </div>

                        <div class="summary-value">

                            ৳ 1,000.00

                        </div>

                    </div>


                    <div class="summary-icon">

                        <i class="fa fa-arrow-up"></i>

                    </div>

                </div>

            </div>

        </div>


        <!-- CLOSING -->

        <div class="col-md-3 col-sm-6 mb-3">

            <div class="summary-card summary-closing">

                <div class="d-flex justify-content-between">

                    <div>

                        <div class="summary-label">

                            Closing Balance

                        </div>

                        <div class="summary-value">

                            ৳ 1,000.00

                        </div>

                    </div>


                    <div class="summary-icon">

                        <i class="fa fa-balance-scale"></i>

                    </div>

                </div>

            </div>

        </div>

    </div>


    <!-- =====================================================
         ACCOUNT STATEMENT
    ====================================================== -->

    <div class="statement-card">

        <!-- HEADER -->

        <div class="statement-card-header">

            <div class="statement-card-title">

                <i class="fa fa-list-alt"></i>

                Customer Account Statement

            </div>


            <button type="button"
                    class="btn btn-sm btn-light print-btn"
                    onclick="window.print()">

                <i class="fa fa-print mr-1"></i>

                Print

            </button>

        </div>


        <!-- TABLE -->

        <div class="table-responsive">

            <table class="table statement-table">

                <thead>

                    <tr>

                        <th width="110">
                            Date
                        </th>

                        <th width="120">
                            Reference
                        </th>

                        <th width="100">
                            Type
                        </th>

                        <th>
                            Description
                        </th>

                        <th width="130"
                            class="text-right">

                            Debit

                        </th>

                        <th width="130"
                            class="text-right">

                            Credit

                        </th>

                        <th width="150"
                            class="text-right">

                            Balance

                        </th>

                    </tr>

                </thead>


                <tbody>


                    <!-- =================================================
                         OPENING BALANCE
                    ================================================== -->

                    <tr class="opening-row">

                        <td>
                            01 Aug 2026
                        </td>

                        <td>
                            -
                        </td>

                        <td>
                            <span class="transaction-badge"
                                  style="background:#f3f4f6;color:#374151;">

                                OPENING

                            </span>
                        </td>

                        <td>

                            <strong>
                                Opening Balance
                            </strong>

                        </td>

                        <td class="text-right">
                            -
                        </td>

                        <td class="text-right">
                            -
                        </td>

                        <td class="text-right balance">

                            ৳ 500.00

                        </td>

                    </tr>


                    <!-- =================================================
                         SALE 1
                    ================================================== -->

                    <tr>

                        <td class="transaction-date">

                            02 Aug 2026

                        </td>

                        <td class="reference">

                            INV-0831

                        </td>

                        <td>

                            <span class="transaction-badge badge-sale">

                                SALE

                            </span>

                        </td>

                        <td class="description">

                            Credit Sale

                        </td>

                        <td class="text-right debit">

                            ৳ 300.00

                        </td>

                        <td class="text-right">

                            -

                        </td>

                        <td class="text-right balance">

                            ৳ 800.00

                        </td>

                    </tr>


                    <!-- =================================================
                         PAYMENT 1
                    ================================================== -->

                    <tr>

                        <td class="transaction-date">

                            03 Aug 2026

                        </td>

                        <td class="reference">

                            PAY-001

                        </td>

                        <td>

                            <span class="transaction-badge badge-payment">

                                PAYMENT

                            </span>

                        </td>

                        <td class="description">

                            Cash Payment

                        </td>

                        <td class="text-right">

                            -

                        </td>

                        <td class="text-right credit">

                            ৳ 200.00

                        </td>

                        <td class="text-right balance">

                            ৳ 600.00

                        </td>

                    </tr>


                    <!-- =================================================
                         SALE 2
                    ================================================== -->

                    <tr>

                        <td class="transaction-date">

                            05 Aug 2026

                        </td>

                        <td class="reference">

                            INV-0833

                        </td>

                        <td>

                            <span class="transaction-badge badge-sale">

                                SALE

                            </span>

                        </td>

                        <td class="description">

                            Credit Sale

                        </td>

                        <td class="text-right debit">

                            ৳ 450.00

                        </td>

                        <td class="text-right">

                            -

                        </td>

                        <td class="text-right balance">

                            ৳ 1,050.00

                        </td>

                    </tr>


                    <!-- =================================================
                         PAYMENT 2
                    ================================================== -->

                    <tr>

                        <td class="transaction-date">

                            06 Aug 2026

                        </td>

                        <td class="reference">

                            PAY-002

                        </td>

                        <td>

                            <span class="transaction-badge badge-payment">

                                PAYMENT

                            </span>

                        </td>

                        <td class="description">

                            Cash Payment

                        </td>

                        <td class="text-right">

                            -

                        </td>

                        <td class="text-right credit">

                            ৳ 300.00

                        </td>

                        <td class="text-right balance">

                            ৳ 750.00

                        </td>

                    </tr>


                    <!-- =================================================
                         SALE 3
                    ================================================== -->

                    <tr>

                        <td class="transaction-date">

                            08 Aug 2026

                        </td>

                        <td class="reference">

                            INV-0838

                        </td>

                        <td>

                            <span class="transaction-badge badge-sale">

                                SALE

                            </span>

                        </td>

                        <td class="description">

                            Credit Sale

                        </td>

                        <td class="text-right debit">

                            ৳ 750.00

                        </td>

                        <td class="text-right">

                            -

                        </td>

                        <td class="text-right balance">

                            ৳ 1,500.00

                        </td>

                    </tr>


                    <!-- =================================================
                         PAYMENT 3
                    ================================================== -->

                    <tr>

                        <td class="transaction-date">

                            10 Aug 2026

                        </td>

                        <td class="reference">

                            PAY-003

                        </td>

                        <td>

                            <span class="transaction-badge badge-payment">

                                PAYMENT

                            </span>

                        </td>

                        <td class="description">

                            Cash Payment

                        </td>

                        <td class="text-right">

                            -

                        </td>

                        <td class="text-right credit">

                            ৳ 500.00

                        </td>

                        <td class="text-right balance">

                            ৳ 1,000.00

                        </td>

                    </tr>


                </tbody>


                <!-- =====================================================
                     FOOTER
                ====================================================== -->

                <tfoot>

                    <tr>

                        <td colspan="4"
                            class="text-right">

                            Statement Total

                        </td>

                        <td class="text-right text-danger">

                            ৳ 1,500.00

                        </td>

                        <td class="text-right text-success">

                            ৳ 1,000.00

                        </td>

                        <td class="text-right text-primary">

                            ৳ 1,000.00

                        </td>

                    </tr>

                </tfoot>

            </table>

        </div>

    </div>


    <!-- =====================================================
         ACCOUNTING NOTE
    ====================================================== -->

    <div class="mt-3">

        <small class="text-muted">

            <i class="fa fa-info-circle mr-1"></i>

            Debit represents credit sales made to the customer.
            Credit represents payments received from the customer.

        </small>

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

    /* =====================================================
       SELECT2
    ===================================================== */

    if ($.fn.select2) {

        $('#customer_id').select2({

            width: '100%',

            placeholder: 'Select Customer',

            allowClear: true

        });

    }

});

</script>

<?php
echo $this->endSection();
?>