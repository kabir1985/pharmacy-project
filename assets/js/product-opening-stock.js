

// Fix modal close buttons
$('.modal .btn-secondary[data-dismiss="modal"], .modal .close').on('click', function () {
    $(this).closest('.modal').modal('hide');
});


$(document).ready(function () {



    $(document).ready(function () {

        // ==========================================================
        // SELECT2 - PRODUCT FORM
        // ==========================================================

        function initProductSelect2() {

            $('#product_category').select2({
                width: '100%',
                placeholder: 'Select Category',
                allowClear: true,
                dropdownParent: $('#AddNewProduct')
            });

            $('#product_brand').select2({
                width: '100%',
                placeholder: 'Select Brand',
                allowClear: true,
                dropdownParent: $('#AddNewProduct')
            });

            $('#product_group').select2({
                width: '100%',
                placeholder: 'Select Generic Name',
                allowClear: true,
                dropdownParent: $('#AddNewProduct')
            });

            $('#strength').select2({
                width: '100%',
                placeholder: 'Select Strength',
                allowClear: true,
                dropdownParent: $('#AddNewProduct')
            });

            $('#product_unit').select2({
                width: '100%',
                placeholder: 'Select Unit',
                allowClear: true,
                dropdownParent: $('#AddNewProduct')
            });
        }

        initProductSelect2();

    });


    $.fn.modal.Constructor.prototype.enforceFocus = function () { };


    /////////////////Product Final Price Calculation start//////////////////////////////////////////////////////////////////////
    function getTaxPercent() {
        return parseFloat($('#tax_id option:selected').data('percent')) || 0;
    }

    // MAIN CALCULATION
    function calculatePrice(fromSales = false) {

        let basePrice = parseFloat($('#base_price').val()) || 0;
        let margin = parseFloat($('#profit_margin').val()) || 0;
        let taxPercent = getTaxPercent();
        let taxType = $('#tax_type').val();

        let purchasePrice = 0;
        let salesPrice = parseFloat($('#sales_price').val()) || 0;

        // PURCHASE PRICE
        if (taxType === 'with_tax') {
            purchasePrice = basePrice;
        } else {
            purchasePrice = basePrice + (basePrice * taxPercent / 100);
        }

        // যদি sales price থেকে margin calculate করতে চান
        if (fromSales) {

            if (purchasePrice > 0) {
                margin = ((salesPrice - purchasePrice) / purchasePrice) * 100;
            } else {
                margin = 0;
            }

            $('#profit_margin').val(margin.toFixed(2));

        } else {

            // margin থেকে sales price calculate
            salesPrice = purchasePrice * (1 + margin / 100);

            $('#sales_price').val(salesPrice.toFixed(2));
        }

        $('#purchase_price').val(purchasePrice.toFixed(2));
    }


    // EVENTS

    // base price / margin change হলে sales price auto calculate
    $('#base_price, #profit_margin').on('input', function () {
        calculatePrice(false);
    });

    // sales price change হলে margin auto calculate
    $('#sales_price').on('input', function () {
        calculatePrice(true);
    });

    // tax change হলে recalculation
    $('#tax_type, #tax_id').on('change', function () {
        calculatePrice(false);
    });
    //////////////Product Final Price Calculation End///////////////////////////////////////////////////////////////////////////////////
    $("#product_category").on("change", function () {
        var categoryId = this.value;

        if (!categoryId) {

            $("#product_brand")
                .html('<option value="">Select Brand</option>')
                .val('')
                .trigger('change');

            return;
        }

        $.ajax({
            // url: "<?=site_url('brands/initial-product-brand')?>",
            //initialbrand
            url: window.APP_URLS.initialbrand,
            type: "POST",
            data: {
                categoryId: categoryId
            },
            success: function (response) {

                $("#product_brand")
                    .html(response)
                    .val('')
                    .trigger('change');

                // এখানে এই অংশ যোগ করুন
                let selectedBrand = $("#product_brand").data("selected_brand");

                if (selectedBrand) {
                    $("#product_brand")
                        .val(selectedBrand)
                        .trigger('change');
                    $("#product_brand").removeData("selected_brand");
                }

                $("#product_brand").trigger("change");
            }
        });
    });



    $('#sampleTable').DataTable({
        responsive: true,
        autoWidth: false,
        pageLength: 25
    });

    ////-------------------Product Entry Form-------------------------//

    $('#tax_id').on('change', function () {

        var tax_percentage = $(this).find(':selected').data('percent');

        $('#tax_percentage').val(tax_percentage);

    });



    var allowSubmit = true;

    $('#NewProductAdd_Form').submit(function (event) {
        event.preventDefault();

        if (allowSubmit) {
            allowSubmit = false;
            var parentMOdal = $(this).closest('.modal');
            var postData = new FormData(this);
            $.ajax({
                //alert("ddd");
                type: $(this).attr("method"),
                url: $(this).attr("action"),
                // alert(;
                data: postData,
                //dataType: 'json',
                encode: true,
                processData: false,
                contentType: false,
            })
                // using the done promise callback
                .done(function (data) {
                    if (data == 1) {
                        parentMOdal.modal('toggle');
                        //     //page refresh after submission
                        location.reload();
                        //     // alert("Success");
                    }

                    // alert(data);
                });

        }
    });


    //////Product Edit submit into database start/////////////////////////////////


    $('#ProductEdit_submit_form').submit(function (event) {
        event.preventDefault();

        if (allowSubmit) {
            allowSubmit = false;
            var parentMOdal = $(this).closest('.modal');
            var postData = new FormData(this);

            $.ajax({
                type: $(this).attr("method"),
                url: $(this).attr("action"),
                data: postData,
                processData: false,
                contentType: false,
            })
                .done(function (data) {
                    allowSubmit = true; // ✅ allow future submissions
                    if (data == 1) {
                        parentMOdal.modal('hide'); // ✅ hide modal
                        location.reload(); // refresh page to show updates
                    } else {
                        alert('Failed to update product.'); // handle failure
                    }
                })
                .fail(function () {
                    allowSubmit = true;
                    alert('Something went wrong. Please try again.');
                });
        }

    });

    /////////Product Edit Submit inot database end here//////////////////////



    //...................JQuery for Modal Edit & Delete option...................................



    // get Edit Product
    $('.btn-edit').on('click', function () {
        // get data from button edit
        const product_id = $(this).data('product_id');
        const product_name = $(this).data('product_name');

        const productinitial_quantity = $(this).data('productinitial_quantity');
        const base_price = $(this).data('base_price');
        // const final_price = $(this).data('final_price');
        const codefor_barcode = $(this).data('codefor_barcode');
        const alert_quantity = $(this).data('alert_quantity');

        // Set data to Form Edit
        $('#product_id').val(product_id);
        $('#product_name').val(product_name);

        //$('#product_category').val(product_category);

        ///Category auto selected/////////////////////////////////////////////
        //var expense_category_id = $(this).data('expense_category_id');
        var product_category_id = $(this).data('product_category');
        $("#product_category12 option[value=product_category_id]").attr('selected', 'selected');
        $("#product_category12").val(product_category_id);
        //////////////////////////////////////////////////////////

        var product_brand_id = $(this).data('product_brand');
        $("#product_brand12 option[value=product_brand_id]").attr('selected', 'selected');
        $("#product_brand12").val(product_brand_id);

        var product_group_id = $(this).data('product_group');
        $("#product_group12 option[value=product_group_id]").attr('selected', 'selected');
        $("#product_group12").val(product_group_id);


        // $('#product_unit').val(product_unit);
        var product_unit_id = $(this).data('product_unit');
        $("#product_unit12 option[value=product_unit_id]").attr('selected', 'selected');
        $("#product_unit12").val(product_unit_id);

        //$('#tax_percentage').val(tax_percentage);
        var tax_perchange_id = $(this).data('tax_percentage');
        $("#tax_percentage12 option[value=tax_perchange_id]").attr('selected', 'selected');
        $("#tax_percentage12").val(tax_perchange_id);

        $('#productinitial_quantity').val(productinitial_quantity);
        $('#base_price').val(base_price);
        // $('#final_price').val(final_price);
        $('#codefor_barcode').val(codefor_barcode);
        $('#alert_quantity').val(alert_quantity);
        // Call Modal Edit
        $('#EditProductModal').modal('show');
    });

    // get Delete Product
    $('.btn-delete').on('click', function () {
        // get data from button edit
        const delete_id = $(this).data('delete_id');
        // Set data to Form Edit
        $('#delete_id').val(delete_id);
        // Call Modal Edit
        $('#DeleteProductModal').modal('show');
    });

    //................ JQuery modal Edit & Delete end here........................................
    // ...............For Date Show.............................
    $('.datePicker').datepicker({
        format: "dd/mm/yyyy",
        autoclose: true,
        todayHighlight: true
    });
    //.................For Date show end........................

    ///////////////////product image upload issue//////////////////////////////////
    $('.custom-file-input').on('change', function () {
        var fileName = $(this).val().split('\\').pop();
        $(this).next('.custom-file-label').html(fileName);
    });



    document.getElementById("file").onchange = function (evt) {
        const [file] = this.files;
        if (file) {
            document.getElementById("preview").src = URL.createObjectURL(file);
            document.getElementById("preview").style.display = "block";
        }
    }
    ////////////////////////////////////////////////////////

    //=================================== Category Add dynamically ==================================

    // $("#btnAddCategory").click(function () {

    //     $('#AddNewProduct').modal('hide');

    //     setTimeout(function () {

    //         Swal.fire({
    //             title: "Add Product Category",
    //             input: "text",
    //             inputPlaceholder: "Enter Category Name",
    //             allowOutsideClick: false,
    //             showCancelButton: true,
    //             confirmButtonText: "Save"
    //         }).then((result) => {

    //             $('#AddNewProduct').modal('show');

    //             if (result.isConfirmed) {
    //                 // const categoryCreateUrl = "<?= site_url('categories/category-create-ajax') ?>";

    //                 $.ajax({
    //                     url: window.APP_URLS.categoryCreate,
    //                     type: "POST",
    //                     dataType: "json",
    //                     data: {
    //                         category_name: result.value
    //                     },
    //                     success: function (response) {

    //                         if (response.status) {

    //                             $("#product_category").append(
    //                                 '<option value="' + response.id +
    //                                 '" selected>' + response.name +
    //                                 '</option>'
    //                             );

    //                             $("#product_category").trigger('change');

    //                             Swal.fire({
    //                                 icon: 'success',
    //                                 title: 'Category Added'
    //                             });
    //                         }
    //                     }
    //                 });

    //             }

    //         });

    //     }, 300);

    // });

    $("#btnAddCategory").click(function () {

    $('#AddNewProduct').modal('hide');

    setTimeout(function () {

        Swal.fire({
            title: "Add Product Category",
            input: "text",
            inputPlaceholder: "Enter Category Name",
            allowOutsideClick: false,
            showCancelButton: true,
            confirmButtonText: "Save",

            inputValidator: (value) => {
                if (!value || !value.trim()) {
                    return "Please enter Category Name";
                }
            }

        }).then((result) => {

            $('#AddNewProduct').modal('show');

            if (result.isConfirmed) {

                $.ajax({
                    url: window.APP_URLS.categoryCreate,
                    type: "POST",
                    dataType: "json",

                    data: {
                        category_name: result.value.trim()
                    },

                    success: function (response) {

                        if (response.status) {

                            // Add new category and automatically select it
                            let newOption = new Option(
                                response.name,
                                response.id,
                                true,
                                true
                            );

                            $("#product_category")
                                .append(newOption)
                                .trigger('change');

                            // Success alert automatically disappears
                            Swal.fire({
                                icon: 'success',
                                title: 'Category Added',
                                timer: 1200,
                                showConfirmButton: false
                            });

                        } else {

                            Swal.fire({
                                icon: 'error',
                                title: 'Failed',
                                text: response.message || 'Unable to add Category',
                                timer: 2000,
                                showConfirmButton: false
                            });

                        }

                    },

                    error: function (xhr) {

                        console.log(xhr.responseText);

                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Unable to add Category',
                            timer: 2000,
                            showConfirmButton: false
                        });

                    }
                });

            }

        });

    }, 300);

});
    //===================================================================================================


  //=================================== Brand Add dynamically ==================================

