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
<div class='row'>
    <div class='col-md-12'>
        <div class='tile collapseable show animate__animated  animate__fadeInUp'>
            <div class='tile-body'>
                <div class='table-responsive'>
                    <table class='table table-hover table-bordered' id='sampleTable'>
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Login ID</th>
                                <th>Role</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($user_show as $row) {
                                ?>
                            <tr>
                                <td>
                                    <?php echo $row['user_name'] ?>
                                </td>
                                <td>
                                    <?php echo $row['user_email'] ?>
                                </td>
                                <td>
                                    <?php echo $row['login_id'] ?>
                                </td>
                                <td>
                                    <?php echo $row['role_holder'] ?>
                                </td>
                                <td>
                                    <!-- Button to invoke the modal -->
                                    <a href="#" class="btn btn-primary btn-sm btn-edit"
                                        data-user_id="<?php echo $row['user_id'] ?>"
                                        data-user_name="<?php echo $row['user_name'] ?>"
                                        data-user_email="<?php echo $row['user_email'] ?>"
                                        data-login_id="<?php echo $row['login_id'] ?>"
                                        data-login_password="<?php echo $row['login_password'] ?>"
                                        data-user_role_id="<?php echo $row['user_role_id'] ?>">
                                        <i class="fa fa-edit"></i></a>

                                    <a href="#" class="btn btn-danger btn-sm btn-delete"
                                        data-delete_id="<?php echo $row['user_id'] ?>"><i class="fa fa-trash-o"></i></a>

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

<!---------------Data Table End Here-----------............................................-------------------->


<!---------------------------Modal Form for entry Load Start---------------------------------------->
<!-- Modal -->
<!-- <div class='modal fade' id='UserAdd' tabindex='-1' role='dialog' aria-labelledby='UserAdd' aria-hidden='true'>
    <div class='modal-dialog  modal-dialog-centered' role='document'>
        <div class='modal-content'>
            <form id="userCreate_form" method='post' action="<?php //echo site_url('userCreate') ?>">
                <div class='modal-header'>
                    <h5 class='modal-title' id='exampleModalLabel'>Please Enter New User Details</h5>
                    <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                        <span aria-hidden='true'>&times;
                        </span>
                    </button>
                </div>
                <div class='modal-body'>
                    <div class='form-row'>
                        <div class='form-group col-md-12'>
                            <label>Name</label>
                            <input required type='text' required class='form-control' name='user_name'
                                placeholder='User Full Name'>
                        </div>
                    </div>
                    <div class='form-row'>
                        <div class='form-group col-md-12'>
                            <label>Email</label>
                            <input type='email' required class='form-control' name='user_email' required
                                placeholder='User Email Address'>
                        </div>
                    </div>
                    <div class='form-row'>
                        <div class='form-group col-md-12'>
                            <label>User Name/Login ID</label>
                            <input required type='text' required class='form-control' name='login_id'
                                placeholder='Login ID'>
                        </div>
                    </div>
                    <div class='form-row'>
                        <div class='form-group col-md-12'>
                            <label>Password</label>
                            <input required type='password' required class='form-control' name='login_password'
                                placeholder='Login Password'>
                        </div>
                    </div>
                    <div class='form-row'>
                        <div class='form-group col-md-12'>
                            <label>Confirm Password</label>
                            <input required type='password' required class='form-control' name='confirm_login_password'
                                placeholder='Confirm Login Password'>
                        </div>
                    </div>
                    <div class='form-row'>
                        <div class='form-group col-md-12'>
                            <label>User Role</label>
                           user_type_show 
                            <select id="user_role_id" name="user_role_id" class="form-control">
                                <?php
                                // $db = \Config\Database::connect();
                                // $builder = $db->table('user_role');
                                // $query = $builder->select('user_role_id, role_holder')->get();
                                // $results = $query->getResultArray();
                                // foreach ($results as $row) {
                                //     ?>
                                <option value="<?php //echo $row["user_role_id"] ?>"><?php //echo $row["role_holder"] ?>
                                </option>
                                <?php
                                //}
                                ?>
                            </select>
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
</div> -->






<div class="modal fade" id="UserAdd" tabindex="-1" role="dialog" aria-labelledby="UserAdd" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">

            <form id="userCreate_form" method="post" action="<?= site_url('userCreate') ?>">
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
                        <input type="password" name="login_password" class="form-control" required placeholder="Password">
                    </div>

                    <div class="form-group">
                        <label>Confirm Password</label>
                        <input type="password" name="confirm_login_password" class="form-control" required placeholder="Confirm Password">
                    </div>
 
                    <div class="form-group">
                        <label>User Role</label>
                        <select id="user_role_id" name="user_role_id" class="form-control" required>
                        <?php
                                $db = \Config\Database::connect();
                                $builder = $db->table('user_role');
                                $query = $builder->select('user_role_id, role_holder')->get();
                                $results = $query->getResultArray();
                                foreach ($results as $row) {
                                    ?>

                                <option value="<?= $row['user_role_id'] ?>">
                                    <?= $row['role_holder'] ?>
                                </option>
                            <?php } ?>
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
            <form id="user_update_submit" method='post' action="<?php echo site_url('/User/update') ?>">
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
                            <input type='password' required class='form-control' name='login_password'
                                id='login_password' pattern=".{6,}" required title="6 characters minimum">
                        </div>
                    </div>
                    <div class='form-row'>
                        <div class='form-group col-md-6'>
                            <label>Confirm Login Password</label>
                            <input type='password' required class='form-control' name='confirm_login_password'
                                id='confirm_login_password'>
                            <div id="confirmpasswordmatch">Password Not Match</div>
                        </div>
                        <div class='form-group col-md-6'>
                            <label>User Role</label>
                            <select id="user_role_id_edit" name="user_role_id_edit" class="form-control">
                                <?php
                                foreach ($results as $row) {
                                    ?>
                                <option value="<?php echo $row['user_role_id'] ?>"><?php echo $row['role_holder'] ?>
                                </option>
                                <?php
                                }
                                ?>
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
            <form action="<?php echo site_url('/User/delete') ?>" method="post">
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
$(document).ready(function() {

    $('#sampleTable').DataTable();


    let submitBtn = $("#userCreate_form button[type='submit']");
    submitBtn.prop('disabled', true);

    function validatePasswords() {
        let password = $("input[name='login_password']").val();
        let confirmPassword = $("input[name='confirm_login_password']").val();

        if (password.length > 0 && password === confirmPassword) {
            submitBtn.prop('disabled', false);
            $("#password-error").text("");
            return true;
        } else {
            submitBtn.prop('disabled', true);
            if (confirmPassword.length > 0) {
                $("#password-error").text("Passwords do not match");
            } else {
                $("#password-error").text("");
            }
            return false;
        }
    }

    $("input[name='login_password'], input[name='confirm_login_password']").on('keyup', validatePasswords);

    $("#userCreate_form").on("submit", function(e) {
        e.preventDefault();

        if (validatePasswords()) {
            let parentModal = $(this).closest('.modal');
            let postData = new FormData(this);

            $.ajax({
                type: $(this).attr("method"),
                url: $(this).attr("action"),
                data: postData,
                processData: false,
                contentType: false,
            }).done(function(data) {
                if (data == 1) {
                    parentModal.modal('toggle');
                    location.reload();
                } else {
                    alert("Error saving user. Please try again.");
                }
            });
        } else {
            $("#password-error").text("Passwords do not match");
        }
    });
    //.........................................................................

    $('#user_update_submit').submit(function(event) {

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



    //...................JQuery for Modal Edit & Delete option...................................

    // get Edit Product
    $('.btn-edit').on('click', function() {
        // get data from button edit
        const user_id = $(this).data('user_id');
        const user_name = $(this).data('user_name');

        const user_email = $(this).data('user_email');
        const login_id = $(this).data('login_id');
        const login_password = $(this).data('login_password');
        const user_role_id = $(this).data('user_role_id');


        // Set data to Form Edit
        $('#user_id').val(user_id);
        $('#user_name').val(user_name);
        $('#user_email').val(user_email);
        $('#login_id').val(login_id);
        $('#login_password').val(login_password);
        $('#user_role_id_edit').val(user_role_id);

        // Call Modal Edit
        $('#user_Update_modal').modal('show');

    });

    // get Delete Product
    $('.btn-delete').on('click', function() {
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

<?php
echo $this->endSection();
?>