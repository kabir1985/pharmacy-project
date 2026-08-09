<?php
echo $this->extend('layout');
echo $this->section('content');
?>

<div class="container-fluid">

    <!-- //////////////////NEw Design Start////////////////////////////////// -->

    <div class="row pos-main-row">
        <!----------------Customer show and Search Product Option-------------------------------->
        <div class="col-sm-8 col-12 pos-main-left">
            <div class="row pos-top-controls">

                <div class="col-md-5 col-12 pos-customer-control mb-2 mb-md-0">
                    <!-- <div class="input-group"> -->
                    <div class="input-group-append">
                        <select id="customer_id" class="form-control select2" name="customer_id">
                            <option value="">Walk-In Customer</option>

                            <?php foreach ($customer_show as $row): ?>
                            <option value="<?=esc($row['customer_id'])?>">
                                <?=esc($row['customer_name'])?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                        <span class="input-group-text" style="1px solid #ced4da; !important" data-toggle="modal"
                            data-target="#CustomerAdd" id="inputGroupPrepend">

                            <i class="fa fa-user-plus text-primary"></i>

                        </span>
                    </div>
                    <!-- </div> -->
                </div>

                <div class="col-md-7 col-12 has-search pos-product-search">
                    <div class="input-group-append">
                        <span class="fa fa-search form-control-feedback"></span>
                        <input type="text" class="form-control " id="search_product"
                            placeholder="Search Item name/Barcode">
                        <span class="input-group-text" style="1px solid #ced4da; !important"><i
                                class="fa fa-barcode "></i></span>
                    </div>
                </div>

            </div>

            <div class="row">
                <div class="col">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr class="table-info">
                                    <th>Name</th>
                                    <th>Stock</th>
                                    <th>Quantity</th>
                                    <th>Sale Price</th>

                                    <!-- <th class="vat-column-header hide">Vat %</th> -->
                                    <th class="discount-column-header hide">Disc %</th>

                                    <th>Avg.P.P/unit</th>
                                    <th class="text-end">Amount</th>
                                    <th width="60" class="text-center">Action</th>
                                </tr>
                            </thead>

                            <tbody id="cartTableBody">
                            </tbody>

                        </table>
                    </div>
                </div>
            </div>


            <div class="row">
                <div class="col-sm-12">
                    <select id="product_category" class="form-control select2">
                        <option value="all_category">All Category</option>
                        <?php
                           foreach ($product_category_show as $row) {
                         ?>
                        <option value="<?php echo $row["product_category_id"] ?>"><?php echo $row["category_name"] ?>
                        </option>
                        <?php
                            }
                            ?>
                    </select>

                </div>
            </div>
            <!-------------------Product Show staart----------------------------------->
            <div class="row">
                <div class="col bg-white rounded text-black pt-2">
                    <div class="row all_products">
                        <?php
                        foreach ($product_show_for_sale as $key => $row) {
                            ?>
                        <?php
                        if ($row["total_stock"] > '0') {
                                ?>

                        <div class="col-3 mb-3 text-center">
                            <!-- Product Image -->
                            <img data-stock="<?=$row['total_stock']?>" data-id="<?=$row['product_id']?>" src="<?=!empty($row['product_image'])
                            ? base_url('public/uploads/' . $row['product_image'])
                            : base_url('public/uploads/default-medicine.png')?>"
                                class="img-thumbnail cart_item_image shadow-sm" alt="<?=$row['product_name']?>"
                                style="width:100px;height:80px;object-fit:cover;">

                            <!-- Product Name -->
                            <p class="mt-2 mb-1 fw-semibold text-dark"
                                style="font-size: 0.75rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                <?php echo $row["product_name"] ?>
                            </p>

                            <!-- Product Price -->
                            <p class="text-primary mb-0" style="font-size: 0.7rem; font-weight: 600;">
                                ৳<?php echo number_format($row["selling_price"], 2) ?>
                            </p>
                        </div>

                        <?php
                        }
                        }
                        ?>
                    </div>
                </div>
            </div>
            <!-----------------------------Product Show END------------------------------------------------------>
        </div>
        <!----------------Customer show and Search Product Option End-------------------------------->

        <div class="col-lg-4 col-12 mb-2 pos-main-right">

            <div class="card text-dark bg-light mb-3">
                <div class="card-header">
                    <h2>Create Sale</h2>
                </div>

                <div class="card-body">
                    <p class="card-title mb-2">
                        <label class="switch">
                            <input type="checkbox" id="ProductWiseVatAndDiscount">
                            <span class="slider round"></span>
                        </label>
                        Product Wise
                        <!--VAT &--> Discount
                    </p>

                    <div class="d-flex justify-content-between">
                        <span><b>Sub Total</b></span>
                        <strong id="subTotalCost">0.00</strong>
                    </div>
                    <hr style="border:0; border-top:1px dashed #b5b5b5; margin:4px 0;">


                    <!-- <div class="productVatDiscountSection" style="display:none;">

                        <div class="charge-row text-danger">
                            <span class="charge-label">(-)Discount</span>

                            <select id="productDiscountType" class="form-select form-select-sm charge-type"
                                onchange="calculateDiscountEachProdcut()">
                                <option value="%">%</option>
                                <option value="flat">Flat</option>
                            </select>

                            <input type="text" id="discount_apply" style="mx-size:70px;"
                                class="form-control form-control-sm charge-input">

                            <span id="productDiscount" class="charge-total">0.00</span>
                        </div>

                        <hr style="border:0;border-top:1px dashed #b5b5b5;margin:4px 0;">

                    </div>

                    <div class="charge-row text-success">

                        <span class="charge-label">(+) Other Charge</span>

                        <select id="otherCharge" class="form-select form-select-sm charge-type"
                            onchange="calculateotherCharge()">
                            <option value="%">%</option>
                            <option value="flat">Flat</option>
                        </select>

                        <input type="number" id="otherChargeValue"
                            class="form-control form-control-sm charge-input extra-fields" style="mx-size:70px;"
                            value="0.00" oninput="calculateotherCharge()">

                        <span id="otherChargeOnTotalPrice" class="charge-total">0.00</span>

                    </div> -->


                    <div class="productVatDiscountSection" style="display:none;">

                        <div class="charge-row text-danger">

                            <span class="charge-label">
                                (-) Discount
                            </span>

                            <select id="productDiscountType" class="form-select form-select-sm charge-type"
                                onchange="calculateDiscountEachProdcut()">

                                <option value="%">%</option>
                                <option value="flat">Flat</option>

                            </select>

                            <input type="text" id="discount_apply" class="form-control form-control-sm charge-input">

                            <span id="productDiscount" class="charge-total">
                                0.00
                            </span>

                        </div>

                        <hr style="border:0;border-top:1px dashed #b5b5b5;margin:4px 0;">

                    </div>


                    <div class="charge-row text-success">

                        <span class="charge-label">
                            (+) Other Charge
                        </span>

                        <select id="otherCharge" class="form-select form-select-sm charge-type"
                            onchange="calculateotherCharge()">

                            <option value="%">%</option>
                            <option value="flat">Flat</option>

                        </select>

                        <input type="number" id="otherChargeValue"
                            class="form-control form-control-sm charge-input extra-fields" value="0.00"
                            oninput="calculateotherCharge()">

                        <span id="otherChargeOnTotalPrice" class="charge-total">
                            0.00
                        </span>

                    </div>


                    <hr style="border:0; border-top:1px dashed #b5b5b5; margin:4px 0;">

                    <div class="d-flex justify-content-between">
                        <strong>Grand Total</strong>
                        <strong id="netTotalPrice">0.00</strong>
                    </div>
                    <hr style="border:0; border-top:1px dashed #b5b5b5; margin:6px 0;">


                    <div class="row text-success">
                        <div class="col-sm-4">Paid</div>
                        <div class="col-sm-8">
                            <input type="text" id="paid" class="form-control form-control-sm text-end extra-fields"
                                style="width: 100px;" onkeypress="return accept_digit_only(event)">
                        </div>
                    </div>

                    <div class="row text-danger">
                        <div class="col-sm-4">Due</div>
                        <div class="col-sm-8">
                            <input type="text" id="due" class="form-control form-control-sm text-end extra-fields"
                                style="width: 100px;" onkeypress="return accept_digit_only(event)">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <div class="mb-1">
                                <button class="btn btn-info w-100 text-uppercase" id="productSale">
                                    <i class="fa fa-money" aria-hidden="true"></i> Submit Order
                                </button>
                            </div>

                            <div class="d-flex gap-2">

                                <button type="button" id="holdSale" class="btn btn-danger w-50">Hold
                                    Sale</button>

                                <button type="button" class="btn btn-primary w-50" data-toggle="modal"
                                    data-target="#recentTransaction">
                                    <i class="fa fa-list" aria-hidden="true"></i> Recent Txn
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">

                            <div class="card mt-1">

                                <div class="card-body" style="max-height: 200px; overflow-y:auto;">
                                    <?php if (!empty($heldSales)): ?>
                                    <ul class="list-group held-sale-list" id="heldSaleSection">
                                        <?php foreach ($heldSales as $sale): ?>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <div>
                                                <strong><?=$sale['hold_id']?></strong><br>
                                                <small><?=$sale['customer_id']?></small>
                                            </div>


                                            <div class="btn-group">
                                                <a href="javascript:void(0)" class="btn btn-sm btn-primary resume-sale"
                                                    data-id="<?=$sale['id']?>">
                                                    Resume
                                                </a>

                                                <a href="javascript:void(0)"
                                                    class="btn btn-sm btn-danger delete-held-sale"
                                                    data-id="<?=$sale['id']?>">
                                                    <i class="fa fa-trash"></i>
                                                </a>
                                            </div>


                                        </li>
                                        <?php endforeach; ?>
                                    </ul>
                                    <?php else: ?>
                                    <ul class="list-group held-sale-list" id="heldSaleSection"></ul>
                                    <p class="text-muted">No held sales found</p>
                                    <?php endif; ?>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>
    <!-- ////////////////////////////////////New Design end/////////////////////////////////////////// -->

    <!-- Recent Transaction Modal -->
    <div class="modal fade" id="recentTransaction" tabindex="-1" role="dialog" aria-labelledby="recentTransactionLabel"
        aria-hidden="true">

        <div class="modal-dialog modal-lg modal-dialog-centered recent-transaction-modal" role="document">

            <div class="modal-content">

                <!-- Header -->
                <div class="modal-header">

                    <h5 class="modal-title" id="recentTransactionLabel">
                        <i class="fa fa-list mr-1"></i>
                        Recent Transaction List
                    </h5>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">

                        <span aria-hidden="true">&times;</span>

                    </button>

                </div>


                <!-- Body -->
                <div class="modal-body recent-transaction-body">

                    <div class="recent-transaction-wrapper">

                        <div class="table-responsive recent-transaction-table-wrapper">

                            <table class="table table-hover table-bordered mb-0" id="sampleTable">

                                <thead>
                                    <tr>
                                        <th>Invoice No</th>
                                        <th>Invoice Date</th>
                                        <th>Quantity</th>
                                        <th>Unit Price</th>
                                        <th>Total Sale Price</th>
                                    </tr>
                                </thead>

                                <tbody>

                                    <?php foreach ($sales_summery_report_show as $row): ?>

                                    <?php

                                    $date = $row['sales_date'];

                                    $new_date = explode(" ", $date);

                                    $str = explode('-', $new_date[0]);

                                    $year  = $str[0];
                                    $month = $str[1];
                                    $day   = $str[2];

                                    $only_date = $day . "/" . $month . "/" . $year;

                                    ?>

                                    <tr>

                                        <td>
                                            <?=esc($row['sales_invoice'])?>
                                        </td>

                                        <td>
                                            <?=esc($only_date)?>
                                        </td>

                                        <td>
                                            <?=esc($row['Sale_Quantity'])?>
                                        </td>

                                        <td>
                                            <?=esc($row['Unite_Price'])?>
                                        </td>

                                        <td>
                                            <?=esc($row['Total_Sale_Value'])?>
                                        </td>

                                    </tr>

                                    <?php endforeach; ?>

                                </tbody>

                            </table>

                        </div>

                    </div>

                </div>


                <!-- Footer -->
                <div class="modal-footer">

                    <button type="button" class="btn btn-secondary" data-dismiss="modal">

                        Close

                    </button>

                </div>

            </div>

        </div>

    </div>
    <!----------------------------Recent Transaction modal End ------------------------------->



    <!----------------------------Customer Add Modal Start------------------------------>
    <div class="modal fade" id="customerAdd" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Customer Title</h5>
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
    </div>
    <!----------------------------Customer Add modal End ------------------------------->


    <!-------------------------- Modal for New Customer Add------------------------------------>
    <div class="modal fade" id="CustomerAdd" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">

                <form id="CustomerModalEntry_Form" method="post" action="<?=site_url('customer/create')?>">

                    <?=csrf_field();?>

                    <div class="modal-header">
                        <h5 class="modal-title">
                            Create New Customer
                        </h5>

                        <button type="button" class="close" data-dismiss="modal">
                            <span>&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">

                        <div class="form-row">

                            <div class="form-group col-md-6">
                                <label>Customer Group <span class="text-danger">*</span></label>

                                <select class="form-control" name="customer_group_id" required>

                                    <option value="">Select Customer Group</option>

                                    <?php foreach ($customer_group_show as $group): ?>

                                    <option value="<?=esc($group['customer_group_id'])?>">
                                        <?=esc($group['group_name'])?>
                                    </option>

                                    <?php endforeach; ?>

                                </select>

                            </div>

                            <div class="form-group col-md-6">
                                <label>Customer Name <span class="text-danger">*</span></label>

                                <input type="text" class="form-control" name="customer_name" placeholder="Customer Name"
                                    required>

                            </div>

                        </div>

                        <div class="form-row">

                            <div class="form-group col-md-6">
                                <label>Phone</label>

                                <input type="text" class="form-control" name="phone" placeholder="Phone Number">

                            </div>

                            <div class="form-group col-md-6">
                                <label>Status</label>

                                <select class="form-control" name="status">

                                    <option value="1" selected>Active</option>
                                    <option value="0">Inactive</option>

                                </select>

                            </div>

                        </div>

                        <div class="form-row">

                            <div class="form-group col-md-12">
                                <label>Address</label>

                                <textarea class="form-control" rows="3" name="address"
                                    placeholder="Customer Address"></textarea>

                            </div>

                        </div>

                    </div>

                    <div class="modal-footer">

                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                            Close
                        </button>

                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-save"></i>
                            Save Customer
                        </button>

                    </div>

                </form>

            </div>
        </div>
    </div>

    <!----------------------Modal Form End------------------------------------------>

