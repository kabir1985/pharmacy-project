<?php
echo $this->extend('layout');
echo $this->section('content');
?>
<div class='app-title'>
    <div>
        <h1><i class='fa fa-th-list'></i>User Permission / Role Update & Set Newly Here</h1>
    </div>

    <!-- Button trigger modal -->
    <button type='button' class='btn btn-primary btn-sm' data-toggle='modal' data-target='#UserAdd'>
        <i class='fa fa-user-plus'></i>
        User Role Add
    </button>
</div>
<!---------------Data Table start Here----..............................................--------------------------->
<div class='row'>
    <div class='col-md-12'>
        <div class='tile collapseable show animate__animated  animate__fadeInUp'>
            <div class='tile-body'>
                <div class='table-responsive'>
                    <!-- <table  id='sampleTable'> -->

                    <table>
                        <tr>
                            <th>Role Name</th>
                            <th>Privilege</th>
                            <th>Role Edit</th>
                        </tr>
                        <?php foreach ($roles as $role): ?>
                            <tr>
                                <td><?= esc($role['role_holder']) ?></td>
                                <td><?= esc($role['privilege_text']) ?></td>
                                <td>
                                    <!-- <a href="<?= site_url('userrole/edit/' . $role['user_role_id']) ?>">Edit</a> -->

                                    <!-- Button to invoke the modal -->
                                    <a href="#" class="btn btn-secondary btn-sm btn-edit"
                                        data-role_id="<?php echo $role['user_role_id'] ?>"
                                        data-user_previlege="<?php echo $role['user_previlege'] ?>"
                                        data-role_holder_name="<?php echo $role['role_holder'] ?>">
                                        <i class="fa fa-edit"> &nbsp;Edit</i></a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!---------------Data Table End Here-----------............................................-------------------->



