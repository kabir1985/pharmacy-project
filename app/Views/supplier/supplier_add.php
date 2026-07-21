<?php
echo $this->extend('layout');
echo $this->section('content');
?>

<div class='app-title'>
    <div>
        <h1><i class='fa fa-th-list'></i> Supplier List, Edit, Delete & Add Section</h1>
    </div>

    <!-- Button trigger modal -->
    <button type='button' class='btn btn-primary btn-sm' data-toggle='modal' data-target='#exampleModal'>
        <i class='fa fa-user-plus'></i>
        Supplier Add
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
                                <th>ID</th>
                                <th>Name</th>
                                <th>Business Name</th>
                                <th>Contact Number</th>
                                <th>Email</th>
                                <th>Address</th>
                                <th>Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            if (count($subjects) > 0) {
                                foreach ($subjects as $subject) {
                            ?>
                            <tr>
                                <td><?php echo $subject['supplier_id'] ?></td>
                                <td><?php echo $subject['supplier_name'] ?></td>
                                <td><?php echo $subject['business_name'] ?></td>
                                <td><?php echo $subject['contact_number'] ?></td>
                                <td><?php echo $subject['supplier_email'] ?></td>
                                <td><?php echo $subject['supplier_address'] ?></td>
                                <td><?php echo $subject['supplier_entry_date'] ?></td>
                                <td>
                                    <!-- Button to invoke the modal -->
                                    <a href="#" class="btn btn-primary btn-sm btn-edit"
                                        data-supplier_id="<?php echo $subject['supplier_id'] ?>"
                                        data-supplier_name="<?php echo $subject['supplier_name'] ?>"
                                        data-business_name="<?php echo $subject['business_name'] ?>"
                                        data-contact_number="<?php echo $subject['contact_number'] ?>"
                                        data-supplier_email="<?php echo $subject['supplier_email'] ?>"
                                        data-supplier_address="<?php echo $subject['supplier_address'] ?>"
                                        data-supplier_entry_date="<?php echo $subject['supplier_entry_date'] ?>"><i
                                            class="fa fa-edit"></i></a>

                                    <a href="#" class="btn btn-danger btn-sm btn-delete"
                                        data-delete_id="<?php echo $subject['supplier_id'] ?>"><i
                                            class="fa fa-trash-o"></i></a>

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

<!---------------Data Table End Here-----------............................................-------------------->



<!---------------------------Modal Form for entry Load Start---------------------------------------->
<!-- Modal -->
<div class='modal fade' id='exampleModal' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel'
    aria-hidden='true'>
    <div class='modal-dialog  modal-dialog-centered' role='document'>
        <div class='modal-content'>
            <div class='modal-header'>
                <h5 class='modal-title' id='exampleModalLabel'>Please Enter Supplier Details</h5>
                <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                    <span aria-hidden='true'>&times;
                    </span>
                </button>
            </div>

            <form id="modalForm" method='post' action="<?= site_url('supplier/create') ?>">
                <div class='modal-body'>

                    <div class='form-row'>
                        <div class='form-group col-md-6'>
                            <label>Supplier Name</label>
                            <input required type='text' required class='form-control' name='supplier_name'
                                placeholder='Name'>
                        </div>
                        <div class='form-group col-md-6'>
                            <label>Business Name</label>
                            <input type='text' class='form-control' name='business_name' placeholder='Business Name'>
                        </div>
                    </div>

                    <div class='form-row'>
                        <div class='form-group col-md-6'>
                            <label>Contact Number</label>
                            <input type='text' pattern="\d{1,13}" class='form-control' name='contact_number'
                                placeholder='Contact No'>
                        </div>
                        <div class='form-group col-md-6'>
                            <label>Supplier Email</label>
                            <input required type='email' class='form-control' name='supplier_email' placeholder='Email'>
                        </div>
                    </div>

                    <div class='form-row'>
                        <div class='form-group col-md-6'>
                            <label> Supplier Address</label>
                            <input type='text' class='form-control' name='supplier_address'
                                placeholder='Supplier Address'>
                        </div>
                        <div class='form-group col-md-6'>
                            <label> Date</label>
                            <input type='text' class='form-control datePicker' name='supplier_entry_date'
                                id="supplier_entry_date" placeholder='demoDate'>
                        </div>
                    </div>
                </div>
                <div class='modal-footer'>
                    <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
                    <button type='submit' class='btn btn-primary'>Save changes</button>
                </div>
        </div>
        </form>
    </div>
</div>
<!----------------------Modal Form End------------------------------------------>





<!---------------------------Modal Form for Edit Section Load Start---------------------------------------->
<!-- Modal -->
<form id="#" method='post' action="<?= site_url('supplier/update') ?>">
    <div class='modal fade' id='ModalEditSectionID' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel'
        aria-hidden='true'>
        <div class='modal-dialog  modal-dialog-centered' role='document'>
            <div class='modal-content'>
                <div class='modal-header'>
                    <h5 class='modal-title' id='#'>Please Enter Supplier Details</h5>
                    <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                        <span aria-hidden='true'>&times;
                        </span>
                    </button>
                </div>
                <div class='modal-body' id="#">
                    <input type='hidden' required class='form-control' name='supplier_id' id='supplier_id'>
                    <div class='form-row'>
                        <div class='form-group col-md-6'>
                            <label>Supplier Name Edit</label>
                            <input type='text' required class='form-control' name='supplier_name' id='supplier_name'>
                        </div>
                        <div class='form-group col-md-6'>
                            <label>Business Name</label>
                            <input type='text' class='form-control' name='business_name' id='business_name'>
                        </div>
                    </div>
                    <div class='form-row'>
                        <div class='form-group col-md-6'>
                            <label>Contact Number</label>
                            <input type='text' required class='form-control' name='contact_number' id='contact_number'>
                        </div>
                        <div class='form-group col-md-6'>
                            <label>E-mail</label>
                            <input type='text' class='form-control' name='supplier_email' id='supplier_email'>
                        </div>
                    </div>

                    <div class='form-row'>
                        <div class='form-group col-md-6'>
                            <label>Address</label>
                            <input type='text' required class='form-control' name='supplier_address'
                                id='supplier_address'>
                        </div>
                        <div class='form-group col-md-6'>
                            <label>Entry Date</label>
                            <input type='text' class='form-control datePicker' name='supplier_entry_date'
                                id='supplier_entry_date'>
                        </div>
                    </div>
                </div>
                <div class='modal-footer'>
                    <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
                    <button type='submit' class='btn btn-primary'>Save Edit</button>
                </div>
            </div>

        </div>
    </div>
</form>
<!----------------------Modal Form Edit Section  End------------------------------------------>

<!-- Modal Delete Product-->

<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Delete Supplier</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <h4>Are you sure want to delete this Supplier?</h4>

            </div>
            <form action="<?= site_url('supplier/delete') ?>" method="post">
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


<script type='text/javascript'>
$(document).ready(function() {

$('#sampleTable').DataTable();
    // -----------------For Modal Not Disappear after submit start--------------------------------

    $('#modalForm').submit(function(event) {

event.preventDefault();

var form = this;
var postData = new FormData(form);

$.ajax({
    type: $(form).attr("method"),
    url: $(form).attr("action"),
    data: postData,
    processData: false,
    contentType: false,
    success: function(response) {

        // Close Modal
        $('#exampleModal').modal('hide');

        // Clear Form
        form.reset();

        // Refresh Table
        location.reload();
    },
    error: function(xhr) {
        console.log(xhr.responseText);
    }
});

});


    // -----------------For Modal Not Disappear after submit End--------------------------------


    //...................JQuery for Modal Edit & Delete option...................................

    // get Edit Product
    $('.btn-edit').on('click', function() {
        // get data from button edit
        const supplier_id = $(this).data('supplier_id');
        const supplier_name = $(this).data('supplier_name');
        const business_name = $(this).data('business_name');

        const contact_number = $(this).data('contact_number');
        const supplier_email = $(this).data('supplier_email');
        const supplier_address = $(this).data('supplier_address');
        const supplier_entry_date = $(this).data('supplier_entry_date');

        // Set data to Form Edit
        $('#supplier_id').val(supplier_id);
        $('#supplier_name').val(supplier_name);
        $('#business_name').val(business_name);

        $('#contact_number').val(contact_number);
        $('#supplier_email').val(supplier_email);
        $('#supplier_address').val(supplier_address);
        $('#supplier_entry_date').val(supplier_entry_date);
        // Call Modal Edit
        $('#ModalEditSectionID').modal('show');

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


    //.....JQuery modal Edit & Delete End here..................
    // ....For Date Show.............................
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