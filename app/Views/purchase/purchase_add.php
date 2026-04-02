<?php
echo $this->extend('layout');
echo $this->section('content');
?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12 col-lg-9">
            <div class="d-flex align-items-center">
                <!-- Product Select (Left Column) -->
                <div class="flex-grow-1 mr-2">
                    <select id="item" class="form-control select2" style="width:100%">
                        <option value="0">Select Product</option>
                        <?php foreach ($product_show_for_sale as $row): ?>
                        <option value="<?=$row['product_id']?>"><?=$row['product_name']?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <!-- Add Button (Right Column) -->
                <div>
                    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal"
                        data-target="#AddNewProduct">
                        <i class="fa fa-plus"></i> Opening Stock
                    </button>
                </div>
            </div>
            <!-- Cart Table -->
            <div class="table-responsive mt-3">
                <table class="table table-striped">
                    <thead>
                        <tr class="table-info">
                            <th>Product</th>
                            <th>Stock</th>
                            <th>QtyPerBox</th>
                            <th>BoxQty</th>
                            <th>PricePerBox</th>
                            <th>B.P/TP</th>
                            <th class="vat-column-header">P.Vat%</th>
                            <th>V.Amt</th>
                            <th>S.Price</th>
                            <th>Dis%</th>
                            <th class="text-end">SubTotal</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody id="cartTableBody"></tbody>
                </table>
            </div>
        </div>
        <div class="col-12 col-lg-3 mb-2">
            <div class="card text-dark bg-light mb-3">
                <div class="card-header">
                    <select id="supplier_id" class="form-control select2 w-100" required>
                        <option value="">Select Supplier</option>
                        <?php foreach ($supplier_show as $row): ?>
                        <option value="<?=$row['supplier_id']?>"><?=$row['supplier_name']?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="card-body">
                    <table class="table table-striped mb-0">
                        <tfoot>
                            <tr class="table-light">
                                <td colspan="4"></td>
                                <td class="text-end pe-0">Total Price</td>
                                <td id="totalPrice" class="text-end">0.00</td>
                            </tr>
                            <tr>
                                <td colspan="4"></td>
                                <td class="text-end p-0 m-0">Discount on Total</td>
                                <td class="text-end p-0 m-0">
                                    <span id="discount_on_total_price" class="badge bg-light">0.00</span>Tk.
                                </td>
                            </tr>
                            <tr>
                                <td colspan="4"></td>
                                <td class="text-end p-0 m-0">VAT % on Total</td>
                                <td class="text-end p-0 m-0">
                                    <span id="vat_percent_on_total" class="badge bg-light">0.00 </span>%
                                </td>
                            </tr>
                            <tr class="table-warning">
                                <td colspan="4"></td>
                                <td class="text-end pe-0">Net Total</td>
                                <td class="text-end" id="netTotalPrice"><strong>0.00</strong></td>
                            </tr>
                            <tr class="table-secondary">
                                <td colspan="6">
                                    <div class="d-flex flex-column flex-md-row bg-secondary text-white gap-2">

                                        <button type="button" class="btn btn-primary flex-fill" data-toggle="modal"
                                            data-target="#discountOnTotalModal">
                                            Discount
                                        </button>

                                        <button type="button" class="btn btn-danger flex-fill" id="openVatModal"
                                            data-toggle="modal" data-target="#vatModal">
                                            VAT %
                                        </button>
                                    </div>

                                    <div class="text-muted">
                                        <button class="btn btn-info text-uppercase w-100" disabled
                                            id="productPurchase">Purchase</button>
                                    </div>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12 col-lg-9"> SubTotal = ( মূল প্রাইজ - ডিসকাউন্ট ) + ভ্যাট</div>
    </div>
</div>






