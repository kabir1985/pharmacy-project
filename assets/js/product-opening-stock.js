

    // Fix modal close buttons
    $('.modal .btn-secondary[data-dismiss="modal"], .modal .close').on('click', function () {
        $(this).closest('.modal').modal('hide');
    });


    $(document).ready(function () {

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

            $.ajax({
               // url: "<?=site_url('brands/initial-product-brand')?>",
               //initialbrand
               url: window.APP_URLS.initialbrand,
                type: "POST",
                data: {
                    categoryId: categoryId
                },
                success: function (response) {

                    $("#product_brand").html(response);

                    // এখানে এই অংশ যোগ করুন
                    let selectedBrand = $("#product_brand").data("selected_brand");

                    if (selectedBrand) {
                        $("#product_brand").val(selectedBrand);
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

        $("#btnAddCategory").click(function () {

            $('#AddNewProduct').modal('hide');

            setTimeout(function () {

                Swal.fire({
                    title: "Add Product Category",
                    input: "text",
                    inputPlaceholder: "Enter Category Name",
                    allowOutsideClick: false,
                    showCancelButton: true,
                    confirmButtonText: "Save"
                }).then((result) => {

                    $('#AddNewProduct').modal('show');

                    if (result.isConfirmed) {
                       // const categoryCreateUrl = "<?= site_url('categories/category-create-ajax') ?>";

                        $.ajax({
                            url: window.APP_URLS.categoryCreate,
                            type: "POST",
                            dataType: "json",
                            data: {
                                category_name: result.value
                            },
                            success: function (response) {

                                if (response.status) {

                                    $("#product_category").append(
                                        '<option value="' + response.id +
                                        '" selected>' + response.name +
                                        '</option>'
                                    );

                                    $("#product_category").trigger('change');

                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Category Added'
                                    });
                                }
                            }
                        });

                    }

                });

            }, 300);

        });
        //===================================================================================================


        //=================================== Brand Add dynamically ==================================

        $("#btnAddBrand").click(function () {

            // alert("kabir")

            $('#AddNewProduct').modal('hide');

            setTimeout(function () {

                $.ajax({
                    //url: "<?=site_url('categories/get-category-list')?>",
                    url: window.APP_URLS.getCategory,
                    type: "GET",
                    dataType: "json",
                    success: function (categories) {

                        //alert(categories)

                        let option = '';

                        $.each(categories, function (i, row) {
                            option += '<option value="' + row
                                .product_category_id + '">' + row
                                    .category_name + '</option>';
                        });

                        Swal.fire({
                            title: '<span style="font-size:22px;font-weight:600;">Add Brand</span>',
                            width: '500px',
                            html: `
        <div style="text-align:left">

            <div class="mb-3">
                <label for="swal_category" style="font-weight:600;margin-bottom:6px;display:block;">
                    Category
                </label>
                <select id="swal_category" class="swal2-select custom-input">
                    ${option}
                </select>
            </div>

            <div class="mt-3">
                <label for="swal_brand" style="font-weight:600;margin-bottom:6px;display:block;">
                    Brand Name
                </label>
                <input
                    id="swal_brand"
                    type="text"
                    class="swal2-input custom-input"
                    placeholder="Enter Brand Name">
            </div>

        </div>
    `,
                            showCancelButton: true,
                            confirmButtonText: '<i class="fa fa-save"></i> Save',
                            cancelButtonText: 'Cancel',
                            confirmButtonColor: '#0d6efd',
                            cancelButtonColor: '#6c757d',
                            focusConfirm: false,

                            /////////////////////////////////////////
                            preConfirm: () => {

                                return {
                                    category: $("#swal_category").val(),
                                    brand: $("#swal_brand").val()
                                };

                            }
                            ////////////////////////////////////////////////


                        }).then((result) => {

                            $('#AddNewProduct').modal('show');

                            if (result.isConfirmed) {

                                $.ajax({
                                   // url: "<?=site_url('brands/brand-create-ajax')?>",
                                   url: window.APP_URLS.brandCreate,
                                    type: "POST",
                                    dataType: "json",
                                    data: {
                                        category_id: result.value
                                            .category,
                                        product_brand_name: result.value
                                            .brand
                                    },
                                    success: function (response) {

                                        if (response.status) {

                                            loadCategory(
                                                result.value
                                                    .category,
                                                response.id
                                            );

                                            Swal.fire({
                                                icon: 'success',
                                                title: 'Brand Added Successfully'
                                            });

                                        } else {

                                            Swal.fire({
                                                icon: 'error',
                                                title: response
                                                    .message
                                            });

                                        }

                                    }
                                });

                            }

                        });

                    }
                });

            }, 300);

        });


        function loadCategory(selected_category = null, selected_brand = null) {
            $.ajax({
               // url: "<?=site_url('get-category-list')?>",
               url: window.APP_URLS.categoryList,
                type: "GET",
                dataType: "json",
                success: function (response) {

                    $("#product_category").empty();

                    $.each(response, function (i, row) {

                        $("#product_category").append(
                            '<option value="' + row.product_category_id + '">' +
                            row.category_name +
                            '</option>'
                        );

                    });

                    if (selected_category) {
                        $("#product_category").val(selected_category);
                    }

                    // Brand ID Store করুন
                    $("#product_brand").data("selected_brand", selected_brand);

                    $("#product_category").trigger("change");
                }
            });
        }

        //===================================================================================================

        //========================Product Group / Generic Name====================================================

        $("#btnAddGroup").click(function () {

            $('#AddNewProduct').modal('hide');

            setTimeout(function () {

                Swal.fire({
                    title: "Add Product Group/Generic",
                    input: "text",
                    inputPlaceholder: "Enter Generic Name",
                    allowOutsideClick: false,
                    showCancelButton: true,
                    confirmButtonText: "Save"
                }).then((result) => {

                    $('#AddNewProduct').modal('show');

                    if (result.isConfirmed) {

                        $.ajax({
                           // url: "<?=site_url('groups/group-create-ajax')?>",
                           url: window.APP_URLS.groupCreate,
                            type: "POST",
                            dataType: "json",
                            data: {
                                group_name: result.value
                            },
                            success: function (response) {

                                if (response.status) {

                                    $("#product_group").append(
                                        '<option value="' + response.id +
                                        '" selected>' + response.name +
                                        '</option>'
                                    );

                                    $("#product_group").trigger('change');

                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Group/Generic Added'
                                    });
                                }
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
                    confirmButtonText: "Save"

                }).then((result) => {

                    $('#AddNewProduct').modal('show');

                    if (result.isConfirmed) {

                        $.ajax({
                           // url: "<?=site_url('units/unit-create-ajax')?>",
                           url: window.APP_URLS.unitCreate,
                            type: "POST",
                            dataType: "json",
                            data: {
                                product_unit: result.value
                            },
                            success: function (response) {

                                if (response.status) {

                                    $("#product_unit").append(
                                        '<option value="' + response.id +
                                        '" selected>' + response.name +
                                        '</option>'
                                    );

                                    $("#product_unit").trigger('change');

                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Product Unit Added'
                                    });
                                }
                            }
                        });

                    }

                });

            }, 300);

        });


        //====================Strength add======================================================================

        $("#btnAddStrength").click(function () {

            $('#AddNewProduct').modal('hide');

            setTimeout(function () {

                Swal.fire({
                    title: "Add Product Strength",
                    input: "text",
                    inputPlaceholder: "Enter Strength (e.g. 500 mg)",
                    allowOutsideClick: false,
                    showCancelButton: true,
                    confirmButtonText: "Save"
                }).then((result) => {

                    $('#AddNewProduct').modal('show');

                    if (result.isConfirmed && result.value.trim() != "") {

                        $.ajax({
                           // url: "<?=site_url('ajax/strength')?>",
                           url: window.APP_URLS.strengthCreate,
                            type: "POST",
                            dataType: "json",
                            data: {
                                strength: result.value
                            },
                            success: function (response) {

                                if (response.status) {

                                    // শুধু input-এ value সেট করুন
                                    // $("#strength").val(response.name);


                                    $("#strength").append(
                                        '<option value="' + response.id +
                                        '" selected>' + response.name +
                                        '</option>'
                                    );

                                    $("#strength").trigger('change');


                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Product Strength Added'
                                    });

                                } else {
                                    Swal.fire({
                                        icon: 'error',
                                        title: response.message
                                    });
                                }

                            }
                        });

                    }

                });

            }, 300);

        });
        //===============================================================================

        $("#btnAddVatTax").click(function () {

            $('#AddNewProduct').modal('hide');

            setTimeout(function () {

                Swal.fire({
                    title: "Add VAT/TAX",
                    html: `
                <input id="tax_name" class="swal2-input" placeholder="Tax Name">
                <input id="tax_percentage" type="number" class="swal2-input" placeholder="Tax Percentage">
            `,
                    focusConfirm: false,
                    showCancelButton: true,
                    confirmButtonText: "Save",

                    preConfirm: () => {

                        return {
                            tax_name: $("#tax_name").val(),
                            tax_percentage: $("#tax_percentage").val()
                        };

                    }

                }).then((result) => {

                    $('#AddNewProduct').modal('show');

                    if (!result.isConfirmed) return;

                    $.ajax({

                        //url: "<?=site_url('tax/vatTax-create-ajax')?>",
                        url: window.APP_URLS.taxCreate,
                        type: "POST",
                        dataType: "json",
                        data: result.value,

                        success: function (response) {

                            if (response.status) {

                                $("#tax_id").append(
                                    '<option value="' + response.id +
                                    '" data-percent="' + response.tax_percentage +
                                    '" selected>' +
                                    response.tax_name + ' (' +
                                    response.tax_percentage + '%)</option>'
                                );

                                $("#tax_id").trigger("change");

                                Swal.fire({
                                    icon: "success",
                                    title: "VAT/TAX Added Successfully"
                                });

                            } else {

                                Swal.fire({
                                    icon: "error",
                                    title: response.message
                                });

                            }

                        }

                    });

                });

            }, 300);

        });
        //=========================================================================================

    });