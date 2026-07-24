<?php

/**
 * --------------------------------------------------------------------
 * Pharmacy Management System
 * --------------------------------------------------------------------
 *
 * Customer Management
 *
 * Features:
 * - Customer List
 * - Add Customer
 * - Edit Customer
 * - Delete Customer
 * - DataTable Search
 * - AJAX CRUD
 *
 * Author  : Kabir Hossain
 * Version : 1.0.0
 *
 * --------------------------------------------------------------------
 */

echo $this->extend('layout');
echo $this->section('content');
?>

<div class='app-title'>
    <div>
        <h1><i class='fa fa-th-list'></i> Customer List, Edit, Delete & Add Section</h1>
    </div>

    <!-- Button trigger modal -->
    <button type='button' class='btn btn-primary btn-sm' data-toggle='modal' data-target='#CustomerAdd'>
        <i class='fa fa-user-plus'></i>
        Customer Add
    </button>
</div>



<!-- ========================================================= -->
<!-- Customer Data shoe -->
<!-- ========================================================= -->
<div class='row'>
    <div class='col-md-12'>
        <div class='tile collapseable show animate__animated  animate__fadeInUp'>
            <div class='tile-body'>
                <div class='table-responsive'>
                    <table class='table table-hover table-bordered' id='sampleTable'>
                        <thead>
                            <tr>
                                
                                <th> Name</th>
                                <th>Phone</th>
                                <th>Address</th>
                                <th> Group</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            if (count($customer_show) > 0) {
                                foreach ($customer_show as $row) {
                                    ?>
                                    <tr>

                                        <td>
                                            <?= esc($row['customer_name']) ?>
                                        </td>
                                        <td>
                                            <?= esc($row['phone']) ?>
                                        </td>
                                        <td>
                                            <?= esc($row['address']) ?>
                                        </td>

                                      <td>
                                            <?= esc($row['group_name']) ?>
                                        </td>
                                    <td>
                                        <?php if ($row['status'] == 1): ?>
                                            <span class="badge badge-success">Active</span>
                                        <?php else: ?>
                                            <span class="badge badge-danger">Inactive</span>
                                        <?php endif; ?>
                                    </td>
                                                                    
                                
                                        <td>
                                            <!-- Button to invoke the modal -->
                                 <a href="#" class="btn btn-primary btn-sm btn-edit"
    data-customer_id="<?= esc($row['customer_id']) ?>"
    data-customer_group_id="<?= esc($row['customer_group_id']) ?>"
    data-customer_name="<?= esc($row['customer_name']) ?>"
    data-phone="<?= esc($row['phone']) ?>"
    data-address="<?= esc($row['address']) ?>"
    data-status="<?= esc($row['status']) ?>">
    <i class="fa fa-edit"></i>
</a>

                                            <a href="#" class="btn btn-danger btn-sm btn-delete"
                                                data-delete_id="<?= $row['customer_id'] ?>"><i class="fa fa-trash-o"></i></a>

                                        </td>
                                    </tr>
                                    <?php
                                }
                            } else {
                                ?>
                                <tr>
                                    <td colspan="7">No data found.</td>
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




<!-- ========================================================= -->
<!-- Add Customer Modal -->
<!-- ========================================================= -->
<form id="CustomerModalEntry_Form" method="post" action="<?= site_url('customer/create') ?>">
    <?= csrf_field() ?>

    <div class="modal fade" id="CustomerAdd" tabindex="-1" role="dialog" aria-labelledby="CustomerAddLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="CustomerAddLabel">
                        Add New Customer
                    </h5>

                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>

                <div class="modal-body">

                    <div class="form-row">

                        <div class="form-group col-md-6">
                            <label>Customer Group <span class="text-danger">*</span></label>

                            <select name="customer_group_id" class="form-control" required>
                                <option value="">Select Customer Group</option>

                                <?php foreach ($customer_group_show as $group): ?>
                                    <option value="<?= esc($group['customer_group_id']) ?>">
                                        <?= esc($group['group_name']) ?>
                                    </option>
                                <?php endforeach; ?>

                            </select>
                        </div>

                        <div class="form-group col-md-6">
                            <label>Customer Name <span class="text-danger">*</span></label>

                            <input
                                type="text"
                                name="customer_name"
                                class="form-control"
                                placeholder="Customer Name"
                                required>
                        </div>

                    </div>

                    <div class="form-row">

                        <div class="form-group col-md-6">
                            <label>Phone</label>

                            <input
                                type="text"
                                name="phone"
                                class="form-control"
                                maxlength="20"
                                placeholder="Phone Number">
                        </div>

                        <div class="form-group col-md-6">
                            <label>Status</label>

                            <select name="status" class="form-control">
                                <option value="1" selected>Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>

                    </div>

                    <div class="form-group">
                        <label>Address</label>

                        <textarea
                            name="address"
                            class="form-control"
                            rows="3"
                            placeholder="Customer Address"></textarea>
                    </div>

                </div>

                <div class="modal-footer">

                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        Close
                    </button>

                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-save"></i> Save Customer
                    </button>

                </div>

            </div>
        </div>
    </div>
</form>


<!-- ========================================================= -->
<!-- Edit Customer Modal -->
<!-- ========================================================= -->
<div class="modal fade" id="customer_edit_modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">

            <form id="customer_edit_submit_form" method="post" action="<?= site_url('customer/update') ?>">

                <?= csrf_field(); ?>

                <div class="modal-header">
                    <h5 class="modal-title">
                        Edit Customer
                    </h5>

                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>

                <div class="modal-body">

                    <input type="hidden"
                           name="customer_id"
                           id="customer_id">

                    <div class="form-row">

                        <div class="form-group col-md-6">
                            <label>Customer Group</label>

                            <select class="form-control"
                                    name="customer_group_id"
                                    id="customer_group_id"
                                    required>

                                <?php foreach ($customer_group_show as $group): ?>

                                    <option value="<?= esc($group['customer_group_id']) ?>">
                                        <?= esc($group['group_name']) ?>
                                    </option>

                                <?php endforeach; ?>

                            </select>

                        </div>

                        <div class="form-group col-md-6">
                            <label>Customer Name</label>

                            <input type="text"
                                   class="form-control"
                                   name="customer_name"
                                   id="customer_name"
                                   required>

                        </div>

                    </div>

                    <div class="form-row">

                        <div class="form-group col-md-6">
                            <label>Phone</label>

                            <input type="text"
                                   class="form-control"
                                   name="phone"
                                   id="phone">

                        </div>

                        <div class="form-group col-md-6">
                            <label>Status</label>

                            <select class="form-control"
                                    name="status"
                                    id="status">

                                <option value="1">Active</option>
                                <option value="0">Inactive</option>

                            </select>

                        </div>

                    </div>

                    <div class="form-row">

                        <div class="form-group col-md-12">
                            <label>Address</label>

                            <textarea class="form-control"
                                      rows="3"
                                      name="address"
                                      id="address"></textarea>

                        </div>

                    </div>

                </div>

                <div class="modal-footer">

                    <button type="button"
                            class="btn btn-secondary"
                            data-dismiss="modal">
                        Close
                    </button>

                    <button type="submit"
                            class="btn btn-primary">
                        <i class="fa fa-save"></i>
                        Update Customer
                    </button>

                </div>

            </form>

        </div>
    </div>
</div>
<!-- ========================================================= -->
<!-- Delete Customer Modal -->
<!-- ========================================================= -->

<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">

            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="deleteModalLabel">
                    <i class="fa fa-trash"></i> Delete Customer
                </h5>

                <button type="button" class="close text-white" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>

            <form id="customer_delete_form"
                  action="<?= site_url('customer/delete') ?>"
                  method="post">

                <?= csrf_field(); ?>

                <div class="modal-body">

                    <input type="hidden"
                           name="delete_id"
                           id="delete_id">

                    <h5 class="text-danger">
                        <i class="fa fa-exclamation-triangle"></i>
                        Are you sure you want to delete this customer?
                    </h5>

                    <p class="text-muted mb-0">
                        This action cannot be undone.
                    </p>

                </div>

                <div class="modal-footer">

                    <button type="button"
                            class="btn btn-secondary"
                            data-dismiss="modal">
                        No
                    </button>

                    <button type="submit"
                            class="btn btn-danger">
                        <i class="fa fa-trash"></i>
                        Yes, Delete
                    </button>

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

<script type='text/javascript'>

    $(document).ready(function () {

        $('#sampleTable').DataTable();

        var allowSubmit = true;

        //product_group_edit_form

        $('#CustomerModalEntry_Form').submit(function (event) {
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
                            parentMOdal.modal('toggle');
                            location.reload();
                        }
                        else if (data == "duplicate") {
                            alert("Customer already exists with same Phone or Email");
                        }

                    });
            }

        });

        //.........................................................................

        $('#customer_edit_submit_form').submit(function (event) {
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
$(document).on('click', '.btn-edit', function () {

    $('#customer_id').val($(this).data('customer_id'));
    $('#customer_group_id').val($(this).data('customer_group_id'));
    $('#customer_name').val($(this).data('customer_name'));
    $('#phone').val($(this).data('phone'));
    $('#address').val($(this).data('address'));
    $('#status').val($(this).data('status'));

    $('#customer_edit_modal').modal('show');

});

        $(document).on('click', '.btn-delete', function (e) {
    e.preventDefault();

    $('#delete_id').val($(this).data('delete_id'));

    $('#deleteModal').modal('show');
});


        //................ JQuery modal Edit & Delete end here........................................
  

    });
</script>

<!-- For Calendar start -->

<!-- For Calendar End -->

<?php
echo $this->endSection();
?>