<!------------------- Modal for discount start----------------------- --->
<!-- Modal -->
<div class="modal fade" id="discountOnTotalModal" tabindex="-1" role="dialog"
    aria-labelledby="discountOnTotalModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="discountOnTotalModalLabel">Discount</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container mt-1">
                    <form>
                        <!-- Discount Type -->
                        <div class="mb-3">
                            <label class="form-label fw-bold">Discount Type</label>
                            <div class="btn-group" role="group" aria-label="Discount Type">
                                <input type="radio" class="btn-check" name="discountType" id="fixedType" value="fixed"
                                    checked>
                                <label class="btn btn-outline-primary" for="fixedType">Fixed</label>

                                <input type="radio" class="btn-check" name="discountType" id="percentType"
                                    value="percent">
                                <label class="btn btn-outline-primary" for="percentType">Percent</label>
                            </div>
                        </div>

                        <!-- Fixed Amount -->
                        <div class="mb-3" id="fixedInput">
                            <label for="fixedAmount" class="form-label">Fixed</label>
                            <input type="number" class="form-control" id="fixedAmount" placeholder="Fixed amount">
                        </div>

                        <!-- Percent Amount -->
                        <div class="mb-3 d-none" id="percentInput">
                            <label for="percentAmount" class="form-label">Percent (%)</label>
                            <input type="number" class="form-control" id="percentAmount" placeholder="Enter percent">
                        </div>
                    </form>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Ok</button>
            </div>
        </div>
    </div>
</div>
<!---------------------- Modal for discount end ------------------------->

<!------------------------Modal for VAT Start---------------------------->

<div class="modal fade" id="vatModal" tabindex="-1" aria-labelledby="vatModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="vatModalLabel">VAT %</h5>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="number" class="form-control" id="vatInput" placeholder="Enter VAT %" min="0" step="0.01">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="saveVatBtn">Apply VAT</button>
            </div>
        </div>
    </div>
</div>



<?php
echo $this->endSection();
?>

<?php
echo $this->section('scripts');
?>
<script src="<?=base_url('assets/js/jquery.mycart.js')?>"></script>
<script src="<?=base_url('assets/js/plugins/jquery.dataTables.min.js')?>"></script>
<script src="<?=base_url('assets/js/plugins/dataTables.bootstrap.min.js')?>"></script>
<script>
var productsList = <?=json_encode($product_show_for_sale, JSON_PRETTY_PRINT)?>;

console.log(productsList);