<!--##############################-Modal Form for Entry Load Start-######################################--->
<!-- Modal -->
<div class='modal fade' id='UserAdd' tabindex='-1' role='dialog' aria-labelledby='UserAdd' aria-hidden='true'>
    <div class='modal-dialog modal-lg modal-dialog-centered' role='document'>
        <div class='modal-content'>
            <div class='modal-header'>
                <h5 class='modal-title' id='exampleModalLabel'>Please Add User Role1122</h5>
                <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                    <span aria-hidden='true'>&times;
                    </span>
                </button>
            </div>
            <div class='modal-body'>
                <div class='form-row'>
                    <div class='form-group col-md-12'>
                        <label>Role Holder Name</label>
                        <input required type='text' required class='form-control' id="role_holder_name"
                            name='role_holder_name' placeholder='Role Holder Name'>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-3 font-weight-bold text-white bg-dark">Product Section</div>
                    <div class="col-sm-3 font-weight-bold text-white bg-info">Sales Section</div>
                    <div class="col-sm-3 font-weight-bold text-white bg-success">Purchase Section</div>
                    <div class="col-sm-3 font-weight-bold text-white " style="background-color:#563d7c;">Expense Section
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-md-3">
                        <!-- <div class="col-sm-12 font-weight-bold text-primary">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="gridCheck1">
                                <label class="form-check-label" for="gridCheck1">
                                    Select All
                                </label>
                            </div>
                        </div> -->
                        <div class="col-sm-12">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="permissions[]"
                                    id="initial_product" value="1">
                                <label class="form-check-label" for="gridCheck1">
                                    initial Product
                                </label>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="permissions[]"
                                    id="barcode_generate" value="2">
                                <label class="form-check-label" for="gridCheck1">
                                    Barcode Gen.
                                </label>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="permissions[]"
                                    id="product_category" value="3">
                                <label class="form-check-label" for="gridCheck1">
                                    Product Category
                                </label>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="permissions[]" id="product_brand"
                                    value="4">
                                <label class="form-check-label" for="gridCheck1">
                                    Product Brand
                                </label>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="permissions[]" id="product_group"
                                    value="5">
                                <label class="form-check-label" for="gridCheck1">
                                    Product Group
                                </label>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="permissions[]" id="product_unit"
                                    value="6">
                                <label class="form-check-label" for="gridCheck1">
                                    Product Unit
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-md-3">
                        <div class="col-sm-12">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="permissions[]" id="pos_sale"
                                    value="7">
                                <label class="form-check-label" for="gridCheck1">
                                    POS Sale
                                </label>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="permissions[]" id="general_sale"
                                    value="8">
                                <label class="form-check-label" for="gridCheck1">
                                    Generale Sale
                                </label>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="permissions[]" id="sale_list"
                                    value="9">
                                <label class="form-check-label" for="gridCheck1">
                                    Sale List
                                </label>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="permissions[]" id="sale_return"
                                    value="10">
                                <label class="form-check-label" for="gridCheck1">
                                    Sales Return
                                </label>
                            </div>
                        </div>

                        <div class="col-sm-12">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="permissions[]"
                                    id="sale_return_list" value="11">
                                <label class="form-check-label" for="gridCheck1">
                                    Sales Return List
                                </label>
                            </div>
                        </div>

                    </div>
                    <div class="form-group col-md-3">
                        <div class="col-sm-12">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="permissions[]"
                                    id="purchase_product" value="12">
                                <label class="form-check-label" for="gridCheck1">
                                    Purchase Product
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-md-3">
                        <div class="col-sm-12">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="permissions[]"
                                    id="expense_category" value="13">
                                <label class="form-check-label" for="gridCheck1">
                                    Expense Category
                                </label>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="permissions[]"
                                    id="expense_sub_category" value="14">
                                <label class="form-check-label" for="gridCheck1">
                                    Exp. Sub-category
                                </label>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="permissions[]" id="expense_add"
                                    value="15">
                                <label class="form-check-label" for="gridCheck1">
                                    Expense Add
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-3 font-weight-bold text-white bg-info">People Section</div>
                    <div class="col-sm-3 font-weight-bold text-white bg-secondary">Payment Section</div>
                    <div class="col-sm-3 font-weight-bold text-white bg-primary">Settings Section</div>
                    <div class="col-sm-3 font-weight-bold text-white bg-success">Report Section</div>
                </div>

                <div class="row">
                    <div class="form-group col-md-3">
                        <!-- <div class="col-sm-12 font-weight-bold text-primary">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="gridCheck1">
                                <label class="form-check-label" for="gridCheck1">
                                    Select All
                                </label>
                            </div>
                        </div> -->
                        <div class="col-sm-12">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="permissions[]" id="customer_group"
                                    value="16">
                                <label class="form-check-label" for="gridCheck1">
                                    Customer Group
                                </label>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="permissions[]" id="customer_add"
                                    value="17">
                                <label class="form-check-label" for="gridCheck1">
                                    Customer Add
                                </label>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="permissions[]" id="supplier_add"
                                    value="18">
                                <label class="form-check-label" for="gridCheck1">
                                    Supplier Add
                                </label>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="permissions[]" id="user_creation"
                                    value="19">
                                <label class="form-check-label" for="gridCheck1">
                                    User Creation
                                </label>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="permissions[]" id="user_role_set"
                                    value="20">
                                <label class="form-check-label" for="gridCheck1">
                                    User Role Set
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-md-3">
                        <div class="col-sm-12">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="permissions[]"
                                    id="receive_customer" value="21">
                                <label class="form-check-label" for="gridCheck1">
                                    Receive Customer
                                </label>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="permissions[]"
                                    id="supplier_payment" value="22">
                                <label class="form-check-label" for="gridCheck1">
                                    Supplier Payment
                                </label>
                            </div>
                        </div>

                    </div>
                    <div class="form-group col-md-3">
                        <div class="col-sm-12">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="permissions[]"
                                    id="general_settings" value="23">
                                <label class="form-check-label" for="gridCheck1">
                                    General Settings
                                </label>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="permissions[]"
                                    id="currency_settings" value="24">
                                <label class="form-check-label" for="gridCheck1">
                                    Currency Settings
                                </label>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="permissions[]" id="tax_setup"
                                    value="25">
                                <label class="form-check-label" for="gridCheck1">
                                    % Tax Setup
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-md-3">
                        <div class="col-sm-12">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="permissions[]" id="stock_report"
                                    value="26">
                                <label class="form-check-label" for="gridCheck1">
                                    Stock Report
                                </label>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="permissions[]" id="sale_report"
                                    value="27">
                                <label class="form-check-label" for="gridCheck1">
                                    Sale Report
                                </label>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="permissions[]" id="profit_loss"
                                    value="28">
                                <label class="form-check-label" for="gridCheck1">
                                    Profit-Losss RPT
                                </label>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="permissions[]" id="expense_report"
                                    value="29">
                                <label class="form-check-label" for="gridCheck1">
                                    Expense Report
                                </label>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="permissions[]"
                                    id="supplier_report" value="30">
                                <label class="form-check-label" for="gridCheck1">
                                    Supplier Report
                                </label>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="permissions[]"
                                    id="customer_report" value="31">
                                <label class="form-check-label" for="gridCheck1">
                                    Customer Report
                                </label>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="permissions[]" id="vat_tax_report"
                                    value="32">
                                <label class="form-check-label" for="gridCheck1">
                                    Vat/Tax Report
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class='modal-footer'>
                <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
                <button type='submit' id="SubmitButton" class='btn btn-primary'>Save changes</button>
            </div>
            <!-- </form> -->
        </div>
    </div>
