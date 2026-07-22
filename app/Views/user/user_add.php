<?php
echo $this->extend('layout');
echo $this->section('content');
?>

<div class='app-title'>
    <div>
        <h1><i class='fa fa-th-list'></i>User List, Edit, Delete & Add New User Here</h1>
    </div>

    <!-- Button trigger modal -->
    <button type='button' class='btn btn-primary btn-sm' data-toggle='modal' data-target='#UserAdd'>
        <i class='fa fa-user-plus'></i>
        User Add
    </button>
</div>
<!---------------Data Table start Here----..............................................--------------------------->
<div class="row">
    <div class="col-md-12">
        <div class="tile collapseable show animate__animated animate__fadeInUp">
            <div class="tile-body">
                <div class="table-responsive">
                    <table class="table table-hover table-bordered" id="sampleTable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Login ID</th>
                                <th>Role</th>
                                <th width="120">Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php $i = 1; ?>

                            <?php foreach ($user_show as $row): ?>
                            <tr>
                                <td><?=$i++?></td>
                                <td><?=esc($row['user_name'])?></td>
                                <td><?=esc($row['user_email'])?></td>
                                <td><?=esc($row['login_id'])?></td>
                                <td><?=esc($row['role_holder'])?></td>
                                <td>
                                    <a href="#" class="btn btn-primary btn-sm btn-edit"
                                        data-user_id="<?=$row['user_id']?>" data-user_name="<?=esc($row['user_name'])?>"
                                        data-user_email="<?=esc($row['user_email'])?>"
                                        data-login_id="<?=esc($row['login_id'])?>"
                                        data-user_role_id="<?=$row['user_role_id']?>">
                                        <i class="fa fa-edit"></i>
                                    </a>

                                    <a href="#" class="btn btn-danger btn-sm btn-delete"
                                        data-delete_id="<?=$row['user_id']?>">
                                        <i class="fa fa-trash-o"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; ?>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!---------------Data Table End Here-----------............................................-------------------->

<div class="modal fade" id="UserAdd" tabindex="-1" role="dialog" aria-labelledby="UserAdd" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">

            <form id="userCreate_form" method="post" action="<?=site_url('user/create')?>">
                <div class="modal-header">
                    <h5 class="modal-title">Please Enter New User Details</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>

                <div class="modal-body">

                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" name="user_name" class="form-control" required placeholder="Full Name">
                    </div>

                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="user_email" class="form-control" required placeholder="Email Address">
                    </div>

                    <div class="form-group">
                        <label>Login ID</label>
                        <input type="text" name="login_id" class="form-control" required placeholder="Login ID">
                    </div>

                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" name="login_password" class="form-control" required
                            placeholder="Password">
                    </div>

                    <div class="form-group">
                        <label>Confirm Password</label>
                        <input type="password" name="confirm_login_password" class="form-control" required
                            placeholder="Confirm Password">
                        <small id="password-error" class="text-danger"></small>
                    </div>


                    <div class="form-group">
                        <label>User Role</label>
                        <select id="user_role_id" name="user_role_id" class="form-control" required>
                            <?php foreach ($roles as $role): ?>

                            <option value="<?=$role['user_role_id'];?>">
                                <?=esc($role['role_holder']);?>
                            </option>

                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>

            </form>

        </div>
    </div>
</div>

<!----------------------Modal Form End------------------------------------------>

<!---------------------------Modal Form for Edit Section Load Start---------------------------------------->
<!-- Modal -->

