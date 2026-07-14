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
            <!-- <div class="tile-header d-flex justify-content-between align-items-center mb-3">
                 <h4 class="mb-0">
                    <i class="fa fa-exchange-alt"></i> Stock Adjustment List
                </h4> 

                <button class="btn btn-primary" data-toggle="modal" data-target="#StockAdjustmentModal">
                    <i class="fa fa-plus"></i> New Adjustment
                </button>
            </div> -->

            <div class="tile-body">

                <div class="table-responsive">

                    <table class="table table-bordered table-hover table-striped" id="sampleTable">

                        <thead class="thead-dark">
                            <tr>
                                <th>#</th>
                                <th>Date</th>
                                <th>Adjustment No</th>
                                <th>Product</th>
                                <th>Type</th>
                                <th class="text-center">Previous Stock</th>
                                <th class="text-center">Qty</th>
                                <th class="text-center">Current Stock</th>
                                <th>Reason</th>
                                <th>User</th>
                                <th width="150">Action</th>
                            </tr>
                        </thead>

                        <tbody>

                            <tr>
                                <td>1</td>
                                <td>13-Jul-2026</td>
                                <td>SA-000001</td>
                                <td>Napa 500 mg</td>
                                <td>
                                    <span class="badge badge-danger">Stock Out</span>
                                </td>
                                <td class="text-center">120</td>
                                <td class="text-center">10</td>
                                <td class="text-center">110</td>
                                <td>Expired</td>
                                <td>Admin</td>
                                <td>
                                    <a href="#" class="btn btn-info btn-sm">
                                        <i class="fa fa-eye"></i>
                                    </a>

                                    <a href="#" class="btn btn-primary btn-sm">
                                        <i class="fa fa-edit"></i>
                                    </a>

                                    <a href="#" class="btn btn-danger btn-sm">
                                        <i class="fa fa-trash"></i>
                                    </a>
                                </td>
                            </tr>

                            <tr>
                                <td>2</td>
                                <td>13-Jul-2026</td>
                                <td>SA-000002</td>
                                <td>Ace 500 mg</td>
                                <td>
                                    <span class="badge badge-success">Stock In</span>
                                </td>
                                <td class="text-center">75</td>
                                <td class="text-center">20</td>
                                <td class="text-center">95</td>
                                <td>Physical Count</td>
                                <td>Manager</td>
                                <td>
                                    <a href="#" class="btn btn-info btn-sm">
                                        <i class="fa fa-eye"></i>
                                    </a>

                                    <a href="#" class="btn btn-primary btn-sm">
                                        <i class="fa fa-edit"></i>
                                    </a>

                                    <a href="#" class="btn btn-danger btn-sm">
                                        <i class="fa fa-trash"></i>
                                    </a>
                                </td>
                            </tr>

                            <tr>
                                <td>3</td>
                                <td>12-Jul-2026</td>
                                <td>SA-000003</td>
                                <td>Seclo 20 mg</td>
                                <td>
                                    <span class="badge badge-danger">Stock Out</span>
                                </td>
                                <td class="text-center">50</td>
                                <td class="text-center">5</td>
                                <td class="text-center">45</td>
                                <td>Damaged</td>
                                <td>Admin</td>
                                <td>
                                    <a href="#" class="btn btn-info btn-sm">
                                        <i class="fa fa-eye"></i>
                                    </a>

                                    <a href="#" class="btn btn-primary btn-sm">
                                        <i class="fa fa-edit"></i>
                                    </a>

                                    <a href="#" class="btn btn-danger btn-sm">
                                        <i class="fa fa-trash"></i>
                                    </a>
                                </td>
                            </tr>

                            <tr>
                                <td>4</td>
                                <td>11-Jul-2026</td>
                                <td>SA-000004</td>
                                <td>ORS Powder</td>
                                <td>
                                    <span class="badge badge-success">Stock In</span>
                                </td>
                                <td class="text-center">30</td>
                                <td class="text-center">15</td>
                                <td class="text-center">45</td>
                                <td>Supplier Return</td>
                                <td>Pharmacist</td>
                                <td>
                                    <a href="#" class="btn btn-info btn-sm">
                                        <i class="fa fa-eye"></i>
                                    </a>

                                    <a href="#" class="btn btn-primary btn-sm">
                                        <i class="fa fa-edit"></i>
                                    </a>

                                    <a href="#" class="btn btn-danger btn-sm">
                                        <i class="fa fa-trash"></i>
                                    </a>
                                </td>
                            </tr>

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

            <form method="post" action="<?= site_url('stock-adjustment/store'); ?>">

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
                            <input type="date" class="form-control" name="adjustment_date" value="<?= date('Y-m-d'); ?>"
                                required>
                        </div>

                        <div class="form-group col-md-6">
        <label>Adjustment Type</label>
        <select class="form-control" name="adjustment_type" id="adjustment_type" required>
            <option value="" selected disabled>Select Type</option>
            <option value="stock_in">Stock In</option>
            <option value="stock_out">Stock Out</option>
        </select>
    </div>

                    </div>

                   <div class="form-group">
    <label>Product</label>

    <select class="form-control select2" name="product_id" id="product_id" required>

        <option value="" selected disabled>Select Product</option>

        <?php foreach($product_show_for_sale as $row){ ?>

            <option
                value="<?= $row['product_id']; ?>"
                data-total_stock="<?= $row['total_stock']; ?>">

                <?= $row['product_name']; ?>
                (Stock : <?= $row['total_stock']; ?>)

            </option>

        <?php } ?>

    </select>

