<?php
/**
 * --------------------------------------------------------------------------
 * Pharmacy Management System
 * --------------------------------------------------------------------------
 * Barcode Label Printing
 * --------------------------------------------------------------------------
 *
 * Features
 * --------
 * • Product search
 * • Barcode label generation
 * • Quantity selection
 * • Supplier selection
 * • Print preview
 *
 * Controller:
 *      BarcodeController
 *
 * View:
 *      barcode.php
 *
 * --------------------------------------------------------------------------
 * @package Pharmacy Management System
 * @author  Kabir Hossain
 * @version 1.0
 * --------------------------------------------------------------------------
 */

echo $this->extend('layout');
echo $this->section('content');
?>

<div class="container-fluid">
    <!----------------Invoice Option Start------------------------>


    <!----------------Invoice Option End------------------------>

    <div class="row">
        <div class="col-sm-7">
             <select class="form-control select2 w-100"> id="item" class="form-control select2">
                <option value="0">Select Product</option>
                <?php
                foreach ($product_show_for_sale as $row) {
                ?>
                <option value="<?= esc($row["product_id"]) ?>">
                    <?= esc($row["product_name"]) ?>
                </option>
                <?php
                } ?>

            </select>
        </div>
        <div class="col-sm-5">
            <select id="supplier_id" class="form-control select2" required>
                <option value="">Select Supplier</option>
                <?php
                foreach ($supplier_show as $row) {
                ?>
                <option value="<?= esc($row["supplier_id"]) ?>">
                    <?= esc($row["supplier_name"]) ?>
                </option>
                <?php
                }
                ?>
            </select>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-sm-7">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr class="table-info">
                            <th scope="col">Product Name</th>
                            <th scope="col">Product ID</th>
                            <th scope="col">Quantity</th>
                            <th scope="col" class="text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody id="cartTableBody">
                    </tbody>
                    <tfoot>
                    </tfoot>
                </table>
            </div>
            <div class="text-right">
                <button class="btn  btn-info" data-toggle="modal" data-target="#inVoiceAdd222222" id="showLabels">Show
                    Labels</button>
                <button class="btn  btn-danger" data-toggle="modal" data-target="#inVoiceAdd222222"
                    id="#">Close</button>
            </div>
        </div>

        <div class="col-sm-5 bg-white rounded text-white pt-2">
            <div class="row">
                <?php
                foreach ($product_show_for_sale as $key => $row) {
                ?>
                <div class="col-3 mb-2">
                    <img data-stock="<?= esc($row["total_stock"]) ?>" data-id="<?= esc($row["product_id"])?>"
                        src="<?= base_url() ?>/public/uploads/<?= $row["product_image"] ?>"
                        class="img-thumbnail cart_item_image" alt="image 1" style="width: 100px; height: 80px;">
                </div>
                <?php
                }
                ?>
            </div>
        </div>
    </div>

    <div class="row bg-white rounded text-black pt-2" style="border-top:1px solid green; margin-top:4px; !important">
        <div class="col-sm-11">
            <div class="row mb-2" id="labelPrint">
            </div>
        </div>
        <div class="col-sm-1"><button type="button" class="btn btn-success">Print</button>
        </div>
    </div>
</div>

<?= $this->endSection();?>

<?= $this->section('scripts');
?>

<!-- Data table plugin-->
<script type='text/javascript' src="<?= base_url('assets/js/jquery.mycart.js') ?>"></script>

