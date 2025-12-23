<?php
    echo $this->extend('layout');
    echo $this->section('content');

?>
<link rel="stylesheet" href="<?php echo base_url('assets/css/jquery-ui.min.css') ?>" />

<div class="container-fluid">
    <!----------------Invoice Option Start------------------------>

    <!---------------------------------Invoice Option End------------------------------------------------------------->

    <!--------------------Product Add Modal Start---------------------------------->
    <div class="modal fade" id="productAdd" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Product Title</h5>
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

    <!----------------------Product Add Modal End------------------------------------------>

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


    <!----------------------------Recent Transaction Modal Start------------------------------>
    <div class="modal fade" id="recentTransaction" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Recent Transaction List</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!--------Data Table start Here------------------->
                    <div class='row'>
                        <div class='col-md-12'>
                            <div class='tile collapseable show animate__animated  animate__fadeInUp'>
                                <div class='tile-body'>
                                    <div class='table-responsive'>
                                        <table class='table table-hover table-bordered' id='sampleTable'>
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
                                                <?php
                                                    foreach ($sales_summery_report_show as $row) {
                                                        //$date_time = $row['sales_date'];
                                                        //$new_date = date("Y-m-d H:i:s",strtotime($date_time));
                                                        $date     = $row['sales_date'];
                                                        $new_date = explode(" ", $date);
                                                        //echo $new_date[0];
                                                        $str       = explode('-', $new_date[0]);
                                                        $year      = $str[0];
                                                        $month     = $str[1];
                                                        $day       = $str[2];
                                                        $only_date = $day . "/" . $month . "/" . $year;
                                                    ?>
                                                <tr>
                                                    <td>
                                                        <?php echo $row['sales_invoice']; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $only_date; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $row['Sale_Quantity']; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $row['Unite_Price']; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $row['Total_Sale_Value']; ?>
                                                    </td>
                                                </tr>

                                                <?php
                                                    }
                                                ?>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!---------Data Table End Here----------------->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>
    <!----------------------------Recent Transaction modal End ------------------------------->



    <!-------------------------tAXmodal start------------------------------>
    <div class="modal fade" id="tAXmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">TAX Update Form</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr class="table-info">
                                    <th scope="col">Product Name</th>
                                    <th scope="col">Stock</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="table-warning">
                                    <td></td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>


                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>
    <!----------------------------tAXmodal  end--------------------------->


    <!-- //////////////////////////NEw Design Start////////////////////////////////////////////////////// -->
    <div class="row">
        <div class="col-sm-9">
            <div class="row">
                <div class="col-sm-5">
                    <!-- <div class="input-group"> -->
                    <div class="input-group-append">
                        <select id="customer_type" class="form-control select2" name="customer_type">
                            <option value="Walk-In-Customer">Walk-In Customer</option>
                            <?php foreach ($customer_show as $row): ?>
                            <option value="<?php echo htmlspecialchars($row['customer_id']) ?>">
                                <?php echo htmlspecialchars($row['cus_first_name']) ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                        <span class="input-group-text" style="1px solid #ced4da; !important" data-toggle="modal"
                            data-target="#CustomerAdd" id="inputGroupPrepend"><i
                                class=" fa fa-user-plus text-primary"></i></span>
                    </div>
                    <!-- </div> -->
                </div>

                <div class="col-sm-7 has-search">
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
                        <table class="table table-striped">
                            <thead>
                                <tr class="table-info">
                                    <th scope="col">Name</th>
                                    <th scope="col">Stock</th>
                                    <th scope="col">Quantity</th>
                                    <th scope="col">Sale Price</th>
                                    <th scope="col">Tax</th>
                                    <th scope="col">TaxAmt</th>
                                    <th scope="col" onkeypress="return accept_digit_only(event)" class="text-right">
                                        Sub-Total
                                    </th>
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
                            <img data-stock="<?php echo $row["total_stock"] ?>"
                                data-id="<?php echo $row["product_id"] ?>"
                                src="<?php echo base_url() ?>/public/uploads/<?php echo $row["product_image"] ?>"
                                class="img-thumbnail cart_item_image shadow-sm" alt="<?php echo $row["product_name"] ?>"
                                style="width: 100px; height: 80px; object-fit: cover;">

                            <!-- Product Name -->
                            <p class="mt-2 mb-1 fw-semibold text-dark"
                                style="font-size: 0.75rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                <?php echo $row["product_name"] ?>
                            </p>

                            <!-- Product Price -->
                            <p class="text-primary mb-0" style="font-size: 0.7rem; font-weight: 600;">
                                ৳<?php echo number_format($row["selling_unit_price"], 2) ?>
                            </p>
                        </div>

                        <?php
                            }
                            }
                        ?>
                    </div>
                </div>
            </div>
            <!-- <div class="row">
                <div class="col"> <button type="button" data-toggle="modal" data-target="#recentTransaction"
                        class=" btn btn-primary text-white"><i class="fa fa-list" aria-hidden="true"></i>
                        Recent Transactions
                    </button>
				</div>
            </div> -->

        </div>

        <div class="col-3 mb-2">
            <div class="card text-dark bg-light mb-3">
                <div class="card-header">
                    <h2>Create Sale</h2>
                </div>

                <div class="card-body">
                    <p class="card-title mb-2">
                        <label class="switch">
                            <input type="checkbox" id="fixedVatToggle">
                            <span class="slider round"></span>
                        </label>
                        Product Wise VAT & Discount
                    </p>

                    <p class="card-title mb-2">
                        <label class="switch">
                            <input type="checkbox" id="vatperchantageToggle">
                            <span class="slider round"></span>
                        </label>
                        VAT Perchantage
                    </p>

                    <table class="table table-striped mb-0">
                        <tfoot>
                            <tr class="table-secondary">
                                <td colspan="4"></td>
                                <td class="text-end pe-2">Total Price</td>
                                <td class="text-end" id="totalPrice">0.00</td>
                            </tr>

                            <tr>
                                <td colspan="4"></td>
                                <td class="text-end pe-2">Discount</td>
                                <td>
                                    <div class="d-flex justify-content-end align-items-center gap-2">
                                        <select id="discountType" class="form-select form-select-sm"
                                            onchange="calculateDiscount()">
                                            <option value="%">%</option>
                                            <option value="flat">Flat</option>
                                        </select>
                                        <input type="number" id="discountValue"
                                            class="form-control form-control-sm extra-fields" placeholder="0"
                                            value="0.00" oninput="calculateDiscount()">
                                        <span id="discountOnTotalPrice">: 0.00</span>
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td colspan="4"></td>
                                <td class="text-end pe-2">VAT</td>
                                <td>
                                    <div class="d-flex justify-content-end align-items-center gap-2">
                                        <select id="vatType" class="form-select form-select-sm"
                                            onchange="calculateVat()">
                                            <option value="%">%</option>
                                            <option value="flat">Flat</option>
                                        </select>
                                        <input type="number" id="vatValue"
                                            class="form-control form-control-sm extra-fields" placeholder="0"
                                            value="0.00" oninput="calculateVat()">
                                        <span id="vatOnTotalPrice">: 0.00</span>
                                    </div>
                                </td>
                            </tr>

                            <tr class="table-warning">
                                <td colspan="4"></td>
                                <td class="text-end pe-2">Net Total</td>
                                <td class="text-end" id="netTotalPrice"><strong>0.00</strong></td>
                            </tr>

                            <tr>
                                <td colspan="4"></td>
                                <td class="text-end pe-2">Paid</td>
                                <td>
                                    <input type="text" id="paid"
                                        class="form-control form-control-sm text-end extra-fields" style="width: 100px;"
                                        onkeypress="return accept_digit_only(event)">
                                </td>
                            </tr>


                            <tr>
                                <td colspan="4"></td>
                                <td class="text-end pe-2">Due</td>
                                <td>
                                    <input type="text" id="due"
                                        class="form-control form-control-sm text-end extra-fields" style="width: 100px;"
                                        onkeypress="return accept_digit_only(event)">
                                </td>
                            </tr>

                            <tr class="table-secondary">
                                <td colspan="6">
                                    <div class="d-flex gap-2">
                                        <button type="button" class="btn btn-danger w-50" id="openVatModal"
                                            data-toggle="modal" data-target="#vatModal">
                                            Hold Txn
                                        </button>
                                        <button type="button" class="btn btn-primary w-50" data-toggle="modal"
                                            data-target="#recentTransaction">
                                            <i class="fa fa-list" aria-hidden="true"></i> Recent Txn
                                        </button>
                                    </div>
                                    <div class="mt-2">
                                        <button class="btn btn-info w-100 text-uppercase" id="productSale">
                                            <i class="fa fa-money" aria-hidden="true"></i> Submit Order
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <!-- <div class="card-footer text-muted">
					<div>
						<button class="btn btn-info text-uppercase w-100" disabled
							id="productPurchase">Purchase</button>
					</div>
				</div> -->
            </div>
        </div>
    </div>
    <!-- ////////////////////////////////////New Design end/////////////////////////////////////////// -->


    <!-------------------------- Modal for New Customer Add------------------------------------>
    <div class='modal fade' id='CustomerAdd' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel'
        aria-hidden='true'>
        <div class='modal-dialog modal-lg ' role='document'>
            <div class='modal-content'>
                <form id="CustomerModalEntry_Form" method='post' action="<?php echo site_url('/customer/create') ?>">
                    <div class='modal-header'>
                        <h5 class='modal-title' id='exampleModalLabel'>Please Enter Customer Details</h5>
                        <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                            <span aria-hidden='true'>&times;
                            </span>
                        </button>
                    </div>

                    <div class='modal-body'>

                        <div class='form-row'>
                            <div class='form-group col-md-4'>
                                <label>First Name</label>
                                <input required type='text' required class='form-control' name='cus_first_name'
                                    placeholder='First Name'>
                            </div>
                            <div class='form-group col-md-4'>
                                <label>Last Name</label>
                                <input type='text' class='form-control' name='cus_last_name' placeholder='Last Name'>
                            </div>
                            <div class='form-group col-md-4'>
                                <label>Email</label>
                                <input type='email' class='form-control' name='cus_email' placeholder='Email'>
                            </div>
                        </div>
                        <div class='form-row'>
                            <div class='form-group col-md-4'>
                                <label> Phone Number</label>
                                <input type='text' pattern="\d{1,13}" class='form-control' name='cus_phone'
                                    placeholder='Phone'>
                            </div>
                            <div class='form-group col-md-4'>
                                <label> Address</label>
                                <input type='text' class='form-control' name='cus_address' placeholder='Address'>
                            </div>
                            <div class='form-group col-md-4'>
                                <label> TIN</label>
                                <input type='text' class='form-control ' name='cus_tin'
                                    placeholder='Tax Identification Number'>
                            </div>
                        </div>

                        <div class='form-row'>
                            <div class='form-group col-md-4'>
                                <label>Company</label>
                                <input type='text' class='form-control' name='cus_company' placeholder='Company'>
                            </div>
                            <div class='form-group col-md-4'>
                                <label for="inputState">Customer Type</label>
                                <select id="CustomerType" name="cus_type" class="form-control">

                                    <option value="general">General</option>
                                    <option value="special">Special</option>
                                </select>
                            </div>
                            <div class='form-group col-md-4'>
                                <label>Date</label>
                                <input type='text' class='form-control datePicker' name='cus_creation_date'
                                    placeholder='Creation Date'>
                            </div>
                        </div>
                    </div>

                    <div class='modal-footer'>
                        <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
                        <button type='submit' class='btn btn-primary'>Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!----------------------Modal Form End------------------------------------------>