</div>


<div class="form-row">

    <div class="form-group col-md-4">
        <label>Current Stock</label>
        <input type="number" class="form-control" id="current_stock" readonly>
    </div>

    <div class="form-group col-md-4">
        <label>Adjustment Qty</label>
        <input type="number" class="form-control"
               id="adjustment_qty"
               name="adjustment_qty"
               min="0">
    </div>

    <div class="form-group col-md-4">
        <label>New Stock</label>
        <input type="number"
               class="form-control"
               id="new_stock"
               min="0">
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

<!-- Data table plugin-->
<script type='text/javascript' src="<?php echo base_url('assets/js/plugins/jquery.dataTables.min.js') ?>"></script>
<script type='text/javascript' src="<?php echo base_url('assets/js/plugins/dataTables.bootstrap.min.js') ?>"></script>

<script type='text/javascript'>
    $(document).ready(function () {

    $('.select2').select2({
        width: '100%'
    });

    function calculateNewStock() {

        let current = Number($('#current_stock').val()) || 0;
        let qty = Number($('#adjustment_qty').val()) || 0;
        let type = $('#adjustment_type').val();

        let newStock = current;

        if (type == "stock_in") {

            newStock = current + qty;

        } else if (type == "stock_out") {

            if (qty > current) {
                qty = current;
                $('#adjustment_qty').val(qty);
            }

            newStock = current - qty;
        }

        $('#new_stock').val(newStock);
    }

    function calculateQty() {

        let current = Number($('#current_stock').val()) || 0;
        let newStock = Number($('#new_stock').val()) || 0;
        let type = $('#adjustment_type').val();

        let qty = 0;

        if (type == "stock_in") {

            if (newStock < current) {
                newStock = current;
                $('#new_stock').val(newStock);
            }

            qty = newStock - current;

        } else if (type == "stock_out") {

            if (newStock > current) {
                newStock = current;
                $('#new_stock').val(current);
            }

            if (newStock < 0) {
                newStock = 0;
                $('#new_stock').val(0);
            }

            qty = current - newStock;
        }

        $('#adjustment_qty').val(qty);
    }


    // Product Change
    $('#product_id').change(function () {

        let stock = Number($('#product_id option:selected').data('total_stock')) || 0;

        $('#current_stock').val(stock);
        $('#adjustment_qty').val('');
        $('#new_stock').val(stock);

    });


    // Adjustment Type Change
    $('#adjustment_type').change(function () {

        $('#adjustment_qty').trigger('input');

    });


    // Qty Change
    $('#adjustment_qty').on('input', function () {

        calculateNewStock();

    });


    // New Stock Change
    $('#new_stock').on('input', function () {

        calculateQty();

    });

});
</script>

<!-- For Calendar start -->

<!-- For Calendar End -->

<?php
echo $this->endSection();
?>