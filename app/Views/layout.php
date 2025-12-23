<!DOCTYPE html>
<html lang="en">

<head>
  <meta name="description" content="Inventory Management System.">
  <!-- Twitter meta-->
  <meta property="twitter:card" content="summary_large_image">
  <meta property="twitter:site" content="@pratikborsadiya">
  <meta property="twitter:creator" content="@pratikborsadiya">
  <!-- Open Graph Meta-->
  <meta property="og:type" content="website">
  <meta property="og:site_name" content="Inventory Management System">
  <meta property="og:title" content="Inventory Management System">
  <meta property="og:url" content="Inventory Management System">
  <meta property="og:image" content="Inventory Management System">
  <meta property="og:description" content="Inventory Management System.">
  <title>Inventory Management System</title>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Main CSS-->
  <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/main.css') ?>">
  <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/animate.min.css') ?>">

  <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/select2.min.css') ?>">
  <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/select2-bootstrap.css') ?>">
  <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/invoice.css') ?>">


<!-- Bootstrap 5 JS (bundle includes Popper) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


  <!-- Font-icon css-->
  <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">


  <style type="text/css">
    .height-fix {
      height: 34px !important;
    }
  </style>

</head>

<body class="app sidebar-mini">
  <!-- Navbar-->
  <?php echo $this->include("partial/navbar"); ?>

  <!-- Sidebar menu-->
  <?php echo $this->include("partial/sidebar"); ?>

  <main class="app-content">
    <?= $this->renderSection('content') ?>
  </main>


  <!-- Essential javascripts for application to work-->
  <!-- <script src="<?php echo base_url('assets/js/jquery-2.2.3.min.js') ?>"></script> -->
  <script src="<?php echo base_url('assets/js/jquery-3.3.1.min.js') ?>"></script>
  <script src="<?php echo base_url('assets/js/popper.min.js') ?>"></script>
  <script src="<?php echo base_url('assets/js/bootstrap.min.js') ?>"></script>
  <script src="<?php echo base_url('assets/js/plugins/bootstrap-datepicker.min.js') ?>"></script>
  <script src="<?php echo base_url('assets/js/plugins/select2.min.js') ?>"></script>
  <script src="<?php echo base_url('assets/js/main.js') ?>"></script>
  <!-- The javascript plugin to display page loading on top-->
  <script src="<?php echo base_url('assets/js/plugins/pace.min.js') ?>"></script>


  <script type='text/javascript'>
    $(document).ready(function() {


      if ($('.select2').length) {

        //$.fn.select2.defaults.set("theme", "bootstrap");

        $('.select2').select2({
          theme: "bootstrap",
          // placeholder: "Select Product",
          // width: null,
          // containerCssClass: ':all:'
        });
      }


      if ($('.dataTable').length) {
        $('.dataTable').DataTable();
      }

    });


    function accept_digit_only(evt) {
      var charCode = (evt.which) ? evt.which : event.keyCode
      //alert(charCode);
      if ((charCode >= 48 && charCode <= 57) || charCode == 8 || charCode == 46)
        return true;

      return false;
    }
  </script>


  <?= $this->renderSection("scripts"); ?>

</body>

</html>