</div>

<?= $this->endSection();?>

<?=$this->section('css')?>
<link rel="stylesheet" href="<?=base_url('assets/css/pos-add-view.css')?>">
<link rel="stylesheet" href="<?=base_url('assets/css/pos-add.css')?>">
<link rel="stylesheet" href="<?=base_url('assets/css/responsive-view.css')?>">
<?=$this->endSection()?>

<?= $this->section('scripts');?>

<script src="<?= base_url('assets/js/jquery.mycart.js') ?>"></script>
<script src="<?= base_url('assets/js/jquery-ui.min.js') ?>"></script>

<script>
window.APP_URLS = {
    productSearch: "<?= site_url('pos/product-search') ?>",
    posSale: "<?= site_url('pos/sale') ?>",
    holdSale: "<?= site_url('pos/hold-sale') ?>",
    deleteHoldSale: "<?= site_url('pos/delete-held-sale') ?>",
    resumeSale: "<?= site_url('pos/resume-sale') ?>",
    filterProduct: "<?= site_url('pos/filterProducts') ?>",
    updateHoldSale: "<?= site_url('pos/update-hold-sale') ?>",
    update_hold_sale: "<?= site_url('pos/update_hold_sale')?>",
    invoiceBase: "<?= rtrim(base_url(), '/') ?>/invoice/",
    successSound: "<?= base_url('public/sounds/success.mp3') ?>",
    warningSound: "<?= base_url('public/sounds/warning.mp3') ?>"
};

window.APP = {
    productsList: <?= json_encode($product_show_for_sale, JSON_PRETTY_PRINT) ?>

    //console.log('Products List:', window.APP.productsList);
};

console.log('Products List:', window.APP.productsList);
</script>

<script src="<?= base_url('assets/js/pos-add.js') ?>"></script>

<?= $this->endSection();?>