</div>

<!--##############################-Modal Form for Entry Load End-######################################--->



<!--%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%Modal Form for Edit Section Load Start%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%------->
<!-- Modal -->
<!-- Modal -->
<div class="modal fade" id="user_previlege_edit" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="POST" action= "<?php echo site_url('roleUpdate') ?>">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Role</h5>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="role_id" id="role_id">

                    <div class="form-group">
                        <label>Role Name</label>
                        <input type="text" name="role_holder_name" id="role_holder_name1" class="form-control" readonly>
                    </div>

                    <div class="form-group">
                        <label>Privileges</label>
                        <div class="row">
                            <?php foreach ($menus as $menu): ?>
                                <div class="col-md-4">
                                    <label>
                                        <input type="checkbox" class="menu_perm" name="menu_perm[]"
                                            value="<?= $menu['menu_id'] ?>">
                                        <?= ucwords(str_replace('_', ' ', $menu['menu_name'])) ?>
                                    </label>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save123</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!--%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%Modal Form for Edit Section Load End %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%------->



<!-- Modal Delete Product-->

<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Delete Customer</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <h4>Are you sure want to delete this Customer?</h4>

            </div>
            <form action="<?php echo site_url('/Group/delete') ?>" method="post">
                <div class="modal-footer">
                    <input type="hidden" required class='form-control' name="delete_id" id="delete_id">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                    <button type="submit" class="btn btn-primary">Yes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- End Modal Delete Product-->


<?php
echo $this->endSection();
?>

<?php
echo $this->section('scripts');
?>

<!-- Data table plugin-->
<script type='text/javascript' src="<?php echo base_url('assets/js/plugins/jquery.dataTables.min.js') ?>"></script>
<script type='text/javascript' src="<?php echo base_url('assets/js/plugins/dataTables.bootstrap.min.js') ?>"></script>