// =================================== Brand Add dynamically ==================================

$("#btnAddBrand").click(function () {

    // Keep currently selected category
    const selectedCategory = $("#product_category").val();

    // Category must be selected first
    if (!selectedCategory) {

        Swal.fire({
            icon: "warning",
            title: "Select Category First",
            text: "Please select a Product Category before adding a Brand.",
            timer: 1800,
            showConfirmButton: false
        });

        return;
    }

    // Get selected category name
    const selectedCategoryName =
        $("#product_category option:selected").text().trim();

    // Hide Product modal
    $('#AddNewProduct').modal('hide');

    setTimeout(function () {

        Swal.fire({

            title: '<span style="font-size:22px;font-weight:600;">Add Brand</span>',

            width: '500px',

            html: `
                <div style="text-align:left">

                    <div class="mb-3">

                        <label style="font-weight:600;margin-bottom:6px;display:block;">
                            Category
                        </label>

                        <input
                            type="text"
                            class="form-control"
                            value="${selectedCategoryName}"
                            readonly
                            style="background-color:#f5f5f5;">

                    </div>

                    <div class="mt-3">

                        <label
                            for="swal_brand"
                            style="font-weight:600;margin-bottom:6px;display:block;">
                            Brand Name
                        </label>

                        <input
                            id="swal_brand"
                            type="text"
                            class="form-control"
                            placeholder="Enter Brand Name"
                            autocomplete="off">

                    </div>

                </div>
            `,

            showCancelButton: true,

            confirmButtonText: '<i class="fa fa-save"></i> Save',

            cancelButtonText: 'Cancel',

            confirmButtonColor: '#0d6efd',

            cancelButtonColor: '#6c757d',

            focusConfirm: false,

            allowOutsideClick: false,

            // =====================================================
            // When SweetAlert opens
            // =====================================================

            didOpen: () => {

                // Automatically focus Brand input
                $("#swal_brand").focus();

                // Press ENTER = Save
                $("#swal_brand").on("keydown", function (e) {

                    if (e.key === "Enter") {

                        e.preventDefault();

                        Swal.clickConfirm();
                    }

                });

            },

            // =====================================================
            // Validate Brand
            // =====================================================

            preConfirm: () => {

                const brand = $("#swal_brand").val().trim();

                if (!brand) {

                    Swal.showValidationMessage(
                        "Please enter Brand Name"
                    );

                    return false;
                }

                return {
                    category: selectedCategory,
                    brand: brand
                };

            }

        }).then((result) => {

            // Show Product modal again
            $('#AddNewProduct').modal('show');

            // Cancel
            if (!result.isConfirmed) {
                return;
            }

            // =====================================================
            // AJAX - Create Brand
            // =====================================================

            $.ajax({

                url: window.APP_URLS.brandCreate,

                type: "POST",

                dataType: "json",

                data: {

                    category_id: result.value.category,

                    product_brand_name: result.value.brand

                },

                success: function (response) {

                    if (response.status) {

                        // =================================================
                        // Store newly created brand ID
                        // =================================================

                        $("#product_brand").data(
                            "selected_brand",
                            response.id
                        );


                        // =================================================
                        // Keep same category selected
                        // =================================================

                        $("#product_category")
                            .val(selectedCategory)
                            .trigger("change");


                        // =================================================
                        // Success message
                        // =================================================

                        Swal.fire({

                            icon: 'success',

                            title: 'Brand Added Successfully',

                            timer: 1200,

                            showConfirmButton: false

                        });

                    } else {

                        // =================================================
                        // Server returned error
                        // =================================================

                        Swal.fire({

                            icon: 'error',

                            title: 'Failed',

                            text: response.message ||
                                'Unable to add Brand',

                            timer: 2000,

                            showConfirmButton: false

                        });

                    }

                },

                error: function (xhr) {

                    console.log(xhr.responseText);

                    Swal.fire({

                        icon: 'error',

                        title: 'Error',

                        text: 'Unable to add brand. Please try again.',

                        timer: 2000,

                        showConfirmButton: false

                    });

                }

            });

        });

    }, 300);

});

    //===================================================================================================


    //========================Product Group / Generic Name====================================================

    // $("#btnAddGroup").click(function () {

    //     $('#AddNewProduct').modal('hide');

    //     setTimeout(function () {

    //         Swal.fire({
    //             title: "Add Product Group/Generic",
    //             input: "text",
    //             inputPlaceholder: "Enter Generic Name",
    //             allowOutsideClick: false,
    //             showCancelButton: true,
    //             confirmButtonText: "Save"
    //         }).then((result) => {

    //             $('#AddNewProduct').modal('show');

    //             if (result.isConfirmed) {

    //                 $.ajax({
    //                     // url: "<?=site_url('groups/group-create-ajax')?>",
    //                     url: window.APP_URLS.groupCreate,
    //                     type: "POST",
    //                     dataType: "json",
    //                     data: {
    //                         group_name: result.value
    //                     },
    //                     success: function (response) {

    //                         if (response.status) {

    //                             $("#product_group").append(
    //                                 '<option value="' + response.id +
    //                                 '" selected>' + response.name +
    //                                 '</option>'
    //                             );

    //                             $("#product_group").trigger('change');

    //                             Swal.fire({
    //                                 icon: 'success',
    //                                 title: 'Group/Generic Added'
    //                             });
    //                         }
    //                     }
    //                 });

    //             }

    //         });

    //     }, 300);

    // });

    $("#btnAddGroup").click(function () {

    $('#AddNewProduct').modal('hide');

    setTimeout(function () {

        Swal.fire({
            title: "Add Product Group/Generic",
            input: "text",
            inputPlaceholder: "Enter Generic Name",
            allowOutsideClick: false,
            showCancelButton: true,
            confirmButtonText: "Save",

            // Optional validation
            inputValidator: (value) => {
                if (!value || !value.trim()) {
                    return "Please enter Generic Name";
                }
            }

        }).then((result) => {

            $('#AddNewProduct').modal('show');

            if (result.isConfirmed) {

                $.ajax({
                    url: window.APP_URLS.groupCreate,
                    type: "POST",
                    dataType: "json",

                    data: {
                        group_name: result.value.trim()
                    },

                    success: function (response) {

                        if (response.status) {

                            // Add new group to Select2
                            let newOption = new Option(
                                response.name,
                                response.id,
                                true,
                                true
                            );

                            $("#product_group")
                                .append(newOption)
                                .trigger('change');

                            // Success message automatically disappears
                            Swal.fire({
                                icon: 'success',
                                title: 'Group/Generic Added',
                                timer: 1200,
                                showConfirmButton: false,
                                allowOutsideClick: false
                            });

                        } else {

                            Swal.fire({
                                icon: 'error',
                                title: 'Failed',
                                text: response.message || 'Unable to add Group/Generic',
                                timer: 2000,
                                showConfirmButton: false
                            });

                        }
                    },

                    error: function (xhr) {

                        console.log(xhr.responseText);

                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Unable to add Group/Generic',
                            timer: 2000,
                            showConfirmButton: false
                        });

                    }
                });
            }

        });

    }, 300);

});
    //===============================================================================================================

    //===============================Product Unit===============================================

  $("#btnAddUnit").click(function () {

    $('#AddNewProduct').modal('hide');

    setTimeout(function () {

        Swal.fire({
            title: "Add Product Unit",
            input: "text",
            inputPlaceholder: "Enter Unit Name",
            allowOutsideClick: false,
            showCancelButton: true,
            confirmButtonText: "Save",

            inputValidator: (value) => {
                if (!value || !value.trim()) {
                    return "Please enter Unit Name";
                }
            }

        }).then((result) => {

            $('#AddNewProduct').modal('show');

            if (result.isConfirmed) {

                $.ajax({
                    url: window.APP_URLS.unitCreate,
                    type: "POST",
                    dataType: "json",

                    data: {
                        product_unit: result.value.trim()
                    },

                    success: function (response) {

                        if (response.status) {

                            // Add new unit and automatically select it
                            let newOption = new Option(
                                response.name,
                                response.id,
                                true,
                                true
                            );

                            $("#product_unit")
                                .append(newOption)
                                .trigger('change');

                            // Success message automatically disappears
                            Swal.fire({
                                icon: 'success',
                                title: 'Product Unit Added',
                                timer: 1200,
                                showConfirmButton: false
                            });

                        } else {

                            Swal.fire({
                                icon: 'error',
                                title: 'Failed',
                                text: response.message || 'Unable to add Product Unit',
                                timer: 2000,
                                showConfirmButton: false
                            });

                        }

                    },

                    error: function (xhr) {

                        console.log(xhr.responseText);

                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Unable to add Product Unit',
                            timer: 2000,
                            showConfirmButton: false
                        });

                    }
                });

            }

        });

    }, 300);

});


    //====================Strength add======================================================================

    // $("#btnAddStrength").click(function () {

    //     $('#AddNewProduct').modal('hide');

    //     setTimeout(function () {

    //         Swal.fire({
    //             title: "Add Product Strength",
    //             input: "text",
    //             inputPlaceholder: "Enter Strength (e.g. 500 mg)",
    //             allowOutsideClick: false,
    //             showCancelButton: true,
    //             confirmButtonText: "Save"
    //         }).then((result) => {

    //             $('#AddNewProduct').modal('show');

    //             if (result.isConfirmed && result.value.trim() != "") {

    //                 $.ajax({
    //                     // url: "<?=site_url('ajax/strength')?>",
    //                     url: window.APP_URLS.strengthCreate,
    //                     type: "POST",
    //                     dataType: "json",
    //                     data: {
    //                         strength: result.value
    //                     },
    //                     success: function (response) {

    //                         if (response.status) {

    //                             // শুধু input-এ value সেট করুন
    //                             // $("#strength").val(response.name);


    //                             $("#strength").append(
    //                                 '<option value="' + response.id +
    //                                 '" selected>' + response.name +
    //                                 '</option>'
    //                             );

    //                             $("#strength").trigger('change');


    //                             Swal.fire({
    //                                 icon: 'success',
    //                                 title: 'Product Strength Added'
    //                             });

    //                         } else {
    //                             Swal.fire({
    //                                 icon: 'error',
    //                                 title: response.message
    //                             });
    //                         }

    //                     }
    //                 });

    //             }

    //         });

    //     }, 300);

    // });

    $("#btnAddStrength").click(function () {

    $('#AddNewProduct').modal('hide');

    setTimeout(function () {

        Swal.fire({
            title: "Add Product Strength",
            input: "text",
            inputPlaceholder: "Enter Strength (e.g. 500 mg)",
            allowOutsideClick: false,
            showCancelButton: true,
            confirmButtonText: "Save",

            inputValidator: (value) => {
                if (!value || !value.trim()) {
                    return "Please enter Strength";
                }
            }

        }).then((result) => {

            $('#AddNewProduct').modal('show');

            if (result.isConfirmed) {

                $.ajax({
                    url: window.APP_URLS.strengthCreate,
                    type: "POST",
                    dataType: "json",

                    data: {
                        strength: result.value.trim()
                    },

                    success: function (response) {

                        if (response.status) {

                            // Add new strength and automatically select it
                            let newOption = new Option(
                                response.name,
                                response.id,
                                true,
                                true
                            );

                            $("#strength")
                                .append(newOption)
                                .trigger('change');

                            // Automatically disappear
                            Swal.fire({
                                icon: 'success',
                                title: 'Product Strength Added',
                                timer: 1200,
                                showConfirmButton: false
                            });

                        } else {

                            Swal.fire({
                                icon: 'error',
                                title: 'Failed',
                                text: response.message || 'Unable to add Product Strength',
                                timer: 2000,
                                showConfirmButton: false
                            });

                        }

                    },

                    error: function (xhr) {

                        console.log(xhr.responseText);

                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Unable to add Product Strength',
                            timer: 2000,
                            showConfirmButton: false
                        });

                    }
                });

            }

        });

    }, 300);

});
    //===============================================================================

    // $("#btnAddVatTax").click(function () {

    //     $('#AddNewProduct').modal('hide');

    //     setTimeout(function () {

    //         Swal.fire({
    //             title: "Add VAT/TAX",
    //             html: `
    //             <input id="tax_name" class="swal2-input" placeholder="Tax Name">
    //             <input id="tax_percentage" type="number" class="swal2-input" placeholder="Tax Percentage">
    //         `,
    //             focusConfirm: false,
    //             showCancelButton: true,
    //             confirmButtonText: "Save",

    //             preConfirm: () => {

    //                 return {
    //                     tax_name: $("#tax_name").val(),
    //                     tax_percentage: $("#tax_percentage").val()
    //                 };

    //             }

    //         }).then((result) => {

    //             $('#AddNewProduct').modal('show');

    //             if (!result.isConfirmed) return;

    //             $.ajax({

    //                 //url: "<?=site_url('tax/vatTax-create-ajax')?>",
    //                 url: window.APP_URLS.taxCreate,
    //                 type: "POST",
    //                 dataType: "json",
    //                 data: result.value,

    //                 success: function (response) {

    //                     if (response.status) {

    //                         $("#tax_id").append(
    //                             '<option value="' + response.id +
    //                             '" data-percent="' + response.tax_percentage +
    //                             '" selected>' +
    //                             response.tax_name + ' (' +
    //                             response.tax_percentage + '%)</option>'
    //                         );

    //                         $("#tax_id").trigger("change");

    //                         Swal.fire({
    //                             icon: "success",
    //                             title: "VAT/TAX Added Successfully"
    //                         });

    //                     } else {

    //                         Swal.fire({
    //                             icon: "error",
    //                             title: response.message
    //                         });

    //                     }

    //                 }

    //             });

    //         });

    //     }, 300);

    // });
    // //=========================================================================================

});