<?php
echo $this->extend('layout');
echo $this->section('content');
?>

<div class='app-title'>
    <div>
        <h1><i class='fa fa-th-list'></i> General Settings Section</h1>
    </div>

    <!-- Button trigger modal -->
    <button type='button' class='btn btn-primary btn-sm' data-toggle='modal' data-target='#SystemSettingsAdd'>
        <i class='fa fa-plus'></i> Add General Settings
    </button>
</div>

<!-- Data Table Start -->
<div class='row'>
    <div class='col-md-12'>
        <div class='tile collapseable show animate__animated animate__fadeInUp'>
            <div class='tile-body'>
                <div class='table-responsive'>
                    <table class='table table-hover table-bordered' id='sampleTable'>
                        <thead>
                            <tr>
                                <th>Country</th>
                                <th>Currency</th>
                                <th>Company</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Address</th>
                                <th>Logo</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($system_settings_show) { ?>
                            <tr>
                                <td><?= $system_settings_show['country'] ?></td>
                                <td><?= $system_settings_show['currency_name'] ?? '' ?></td>
                                <td><?= $system_settings_show['company_name'] ?></td>
                                <td><?= $system_settings_show['company_email'] ?></td>
                                <td><?= $system_settings_show['company_phone'] ?></td>
                                <td><?= $system_settings_show['company_address'] ?></td>
                                <td><?= $system_settings_show['company_logo'] ?></td>
                                <td>
                                    <a href="#" class="btn btn-primary btn-sm btn-edit"
                                        data-system_settings_id="<?= $system_settings_show['id'] ?>"
                                        data-company_name="<?= $system_settings_show['company_name'] ?>"
                                        data-company_email="<?= $system_settings_show['company_email'] ?>"
                                        data-company_phone="<?= $system_settings_show['company_phone'] ?>"
                                        data-company_address="<?= $system_settings_show['company_address'] ?>"
                                        data-company_logo="<?= $system_settings_show['company_logo'] ?>"
                                        data-country="<?= $system_settings_show['country'] ?>"
                                        data-currency_id="<?= $system_settings_show['currency_id'] ?>">
                                        <i class="fa fa-edit"></i>
                                    </a>

                                    <a href="#" class="btn btn-danger btn-sm btn-delete"
                                        data-delete_id="<?= $system_settings_show['id'] ?>">
                                        <i class="fa fa-trash-o"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Data Table End -->

<!-- Modal Add -->
<div class='modal fade' id='SystemSettingsAdd' tabindex='-1' role='dialog' aria-hidden='true'>
    <div class='modal-dialog modal-dialog-centered' role='document'>
        <div class='modal-content'>
            <form id="system_settings_submit_form" method='post' action="<?= site_url('settings/create') ?>" enctype="multipart/form-data">
                <div class='modal-header'>
                    <h5 class='modal-title'>Please Enter Company Info</h5>
                    <button type='button' class='close' data-dismiss='modal'>&times;</button>
                </div>
                <div class='modal-body'>
                    <div class='form-row'>
                        <div class='form-group col-md-6'>
                            <label>Company Name</label>
                            <input type='text' class='form-control' name='company_name' placeholder='Company Name' required>
                        </div>
                        <div class='form-group col-md-6'>
                            <label>Company Email</label>
                            <input type='email' class='form-control' name='company_email' placeholder='Company Email' required>
                        </div>
                    </div>
                    <div class='form-row'>
                        <div class='form-group col-md-6'>
                            <label>Country</label>
                            <input type='text' class='form-control' name='country' placeholder='Country' required>
                        </div>
                        <div class='form-group col-md-6'>
                            <label>Currency</label>
                            <select id="currency_id" name="currency_id" class="form-control" required>
                                <option value="">Select Currency</option>
                                <?php foreach ($currency_show as $row) { ?>
                                    <option value="<?= $row['id'] ?>"><?= $row['currency_name'] ?> (<?= $row['currency_symbol'] ?>)</option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class='form-row'>
                        <div class='form-group col-md-6'>
                            <label>Phone</label>
                            <input type='text' class='form-control' name='company_phone' placeholder='Phone' required>
                        </div>
                        <div class='form-group col-md-6'>
                            <label>Company Logo</label>
                            <input type="file" class="form-control" name="company_logo" id="company_logo">
                        </div>
                    </div>
                    <div class='form-row'>
                        <div class='form-group col-md-12'>
                            <label>Company Address</label>
                            <textarea class="form-control" name="company_address" placeholder='Address' rows="2"></textarea>
                        </div>
                    </div>
                </div>
                <div class='modal-footer'>
                    <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
                    <button type='submit' class='btn btn-primary'>Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit -->
<div class='modal fade' id='system_setting_edit_modal' tabindex='-1' role='dialog' aria-hidden='true'>
    <div class='modal-dialog modal-dialog-centered' role='document'>
        <div class='modal-content'>
            <form id="systemSettings_edit_submit_form" method='post' action="<?= site_url('settings/update') ?>" enctype="multipart/form-data">
                <div class='modal-header'>
                    <h5 class='modal-title'>System Settings Update</h5>
                    <button type='button' class='close' data-dismiss='modal'>&times;</button>
                </div>
                <div class='modal-body'>
                    <input type='hidden' class='form-control system_settings_id' name='system_settings_id'>
                    <div class='form-row'>
                        <div class='form-group col-md-6'>
                            <label>Company Name</label>
                            <input type='text' class='form-control company_name' name='company_name'>
                        </div>
                        <div class='form-group col-md-6'>
                            <label>Company Email</label>
                            <input type='email' class='form-control company_email' name='company_email'>
                        </div>
                    </div>
                    <div class='form-row'>
                        <div class='form-group col-md-6'>
                            <label>Country</label>
                            <input type='text' class='form-control country' name='country'>
                        </div>
                        <div class='form-group col-md-6'>
                            <label>Currency</label>
                            <select class='form-control currency_id' name='currency_id'>
                                <?php foreach ($currency_show as $cur) { ?>
                                    <option value="<?= $cur['id'] ?>"><?= $cur['currency_name'] ?> (<?= $cur['currency_symbol'] ?>)</option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class='form-row'>
                        <div class='form-group col-md-6'>
                            <label>Phone</label>
                            <input type='text' class='form-control company_phone' name='company_phone'>
                        </div>
                        <div class='form-group col-md-6'>
                            <label>Address</label>
                            <input type='text' class='form-control company_address' name='company_address'>
                        </div>
                    </div>
                    <div class='form-row'>
                        <div class='form-group col-md-12'>
                            <label>Company Logo</label>
                            <input type="file" class="form-control company_logo" name="company_logo">
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

<!-- Delete Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form action="<?= site_url('settings/delete') ?>" method="post">
                <div class="modal-header">
                    <h5 class="modal-title">Delete Company</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <h4>Are you sure want to delete this Company?</h4>
                    <input type="hidden" name="delete_id" id="delete_id">
                </div>
                <div class="modal-footer">
                    <button type='button' class='btn btn-secondary' data-dismiss='modal'>No</button>
                    <button type='submit' class='btn btn-primary'>Yes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php
echo $this->endSection();
echo $this->section('scripts');
?>

<script src="<?= base_url('assets/js/plugins/jquery.dataTables.min.js') ?>"></script>
<script src="<?= base_url('assets/js/plugins/dataTables.bootstrap.min.js') ?>"></script>

<script>
$(document).ready(function() {

    $('#sampleTable').DataTable();

    var allowSubmit = true;

    // Add form submit
    $('#system_settings_submit_form').submit(function(e){
        e.preventDefault();
        if(!allowSubmit) return;
        allowSubmit = false;

        var parentModal = $(this).closest('.modal');
        var formData = new FormData(this);

        $.ajax({
            type: $(this).attr('method'),
            url: $(this).attr('action'),
            data: formData,
            processData: false,
            contentType: false
        })
        .done(function(data){
            if(data == 1){
                parentModal.modal('hide');
                location.reload();
            } else if(data == 2){
                alert('Company already exists. Cannot add another.');
                allowSubmit = true;
            } else {
                alert('Something went wrong!');
                allowSubmit = true;
            }
        })
        .fail(function(){
            alert('Server error!');
            allowSubmit = true;
        });
    });

    // Edit form submit
    $('#systemSettings_edit_submit_form').submit(function(e){
        e.preventDefault();
        if(!allowSubmit) return;
        allowSubmit = false;

        var parentModal = $(this).closest('.modal');
        var formData = new FormData(this);

        $.ajax({
            type: $(this).attr('method'),
            url: $(this).attr('action'),
            data: formData,
            processData: false,
            contentType: false
        })
        .done(function(data){
            if(data == 1){
                parentModal.modal('hide');
                location.reload();
            } else {
                alert('Something went wrong!');
                allowSubmit = true;
            }
        })
        .fail(function(){
            alert('Server error!');
            allowSubmit = true;
        });
    });

    // Edit button click
    $('.btn-edit').click(function(){
        const btn = $(this);
        $('.system_settings_id').val(btn.data('system_settings_id'));
        $('.company_name').val(btn.data('company_name'));
        $('.company_email').val(btn.data('company_email'));
        $('.company_phone').val(btn.data('company_phone'));
        $('.company_address').val(btn.data('company_address'));
        $('.company_logo').val(btn.data('company_logo'));
        $('.country').val(btn.data('country'));
        $('.currency_id').val(btn.data('currency_id'));
        $('#system_setting_edit_modal').modal('show');
    });

    // Delete button click
    $('.btn-delete').click(function(){
        $('#delete_id').val($(this).data('delete_id'));
        $('#deleteModal').modal('show');
    });

});
</script>

<?php
echo $this->endSection();
?>