<script type='text/javascript'>
    $(document).ready(function () {


        $('#sampleTable').DataTable();

        ////-------------------Product Group Entry Form-------------------------//

        $('#SubmitButton').click(function (e) {
            e.preventDefault();

            var roleHolderName = $('#role_holder_name').val();
            var permissions = [];

            var orderedCheckboxIds = [
                'initial_product', 'barcode_generate', 'product_category', 'product_brand',
                'product_group', 'product_unit', 'pos_sale', 'general_sale',
                'sale_list', 'sale_return', 'sale_return_list', 'purchase_product',
                'expense_category', 'expense_sub_category', 'expense_add',
                'customer_group', 'customer_add', 'supplier_add',
                'user_creation', 'user_role_set', 'receive_customer', 'supplier_payment',
                'general_settings', 'currency_settings', 'tax_setup',
                'stock_report', 'sale_report', 'profit_loss', 'expense_report',
                'supplier_report', 'customer_report', 'vat_tax_report'
            ];

            // Build permission array respecting order
            orderedCheckboxIds.forEach(function (id) {
                var checkbox = $('#' + id);
                if (checkbox.is(':checked')) {
                    permissions.push(checkbox.val());
                } else {
                    permissions.push(0);
                }
            });

            if (roleHolderName.trim() === '') {
                alert('Please enter Role Holder Name');
                return;
            }

            // Send data
            $.ajax({
                url: '<?= site_url("roleCreate") ?>',
                type: 'POST',
                dataType: 'json',
                data: {
                    role_holder_name: roleHolderName,
                    permissions: permissions
                },
                success: function (response) {
                    //alert(response);
                    alert(response.message);
                    if (response.status === 'success') {
                        $('#UserAdd').modal('hide');
                        $('#UserAdd').find('input').prop('checked', false);
                        $('#role_holder_name').val('');
                    }
                },
                error: function () {
                    alert('An error occurred while saving. Please try again.');
                }
            });
        });


        //.........................................................................

        $('#product_group_edit_form').submit(function (event) {
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
                    .done(function (data) {
                        if (data == 1) {
                            //Modal Remove after submission
                            parentMOdal.modal('toggle');
                            //page refresh after submission
                            location.reload();
                        }
                    });
            }

        });



        //...................JQuery for Modal Edit & Delete option...................................

        // get Edit Product
        $('.btn-edit').on('click', function () {
            const role_id = $(this).data('role_id');
            const role_holder_name = $(this).data('role_holder_name');
            const user_previlege = $(this).data('user_previlege'); // e.g. "0,0,0,21,0,27"

            // Step 1: Parse values and remove "0"s
            const rawArray = user_previlege.split(',');
            const allowedPrivileges = rawArray.filter(v => v !== '0' && v !== '').map(v => v.trim());


           // console.log('user_previlege:', user_previlege);
           // console.log('allowedPrivileges:', allowedPrivileges);

            // Step 2: Uncheck all checkboxes
            $('.menu_perm').prop('checked', false);

            // Step 3: Check only matching ones
            $('.menu_perm').each(function () {
                const val = $(this).val();
                if (allowedPrivileges.includes(val)) {
                    $(this).prop('checked', true);
                }
            });

            // Step 4: Fill other modal fields
            $('#role_id').val(role_id);
            $('#role_holder_name1').val(role_holder_name);

            // Step 5: Show modal
            $('#user_previlege_edit').modal('show');
        });



        // get Delete Product
        $('.btn-delete').on('click', function () {
            // get data from button edit
            const delete_id = $(this).data('delete_id');
            //alert(delete_id);
            // Set data to Form Edit
            $('#delete_id').val(delete_id);
            // Call Modal Edit
            $('#deleteModal').modal('show');
        });


        //................ JQuery modal Edit & Delete end here........................................
        // ...............For Date Show.............................
        $('.datePicker').datepicker({
            format: "dd/mm/yyyy",
            autoclose: true,
            todayHighlight: true
        });
        //.................For Date show end........................ 

    });
</script>

<!-- For Calendar start -->

<!-- For Calendar End -->

<style>
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background: #f0f2f5;
        margin: 20px;
    }

    h2 {
        text-align: center;
        color: #333;
    }

    table {
        border-collapse: collapse;
        width: 100%;
        margin: 2px auto;
        background: #fff;
        box-shadow: 0 0 8px rgba(0, 0, 0, 0.1);
    }

    th,
    td {
        border: 1px solid #ddd;
        padding: 10px 8px;
        text-align: left;
    }

    th {
        background: #4CAF50;
        color: #fff;
    }

    tr:nth-child(even) {
        background: #f9f9f9;
    }

    tr:hover {
        background: #eef5f1;
    }

    a {
        color: #007BFF;
        text-decoration: none;
        font-weight: bold;
    }

    a:hover {
        text-decoration: underline;
    }
</style>


<?php
echo $this->endSection();
?>