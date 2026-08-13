const productsList = APP.data.productsList;

//console.table(productsList);

$(document).ready(function() {

//alert("i am product-purchase.js page");
    // console.log("kaiirsdffsdfdsfdsfdsfs");

    // console.log(productsList.find(p => p.product_id == product_id));

    $("body").addClass("sidenav-toggled");

    // =========================================================================
    // Variables
    // =========================================================================

    let itemsInCart = [];
    let totalPrice = 0;

    // =========================================================================
    // Helper Functions
    // =========================================================================

    function enableButton() {
        const supplier = $("#supplier_id").val();
        const hasItems = itemsInCart.length > 0;

        $("#productPurchase").prop("disabled", !(supplier && hasItems));
    }


    function getDiscountValue(item) {
        return item.discount_type === "fixed" ?
            (item.discount_fixed || 0) :
            (item.discount_percent || 0);
    }



    function calculateRow(item) {

        let qty = (Number(item.quantity_per_pack) || 0) *
            (Number(item.box_quantity) || 1);

        let unitPrice = Number(item.purchase_price_without_vat) || 0;

        let purchaseTotal = qty * unitPrice;

        // Product Discount
        let discount = 0;

        if (item.discount_type === "fixed") {
            discount = Number(item.discount_fixed) || 0;
        } else {
            discount = purchaseTotal * (Number(item.discount_percent) || 0) / 100;
        }

        let taxable = Math.max(0, purchaseTotal - discount);

        // Product VAT
        let vat = taxable * (Number(item.tax_percentage) || 0) / 100;

        let subtotal = taxable + vat;

        return {
            purchaseTotal,
            discount,
            taxable,
            vat,
            subtotal,
            tradePrice: unitPrice * (Number(item.quantity_per_pack) || 0)
        };
    }


    function updateGrandTotal() {

        let totalPrice = 0;
        let totalVat = 0;
        let totalDiscount = 0;

        itemsInCart.forEach(function(item) {

            let c = calculateRow(item);

            totalPrice += c.purchaseTotal;
            totalVat += c.vat;
            totalDiscount += c.discount;
        });

        $("#totalPrice").data("value", totalPrice).text(totalPrice.toFixed(2));

        $("#discount_on_total_price")
            .data("value", totalDiscount)
            .text(totalDiscount.toFixed(2));

        $("#vat_amt_on_total")
            .data("value", totalVat)
            .text(totalVat.toFixed(2));

        recalcNetTotal();
    }



    function recalcNetTotal() {

        let totalPrice =
            parseFloat($("#totalPrice").data("value")) || 0;

        let discount =
            parseFloat($("#discount_on_total_price").data("value")) || 0;

        let vat =
            parseFloat($("#vat_amt_on_total").data("value")) || 0;

        let taxable = totalPrice - discount;

        if (taxable < 0)
            taxable = 0;

        let netTotal = taxable + vat;

        $("#taxableAmount").text(taxable.toFixed(2));

        $("#netTotalPrice")
            .html("<strong>" + netTotal.toFixed(2) + "</strong>");
    }



    function updateRow(index, skipTradePrice = false) {

        let item = itemsInCart[index];

        let calc = calculateRow(item);

        let row = $("#cartTableBody tr[data-index='" + index + "']");

        // Update Buying Price
        row.find(".purchase_price_no_vat")
            .val(parseFloat(item.purchase_price_without_vat).toFixed(2));

        // Update Trade Price (unless currently typing in it)
        if (!skipTradePrice) {
            row.find(".trade_price_per_box")
                .val(calc.tradePrice.toFixed(2));
        }

        row.find(".vatAmount")
            .text(calc.vat.toFixed(2));

        row.find(".rowTotal")
            .text(calc.subtotal.toFixed(2));


        // Update Grand Total
        updateGrandTotal();
    }



    function totalCalculation() {

        $("#totalPrice")
            .data("value", totalPrice) // ✅ store raw number
            .text(totalPrice.toFixed(2)); // display only

        updateLivePreview();
        recalcNetTotal();
    }


    function updateLivePreview() {

        var total = parseFloat($("#totalPrice").data("value")) || 0;
        var discountValue = 0;

        if ($("#fixedType").is(":checked")) {

            let fixed = parseFloat($("#fixedAmount").val()) || 0;

            // Total discount = fixed amount × number of products
            discountValue = fixed * itemsInCart.length;

        } else {

            var percent = parseFloat($("#percentAmount").val()) || 0;

            discountValue = (total * percent) / 100;
        }

        $("#discount_on_total_price")
            .data("value", discountValue)
            .text(discountValue.toFixed(2));

        recalcNetTotal();
    }


    // =========================================================================
    // Drawing Functions
    // =========================================================================

    // ================= DRAW TABLE ================= //
//     function drawTable() {

//         const tbody = $("#cartTableBody");
//         tbody.empty();

//         let rows = "";

//         $.each(itemsInCart, function(key, item) {

//             var qtyPerPack = Number(item.quantity_per_pack) || 0;
//             var Boxqty = Number(item.box_quantity) || 1;
//             var UnitPrice = Number(item.purchase_price_without_vat) || 0;

//             var Trade_Price_Per_Box = qtyPerPack * UnitPrice;

//             let calc = calculateRow(item);

//             let vatAfterDiscount = calc.vat;
//             let rowTotal = calc.subtotal;

//             rows += `<tr data-index="${key}">
//         <td>${item.product_name}</td>
//         <td>${item.total_stock}</td>

// <!---------- QtyPerBox----------------------->
// <td>
//     <input
//         data-id="${key}"
//         class="product_quantity_change form-control form-control-sm w-100"
//         type="number"
//         step="any"
//         value="${item.quantity_per_pack || 1}">
// </td>
// <!--------------------BoxQty-------------------------------->
// <td>
//     <input
//         data-id="${key}"
//         class="product_boxqty_change form-control form-control-sm"
//         type="number"
//         min="1"
//         step="any"
//         value="${item.box_quantity || 1}">
// </td>


// <!---------------- Unit Price------------------------------>
// <td>
//     <input
//         type="text"
//         class="purchase_price_no_vat form-control form-control-sm w-100"
//         value="${item.purchase_price_without_vat || 1}"
//         min="1"
//         data-id="${key}" readonly>
// </td>


// <!----------------Trade Price Per Box-------------------------------------->
// <td style="min-width:70px;">
// <input
//     type="text"
//     class="trade_price_per_box form-control form-control-sm text-end"
//     value="${parseFloat(Trade_Price_Per_Box).toFixed(2)}"
//     data-id="${key}">
// </td>

// <!----------------Free Qty-------------------------------------->
// <td>
//     <input style="min-width: 50px;"
//     type="number"
//     class="free_qty form-control form-control-sm"
//     data-id="${key}"
//     min="0"
//     value="${item.free_qty || 0}">
//  </td>


// <td>
//     <input
//         type="text"
//         class="vat-input form-control form-control-sm"
//         min="0"
//         value="${item.tax_percentage || 0}"
//         data-id="${key}">
// </td>

// <td class="vatAmount"> ${vatAfterDiscount.toFixed(2)}</td>

// <td>
//     <input
//         type="text"
//         class="sale_price form-control form-control-sm"
//         value="${item.selling_price || 0}"
//         data-id="${key}"
//         >
// </td>

// <td>
// <input
// type="text"
// class="discount_percent form-control form-control-sm"
// value="${getDiscountValue(item)}"
// data-id="${key}">
// </td>

// <td class="text-end rowTotal">
// ${rowTotal.toFixed(2)}
// </td>

// <td>
//     <button
//         data-index="${key}"
//         class="btn btn-sm btn-danger btn_item_delete">
//         ×
//     </button>
// </td>

//     </tr>`;
//         });

//         tbody.html(rows);

//         updateGrandTotal();
//         enableButton();
//     }



// ================= DRAW TABLE ================= //
function drawTable() {

    const tbody = $("#cartTableBody");
    tbody.empty();

    let rows = "";

    $.each(itemsInCart, function(key, item) {

        const qtyPerPack = Number(item.quantity_per_pack) || 1;
        const Boxqty = Number(item.box_quantity) || 1;
        const UnitPrice = Number(item.purchase_price_without_vat) || 0;

        const Trade_Price_Per_Box = qtyPerPack * UnitPrice;

        let calc = calculateRow(item);

        let vatAfterDiscount = calc.vat;
        let rowTotal = calc.subtotal;

        rows += `
        <tr data-index="${key}">

            <!-- Product -->
            <td>${item.product_name}</td>

            <!-- Stock -->
            <td>${Number(item.total_stock || 0).toFixed(2)}</td>

            <!-- Qty Per Box -->
            <td>
                <input
                    data-id="${key}"
                    class="product_quantity_change form-control form-control-sm w-100"
                    type="number"
                    min="1"
                    step="any"
                    value="${qtyPerPack}">
            </td>

            <!-- Box Qty -->
            <td>
                <input
                    data-id="${key}"
                    class="product_boxqty_change form-control form-control-sm"
                    type="number"
                    min="1"
                    step="any"
                    value="${Boxqty}">
            </td>

            <!-- Unit Purchase Price -->
            <td>
                <input
                    type="text"
                    class="purchase_price_no_vat form-control form-control-sm w-100"
                    value="${UnitPrice.toFixed(2)}"
                    min="0"
                    data-id="${key}"
                    readonly>
            </td>

            <!-- Trade Price Per Box -->
            <td style="min-width:70px;">
                <input
                    type="text"
                    class="trade_price_per_box form-control form-control-sm text-end"
                    value="${Trade_Price_Per_Box.toFixed(2)}"
                    data-id="${key}"
                    >
            </td>

            <!-- Free Qty -->
            <td>
                <input
                    style="min-width:50px;"
                    type="number"
                    class="free_qty form-control form-control-sm"
                    data-id="${key}"
                    min="0"
                    step="any"
                    value="${Number(item.free_qty || 0)}">
            </td>

            <!-- VAT % -->
            <td>
                <input
                    type="text"
                    class="vat-input form-control form-control-sm"
                    min="0"
                    step="any"
                    value="${Number(item.tax_percentage || 0)}"
                    data-id="${key}">
            </td>

            <!-- VAT Amount -->
            <td class="vatAmount">
                ${vatAfterDiscount.toFixed(2)}
            </td>

            <!-- SELLING PRICE -->
            <td>
                <input
                    type="number"
                    class="sale_price form-control form-control-sm"
                    value="${item.selling_price !== undefined && item.selling_price !== null
                        ? item.selling_price
                        : ''}"
                    data-id="${key}"
                    min="0"
                    step="0.01"
                    placeholder="Enter S.Price">
            </td>

            <!-- Discount % -->
            <td>
                <input
                    type="text"
                    class="discount_percent form-control form-control-sm"
                    value="${getDiscountValue(item)}"
                    data-id="${key}">
            </td>

            <!-- Sub Total -->
            <td class="text-end rowTotal">
                ${rowTotal.toFixed(2)}
            </td>

            <!-- Delete -->
            <td>
                <button
                    type="button"
                    data-index="${key}"
                    class="btn btn-sm btn-danger btn_item_delete">
                    ×
                </button>
            </td>

        </tr>`;
    });

    tbody.html(rows);

    updateGrandTotal();
    enableButton();
}



    // =========================================================================
    // Product Functions
    // =========================================================================
    // ================= ADD PRODUCT ================= //

    function addProductToCart(product_id) {

        console.log("Draw Item:", itemsInCart[0]);

        var found = false;

        $.each(itemsInCart, function(key, item) {
            if (item.product_id == product_id) {
                item.quantity_per_pack += 1;
                found = true;
                return false;
            }
        });

        if (!found) {
            $.each(productsList, function(key, product) {
                if (product.product_id == product_id) {

                    product.quantity_per_pack = 1;
                    product.discount_percent = 0;
                    //  product.tax_percentage = 0;
                    product.box_quantity = 1;
                    // console.log('kabir');
                    // console.log(product);
                    // console.log(product.purchase_price_without_vat);

                    // itemsInCart.push(product);
                    itemsInCart.push({
                        ...product,
                        quantity_per_pack: 1,
                        discount_percent: 0,
                        box_quantity: 1,
                        free_qty: 0 // ✅ Add this
                    });

                    console.log("Product:", product);
                    console.log("Cart:", itemsInCart[itemsInCart.length - 1]);

                    return false;
                }
            });
        }

        drawTable();
    }


    // =========================================================================
    // Supplier Events
    // =========================================================================

    $("#supplier_id").on("change", enableButton);

    // =========================================================================
    // Cart Events
    // =========================================================================


    // ================= EVENTS ================= //

    $(document).on("input", ".product_quantity_change", function() {

        let index = $(this).data("id");

        let qty = parseFloat($(this).val()) || 1;

        // Save new Qty Per Box
        itemsInCart[index].quantity_per_pack = qty;

        // Read current Trade Price Per Box from the row
        let tradePrice = parseFloat(
            $("#cartTableBody tr[data-index='" + index + "']")
            .find(".trade_price_per_box")
            .val()
        ) || 0;

        // Buying Price = Trade Price / Qty Per Box
        itemsInCart[index].purchase_price_without_vat = tradePrice / qty;

        updateRow(index);

    });

    $(document).on("input", ".product_boxqty_change", function() {

        let index = $(this).data("id");

        itemsInCart[index].box_quantity = Number($(this).val()) || 0;

        updateRow(index);

    });

    $(document).on("input", ".trade_price_per_box", function() {

        let index = $(this).data("id");

        let tradePrice = Number($(this).val()) || 0;

        let qty = Number(itemsInCart[index].quantity_per_pack) || 1;

        itemsInCart[index].purchase_price_without_vat = tradePrice / qty;

        updateRow(index, true);

    });



    $(document).on("input", ".purchase_price_no_vat", function() {
        var index = $(this).closest("tr").data("index");
        var newPrice = Number($(this).val()) || 0;

        // itemsInCart[index].purchase_price_without_vat = newPrice;

        // drawTable();

        itemsInCart[index].purchase_price_without_vat = newPrice;

        updateRow(index);
    });

    $(document).on("input", ".free_qty", function() {
        const index = $(this).data("id");

        itemsInCart[index].free_qty = Number($(this).val()) || 0;

        //console.log(itemsInCart);

        updateRow(index); // or updateRow(index)
    });




    $(document).on("input", ".sale_price", function () {

        const key = $(this).data("id");
    
        itemsInCart[key].selling_price =
            parseFloat($(this).val()) || 0;
    });



    $(document).on("input", ".vat-input", function() {

        let index = $(this).data("id");

        itemsInCart[index].tax_percentage = Number($(this).val()) || 0;

        updateRow(index);

    });


    $(document).on("input", ".discount_percent", function() {

        let index = $(this).data("id");
        let value = Number($(this).val()) || 0;

        if (itemsInCart[index].discount_type === "fixed") {
            itemsInCart[index].discount_fixed = value;
        } else {
            itemsInCart[index].discount_percent = value;
        }

        updateRow(index);
    });

    $(document).on("click", ".btn_item_delete", function() {
        var index = $(this).data("index");
        itemsInCart.splice(index, 1);
        drawTable();
    });


    // Live update when typing
    $("#fixedAmount").on("input", updateLivePreview);
    $("#percentAmount").on("input", updateLivePreview);

    // Show/Hide Fixed & Percent Input
    $("input[name='discountType']").on("change", function() {

        if ($("#fixedType").is(":checked")) {
            $("#fixedInput").removeClass("d-none");
            $("#percentInput").addClass("d-none");
        } else {
            $("#fixedInput").addClass("d-none");
            $("#percentInput").removeClass("d-none");
        }

        updateLivePreview();
    });


    // =========================================================================
    // VAT Modal
    // =========================================================================

    // $("#openVatModal").on("click", function() {
    //     var currentVat = $("#vat_amt_on_total").data("value", vatPercent).text(vatPercent.toFixed(
    //         2));
    //     //parseFloat($("#vat_amt_on_total").text()) || 0;
    //     $("#vatInput").val(currentVat);
    // });


    $("#openVatModal").on("click", function() {

        let currentVat =
            parseFloat($("#vat_amt_on_total").data("value")) || 0;
    
        $("#vatInput").val(currentVat);
    });



    $("#saveVatBtn").on("click", function() {

        let vatPercent = parseFloat($("#vatInput").val()) || 0;

        // Update summary
        $("#vat_amt_on_total")
            .data("value", vatPercent)
            .text(vatPercent.toFixed(2));

        // Apply to every product
        itemsInCart.forEach(function(item) {
            item.tax_percentage = vatPercent;
        });

        drawTable();

        $("#vatModal").modal("hide");
    });

    $("#vatInput").on("input", function() {
        var vatPercent = parseFloat($(this).val()) || 0;
        $("#vat_amt_on_total").data("value", vatPercent).text(vatPercent.toFixed(2));
        recalcNetTotal();
    });

    // =========================================================================
    // Discount Modal
    // =========================================================================
    $("#discountOnTotalModal .btn-primary").on("click", function() {

        if ($("#percentType").is(":checked")) {

            let discountPercent = parseFloat($("#percentAmount").val()) || 0;

            $("#discountHeader").text("Dis%");

            itemsInCart.forEach(function(item) {
                item.discount_type = "percent";
                item.discount_percent = discountPercent;
                item.discount_fixed = 0;
            });

        } else {

            let fixed = parseFloat($("#fixedAmount").val()) || 0;

            $("#discountHeader").text("Disc");

            itemsInCart.forEach(function(item) {
                item.discount_type = "fixed";
                item.discount_fixed = fixed; // 10 Tk for EVERY product
                item.discount_percent = fixed; // Display 10 in the Disc column
            });
        }

        drawTable();
        updateGrandTotal();
        $("#discountOnTotalModal").modal("hide");

    });

    // =========================================================================
    // Product Selection
    // =========================================================================

    $("#item").on('change', function() {
        var product_id = $(this).val();
        if (product_id > 0) addProductToCart(product_id);
        $(this).val("0");
    });
    // =========================================================================
    // Purchase
    // =========================================================================

    $("#productPurchase").on("click", function() {

        var supplier_id = $("#supplier_id").val();

        if (!supplier_id) {
            alert("Please Select Supplier");
            return;
        }

        if (itemsInCart.length === 0) {
            alert("Cart is empty!");
            return;
        }

        $(this).prop("disabled", true).text("Processing...");

         //url: "<?=site_url('purchase/product')?>",

        //  $.ajax({
        //     url: APP_URLS.purchaseProduct,
        //     type: "POST",
        //     dataType: "json",
        //     data: {
        //         cart_data: JSON.stringify(itemsInCart),
        //         discount_on_total_price: $("#discount_on_total_price").text(),
        //         vat_amt_on_total: $("#vat_amt_on_total").text(),
        //         supplier_id: supplier_id
        //     },
        
        //     success: function (response) {
        
        //         if (response.status) {
        
        //             Swal.fire({
        //                 icon: "success",
        //                 title: "Success",
        //                 text: response.message,
        //                 confirmButtonText: "OK"
        //             }).then(() => {
        
        //                 itemsInCart = [];
        //                 location.reload();
        
        //             });
        
        //         } else {
        
        //             Swal.fire({
        //                 icon: "error",
        //                 title: "Purchase Failed",
        //                 text: response.message
        //             });
        
        //             $("#productPurchase")
        //                 .prop("disabled", false)
        //                 .text("Purchase");
        //         }
        //     },
        
        //     error: function (xhr) {
        
        //         Swal.fire({
        //             icon: "error",
        //             title: "Server Error",
        //             text: "Something went wrong. Please try again."
        //         });
        
        //         $("#productPurchase")
        //             .prop("disabled", false)
        //             .text("Purchase");
        
        //         console.error(xhr.responseText);
        //     }
        // });

$.ajax({
    url: APP_URLS.purchaseProduct,
    type: "POST",
    dataType: "json",
    data: {
        cart_data: JSON.stringify(itemsInCart),
        discount_on_total_price: $("#discount_on_total_price").text(),
        vat_amt_on_total: $("#vat_amt_on_total").text(),
        supplier_id: supplier_id
    },

    success: function (response) {

        if (response.status) {

            Swal.fire({
                icon: "success",
                title: "Success",
                text: response.message,
                timer: 2000,
                timerProgressBar: true,
                showConfirmButton: false
            }).then(() => {

                itemsInCart = [];
                location.reload();

            });

        } else {

            Swal.fire({
                icon: "error",
                title: "Purchase Failed",
                text: response.message
            });

            $("#productPurchase")
                .prop("disabled", false)
                .text("Purchase");
        }
    },

    error: function (xhr) {

        Swal.fire({
            icon: "error",
            title: "Server Error",
            text: "Something went wrong. Please try again."
        });

        $("#productPurchase")
            .prop("disabled", false)
            .text("Purchase");

        console.error(xhr.responseText);
    }
});


    });

    // =========================================================================
    // Initialize
    // =========================================================================

    drawTable();

});