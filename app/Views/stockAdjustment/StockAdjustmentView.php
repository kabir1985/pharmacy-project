<?php
echo $this->extend('layout');
echo $this->section('content');
?>

<div class='app-title'>
    <div>
        <h1><i class='fa fa-th-list'></i> Stock Adjustment List</h1>
    </div>

    <!-- Button trigger modal -->
    <button class="btn btn-primary" data-toggle="modal" data-target="#StockAdjustmentModal">
        <i class="fa fa-plus"></i> New Adjustment
    </button>
</div>



<!---------------Data Table start Here----..............................................--------------------------->
<div class="row">
    <div class="col-md-12">

        <div class="tile">

            <div class="tile-body">

                <div class="table-responsive">

                    <table class="table table-bordered table-hover table-striped" id="sampleTable">

                        <thead class="thead-dark">
                            <tr>
                                <th width="50">#</th>
                                <th>Date</th>
                                <th>Adjustment No</th>
                                <th>Product</th>
                                <th>Type</th>
                                <th class="text-center">Previous Stock</th>
                                <th class="text-center">Adjustment Qty</th>
                                <th class="text-center">Current Stock</th>
                                <th>Reason</th>
                                <th>User</th>
                                <th width="150" class="text-center">Action</th>
                            </tr>
                        </thead>

                        <tbody>

                        <?php if (!empty($adjustments)): ?>

                            <?php $sl = 1; ?>

                            <?php foreach ($adjustments as $row): ?>

                                <tr>

                                    <td><?=$sl++;?></td>

                                    <td><?=date('d-M-Y', strtotime($row['adjustment_date']));?></td>

                                    <td><?=esc($row['adjustment_no']);?></td>

                                    <td><?=esc($row['product_name']);?></td>

                                    <td class="text-center">

                                        <?php if ($row['adjustment_type'] == 'STOCK_IN'): ?>

                                            <span class="badge badge-success">
                                                Stock In
                                            </span>

                                        <?php elseif ($row['adjustment_type'] == 'STOCK_OUT'): ?>

                                            <span class="badge badge-danger">
                                                Stock Out
                                            </span>

                                        <?php else: ?>

                                            <span class="badge badge-secondary">
                                                <?=esc($row['adjustment_type']);?>
                                            </span>

                                        <?php endif; ?>

                                    </td>

                                    <td class="text-center">
                                        <?=number_format((float) $row['previous_stock'], 2);?>
                                    </td>

                                    <td class="text-center">
                                        <?=number_format((float) $row['adjustment_qty'], 2);?>
                                    </td>

                                    <td class="text-center">
                                        <?=number_format((float) $row['current_stock'], 2);?>
                                    </td>

                                    <td><?=esc($row['reason']);?></td>

                                    <td><?=esc($row['user_name']);?></td>

                                    <td class="text-center">

                                        <a href="<?=site_url('stock-adjustment/view/' . $row['adjustment_id'])?>"
                                           class="btn btn-info btn-sm"
                                           title="View">
                                            <i class="fa fa-eye"></i>
                                        </a>

                                        <a href="<?=site_url('stock-adjustment/edit/' . $row['adjustment_id'])?>"
                                           class="btn btn-primary btn-sm"
                                           title="Edit">
                                            <i class="fa fa-edit"></i>
                                        </a>

                                        <a href="<?=site_url('stock-adjustment/delete/' . $row['adjustment_id'])?>"
                                           class="btn btn-danger btn-sm"
                                           title="Delete"
                                           onclick="return confirm('Are you sure you want to delete this adjustment?');">
                                            <i class="fa fa-trash"></i>
                                        </a>

                                    </td>

                                </tr>

                            <?php endforeach; ?>

                        <?php else: ?>

                            <tr>
                                <td colspan="11" class="text-center text-muted">
                                    No stock adjustment found.
                                </td>
                            </tr>

                        <?php endif; ?>

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>
</div>

<!---------------Data Table End Here-----------............................................-------------------->



