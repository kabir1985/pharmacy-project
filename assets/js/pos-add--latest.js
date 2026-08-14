

let productsList = window.APP.productsList;

$(document).ready(function () {

    $("body").addClass("sidenav-toggled");

    setTimeout(function () {
        $("#search_product").focus();
    }, 200);

    //console.log(productsList)
    //################################Product Vat and Discount show/hide##############################//////////////////
    function toggleProductVatDiscount() {
        if ($("#ProductWiseVatAndDiscount").is(":checked")) {
            $(".productVatDiscountSection").slideDown(200);
        } else {
            $(".productVatDiscountSection").slideUp(200);
        }
    }

    // Initial state
    toggleProductVatDiscount();

    // On checkbox change
    $("#ProductWiseVatAndDiscount").change(function () {
        toggleProductVatDiscount();
    });
    /////////////#########################################################################///////////////////////////////////////////


    /*--- Sound -------------------*/
    const obj = new Audio(APP_URLS.successSound);
    const obj_warning = new Audio(APP_URLS.warningSound);

    obj.volume = 1.0;

    $("#search_product").autocomplete({

        source: function (request, response) {
            $.ajax({
                url: APP_URLS.productSearch,
                dataType: "json",
                data: {
                    term: request.term
                },
                success: function (data) {
                    response(data);
                }
            });
        },

        minLength: 1,
        delay: 150,
        autoFocus: true,

        open: function () {

            $(".ui-autocomplete").css({
                width: $(this).outerWidth() + "px"
            });

            // Focus first item
            var menu = $(this).autocomplete("instance").menu;
            menu.focus(null, menu.element.children("li:first"));

        },

        select: function (event, ui) {

            productAddToCart(ui.item.id, ui.item.total_stock);

            obj.play();

            $(this).val("");

            return false;
        }

    });

    // ==============================
    // Press Enter to add product
    // ==============================
    $("#search_product").keydown(function (e) {

        if (e.keyCode === 13) {

            e.preventDefault();

            var instance = $(this).autocomplete("instance");

            if (instance.menu.active) {

                instance.menu.select(e);

            }

        }

    });




    var itemsInCart = [];
    var subTotalCost = 0;

    $("#productSale").on("click", function () {

        var otherChargeOnTotalPrice = $("#otherChargeOnTotalPrice").text();

        var customer_id = $("#customer_id").val();

        var paid = $("#paid").val();
        var due = $("#due").val();


        if (customer_id === '' && parseFloat(due) > 0) {
            alert("Due is not allowed for Walk-In Customer.");
            $("#paid").focus();
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

        var itemsInCartObject = JSON.parse(JSON.stringify(itemsInCart)); // deep copy

        $.each(itemsInCartObject, function (key, item) {
            item.discount_on_each_product = parseFloat(item.discount_percent || 0);
            item.discount_type = item.discount_type || $("#productDiscountType").val();
            item.vat = parseFloat(item.vat_input || 0);

        });

        var hold_id = itemsInCartObject[0].hold_id || null; // take from first product if exists

        // var base_url = "<?php echo rtrim(base_url(), '/') ?>";

        // var sales_process_url = "<?php echo site_url('pos/sale') ?>";
        $.ajax({
            // url: sales_process_url,
            url: APP_URLS.posSale,
            method: 'POST',
            dataType: "json",
            data: {
                cart_data: itemsInCartObject,
                // discountOnAllPrice: parseFloat(discountOnAllPrice) || 0,
                otherChargeOnTotalPrice: parseFloat(otherChargeOnTotalPrice) || 0,
                customer_id: customer_id,
                due: parseFloat(due) || 0,
                paid: parseFloat(paid) || 0,
                hold_id: hold_id // ✅ send hold_id

            },
            success: function (data) {

                if (data.sales_id && data.sales_id > 0) {

                    // const url = base_url + "/invoice/" + data.sales_id;
                    const url = APP_URLS.invoiceBase + data.sales_id;

                    window.open(
                        url,
                        "Invoice_" + data.sales_id + "_" + Date.now(),
                        "width=900,height=800,left=150,top=50,toolbar=no,menubar=no,location=no,status=no,resizable=yes,scrollbars=yes"
                    );
                }

                itemsInCart = [];
                drawTable();

                // $('#discountOnAllPrice').text('');
                $('#otherChargeOnTotalPrice').text('');
                $('#paid').val('');
                $('#due').val('');

                // --- Remove held sale from list dynamically ---
                $(".resume-sale").each(function () {
                    if ($(this).data('id') == itemsInCartObject[0].hold_id) {
                        $(this).closest('li').remove();
                    }
                });

                location.reload(); // optional
            },
            error: function () {
                alert('error');
            }
        });

    });


    /////////////////////////////////////Sale HOLD Section//////////////////////////////////////////////////////////////

    $('#holdSale').on('click', function () {
        if (itemsInCart.length === 0) {
            alert('Cart is empty. Add products first!');
            return;
        }

        // Define these inside the function
        // var discountOnAllPrice = parseFloat($("#discountOnAllPrice").text()) || 0;
        var otherChargeOnTotalPrice = parseFloat($("#otherChargeOnTotalPrice").text()) || 0;
        var customer_id = $("#customer_id").val();

        var itemsInCartObject = Object.assign({}, itemsInCart);

        $.ajax({
            //url: '<?=site_url("pos/hold-sale")?>',
            url: APP_URLS.holdSale,
            method: 'POST',
            dataType: 'json',
            data: {
                cart_data: itemsInCartObject,
                //discountOnAllPrice: discountOnAllPrice,
                otherChargeOnTotalPrice: otherChargeOnTotalPrice,
                customer_id: customer_id
            },
            success: function (response) {
                if (response.status === 'success') {
                    alert('Sale has been put on hold!');

                    // clear current cart
                    itemsInCart = [];
                    drawTable();

                    // ---------------- FIX: ensure resume list exists ----------------
                    if ($(".held-sale-list").length === 0) {
                        $("#heldSaleSection").html(`
                <ul class="list-group held-sale-list"></ul>
            `);
                    }

                    // ---------------- UI UPDATE WITHOUT REFRESH ----------------
                    let li = `
<li class="list-group-item d-flex justify-content-between align-items-center">
    <div>
        <strong>${response.hold_id}</strong><br>
        <small>${response.customer_id}</small>
    </div>

    <div class="btn-group">
        <a href="javascript:void(0)"
           class="btn btn-sm btn-primary resume-sale"
           data-id="${response.id}">
            Resume
        </a>

        <a href="javascript:void(0)"
           class="btn btn-sm btn-danger delete-held-sale"
           data-id="${response.id}">
            <i class="fa fa-trash"></i>
        </a>
    </div>
</li>`;

                    $(".held-sale-list").prepend(li);
                    // ------------------------------------------------------------

                } else {
                    alert('Failed to hold the sale!');
                }
            },
            error: function (xhr, status, error) {
                console.error(xhr.responseText);
                alert('AJAX error: ' + error);
            }
        });
    });

    //==========================Delete from HOld============================================
    $(document).on("click", ".delete-held-sale", function () {

        if (!confirm("Delete this held sale?")) {
            return;
        }

        let id = $(this).data("id");
        let row = $(this).closest("li");

        $.ajax({

            // url: "<?=site_url('pos/delete-held-sale')?>/" + id,
            url: APP_URLS.deleteHoldSale + "/" + id,
            type: "POST",
            dataType: "json",

            success: function (res) {

                if (res.status == "success") {

                    row.remove();

                } else {

                    alert(res.message);

                }

            },

            error: function () {

                alert("Unable to delete.");

            }

        });

    });

    // ===================== Resume Sale =====================
    $(document).on('click', '.resume-sale', function () {

        let saleId = $(this).data('id');
        let $clickedButton = $(this);

        $.ajax({
            // url: '<?=site_url("pos/resume-sale")?>/' + saleId,
            url: APP_URLS.resumeSale + "/" + saleId,
            type: 'POST',
            dataType: 'json',

            success: function (res) {

                if (res.status === 'success') {

                    // Restore Cart
                    itemsInCart = res.cart_data || [];

                    // Attach Hold ID to every item
                    $.each(itemsInCart, function (i, item) {
                        item.hold_id = saleId;
                    });

                    // Restore Other Charge
                    otherChargeOnTotalPrice = parseFloat(res.otherChargeOnTotalPrice) || 0;
                    $('#otherChargeValue').val(otherChargeOnTotalPrice);

                    // Restore Customer
                    let customerId = res.customer_id ? res.customer_id : '';

                    $('#customer_id')
                        .val(null)
                        .trigger('change');

                    $('#customer_id')
                        .val(customerId)
                        .trigger('change');

                    // Draw Cart
                    drawTable();

                    // Recalculate Totals
                    calculateotherCharge();

                    // Remove resumed sale from Held Sale list
                    $clickedButton.closest('li').remove();

                    alert('Sale resumed successfully.');

                } else {

                    alert(res.message);

                }

            },

            error: function (xhr) {

                console.log(xhr.responseText);
                alert('Unable to resume sale.');

            }

        });

    });

    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //Product show Category-wise
    $("#product_category").change(function () {
        var product_category = $(this).val();

        //var product_show_url = "<?php echo site_url('pos/filterProducts') ?>";
        var product_show_url = APP_URLS.filterProduct;
        $.ajax({
            url: product_show_url,
            method: 'POST',
            data: "product_category=" + product_category,
            success: function (data) {
                $(".all_products").html(data);
            },
            error: function () {
                alert('error');
            }
        });

    });


    $(".extra-fields").on("input", function () {
        totalCalculation();
    });

    $('body').on("input", ".product_quantity_change", function () {

        let index = $(this).data("id");
        let qty = parseFloat($(this).val()) || 0;
        let stock = parseFloat($(this).data("current_stock"));

        if (qty <= 0) {
            itemsInCart.splice(index, 1);
            drawTable(); // Only when deleting a row
            return;
        }

        if (qty > stock) {
            qty = stock;
            $(this).val(stock);
            obj_warning.play();
            alert("Your Stock is Exceeded!");
        }

        itemsInCart[index].quantity = qty;
        //=====================================================
        if (itemsInCart[index].hold_id) {

            $.ajax({
                // url: "<?=site_url('pos/update-hold-sale')?>",
                url: APP_URLS.updateHoldSale,
                type: "POST",
                data: {
                    id: itemsInCart[index].hold_id,
                    cart_data: itemsInCart
                }
            });

        }
        //===========================================================

        updateRow(index); // Smooth update only
    });

    /* Product Delete Strat */
    $('body').on("click", ".btn_item_delete", function () {

        if (!confirm("Really Want to Delete?")) {
            return;
        }

        var index = $(this).data("index");
        var holdId = itemsInCart[index].hold_id || 0;

        itemsInCart.splice(index, 1);

        if (holdId > 0) {

            $.ajax({
                // url: "<?=site_url('pos/update-hold-sale')?>",
                url: APP_URLS.updateHoldSale,
                type: "POST",
                dataType: "json",
                data: {
                    id: holdId,
                    cart_data: itemsInCart
                },
                success: function (res) {
                    drawTable();
                    obj_warning.play();
                }
            });

        } else {

            drawTable();
            obj_warning.play();

        }

    });
    /* Product Delete End */


    // VAT and Discount toggle handler
    $("#ProductWiseVatAndDiscount").on('change', function () {
        var enabled = $(this).is(":checked");
        toggleVatAndDiscount(enabled);
    });


    /* Image e click kore product add kora strat */
    $('body').on("click", ".cart_item_image", function () {
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

    $.each(productsList, function (key, value) {

        if (value.product_id == product_id) {

            const response = itemExist(product_id);

            if (response.inCart) {

                if (
                    (parseFloat(itemsInCart[response.productIndex].quantity) + 1)
                    <= stock
                ) {

                    itemsInCart[response.productIndex].quantity++;

                } else {

                    obj_warning.play();
                    alert("Your Stock is Exceeded!");
                }

            } else {

                const cartItem = JSON.parse(JSON.stringify(value));

                cartItem.quantity = 1;

                itemsInCart.push(cartItem);
            }

            drawTable();
        }
    });
}

$(document).on("input", ".sale_price_change", function () {

    const index = $(this).data("id");

    if (!itemsInCart[index]) {
        return;
    }

    const sellingUnitPrice =
        parseFloat($(this).val()) || 0;

    itemsInCart[index].selling_unit_price =
        sellingUnitPrice;

    if (itemsInCart[index].hold_id) {

        $.ajax({
            url: APP_URLS.update_hold_sale,
            type: "POST",
            data: {
                id: itemsInCart[index].hold_id,
                cart_data: itemsInCart
            }
        });
    }

    updateRow(index);
});



    $(document).on("input", ".vat_input", function () {

        let index = $(this).closest("tr").find(".btn_item_delete").data("index");

        itemsInCart[index].vat_input = parseFloat($(this).val()) || 0;
        ///===============================================================
        if (itemsInCart[index].hold_id) {

            $.ajax({
                //url: "<?=site_url('pos/update_hold_sale')?>",
                url: APP_URLS.update_hold_sale,
                type: "POST",
                data: {
                    id: itemsInCart[index].hold_id,
                    cart_data: itemsInCart
                }
            });

        }
        //======================================================================

        updateRow(index);
    });

    $(document).on("input", ".discount_percent", function () {

        let index = $(this).closest("tr").find(".btn_item_delete").data("index");

        itemsInCart[index].discount_percent = parseFloat($(this).val()) || 0;
        //=============================================================================
        if (itemsInCart[index].hold_id) {

            $.ajax({
                //url: "<?=site_url('pos/update_hold_sale')?>",
                url: APP_URLS.update_hold_sale,
                type: "POST",
                data: {
                    id: itemsInCart[index].hold_id,
                    cart_data: itemsInCart
                }
            });

        }
        //===============================================================================

        updateRow(index);
    });


    /////##############################################################


function getSellingUnitPrice(item) {
    return parseFloat(item.selling_unit_price) || 0;
}




    function updateRow(index) {

        const item = itemsInCart[index];
        if (!item) return;

        // let subtotal =
        //     (parseFloat(item.quantity) || 0) *
        //     (parseFloat(item.selling_price) || 0);


        let qty =
            parseFloat(item.quantity) || 0;

        // IMPORTANT
        // Use calculated selling unit price
        let sellingUnitPrice = getSellingUnitPrice(item);

        // Base total
        let subtotal = qty * sellingUnitPrice;


        if ($("#ProductWiseVatAndDiscount").is(":checked")) {

            const vat = parseFloat(item.vat_input) || 0;
            const discount = parseFloat(item.discount_percent) || 0;

            subtotal += subtotal * vat / 100;
            //subtotal -= subtotal * discount / 100;

            if (item.discount_type === "%") {
                subtotal -= subtotal * discount / 100;
            } else {
                subtotal -= discount;
            }

        }

        const $row = $('.product_quantity_change[data-id="' + index + '"]').closest('tr');

        if ($row.length) {
            $row.find(".subtotal_td").text(subtotal.toFixed(2));
        }

        updateGrandTotal();
    }

    function updateGrandTotal() {

        subTotalCost = 0;

        itemsInCart.forEach(function (item) {

            //let subtotal = item.quantity * item.selling_price;
            // let subtotal = (parseFloat(item.quantity) || 0) * (parseFloat(item
            //     .selling_price) || 0);

            let qty = parseFloat(item.quantity) || 0;

            let sellingUnitPrice = getSellingUnitPrice(item);

            let subtotal = qty * sellingUnitPrice;

            subTotalCost += subtotal;
        });

        totalCalculation();
    }
    /////###############################################################


    /*
    Draw / Redraw Table
    */
    function drawTable() {
        $("#cartTableBody").empty();
        $("#subTotalCost").html("0.00");
        subTotalCost = 0;
        $.each(itemsInCart, function (key, item) {

            // var baseTotal = parseInt(item.quantity) * parseFloat(item.selling_price);
            // var baseTotal = (parseFloat(item.quantity) || 0) * (parseFloat(item
            //     .selling_price) || 0);
            // var subtotalPrice = baseTotal; // default, no VAT/Discount

let qty = parseFloat(item.quantity) || 0;

let sellingUnitPrice = getSellingUnitPrice(item);

//alert('Selling Unit Price: ' + sellingUnitPrice);

let baseTotal = qty * sellingUnitPrice;

let subtotalPrice = baseTotal; // default, no VAT/Discount

            // Add to total
            subTotalCost += subtotalPrice;

            // Append Row
            $("#cartTableBody").append(`
<tr>

    <!-- Product Name -->
    <td>${item.product_name}</td>

    <!-- Current Stock -->
    <td class="text-center">${item.total_stock}</td>

    <!-- Quantity -->
    <td class="text-center">
        <input
            type="number"
            class="product_quantity_change form-control form-control-sm text-center"
            data-current_stock="${item.total_stock}"
            data-oldQuantity="${item.quantity}"
            data-id="${key}"
            value="${item.quantity}"
            min="0"
            max="99999"
            onkeypress="return accept_digit_only(event)">
    </td>

<!-- Selling Unit Price -->
<td class="d-flex justify-content-center">
    <input
        type="number"
        step="0.01"
        min="0"
        inputmode="decimal"
        class="form-control form-control-sm sale_price_change text-center"
        data-id="${key}"
        name="selling_unit_price"
        value="${getSellingUnitPrice(item).toFixed(2)}">
</td>

    <!-- VAT -->
    <!--- <td class="vat-column hide">-->
       <!---  <input-->
        <!---     type="number"class="vat_input form-control form-control-sm text-center" data-id="${key}" value="${item.vat_input || 0}">-->
  <!---   </td>-->

    <!-- Discount -->
    <td class="discount-column hide">
        <input
            type="number"
            class="discount_percent form-control form-control-sm text-center"
            data-id="${key}"
            value="${item.discount_percent || 0}">
    </td>

    <!-- Purchase Price -->
    <td class="text-end">
        ${parseFloat(item.purchase_price_with_vat || 0).toFixed(2)}
    </td>

    <!-- Subtotal -->
    <td class="text-end subtotal_td">
        ${subtotalPrice.toFixed(2)}
    </td>

    <!-- Action -->
    <td class="text-center">
        <button
            type="button"
            class="btn btn-danger btn-sm btn_item_delete"
            data-index="${key}">
            <i class="fa fa-trash"></i>
        </button>
    </td>

</tr>
`);

        });
        totalCalculation();
        // Show/hide VAT and Discount columns and inputs based on toggle state
        toggleVatAndDiscount($("#ProductWiseVatAndDiscount").is(":checked"));

    }

    // Show or hide VAT and Discount UI elements
    function toggleVatAndDiscount(show) {
        if (show) {
            $("th.vat-column-header, td.vat-column").removeClass('hide');
            $("th.discount-column-header, td.discount-column").removeClass('hide');
            $(".vat_input, .discount_percent").prop("disabled", false);
        } else {
            $("th.vat-column-header, td.vat-column").addClass('hide');
            $("th.discount-column-header, td.discount-column").addClass('hide');
            $(".vat_input, .discount_percent").prop("disabled", true);
        }
    }

    /*
    Calculate Table Total / SUbtotal
    */
    function totalCalculation() {

        let otherChargeOnTotalPrice = $("#otherChargeOnTotalPrice").text();
        if (otherChargeOnTotalPrice != "") {
            otherChargeOnTotalPrice = parseFloat((Number.isNaN(otherChargeOnTotalPrice)) ? 0 :
                otherChargeOnTotalPrice);
        } else {
            otherChargeOnTotalPrice = 0;
        }

        //////////////////////////////////////////////////
        let subTotalCost = 0;
        let productTotalVat = 0;
        let productTotalDiscount = 0;

        itemsInCart.forEach(function (item) {

            // let qty = parseFloat(item.quantity) || 0;
            // let price = parseFloat(item.selling_price) || 0;

            // // Basic subtotal (without VAT & Discount)
            // let lineTotal = qty * price;

            let qty = parseFloat(item.quantity) || 0;

            // IMPORTANT
            // Do NOT use item.selling_price here
            let sellingUnitPrice = getSellingUnitPrice(item);

            // Example:
            // selling_price = 120
            // quantity_per_pack = 10
            // box_quantity = 1
            //
            // sellingUnitPrice = 120 / (10 * 1)
            //                   = 12

            let lineTotal =
                qty * sellingUnitPrice;



            subTotalCost += lineTotal;

            if ($("#ProductWiseVatAndDiscount").is(":checked")) {

                let vatPercent = parseFloat(item.vat_input) || 0;
                let vatAmount = lineTotal * vatPercent / 100;


                // let discountPercent = parseFloat(item.discount_percent) || 0;
                // let discountAmount = lineTotal * discountPercent / 100;

                let discount = parseFloat(item.discount_percent) || 0;
                let discountAmount = 0;

                if (item.discount_type === "%") {
                    discountAmount = lineTotal * discount / 100;
                } else {
                    discountAmount = discount;
                }

                productTotalVat += vatAmount;
                productTotalDiscount += discountAmount;
            }

        });
        ////////////////////////////////////////////////

        let netTotalPrice = Math.round(
            subTotalCost - productTotalDiscount + productTotalVat + otherChargeOnTotalPrice
        );


        let paid = parseFloat($("#paid").val()) || 0;
        let due = Math.round(netTotalPrice - paid);

        $("#due").val(due);


        $("#subTotalCost").html(subTotalCost.toFixed(2));
        $("#productDiscount").html(productTotalDiscount.toFixed(2));
        $("#productVat").html(productTotalVat.toFixed(2));
        $("#netTotalPrice").html(netTotalPrice.toFixed(2));
    }
    /*
    Chek Is the selected Item Exist in List
    */
    function itemExist(product_id) {
        let response = {
            inCart: false,
            productIndex: null
        };
        $.each(itemsInCart, function (key, item) {
            if (item.product_id == product_id) {
                if (!response.inCart) {
                    response.inCart = true;
                    response.productIndex = key;
                }
            }
        });
        return response;
    }


    $("#discount_apply, #productDiscountType").on("input change", function () {

        let value = parseFloat($("#discount_apply").val()) || 0;
        let type = $("#productDiscountType").val();

        if (itemsInCart.length === 0) return;

        // Calculate current subtotal
        let subTotal = 0;
        itemsInCart.forEach(function (item) {
            // subTotal += (parseFloat(item.quantity) || 0) *
            //     (parseFloat(item.selling_price) || 0);

               let qty = parseFloat(item.quantity) || 0;

    let sellingUnitPrice = getSellingUnitPrice(item);

    subTotal += qty * sellingUnitPrice;
        });

        if (type === "%") {

            // Percentage cannot exceed 50
            if (value > 50) {
                value = 50;
                $("#discount_apply").val(50);
                alert("Discount percentage cannot exceed 50%.");
            }

        } else {

            let maxDiscount = subTotal / 2;

            if (value > maxDiscount) {
                value = maxDiscount;
                $("#discount_apply").val(maxDiscount.toFixed(2));
                alert("Discount cannot be greater than 50% of the Sub Total.");
            }
        }

        // itemsInCart.forEach(function (item) {
        //     item.discount_type = type;
        //     item.discount_percent = value;
        // });
        itemsInCart.forEach(function (item) {
            item.discount_type = type;

            if (type === "%") {
                item.discount_percent = value;
            } else {
                // item.discount_percent = value / itemsInCart.length;
                item.discount_percent = +(value / itemsInCart.length).toFixed(2);
            }
        });

        drawTable();
    });

    $("#productDiscountType").on("change", function () {
        $(".discount-column-header").text(
            $(this).val() === "%" ? "Disc %" : "Disc"
        );
    });
    //=========================================================================================



    ////////////////////New Customer Add//////////////////////////////
    let allowSubmit = true;

    //product_group_edit_form

    $('#CustomerModalEntry_Form').submit(function (event) {
        // stop the form from submitting the normal way and refreshing the page
        event.preventDefault();

        if (allowSubmit) {
            allowSubmit = false;
            //for modal close variable after submit
            let parentMOdal = $(this).closest('.modal');
            let postData = new FormData(this);
            $.ajax({
                type: $(this).attr("method"),
                url: $(this).attr("action"),
                data: postData,
                encode: true,
                processData: false,
                contentType: false,
            })
                .done(function (data) {
                    if (data == 1) {
                        parentMOdal.modal('toggle');
                        location.reload();
                    } else if (data == "duplicate") {
                        alert("Customer already exists with same Phone or Email");
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


    function calculateotherCharge() {
        let subTotalCost = parseFloat($("#subTotalCost").text()) || 0;
        let otherCharge = $("#otherCharge").val();
        let otherChargeValue = parseFloat($("#otherChargeValue").val()) || 0;

        let totalVat = 0;

        if (otherCharge === "%") {
            totalVat = subTotalCost * (otherChargeValue / 100);
        } else if (otherCharge === "flat") {
            totalVat = otherChargeValue;
        }

        if (totalVat < 0) totalVat = 0; // prevent negative
        // set value into input box instead of span
        $("#otherChargeOnTotalPrice").text(totalVat.toFixed(2));
        totalCalculation(); // 🔥 update net total immediately
    }
    // Auto update when values change
    // $("#discountType, #discountOnAllValue").on("input change", calculateDiscountOnAll);
    $("#otherCharge, #otherChargeValue").on("input change", calculateotherCharge);

    // Run once on page load
    // calculateDiscountOnAll();
    calculateotherCharge();

});