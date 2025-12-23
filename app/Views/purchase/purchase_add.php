<?php
echo $this->extend('layout');
echo $this->section('content');
?>
<div class="container-fluid">
    <div class="row">
        <div class="col-9">
            <div class="d-flex align-items-center">
                <!-- Product Select (Left Column) -->
                <div class="flex-grow-1 mr-2">
                    <select id="item" class="form-control select2" style="width:100%">
                        <option value="0">Select Product</option>
                        <?php foreach ($product_show_for_sale as $row): ?>
                        <option value="<?= $row['product_id'] ?>"><?= $row['product_name'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Add Button (Right Column) -->
                <div>
                    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal"
                        data-target="#AddNewProduct">
                        <i class="fa fa-plus"></i> Add Product
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
                            <th>QtyPerPack</th>
                            <th>BoxQty</th>
                            <th>TP</th>
                            <th class="vat-column-header">Vat</th>
                            <th>SalePrice</th>
                            <th class="discount-column-header">Disc%</th>
                            <th class="text-end">Amount</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody id="cartTableBody"></tbody>
                </table>
            </div>
        </div>

        <div class="col-3 mb-2">
            <div class="card text-dark bg-light mb-3">
                <div class="card-header">
                    <select id="supplier_id" class="form-control select2 w-100" required>
                        <option value="">Select Supplier</option>
                        <?php foreach ($supplier_show as $row): ?>
                        <option value="<?= $row['supplier_id'] ?>"><?= $row['supplier_name'] ?></option>
                        <?php endforeach; ?>
                    </select>
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
                            <tr class="table-light">
                                <td colspan="4"></td>
                                <td class="text-end pe-0">Total Price</td>
                                <td id="totalPrice" class="text-end">0.00</td>
                            </tr>
                            <!-- <tr>
								<td colspan="4"></td>
								<td class="text-end p-0 m-0">Discount on Total</td>
								<td class="text-end p-0 m-0">
									 <input style="width: 70px;"
										class="border border-primary rounded extra-fields blur-field" type="text"
										id="discount_on_total_price" readonly> 

										<span id="discount_on_total_price" class="badge bg-primary w-100 text-end">0.00</span>

								</td>
							</tr> -->

                            <tr>
                                <td colspan="4"></td>
                                <td class="text-end p-0 m-0">Discount on Total</td>
                                <td class="text-end p-0 m-0">
                                    <span id="discount_on_total_price" class="badge bg-light">0.00</span>
                                </td>
                            </tr>


                            <tr>
                                <td colspan="4"></td>
                                <td class="text-end p-0 m-0">VAT on Total</td>
                                <td class="text-end p-0 m-0">
                                    <span id="vat_on_total_price" class="badge bg-light">0.00</span>
                                </td>
                            </tr>

                            <!-- <tr>
								<td colspan="4"></td>
								<td class="text-end p-0 m-0">VAT% on Total</td>
								<td class="text-end p-0 m-0">
									<input style="width: 70px;"
										class="border border-info rounded extra-fields blur-field" type="text"
										id="vat_on_total_price" readonly>
								</td>
							</tr> -->


                            <tr class="table-warning">
                                <td colspan="4"></td>
                                <td class="text-end pe-0">Net Total</td>
                                <td class="text-end" id="netTotalPrice"><strong>0.00</strong></td>
                            </tr>
                            <tr class="table-secondary">
                                <td colspan="6">
                                    <div class="d-flex bg-secondary text-white">
                                        <button type="button" class="btn btn-danger w-100 text-start mb-2"
                                            id="openVatModal" data-toggle="modal" data-target="#vatModal">
                                            VAT
                                        </button>
                                        <div>
                                            <button type="button" class="btn btn-primary" data-toggle="modal"
                                                data-target="#exampleModal">
                                                Discount
                                            </button>
                                        </div>

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

                <!-- <div class="card-footer text-muted">
					<div>
						<button class="btn btn-info text-uppercase w-100" disabled
							id="productPurchase">Purchase</button>
					</div>
				</div> -->
            </div>
        </div>
    </div>
</div>
<!------------------- Modal for discount start----------------------- --->
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Discount</h5>
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
<script src="<?= base_url('assets/js/jquery.mycart.js') ?>"></script>
<script src="<?= base_url('assets/js/plugins/jquery.dataTables.min.js') ?>"></script>
<script src="<?= base_url('assets/js/plugins/dataTables.bootstrap.min.js') ?>"></script>
<script>
var productsList = <?= json_encode($product_show_for_sale, JSON_PRETTY_PRINT) ?>;

$(document).ready(function() {
    var itemsInCart = [];
    var totalPrice = 0;

    function enableButton() {
        $("#productPurchase").prop("disabled", itemsInCart.length === 0);
    }

    function itemExist(product_id) {
        var response = {
            inCart: false,
            productIndex: null
        };
        $.each(itemsInCart, function(key, item) {
            if (item.product_id == product_id) {
                response.inCart = true;
                response.productIndex = key;
            }
        });
        return response;
    }

    function totalCalculation() {
        var discount_on_total_price = parseFloat($("#discount_on_total_price").text()) || 0;
        //var others_cost = parseFloat($("#others_cost").val()) || 0;

        var netTotalPrice = totalPrice - discount_on_total_price;
        $("#totalPrice").html(totalPrice.toFixed(2));
        $("#netTotalPrice").html(netTotalPrice.toFixed(2));
    }

    function drawTable() {
        $("#cartTableBody").empty();
        totalPrice = 0;

        $.each(itemsInCart, function(key, item) {
            var baseTotal = parseInt(item.quantity) * parseFloat(item.buying_unit_price);
            var vatPercent = parseFloat(item.tax_perchantage) || 0;
            var vatAmount = baseTotal * (vatPercent / 100);
            var subTotalPrice = baseTotal + vatAmount;

            totalPrice += subTotalPrice;

            $("#cartTableBody").append('<tr>' +
                '<td>' + item.product_name + '</td>' +
                '<td>' + item.total_stock + '</td>' +
                '<td><input data-id="' + key +
                '" class="product_quantity_change form-control form-control-sm" type="number" min="1" step="1" value="' +
                item.quantity + '"></td>' +
                '<td><input data-id="' + key +
                '" class="product_boxqty_change form-control form-control-sm" type="number" min="1" step="1" value="' +
                (item.box_quantity || 1) + '"></td>' +
                '<td><input type="number" class="buying_price form-control form-control-sm" value="' +
                item.buying_unit_price + '" min="1" step="0.01"></td>' +
                '<td class="vat-column"><input type="number" name="vat" class="form-control form-control-sm vat-input" value="' +
                vatPercent + '" min="0" step="0.01"></td>' +
                '<td><input type="number" class="sale_price form-control form-control-sm" value="' +
                (item.sale_price || 0) + '" min="0" step="0.01"></td>' +
                '<td class="discount-column"><input type="number" name="discount_on_each_product" class="discount_percent form-control form-control-sm" value="' +
                (item.discount_percent || 0) + '" min="0" step="0.01"></td>' +
                '<td class="text-end">' + subTotalPrice.toFixed(2) + '</td>' +
                '<td> <button data-index="' + key +
                '" class="btn btn-sm btn-danger btn_item_delete">×</button>' +
                '</td>' +
                '</tr>');
        });

        totalCalculation();
        enableButton();

        // Show/hide VAT and Discount columns and inputs based on toggle state
        toggleVatAndDiscount($("#fixedVatToggle").is(":checked"));

        // Update VAT header text based on VAT Percentage toggle
        updateVatHeaderText();
    }

    // Show or hide VAT and Discount UI elements
    function toggleVatAndDiscount(show) {
        if (show) {
            $("th.vat-column-header, td.vat-column").removeClass('hide');
            $("th.discount-column-header, td.discount-column").removeClass('hide');
            $(".vat-input, .discount_percent").prop("disabled", false);
        } else {
            $("th.vat-column-header, td.vat-column").addClass('hide');
            $("th.discount-column-header, td.discount-column").addClass('hide');
            $(".vat-input, .discount_percent").prop("disabled", true);
        }
    }

    // Update VAT header text depending on vatperchantageToggle state
    function updateVatHeaderText() {
        if ($('#vatperchantageToggle').is(':checked')) {
            $('th.vat-column-header').text('VAT %');
        } else {
            $('th.vat-column-header').text('VAT');
        }
    }

    /////////////////Apply VAT % on Total Price/////////////////////////////////
    // If you want the modal to reflect the current VAT value:
    // When opening modal, show current VAT %
    $("#openVatModal").on("click", function() {
        var currentVatPercent = parseFloat($("#vat_on_total_price").text()) || 0;
        $("#vatInput").val(currentVatPercent);
    });

    // Save VAT % from modal
    $("#saveVatBtn").on("click", function() {
        var vatPercent = parseFloat($("#vatInput").val()) || 0;
        $("#vat_on_total_price").text(vatPercent.toFixed(2)); // store percentage
        recalcNetTotal(); // update net total
        $("#vatModal").modal("hide");
    });

    // Optional: live update while typing
    $("#vatInput").on("input", function() {
        var vatPercent = parseFloat($(this).val()) || 0;
        $("#vat_on_total_price").text(vatPercent.toFixed(2));
        recalcNetTotal();
    });

    // Recalculate net total using VAT %
    function recalcNetTotal() {
        var totalPrice = parseFloat($("#totalPrice").text()) || 0;
        var discount_on_total_price = parseFloat($("#discount_on_total_price").text()) || 0;
        var vatPercent = parseFloat($("#vat_on_total_price").text()) || 0;

        var vatAmount = (totalPrice - discount_on_total_price) * (vatPercent / 100);
        var netTotal = totalPrice - discount_on_total_price + vatAmount;

        $("#netTotalPrice").text(netTotal.toFixed(2));
    }

    // Also update when discount_on_total_price input changes
    $("#discount_on_total_price").on("input", function() {
        recalcNetTotal();
    });
    ///////////////////////////////////////////////////////////////////////////


    $("#productPurchase").on("click", function() {
        var discount_on_total_price = $("#discount_on_total_price").text();
        //var others_cost = $("#others_cost").val();
        var supplier_id = $("#supplier_id").val();

        if (!supplier_id) {
            alert("Please Select Supplier");
            $("#supplier_id").focus();
            return;
        }

        $(this).prop("disabled", true).text("Processing...");

        var itemsInCartObject = Object.assign({}, itemsInCart);
        var purchase_process_url = "<?= site_url('Purchase/purchase_product') ?>";

        $.ajax({
            url: purchase_process_url,
            method: 'POST',
            data: {
                cart_data: itemsInCartObject,
                discount_on_total_price,
                //others_cost,
                supplier_id
            },
            success: function() {
                alert('Purchase Successful');
                location.reload();
            },
            error: function() {
                alert('Something went wrong. Please try again.');
                $("#productPurchase").prop("disabled", false).text("Purchase");
            }
        });
    });

    $("#item").on('change', function() {
        var product_id = $(this).val();
        if (product_id > 0) {
            addProductToCart(product_id);
        }
        $(this).val("0"); // reset select
    });

    $(".extra-fields").on("input", function() {
        totalCalculation();
    });

    $(document).on("input", ".product_quantity_change", function() {
        var index = $(this).data("id");
        var newQty = parseInt($(this).val());
        if (newQty < 1) {
            itemsInCart.splice(index, 1);
        } else {
            itemsInCart[index].quantity = newQty;
        }
        drawTable();
    });

    $(document).on("click", ".btn_item_delete", function() {
        var index = $(this).data("index");
        itemsInCart.splice(index, 1);
        drawTable();
    });

    // VAT and Discount toggle handler
    $("#fixedVatToggle").on('change', function() {
        var enabled = $(this).is(":checked");
        toggleVatAndDiscount(enabled);
    });

    // VAT header text toggle handler
    $('#vatperchantageToggle').on('change', function() {
        updateVatHeaderText();
    });

    function addProductToCart(product_id) {
        var found = false;
        $.each(itemsInCart, function(key, item) {
            if (item.product_id == product_id) {
                item.quantity += 1;
                found = true;
                return false;
            }
        });
        if (!found) {
            $.each(productsList, function(key, product) {
                if (product.product_id == product_id) {
                    product.quantity = 1;
                    product.discount_percent = 0;
                    product.sale_price = product.sale_price || product.buying_unit_price || 0;
                    product.tax_perchantage = product.tax_perchantage || 0;
                    product.box_quantity = product.box_quantity || 1;
                    itemsInCart.push(product);
                    return false;
                }
            });
        }
        drawTable();
    }

    // Initial draw
    drawTable();
});



const fixedType = document.getElementById('fixedType');
const percentType = document.getElementById('percentType');
const fixedInput = document.getElementById('fixedInput');
const percentInput = document.getElementById('percentInput');

fixedType.addEventListener('change', () => {
    fixedInput.classList.remove('d-none');
    percentInput.classList.add('d-none');
});

percentType.addEventListener('change', () => {
    percentInput.classList.remove('d-none');
    fixedInput.classList.add('d-none');
});



///////////////////Adding discount_on_total_price on Total Price////////////////////
// Function to recalculate discount_on_total_price + net total live
function updateLivePreview() {
    var totalPrice = parseFloat($("#totalPrice").text()) || 0;
    var discountValue = 0;

    $("#percentPreview, #fixedPreview").remove();

    if ($("#fixedType").is(":checked")) {
        var fixed = parseFloat($("#fixedAmount").val()) || 0;
        discountValue = fixed;

        if (fixed > 0) {
            var percentOfTotal = (fixed / totalPrice) * 100;
            $("#fixedAmount").after(
                `<small id="fixedPreview" class="text-muted">≈ ${percentOfTotal.toFixed(2)}% of total</small>`
            );
        }

    } else if ($("#percentType").is(":checked")) {
        var percent = parseFloat($("#percentAmount").val()) || 0;
        discountValue = (totalPrice * percent) / 100;

        if (percent > 0) {
            $("#percentAmount").after(
                `<small id="percentPreview" class="text-muted">≈ ${discountValue.toFixed(2)} discount_on_total_price</small>`
            );
        }
    }

    // Update discount_on_total_price field
    $("#discount_on_total_price").text(discountValue.toFixed(2));

    // ✅ Update net total instantly
    var netTotal = totalPrice - discountValue;
    $("#netTotalPrice").text(netTotal.toFixed(2));
}

// Apply discount_on_total_price and close modal
function applyDiscountFromModal() {
    updateLivePreview(); // ensure latest value is applied

    // Save last state
    $("#exampleModal").data("discountType", $("input[name='discountType']:checked").val());
    $("#exampleModal").data("fixedAmount", $("#fixedAmount").val());
    $("#exampleModal").data("percentAmount", $("#percentAmount").val());

    $("#exampleModal").modal("hide");
}

// On modal "Ok" click
$("#exampleModal .btn-primary").on("click", function() {
    applyDiscountFromModal();
});

// When modal opens, restore last state
$("#exampleModal").on("show.bs.modal", function() {
    var type = $(this).data("discountType") || "fixed";
    var fixedVal = $(this).data("fixedAmount") || "";
    var percentVal = $(this).data("percentAmount") || "";

    if (type === "fixed") {
        $("#fixedType").prop("checked", true).trigger("change");
    } else {
        $("#percentType").prop("checked", true).trigger("change");
    }

    $("#fixedAmount").val(fixedVal);
    $("#percentAmount").val(percentVal);

    updateLivePreview();
});

// Live preview events
$("#fixedAmount, #percentAmount").on("input", function() {
    updateLivePreview();
});
$("#fixedType, #percentType").on("change", function() {
    updateLivePreview();
});

/////////////////VAT % ON Total Price///////////////////////////////
function recalcNetTotal() {
    var totalPrice = parseFloat($("#totalPrice").text()) || 0;
    var discount_on_total_price = parseFloat($("#discount_on_total_price").text()) || 0;
    var vatAmount = parseFloat($("#vat_on_total_price").text()) || 0;

    var netTotal = totalPrice - discount_on_total_price + vatAmount;
    $("#netTotalPrice").text(netTotal.toFixed(2));
}

// Live update VAT amount
$("#vat_percent").on("input", function() {
    var totalPrice = parseFloat($("#totalPrice").text()) || 0;
    var vatPercent = parseFloat($(this).val()) || 0;

    var vatAmount = (totalPrice * vatPercent) / 100;
    $("#vat_on_total_price").text(vatAmount.toFixed(2));

    recalcNetTotal();
});

// Also recalc net total if discount_on_total_price changes
$("#discount_on_total_price").on("input", function() {
    recalcNetTotal();
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
</style>

<?php
echo $this->endSection();
?>