</div>

<?php
    echo $this->endSection();
?>

<?php
    echo $this->section('scripts');
?>

<!-- Data table plugin-->
<script type='text/javascript' src="<?php echo base_url('assets/js/jquery.mycart.js') ?>"></script>
<script type='text/javascript' src="<?php echo base_url('assets/js/plugins/jquery.dataTables.min.js') ?>"></script>
<script type='text/javascript' src="<?php echo base_url('assets/js/plugins/dataTables.bootstrap.min.js') ?>"></script>
<script type='text/javascript' src="<?php echo base_url('assets/js/jquery-ui.min.js') ?>"></script>


<script type='text/javascript'>
$('#sampleTable').DataTable();
var productsList = <?php echo json_encode($product_show_for_sale, JSON_PRETTY_PRINT) ?>;

//document.write(productsList);

$(document).ready(function() {
    $("#search_product").focus();

    /*---sound adding-------------------*/
    var obj = document.createElement("audio");
    var obj_warning = document.createElement("audio");
    obj.src = "<?php echo site_url('public/sounds/success.mp3') ?>";
    obj_warning.src = "<?php echo site_url('public/sounds/warning.mp3') ?>";
    obj.volume = 1.0;
    obj.autoPlay = false;
    obj.preLoad = true;
    /*---sound adding-------------------*/

    $("#search_product").autocomplete({
        source: "<?php echo site_url('pos/product_call') ?>",
        minLength: 1,
        //select: function(event, ui) {
        autoFocus: true,
        select: function(event, ui) {
            productAddToCart(ui.item.id, ui.item.total_stock);
            obj.play();
            $(this).val("");
            return false;
        }
    });

    var itemsInCart = [];
    var totalPrice = 0;

    $("#productSale").on("click", function() {

        var discountOnTotalPrice = $("#discountOnTotalPrice").text();
        var vatOnTotalPrice = $("#vatOnTotalPrice").text();
        var customer_type = $("#customer_type").val();
        var paid = $("#paid").val();
        var due = $("#due").val();

        if (customer_type == 'Walk-In-Customer' && due != 0) {
            alert("Due is not Allow for Walk-In Customer");
            $("#due").focus();
            return;
        }

        if (itemsInCart.length == 0) {
            alert("Please Add Product To Sale")
            //swal("Please Add Product To Sale");
            $("#search_product").focus();
            return;
        }
        if (due == "") {
            alert("Due is Empty")
            $("#paid").focus();
            return;
        }

        var itemsInCartObject = Object.assign({}, itemsInCart);
        //console.log(itemsInCartObject);
        var base_url = "<?php echo rtrim(base_url(), '/') ?>";

        var sales_process_url = "<?php echo site_url('pos/sale') ?>";
        $.ajax({
            url: sales_process_url,
            method: 'POST',
            dataType: "json",
            data: {
                cart_data: itemsInCartObject,
                discountOnTotalPrice,
                vatOnTotalPrice,
                customer_type,
                due,
                paid
            },
            success: function(data) {
                //console.log(data[0]);

                //$("#inVoiceAdd").modal('show');
                //$("#invoiceData").html(data);
                if (data.sales_id > 0) {
                    window.open(base_url + "/invoice/" + data.sales_id, "_blank");
                }
                location.reload();

                var index = $(this).data("index");
                itemsInCart.splice(index);
                drawTable();

                $('#discountOnTotalPrice').text('');
                $('#vatOnTotalPrice').text('');
                $('#paid').val('');
                $('#due').val('');
            },
            error: function() {
                alert('error');
            }
        });

    });

    //Product show Category-wise
    $("#product_category").change(function() {
        var product_category = $(this).val();

        var product_show_url = "<?php echo site_url('pos/products') ?>";
        $.ajax({
            url: product_show_url,
            method: 'POST',
            data: "product_category=" + product_category,
            success: function(data) {
                $(".all_products").html(data);
            },
            error: function() {
                alert('error');
            }
        });

    });


    $(".extra-fields").on("input", function() {
        totalCalculation();
    });

    $('body').on("input", ".product_quantity_change", function() {
        var index = $(this).data("id");
        var newQuantity = Number.parseInt($(this).val());
        var current_stock = Number.parseInt($(this).data('current_stock'));
        if (newQuantity < current_stock) {
            if (newQuantity < 1) {
                itemsInCart.splice(index, 1);
                obj_warning.play();
            } else {
                itemsInCart[index].quantity = newQuantity;
                obj.play();
            }
            drawTable();
        } else {
            itemsInCart[index].quantity = current_stock;
            $(this).val(current_stock);
            obj_warning.play();
            alert("Your Stock is Exceeded !");
        }
    });

    /* Product Delete Strat */
    $('body').on("click", ".btn_item_delete", function() {
        if (confirm("Really Want to Delete ?")) {
            var index = $(this).data("index");
            itemsInCart.splice(index, 1);
            drawTable();
            obj_warning.play();
        }
    });
    /* Product Delete End */

    /* Image e click kore product add kora strat */
    $('body').on("click", ".cart_item_image", function() {
        var product_id = $(this).data("id");
        var stock = Number.parseInt($(this).data('stock'));
        if (stock <= 0) {
            obj_warning.play();
            alert("Stock not Available for Sale");
            $(this).val("");
            return false;
        } else {
            productAddToCart(product_id, stock);
            obj.play();
        }
    });
    /* Image e click kore product add kora End */
    /*
    Cart Initialize the cart
    */
    function productAddToCart(product_id, stock) {
        $.each(productsList, function(key, value) {
            if (value.product_id == product_id) {
                var response = itemExist(product_id);
                if (response.inCart) {
                    if ((itemsInCart[response.productIndex].quantity + 1) <= stock) {
                        itemsInCart[response.productIndex].quantity = itemsInCart[response.productIndex]
                            .quantity + 1;
                    } else {
                        obj_warning.play();
                        alert("Your Stock is Exceeded ----------------!");
                    }
                } else {
                    value.quantity = 1;
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
        $("#totalPrice").html("0.00");
        totalPrice = 0;
        $.each(itemsInCart, function(key, item) {
            var totalBasePrice = parseInt(item.quantity) * parseFloat(item.selling_unit_price);
            var subTotalTax = parseFloat(totalBasePrice) * (parseFloat(item.tax_perchantage) / 100);
            var subtotalPrice = parseFloat(totalBasePrice) + subTotalTax;
            //var subtotalPrice = parseFloat(totalBasePrice);
            $("#cartTableBody").append('<tr>' +
                '<td>' + item.product_name + '</td>' +
                '<td>' + item.total_stock + '</td>' +
                '<td>' +
                '<input  data-current_stock="' + item.total_stock + '"  data-oldQuantity="' + item
                .quantity + '" data-id="' + key +
                '" class="product_quantity_change" type = "number"  size="4"' +
                'value="' + item.quantity +
                '" onkeypress="return accept_digit_only(event)" min="0"+ max="99999"/> ' +
                '</td>' +
                '<td>' + item.selling_unit_price + '</td>' +

                // '<td> ' + item.tax_perchantage + '% = ' + subTotalTax.toFixed(2) +
                '<td> ' + item.tax_perchantage + '%' +
                '<td>' +
                '<input type = text data-id="" data-toggle="modal" data-target="#tAXmodal"' +
                '+ value="' + subTotalTax.toFixed(2) + '"  size="6" >' +
                '</td>' +
                '<td class = "text-right" > ' + subtotalPrice.toFixed(2) +
                '<button  data-index="' + key +
                '" class="badge badge-danger badge-sm btn_item_delete">' +
                '<i class="fa fa-times"></i></button>' +
                '</td>' +
                '</tr>');
            totalPrice += subtotalPrice;
            //item.tax_perchantage.toFixed(2)
        });
        totalCalculation();
    }

    /*
    Calculate Table Total / SUbtotal
    */
    function totalCalculation() {
        var discountOnTotalPrice = $("#discountOnTotalPrice").text();
        if (discountOnTotalPrice != "") {
            discountOnTotalPrice = parseFloat((Number.isNaN(discountOnTotalPrice)) ? 0 : discountOnTotalPrice);
        } else {
            discountOnTotalPrice = 0;
        }
        var vatOnTotalPrice = $("#vatOnTotalPrice").text();
        if (vatOnTotalPrice != "") {
            vatOnTotalPrice = parseFloat((Number.isNaN(vatOnTotalPrice)) ? 0 : vatOnTotalPrice);
        } else {
            vatOnTotalPrice = 0;
        }
        var netTotalPrice = (totalPrice + vatOnTotalPrice) - discountOnTotalPrice;

        ///////////////////////////
        var paid = $("#paid").val();
        var due = netTotalPrice - paid;
        $("#due").val(due.toFixed(2));
        ////////////////////////////////
        $("#totalPrice").html(totalPrice.toFixed(2));
        $("#netTotalPrice").html(netTotalPrice.toFixed(2));
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

    ////////////////////New Customer Add//////////////////////////////
    var allowSubmit = true;

    //product_group_edit_form

    $('#CustomerModalEntry_Form').submit(function(event) {
        // stop the form from submitting the normal way and refreshing the page
        event.preventDefault();

        if (allowSubmit) {
            allowSubmit = false;
            //for modal close variable after submit
            var parentMOdal = $(this).closest('.modal');
            var postData = new FormData(this);
            $.ajax({
                    type: $(this).attr("method"),
                    url: $(this).attr("action"),
                    data: postData,
                    encode: true,
                    processData: false,
                    contentType: false,
                })
                .done(function(data) {
                    if (data == 1) {

                        //Modal Remove after submission
                        parentMOdal.modal('toggle');
                        //page refresh after submission
                        location.reload();
                    }

                });
        }

    });

    //.........................................................................

    // ...............For Date Show.............................
    $('.datePicker').datepicker({
        format: "dd/mm/yyyy",
        autoclose: true,
        todayHighlight: true
    });
    //.................For Date show end........................


    function calculateDiscount() {
        let totalPrice = parseFloat($("#totalPrice").text()) || 0;
        let discountType = $("#discountType").val();
        let discountValue = parseFloat($("#discountValue").val()) || 0;

        let discountPrice = 0;

        if (discountType === "%") {
            discountPrice = totalPrice * (discountValue / 100);
        } else if (discountType === "flat") {
            discountPrice = discountValue;
        }

        if (discountPrice < 0) discountPrice = 0;

        // set value into input box instead of span
        $("#discountOnTotalPrice").text(discountPrice.toFixed(2));
        totalCalculation(); // 🔥 update net total immediately
    }

    // Auto update when user types or changes values
    $("#totalPrice, #discountType, #discountValue").on("input change", calculateDiscount);

    // Run once on page load
    calculateDiscount();



    function calculateVat() {
        let totalPrice = parseFloat($("#totalPrice").text()) || 0;
        let vatType = $("#vatType").val();
        let vatValue = parseFloat($("#vatValue").val()) || 0;

        let totalVat = 0;

        if (vatType === "%") {
            totalVat = totalPrice * (vatValue / 100);
        } else if (vatType === "flat") {
            totalVat = vatValue;
        }

        if (totalVat < 0) totalVat = 0; // prevent negative
        // set value into input box instead of span
        $("#vatOnTotalPrice").text(totalVat.toFixed(2));
        totalCalculation(); // 🔥 update net total immediately
    }
    // Auto update when values change
    $("#discountType, #discountValue").on("input change", calculateDiscount);
    $("#vatType, #vatValue").on("input change", calculateVat);

    // Run once on page load
    calculateDiscount();
    calculateVat();


});
</script>

<style>
.discount-container {
    display: flex;
    align-items: center;
    gap: 5px;
    margin: 10px 0;
}

select,
input[type="number"] {
    padding: 6px;
    font-size: 14px;
    border: 1px solid #ccc;
    border-radius: 6px;
}

select {
    width: 70px;
    text-align: center;
}

input[type="number"] {
    width: 80px;
}

.result {
    margin-top: 15px;
    font-size: 16px;
    font-weight: bold;
}

/* Toggle switch styling */
.switch {
    position: relative;
    display: inline-block;
    width: 50px;
    height: 20px;
    vertical-align: middle;
    margin-right: 8px;
}

.switch input {
    opacity: 0;
    width: 0;
    height: 0;
}

.slider {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: #ccc;
    transition: 0.4s;
    border-radius: 20px;
}

.slider:before {
    position: absolute;
    content: "";
    height: 14px;
    width: 14px;
    left: 3px;
    bottom: 3px;
    background-color: white;
    transition: 0.4s;
    border-radius: 50%;
}

input:checked+.slider {
    background-color: #17a2b8;
}

input:checked+.slider:before {
    transform: translateX(30px);
}

.slider.round {
    border-radius: 20px;
}

/* Hide elements with this class */
.hide {
    display: none !important;
}

</style>


<?php
echo $this->endSection();
?>