<!---------------------------Modal Form unitAdd Start---------------------------------------->
<!-- Stock Adjustment Modal -->
<div class="modal fade" id="StockAdjustmentModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">

            <form action="#" id="stockAdjustmentForm">

                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">
                        <i class="fa fa-exchange-alt"></i>
                        Stock Adjustment
                    </h5>

                    <button type="button" class="close text-white" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>

                <div class="modal-body">

                    <div class="form-row">

                        <div class="form-group col-md-6">
                            <label>Adjustment Date</label>
                            <input type="date" class="form-control" name="adjustment_date" value="<?=date('Y-m-d');?>"
                                required>
                        </div>

                        <div class="form-group col-md-6">
                            <label>Adjustment Type</label>
                            <select name="adjustment_type" id="adjustment_type" class="form-control" required>
                                <option value="">Select Type</option>
                                <option value="stock_in">Stock In</option>
                                <option value="stock_out">Stock Out</option>
                            </select>
                        </div>

                    </div>

                    <div class="form-group">
                        <label>Product</label>

                        <select class="form-control" name="product_id" id="product_id" required>

                            <option value="" selected disabled>Select Product</option>

                            <?php foreach ($product_show_for_sale as $row) {?>

                                <option value="<?=$row['product_id'];?>" data-total_stock="<?=$row['total_stock'];?>">

                                    <?=$row['product_name'];?>
                                    (Stock : <?=$row['total_stock'];?>)

                                </option>

                            <?php }?>

                        </select>

                    </div>


                    <div class="form-row">

                        <div class="form-group col-md-4">
                            <label>Previous Stock</label>
                            <input type="number" class="form-control" id="previous_stock" name="previous_stock" readonly>
                        </div>


                        <div class="form-group col-md-4">
                            <label>Current Stock</label>
                            <input type="number" class="form-control" id="current_stock" name="current_stock" min="0">
                        </div>

                        <div class="form-group col-md-4">
                            <label>Adjustment Qty</label>
                            <input type="number" class="form-control" id="adjustment_qty" name="adjustment_qty"
                                readonly>
                        </div>

                    </div>


                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Reason</label>
                            <select class="form-control" name="reason">
                                <option value="">Select Reason</option>
                                <option>Expired</option>
                                <option>Damaged</option>
                                <option>Lost</option>
                                <option>Physical Count</option>
                                <option>Stock Correction</option>
                                <option>Supplier Return</option>
                                <option>Other</option>
                            </select>
                        </div>

                        <div class="form-group col-md-6">
                            <label>Reference No</label>
                            <input type="text" class="form-control" name="reference_no" placeholder="Reference Number">
                        </div>
                    </div>


                    <div class="form-group">
                        <label>Remarks</label>
                        <textarea class="form-control" rows="3" name="remarks"
                            placeholder="Remarks (Optional)"></textarea>
                    </div>

                </div>

                <div class="modal-footer">

                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        Close
                    </button>

                    <button type="submit" class="btn btn-success">
                        <i class="fa fa-save"></i>
                        Save Adjustment
                    </button>

                </div>

            </form>

        </div>
    </div>
</div>
<!----------------------Modal Form End------------------------------------------>

<!---------------------------Modal Form Unit Edit Start---------------------------------------->
<!-- Modal -->
<!-- <div class='modal fade' id='unit_edit_modal' tabindex='-1' role='dialog' aria-labelledby='unit_edit_modal' aria-hidden='true'>
    <div class='modal-dialog  modal-dialog-centered' role='document'>
        <div class='modal-content'>
            <form method='post' action="<? php// echo site_url('/unitUpdate') ?>">
                <div class='modal-header'>
                    <h5 class='modal-title' id='#'>Product Unit Update</h5>
                    <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                        <span aria-hidden='true'>&times;
                        </span>
                    </button>
                </div>
                <div class='modal-body' id="#">
                    <input type='hidden' required class='form-control' name='product_unit_id' id='product_unit_id'>
                    <div class='form-row'>
                        <div class='form-group col-md-12'>
                            <label>Product Unit</label>
                            <input type='text' required class='form-control' name='product_unit_name' id='product_unit_name'>
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
</div> -->
<!----------------------Modal Form Edit Section  End------------------------------------------>

