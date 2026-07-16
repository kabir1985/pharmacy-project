<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<div class="app-title">
    <div>
        <h1>
            <i class="fa fa-life-ring"></i>
            Help & Support
        </h1>
    </div>

    <div>
        <a href="<?= site_url('help-support/pdf') ?>"
           target="_blank"
           class="btn btn-danger">

            <i class="fa fa-file-pdf"></i>

            Download User Guide

        </a>
    </div>
</div>

<div class="row">

<div class="col-md-12">

<div class="tile">

<div class="tile-body">

<h3>Frequently Asked Questions</h3>

<hr>

<h5>1. How to Create a Sale?</h5>

<ol>

<li>Go to POS</li>

<li>Select Customer</li>

<li>Add Products</li>

<li>Receive Payment</li>

<li>Click Save Invoice</li>

</ol>

<hr>

<h5>2. How to Purchase Medicines?</h5>

<ol>

<li>Purchase Menu</li>

<li>Create Purchase</li>

<li>Select Supplier</li>

<li>Add Products</li>

<li>Save Purchase</li>

</ol>

<hr>

<h5>3. How to Adjust Stock?</h5>

<ul>

<li>Stock In</li>

<li>Stock Out</li>

<li>Physical Count</li>

<li>Damaged Product</li>

<li>Expired Product</li>

</ul>

<hr>

<h5>4. Reports Available</h5>

<ul>

<li>Sales Report</li>

<li>Purchase Report</li>

<li>Stock Report</li>

<li>Customer Due Report</li>

<li>Supplier Report</li>

<li>Profit & Loss Report</li>

</ul>

<hr>

<h5>Support Information</h5>

<table class="table table-bordered">

<tr>

<th>Email</th>

<td>support@yourcompany.com</td>

</tr>

<tr>

<th>Phone</th>

<td>+8801XXXXXXXXX</td>

</tr>

<tr>

<th>Office Hour</th>

<td>Saturday - Thursday (9:00 AM - 6:00 PM)</td>

</tr>

</table>

</div>

</div>

</div>

</div>

<?= $this->endSection() ?>