<div class='modal fade' id='user_Update_modal' tabindex='-1' role='dialog' aria-labelledby='product_group_edit'
    aria-hidden='true'>
    <div class='modal-dialog  modal-dialog-centered' role='document'>
        <div class='modal-content'>
            <form id="user_update_submit" method='post' action="<?=site_url('user/update')?>">
                <div class='modal-header'>
                    <h5 class='modal-title' id='#'>Udate User Role</h5>
                    <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                        <span aria-hidden='true'>&times;
                        </span>
                    </button>
                </div>
                <div class='modal-body' id="#">
                    <input type='hidden' required class='form-control' name='user_id' id='user_id'>
                    <div class='form-row'>
                        <div class='form-group col-md-6'>
                            <label>User Full Name</label>
                            <input type='text' required class='form-control' name='user_name' id='user_name'>
                        </div>
                        <div class='form-group col-md-6'>
                            <label>User Email</label>
                            <input type='email' required class='form-control' name='user_email' id='user_email'>
                        </div>
                    </div>
                    <div class='form-row'>
                        <div class='form-group col-md-6'>
                            <label>User Login ID</label>
                            <input type='text' required class='form-control' name='login_id' id='login_id'>
                        </div>
                        <div class='form-group col-md-6'>
                            <label>User Login Password</label>
                            <!-- <input type='password' required class='form-control' name='login_password'
                                id='login_password' pattern=".{6,}" required title="6 characters minimum"> -->
                            <input type="password" class="form-control" name="login_password" id="login_password"
                                autocomplete="new-password" placeholder="Leave blank to keep current password">
                        </div>
                    </div>
                    <div class='form-row'>

                        <div class='form-group col-md-12'>
                            <label>User Role</label>
                            <select id="user_role_id_edit" name="user_role_id_edit" class="form-control">

                                <?php foreach ($roles as $role): ?>

                                <option value="<?=$role['user_role_id'];?>">
                                    <?=esc($role['role_holder']);?>
                                </option>

                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class='modal-footer'>
                    <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
                    <button type='submit' class='btn btn-primary'>Save Edit</button>
                </div>
            </form>
        </div>

    </div>
</div>

<!----------------------Modal Form Edit Section  End------------------------------------------>