$(document).ready(function() {

    var itemsInCart = [];
    var totalPrice = 0;

    // ================= Purchase Button Enable when Supplier and product selected ================= //
    function enableButton() {
        var supplier = $("#supplier_id").val();
        var hasItems = itemsInCart.length > 0;

        $("#productPurchase").prop("disabled", !(supplier && hasItems));
    }

    // ✅ ADD HERE 👇
    $("#supplier_id").on("change", enableButton);

    // ================= Purchase Button Enable when Supplier and product selected ================= //



    // ================= DRAW TABLE ================= //
    function drawTable() {

        const tbody = $("#cartTableBody");
        tbody.empty();

        totalPrice = 0;
        let rows = "";

        $.each(itemsInCart, function(key, item) {

            var qtyPerPack = Number(item.quantity_per_pack) || 0;
            var qty = Number(item.box_quantity) || 1;
            var basePrice = Number(item.base_price) || 0;
            var vatPercent = Number(item.tax_percentage) || 0;
            var discountPercent = Number(item.discount_percent) || 0;
            var taxType = item.tax_type;

            var PricePerBox = qtyPerPack * basePrice;

            // 👉 Total quantity
            var totalQty = qtyPerPack * qty;
            //var totalQty = qty;

            // 👉 Base total price
            var purchaseTotal = totalQty * basePrice;
            var productDiscountAmt = 0;
            var vatAfterDiscount = 0;
            var rowTotal = 0;

            if (taxType === 'with_tax') {

                // var priceWithoutVat = purchaseTotal / (1 + vatPercent / 100);
                var priceWithoutVat = vatPercent > 0 ?
                    purchaseTotal / (1 + vatPercent / 100) :
                    purchaseTotal;

                productDiscountAmt = priceWithoutVat * (discountPercent / 100);

                var discountedBase = priceWithoutVat - productDiscountAmt;

                vatAfterDiscount = discountedBase * (vatPercent / 100);

                rowTotal = discountedBase + vatAfterDiscount;

            } else {

                productDiscountAmt = purchaseTotal * (discountPercent / 100);

                var discountedBase = purchaseTotal - productDiscountAmt;

                vatAfterDiscount = discountedBase * (vatPercent / 100);

                rowTotal = discountedBase + vatAfterDiscount;
            }

            // 👉 Grand total
            totalPrice += rowTotal;

            rows += `<tr data-index="${key}">
                <td>${item.product_name}</td>
                <td>${item.total_stock}</td>

                <td>
                    <input data-id="${key}" class="product_quantity_change form-control form-control-sm"
                    type="number" step="any" value="${item.quantity_per_pack || 1}">
                </td>

                <td>
                    <input data-id="${key}" class="product_boxqty_change form-control form-control-sm"
                    type="number" step="any"  min='1' value="${item.box_quantity}">
                </td>


                <td>
                    <input type="text" class="price_per_box form-control form-control-sm"
                    value="${PricePerBox}" data-id="${key}" readonly>
                </td>

                <td>
                    <input type="text" class="buying_price form-control form-control-sm"
                    value="${item.base_price}" min="1">
                </td>

                <td>
                    <input type="text" class="vat-input form-control form-control-sm" min="0"
                    value="${item.tax_percentage}" data-id="${key}">
                </td>

                <td>${vatAfterDiscount.toFixed(2)}</td>

                <td>
                    <input type="text" class="sale_price form-control form-control-sm"
                    value="${item.sales_price_for_customer}" data-id="${key}" disabled>
                </td>

                <td>
                    <input type="text" class="discount_percent form-control form-control-sm"
                    value="${item.discount_percent || 0}" data-id="${key}">
                </td>


                <td class="text-end">${rowTotal.toFixed(2)}</td>

                <td>
                    <button data-index="${key}" class="btn btn-sm btn-danger btn_item_delete">×</button>
                </td>
            </tr>`;
        });

        tbody.html(rows);

        totalCalculation();
        enableButton();
    }

    function recalcNetTotal() {

        var subtotal = $("#totalPrice").data("value") || 0;
        var discount = $("#discount_on_total_price").data("value") || 0;
        var vatPercent = $("#vat_percent_on_total").data("value") || 0;

        var afterDiscount = Math.max(0, subtotal - discount);
        var vatAmount = afterDiscount * (vatPercent / 100);

        var netTotal = afterDiscount + vatAmount;

        $("#netTotalPrice").text(netTotal.toFixed(2));
    }

    function totalCalculation() {

        $("#totalPrice")
            .data("value", totalPrice) // ✅ store raw number
            .text(totalPrice.toFixed(2)); // display only

        updateLivePreview();
        recalcNetTotal();
    }

    // ================= EVENTS ================= //

    $(document).on("input", ".product_quantity_change", function() {
        var index = $(this).data("id");
        itemsInCart[index].quantity_per_pack = Number($(this).val());
        drawTable();
    });

    $(document).on("input", ".product_boxqty_change", function() {
        var index = $(this).data("id");
        itemsInCart[index].box_quantity = Number($(this).val());
        drawTable();
    });

    $(document).on("input", ".price_per_box", function() {
        var index = $(this).data("id");
        var pricePerBox = Number($(this).val());

        var qtyPerPack = itemsInCart[index].quantity_per_pack || 1;
        itemsInCart[index].base_price = pricePerBox / qtyPerPack;

        drawTable();
    });

    $(document).on("input", ".vat-input", function() {
        var index = $(this).data("id");
        itemsInCart[index].tax_percentage = Number($(this).val());
        drawTable();
    });

    $(document).on("input", ".discount_percent", function() {
        var index = $(this).data("id");
        itemsInCart[index].discount_percent = Number($(this).val());
        drawTable();
    });

    $(document).on("click", ".btn_item_delete", function() {
        var index = $(this).data("index");
        itemsInCart.splice(index, 1);
        drawTable();
    });

    // ================= VAT on total price MODAL ================= //

    $("#openVatModal").on("click", function() {
        var currentVat = $("#vat_percent_on_total").data("value", vatPercent).text(vatPercent.toFixed(
            2));
        //parseFloat($("#vat_percent_on_total").text()) || 0;
        $("#vatInput").val(currentVat);
    });

    $("#saveVatBtn").on("click", function() {
        var vatPercent = parseFloat($("#vatInput").val()) || 0;
        $("#vat_percent_on_total").data("value", vatPercent).text(vatPercent.toFixed(2));
        recalcNetTotal();
        $("#vatModal").modal("hide");
    });

    $("#vatInput").on("input", function() {
        var vatPercent = parseFloat($(this).val()) || 0;
        $("#vat_percent_on_total").data("value", vatPercent).text(vatPercent.toFixed(2));
        recalcNetTotal();
    });

    // ================= DISCOUNT on total price Modal ================= //

    function updateLivePreview() {
        var total = parseFloat($("#totalPrice").text()) || 0;
        var discountValue = 0;

        if ($("#fixedType").is(":checked")) {
            discountValue = parseFloat($("#fixedAmount").val()) || 0;
        } else {
            var percent = parseFloat($("#percentAmount").val()) || 0;
            discountValue = (total * percent) / 100;
        }

        // $("#discount_on_total_price").text(discountValue.toFixed(2));
        $("#discount_on_total_price")
            .data("value", discountValue) // ✅ store number
            .text(discountValue.toFixed(2));
        recalcNetTotal();
    }

    $("#fixedAmount, #percentAmount").on("input", updateLivePreview);
    $("#fixedType, #percentType").on("change", updateLivePreview);

    $("#discountOnTotalModal .btn-primary").on("click", function() {
        updateLivePreview();
        $("#discountOnTotalModal").modal("hide");
    });

    // ================= ADD PRODUCT ================= //

    $("#item").on('change', function() {
        var product_id = $(this).val();
        if (product_id > 0) addProductToCart(product_id);
        $(this).val("0");
    });

    function addProductToCart(product_id) {

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

                    // itemsInCart.push(product);
                    itemsInCart.push({
                        ...product
                    });
                    return false;
                }
            });
        }

        drawTable();
    }


    // ================= PURCHASE ================= //

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

        $.ajax({
            url: "<?=site_url('purchase-product')?>",
            type: "POST",
            data: {
                cart_data: JSON.stringify(itemsInCart),
                discount_on_total_price: $("#discount_on_total_price").text(),
                vat_percent_on_total: $("#vat_percent_on_total").text(),
                supplier_id: supplier_id
            },
            success: function() {

                alert("Purchase Successful");

                // ✅ FIXED BUG
                itemsInCart = [];

                location.reload();
            },
            error: function() {
                alert("Error!");
                $("#productPurchase").prop("disabled", false).text("Purchase");
            }
        });
    });

    drawTable();
});
</script>