<!-- Modal Delete Product-->

<!-- <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
            <form action="<?php echo site_url('/unitDelete') ?>" method="post">
                <div class="modal-footer">
                    <input type="hidden" required class='form-control' name="delete_id" id="delete_id">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                    <button type="submit" class="btn btn-primary">Yes</button>
                </div>
            </form>
        </div>
    </div>
</div> -->

<!-- End Modal Delete Product-->


<?php
echo $this->endSection();
?>

<?php
echo $this->section('scripts');
?>

<script type='text/javascript'>
    $(document).ready(function () {


        $('#sampleTable').DataTable({

responsive:true,

autoWidth:false,

pageLength:10,

order:[[0,'asc']]

});

        //===========================
        // Calculate Adjustment
        //===========================
        function calculateAdjustment() {

            let previousStock = parseFloat($('#previous_stock').val()) || 0;
            let currentStock = parseFloat($('#current_stock').val()) || 0;
            let type = $('#adjustment_type').val();

            if (type == "stock_in") {

                // Only calculate
                if (currentStock >= previousStock) {
                    $('#adjustment_qty').val(currentStock - previousStock);
                } else {
                    $('#adjustment_qty').val(0);
                }

            } else if (type == "stock_out") {

                if (currentStock <= previousStock) {
                    $('#adjustment_qty').val(previousStock - currentStock);
                } else {
                    $('#adjustment_qty').val(0);
                }

            }

        }

        //===========================
        // Product Change
        //===========================
        $('#product_id').change(function () {

            let stock = Number($('#product_id option:selected').data('total_stock')) || 0;

            $('#previous_stock').val(stock);
            $('#current_stock').val(stock);

            calculateAdjustment();

        });

        //===========================
        // Adjustment Type Change
        //===========================
        $('#adjustment_type').change(function () {

            calculateAdjustment();

        });

        //===========================
        // New Stock Change
        //===========================
        $('#current_stock').on('input', function () {

            calculateAdjustment();

        });

        //===========================
        // Validation on Blur
        //===========================
        $('#current_stock').on('blur', function () {

            let previousStock = parseFloat($('#previous_stock').val()) || 0;
            let currentStock = parseFloat($(this).val()) || 0;
            let type = $('#adjustment_type').val();

            if (type == 'stock_in') {

                if (currentStock < previousStock) {

                    alert('New Stock must be greater than or equal to Current Stock.');

                    $(this).val(previousStock);

                }

            } else if (type == 'stock_out') {

                if (currentStock > previousStock) {

                    alert('New Stock cannot be greater than Current Stock.');

                    $(this).val(previousStock);

                }

                if (currentStock < 0) {

                    $(this).val(0);

                }

            }

            calculateAdjustment();

        });





        //====================================
        // Save Stock Adjustment
        //====================================
        $('#stockAdjustmentForm').submit(function (e) {

            e.preventDefault();

            $.ajax({

                url: "<?=site_url('stock-adjustment/create');?>",
                type: "POST",
                data: $(this).serialize(),
                dataType: "json",

                beforeSend: function () {

                    $('button[type=submit]').prop('disabled', true);

                },

                success: function (response) {

                    $('button[type=submit]').prop('disabled', false);

                    if (response.status == "success") {

                        alert(response.message);

                        $('#stockAdjustmentModal').modal('hide');

                        $('#stockAdjustmentForm')[0].reset();

                        $('.select2').val('').trigger('change');

                        // Reload DataTable
                        $('#sampleTable').DataTable().ajax.reload(null, false);

                    } else {

                        alert(response.message);

                    }

                },

                error: function (xhr) {

                    $('button[type=submit]').prop('disabled', false);

                    alert("Something went wrong.");

                    console.log(xhr.responseText);

                }

            });

        });





    });
</script>

<!-- For Calendar start -->

<!-- For Calendar End -->

<?php
echo $this->endSection();
?>