<!-- Modal Delete Product-->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Delete User</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <h5>Are you sure you want to delete this user?</h5>
            </div>

            <form id="deleteForm" action="<?= site_url('user/delete') ?>" method="post">

                <div class="modal-footer">

                    <input type="hidden" name="delete_id" id="delete_id">

                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        No
                    </button>

                    <button type="submit" class="btn btn-danger">
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
$(document).ready(function() {

    // Initialize DataTable
    $('#sampleTable').DataTable();

    // ---------------- Global variable for submit control ----------------
    var allowSubmit = true;

    // ---------------- User Create Modal ----------------
    let submitBtn = $("#userCreate_form button[type='submit']");
    submitBtn.prop('disabled', true);

    function validatePasswords() {

        let password = $("input[name='login_password']").val();
        let confirmPassword = $("input[name='confirm_login_password']").val();

        if (password === confirmPassword && password.length > 0) {

            $("input[name='confirm_login_password']")
                .removeClass("is-invalid")
                .addClass("is-valid");

            $("#password-error").text("");
            submitBtn.prop("disabled", false);

            return true;

        } else {

            $("input[name='confirm_login_password']")
                .removeClass("is-valid")
                .addClass("is-invalid");

            if (confirmPassword.length > 0) {
                $("#password-error").text("Passwords do not match.");
            } else {
                $("#password-error").text("");
            }

            submitBtn.prop("disabled", true);

            return false;
        }
    }

    $("input[name='login_password'], input[name='confirm_login_password']").on('keyup', validatePasswords);

    $("#userCreate_form").on("submit", function(e) {
        e.preventDefault();

        if (validatePasswords()) {
            let parentModal = $(this).closest('.modal');
            let postData = new FormData(this);

            if (allowSubmit) {
                allowSubmit = false;

                $.ajax({
                    type: $(this).attr("method"),
                    url: $(this).attr("action"),
                    data: postData,
                    processData: false,
                    contentType: false,
                }).done(function(res) {

                    allowSubmit = true;

                    if (res.status === "success") {

                        parentModal.modal('hide');

                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: res.message,
                            timer: 1500,
                            showConfirmButton: false
                        }).then(() => {
                            location.reload();
                        });

                    } else if (res.status === "exists") {

                        Swal.fire({
                            icon: 'warning',
                            title: 'Duplicate Login ID',
                            text: res.message
                        });

                    } else if (res.status === "validation") {

                        let msg = "";

                        $.each(res.errors, function(key, value) {
                            msg += value + "<br>";
                        });

                        Swal.fire({
                            icon: 'error',
                            title: 'Validation Error',
                            html: msg
                        });

                    } else {

                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: res.message
                        });

                    }

                });
            }
        }
    });

    // ---------------- User Update Modal ----------------
    $('#user_update_submit').submit(function(event) {
        event.preventDefault();

        if (allowSubmit) {
            allowSubmit = false;
            let parentModal = $(this).closest('.modal');
            let postData = new FormData(this);

            $.ajax({
                type: $(this).attr("method"),
                url: $(this).attr("action"),
                data: postData,
                processData: false,
                contentType: false,
            }).done(function(res) {

                allowSubmit = true;

                if (res.status === "success") {

                    parentModal.modal('hide');

                    Swal.fire({
                        icon: 'success',
                        title: 'Updated',
                        text: res.message,
                        timer: 1500,
                        showConfirmButton: false
                    }).then(() => {
                        location.reload();
                    });

                } else if (res.status === "exists") {

                    Swal.fire({
                        icon: 'warning',
                        title: 'Duplicate Login ID',
                        text: res.message
                    });

                } else if (res.status === "validation") {

                    let msg = "";

                    $.each(res.errors, function(key, value) {
                        msg += value + "<br>";
                    });

                    Swal.fire({
                        icon: 'error',
                        title: 'Validation Error',
                        html: msg
                    });

                } else {

                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: res.message
                    });

                }

            });
        }
    });

    // ---------------- Edit Button Click ----------------
    $('.btn-edit').on('click', function() {
        const user_id = $(this).data('user_id');
        const user_name = $(this).data('user_name');
        const user_email = $(this).data('user_email');
        const login_id = $(this).data('login_id');
        const login_password = $(this).data('login_password');
        const user_role_id = $(this).data('user_role_id');

        // Set data to edit modal form
        $('#user_id').val(user_id);
        $('#user_name').val(user_name);
        $('#user_email').val(user_email);
        $('#login_id').val(login_id);
        // $('#login_password').val(login_password);
        // $('#confirm_login_password').val(login_password);
        $('#user_role_id_edit').val(user_role_id);

        // Show edit modal
        $('#user_Update_modal').modal('show');
    });

    // ---------------- Delete Button Click ----------------
    // $(document).on('click', '.btn-delete', function() {
    //     const delete_id = $(this).data('delete_id');
    //     $('#delete_id').val(delete_id);
    //     $('#deleteModal').modal('show');
    // });

    $("#deleteForm").submit(function (e) {

e.preventDefault();

let form = $(this);

$.ajax({

    url: form.attr("action"),
    type: "POST",
    data: form.serialize(),
    dataType: "json",

    success: function (res) {

        if (res.status === "success") {

            $("#deleteModal").modal("hide");

            Swal.fire({
                icon: "success",
                title: "Deleted",
                text: res.message,
                timer: 1500,
                showConfirmButton: false
            }).then(function () {
                location.reload();
            });

        } else {

            Swal.fire({
                icon: "error",
                title: "Error",
                text: res.message
            });

        }

    },

    error: function () {

        Swal.fire({
            icon: "error",
            title: "Server Error",
            text: "Something went wrong."
        });

    }

});

});




    $(document).on('click', '.btn-delete', function () {

$('#delete_id').val($(this).data('delete_id'));

$('#deleteModal').modal('show');

});




});
</script>

<?php
echo $this->endSection();
?>