<style>
/* Your existing styles for cols */
.col-1,
.col-2,
.col-3,
.col-4,
.col-5,
.col-6,
.col-7,
.col-8,
.col-9,
.col-10,
.col-11,
.col-12,
.col,
.col-auto,
.col-sm-1,
.col-sm-2,
.col-sm-3,
.col-sm-4,
.col-sm-5,
.col-sm-6,
.col-sm-7,
.col-sm-8,
.col-sm-9,
.col-sm-10,
.col-sm-11,
.col-sm-12,
.col-sm,
.col-sm-auto,
.col-md-1,
.col-md-2,
.col-md-3,
.col-md-4,
.col-md-5,
.col-md-6,
.col-md-7,
.col-md-8,
.col-md-9,
.col-md-10,
.col-md-11,
.col-md-12,
.col-md,
.col-md-auto,
.col-lg-1,
.col-lg-2,
.col-lg-3,
.col-lg-4,
.col-lg-5,
.col-lg-6,
.col-lg-7,
.col-lg-8,
.col-lg-9,
.col-lg-10,
.col-lg-11,
.col-lg-12,
.col-lg,
.col-lg-auto,
.col-xl-1,
.col-xl-2,
.col-xl-3,
.col-xl-4,
.col-xl-5,
.col-xl-6,
.col-xl-7,
.col-xl-8,
.col-xl-9,
.col-xl-10,
.col-xl-11,
.col-xl-12,
.col-xl,
.col-xl-auto {
    position: relative;
    width: 100%;
    padding-right: 6px !important;
    padding-left: 7px !important;
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

.blur-field {
    background-color: #f5f5f5;
    /* light gray background */
    opacity: 0.7;
    /* slightly transparent */
    color: #000;
    /* keep text fully visible */
}

.modal-body input {
    height: 45px;
    font-size: 16px;
}


/* ============================= */
/* MOBILE RESPONSIVE IMPROVEMENT */
/* ============================= */

@media (max-width: 768px) {

    /* Make table font smaller */
    table {
        font-size: 12px;
    }

    /* Reduce padding inside table */
    .table td,
    .table th {
        padding: 4px !important;
    }

    /* Input fields smaller */
    .table input {
        min-width: 70px;
        font-size: 12px;
    }

    /* Make summary card sticky bottom */
    .card {
        margin-top: 15px;
    }

    /* Buttons full width on mobile */
    .btn {
        font-size: 13px;
    }

    /* Reduce select height */
    .select2-container .select2-selection--single {
        height: 34px !important;
    }

    /* Cart scroll fix */
    .table-responsive {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }
}
</style>

<?php
echo $this->endSection();
?>