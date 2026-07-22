<?php
$this->extend('layout/layout');
$this->section('content');
?>

<style>
h4 {
    font-size: 14px;
}
</style>
<?php 
//$allowedMenus = session()->get('allowedMenus');
//echo $this->include('partial/sidebar', ['allowedMenus' => $allowedMenus]); ?>
<?php //echo $this->include('partial/sidebar'); ?>

<div class="app-title">
    <div>
        <h3>
            <i class="fa fa-cubes"></i>
            Welcome <?= esc(session('user_name') ?? session('login_id')) ?> To POS Pharmacy Software
        </h3>
        <!-- <p>Welcome to View Dashboard </p>
        <p>
            <?//= $userId = session()->get('user_id');?>
        </p> -->
    </div>
    <ul class="app-breadcrumb breadcrumb">
        <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
    </ul>
</div>
<div class="row">
    <div class="col-md-6 col-lg-3">
        <div class="widget-small primary coloured-icon"><i class="icon fa fa-user-o" aria-hidden="true fa-3x"></i>
            <div class="info">
                <h4>Today Sale Amt</h4>
                <p><b> <?= number_format($today_sales, 2) ?>&nbsp;Tk.
                    </b></p>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-lg-3">
        <div class="widget-small info coloured-icon"><i class="icon fa fa-shopping-basket" aria-hidden="true fa-3x"></i>
            <div class="info">
                <h4>Today Purchase</h4>
                <p><b><?= number_format($today_purchase, 2) ?>&nbsp;Tk.</b></p>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-lg-3">
        <div class="widget-small warning coloured-icon"><i class="icon fa fa-usd" aria-hidden="true fa-3x"></i>
            <div class="info">
                <h4>Today Return</h4>
                <p><b>10</b></p>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-lg-3">
        <div class="widget-small danger coloured-icon"><i class="icon fa fa-credit-card" aria-hidden="true fa-3x"></i>
            <div class="info">
                <h4>Today Credit Sale</h4>
                <p><b>500</b></p>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="tile">
            <h3 class="tile-title">Monthly Sales</h3>
            <div class="embed-responsive embed-responsive-16by9">
                <canvas class="embed-responsive-item" id="lineChartDemo"></canvas>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="tile">
            <h3 class="tile-title">Support Team</h3>

            <div class="text-center" style="padding:50px 20px;">
                <h2>📞 01913-69-11-85</h2>
                <p>Support Hotline</p>
            </div>
        </div>
    </div>
</div>



<!-- Button trigger modal -->
<!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
  Launch demo modal
</button> -->

<!-- Modal -->
<!-- <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div> -->

<?php
$this->endSection();
?>


<?php


$this->section("scripts");
?>
<!-- Page specific javascripts-->
<script type="text/javascript" src="<?php echo base_url('assets/js/plugins/chart.js') ?>"></script>

<script type="text/javascript">
var data = {
    labels: <?= $sales_labels ?? '[]' ?>,
    datasets: [{
        label: "Monthly Sales",
        fillColor: "rgba(151,187,205,0.2)",
        strokeColor: "rgba(151,187,205,1)",
        pointColor: "rgba(151,187,205,1)",
        pointStrokeColor: "#fff",
        pointHighlightFill: "#fff",
        pointHighlightStroke: "rgba(151,187,205,1)",
        data: <?= $sales_amounts ?? '[]' ?>
    }]
};

var ctxl = $("#lineChartDemo").get(0).getContext("2d");
var lineChart = new Chart(ctxl).Line(data);
</script>


<!-- Google analytics script-->
<script type="text/javascript">
if (document.location.hostname == 'pratikborsadiya.in') {
    (function(i, s, o, g, r, a, m) {
        i['GoogleAnalyticsObject'] = r;
        i[r] = i[r] || function() {
            (i[r].q = i[r].q || []).push(arguments)
        }, i[r].l = 1 * new Date();
        a = s.createElement(o),
            m = s.getElementsByTagName(o)[0];
        a.async = 1;
        a.src = g;
        m.parentNode.insertBefore(a, m)
    })(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');
    ga('create', 'UA-72504830-1', 'auto');
    ga('send', 'pageview');
}
</script>

<?php
$this->endSection();
?>