<script type='text/javascript'>
var productsList = <?php echo json_encode($product_show_for_sale, JSON_PRETTY_PRINT) ?>;
//console.log('sdfsdf ' + JSON.stringify(productsList));
$(document).ready(function() {

    var itemsInCart = [];
    // var totalPrice = 0;

    $("#showLabels").on("click", function() {

        //var discount = $("#discount").val();
        // var others_cost = $("#others_cost").val();
        var supplier_id = $("#supplier_id :selected").val();

        if (supplier_id == "") {
            alert("Please Select Warehouse");
            $("#supplier_id").focus();
            return;
        }


        var itemsInCartObject = Object.assign({}, itemsInCart);

        // console.log(itemsInCartObject);

        //var sales_process_url = "http://localhost/codeigniter4/Purchase/purchase_product";
        var barcodeprinturl = "<?= site_url('barcode/print') ?>";

        $.ajax({
            url: barcodeprinturl, // complete url from siteurl/constroller/function
            method: 'POST',
            data: {
                //cart_data: itemsInCartObject,
                cart_data: JSON.stringify(itemsInCart), // send as JSON string
                // discount,
                //others_cost,
                supplier_id
            },
            success: function(data) {
                //alert('success');
                $("#labelPrint").html(data);
            },
            error: function() {
                alert('error');
            }
        });

    });


    $("#item").on('change', function() {
        var product_id = $(this).val();
        //alert(product_id);
        productAddToCart(product_id);
    });

    $(".extra-fields").on("input", function() {
        totalCalculation();
    });


    $('body').on("input", ".product_quantity_change", function() {

        var index = $(this).data("id");
        //var newQuantity = $(this).val();
        var newQuantity = Number.parseInt($(this).val());

        if (newQuantity < 1) {
            itemsInCart.splice(index, 1);
        } else {
            itemsInCart[index].quantity_per_pack = newQuantity;
        }
        drawTable();
    });


    /* Product Delete Strat */
    $('body').on("click", ".btn_item_delete", function() {
        //if (confirm("Really Want to Delete ?")) {
        var index = $(this).data("index");
        itemsInCart.splice(index, 1);
        drawTable();
        //}
    });
    /* Product Delete End */
    /* Image e click kore product add kora strat */
    $('body').on("click", ".cart_item_image", function() {
        var product_id = $(this).data("id");
        productAddToCart(product_id);
    });
    /* Image e click kore product add kora End */
    /*
    Cart Initialize the cart
    */
    function productAddToCart(product_id) {
        $.each(productsList, function(key, value) {
            if (value.product_id == product_id) {
                var response = itemExist(product_id);
                //console.log("testsdfsd sdf" + response);
                if (response.inCart) {
                    itemsInCart[response.productIndex].quantity_per_pack = itemsInCart[response.productIndex]
                        .quantity_per_pack + 1;
                } else {
                    value.quantity_per_pack = 1;
                    itemsInCart.push(value);
                }
                drawTable();
            }
        });
    }

    /*
    Draw / Redraw Table
    */
    function drawTable() {
        $("#cartTableBody").empty();
        // $("#totalPrice").html("0.00");
        // totalPrice = 0;
        $.each(itemsInCart, function(key, item) {
            // var totalBasePrice = parseInt(item.quantity) * parseFloat(item.buying_unit_price);
            // var subTotalTax = parseFloat(totalBasePrice) * (parseFloat(item.tax_perchantage) / 100);
            // var subtotalPrice = parseFloat(totalBasePrice) + subTotalTax;
            $("#cartTableBody").append('<tr>' +
                '<td>' + item.product_name + '</td>' +
                '<td>' + item.product_id + '</td>' +
                '<td>' +
                '<input data-oldQuantity="' + item.quantity_per_pack + '" data-id="' + key +
                '" class="product_quantity_change" type = "number"  size="10"' +
                'value="' + item.quantity_per_pack +
                '" onkeypress="return accept_digit_only(event)" min="0" max="99999"/> ' +
                '</td>' +
                '<td class = "text-right" > ' +
                '<button  data-index="' + key +
                '" class="badge badge-danger badge-sm btn_item_delete">' +
                '<i class="fa fa-times"></i></button>' +
                '</td>' +
                '</tr>');
            // totalPrice += subtotalPrice;
            //item.tax_perchantage.toFixed(2)
        });
        // totalCalculation();
        //enableButton(); //For supplier select
    }

    /*
    Chek Is the selected Item Exist in List
    */
    function itemExist(product_id) {
        var response = {
            inCart: false,
            productIndex: null
        };
        $.each(itemsInCart, function(key, item) {
            if (item.product_id == product_id) {
                if (!response.inCart) {
                    response.inCart = true;
                    response.productIndex = key;
                }
            }
        });
        return response;
    }


});

document.addEventListener('click', function (e) {

if (e.target.classList.contains('btn-success')) {

    let printContents = document.getElementById('labelPrint').innerHTML;

    if (!printContents.trim()) {
        alert('No label to print');
        return;
    }

    let printWindow = window.open('', '', 'width=900,height=650');
    printWindow.document.write(`
        <html>
        <head>
            <title>Print Labels</title>
            <style>
                body { margin: 10px; }
                .card { page-break-inside: avoid; }
            </style>
        </head>
        <body>
            ${printContents}
        </body>
        </html>
    `);

    printWindow.document.close();
    printWindow.focus();

    setTimeout(() => {
        printWindow.print();
        printWindow.close();
    }, 500);
}

});
</script>

<?= $this->endSection();?>