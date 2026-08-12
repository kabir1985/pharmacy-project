<?php
$this->extend('layout');
$this->section('content');
?>

<div class="app-title">
    <div>
        <h3>
            <i class="fa fa-cubes"></i>
            Welcome To CARE POINT Pharmacy and Dept. Store
        </h3>
    </div>

    <ul class="app-breadcrumb breadcrumb">
        <li class="breadcrumb-item">
            <i class="fa fa-home fa-lg"></i>
        </li>
        <li class="breadcrumb-item">
            <a href="#">Dashboard</a>
        </li>
    </ul>
</div>


<!-- =========================================================
     TODAY SUMMARY
========================================================= -->

<div class="row dashboard-summary">

    <!-- Today Sale -->
    <div class="col-md-6 col-lg-4">
        <div class="summary-card sale-summary">

            <div class="summary-icon">
                <i class="fa fa-shopping-cart"></i>
            </div>

            <div class="summary-content">
                <h4>Today Sale Amt</h4>

                <h3>
                    <?= number_format($today_sales, 2) ?>
                    <small>Tk.</small>
                </h3>
            </div>

        </div>
    </div>


    <!-- Today Purchase -->
    <div class="col-md-6 col-lg-4">
        <div class="summary-card purchase-summary">

            <div class="summary-icon">
                <i class="fa fa-shopping-basket"></i>
            </div>

            <div class="summary-content">
                <h4>Today Purchase</h4>

                <h3>
                    <?= number_format($today_purchase, 2) ?>
                    <small>Tk.</small>
                </h3>
            </div>

        </div>
    </div>


    <!-- Today Return -->
    <div class="col-md-6 col-lg-4">
        <div class="summary-card return-summary">

            <div class="summary-icon">
                <i class="fa fa-undo"></i>
            </div>

            <div class="summary-content">
                <h4>Today Return</h4>

                <h3>
                    <?= number_format($today_return, 2) ?>
                    <small>Tk.</small>
                </h3>
            </div>

        </div>
    </div>


    <!-- Today Credit Sale -->
    <!-- <div class="col-md-6 col-lg-3">
        <div class="summary-card credit-summary">

            <div class="summary-icon">
                <i class="fa fa-credit-card"></i>
            </div>

            <div class="summary-content">
                <h4>Today Credit Sale</h4>

                <h3>
                    <?//= number_format($today_credit_sale, 2) ?>
                    <small>Tk.</small>
                </h3>
            </div>

        </div>
    </div> -->

</div>


<!-- =========================================================
     QUICK ACTIONS
========================================================= -->

<div class="row quick-actions">

    <!-- Quick Sale -->
    <div class="col-md-4">

        <a href="<?= base_url('pos') ?>"
           class="quick-action-card sale-card">

            <div class="quick-action-icon">
                <i class="fa fa-shopping-cart"></i>
            </div>

            <div class="quick-action-content">
                <h4>Quick Sale</h4>
                <p>Create a new sales invoice quickly</p>
            </div>

            <div class="quick-action-arrow">
                <i class="fa fa-arrow-right"></i>
            </div>

        </a>

    </div>


    <!-- Quick Purchase -->
    <div class="col-md-4">

        <a href="<?= base_url('purchase') ?>"
           class="quick-action-card purchase-card">

            <div class="quick-action-icon">
                <i class="fa fa-shopping-basket"></i>
            </div>

            <div class="quick-action-content">
                <h4>Quick Purchase</h4>
                <p>Enter a new purchase quickly</p>
            </div>

            <div class="quick-action-arrow">
                <i class="fa fa-arrow-right"></i>
            </div>

        </a>

    </div>


    <!-- Quick Stock -->
    <div class="col-md-4">

        <a href="<?= base_url('opening-stock') ?>"
           class="quick-action-card stock-card">

            <div class="quick-action-icon">
                <i class="fa fa-cubes"></i>
            </div>

            <div class="quick-action-content">
                <h4>Quick Stock</h4>
                <p>Add or manage opening stock</p>
            </div>

            <div class="quick-action-arrow">
                <i class="fa fa-arrow-right"></i>
            </div>

        </a>

    </div>

</div>


<!-- =========================================================
     CHART + SUPPORT
========================================================= -->

<div class="row">

    <!-- Monthly Sales -->
    <div class="col-md-6">

        <div class="tile dashboard-tile">

            <h3 class="tile-title">
                <i class="fa fa-line-chart"></i>
                Monthly Sales
            </h3>

            <div class="embed-responsive embed-responsive-16by9">

                <canvas
                    class="embed-responsive-item"
                    id="lineChartDemo">
                </canvas>

            </div>

        </div>

    </div>


    <!-- Support -->
    <div class="col-md-6">

        <div class="tile dashboard-tile">

            <h3 class="tile-title">
                <i class="fa fa-headphones"></i>
                Support Team
            </h3>

            <div class="support-box">

                <div class="support-icon">
                    <i class="fa fa-phone"></i>
                </div>

                <h2>01913-69-11-85</h2>

                <p>Support Hotline</p>

                <a href="tel:01913691185"
                   class="support-call-btn">
                    <i class="fa fa-phone"></i>
                    Call Support
                </a>

            </div>

        </div>

    </div>

</div>


<?= $this->endSection(); ?>


<!-- =========================================================
     CSS
========================================================= -->

<?= $this->section("css"); ?>

<link rel="stylesheet" href="<?= base_url('assets/css/dashboard.css') ?>">

<?= $this->endSection(); ?>


<!-- =========================================================
     SCRIPTS
========================================================= -->

<?= $this->section("scripts"); ?>

<script src="<?= base_url('assets/js/plugins/chart.js') ?>"></script>

<script>

var data = {

    labels: <?= $sales_labels ?? '[]' ?>,

    datasets: [{

        label: "Monthly Sales",

        fillColor: "rgba(151,187,205,0.2)",

        strokeColor: "rgba(151,187,205,1)",

        pointColor: "rgba(151,187,205,1)",

        pointStrokeColor: "#fff",

        pointHighlightFill: "#fff",

        pointHighlightStroke:
            "rgba(151,187,205,1)",

        data: <?= $sales_amounts ?? '[]' ?>

    }]

};


var ctxl = $("#lineChartDemo")
    .get(0)
    .getContext("2d");

var lineChart = new Chart(ctxl).Line(data);

</script>

<?= $this->endSection(); ?>