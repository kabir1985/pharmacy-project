<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<div class="app-title">
    <div>
        <h1><i class="fa fa-th-list"></i> &nbsp;&nbsp; Enter Invoice for Sales Return</h1>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="tile collapseable show animate__animated animate__fadeInUp">
            <div class="tile-body">
                <div class="table-responsive">
                    <table class="table table-hover table-bordered" id="sampleTable">
                        <thead>
                            <tr>
                                <th>Sales Date</th>
                                <th>Invoice</th>
                                <th>Customer</th>
                                <th>Total Sale</th>
                                <th>Tax</th>
                                <th>Discount</th>
                                <th>Other Cost</th>
                                <th>Paid</th>

                                <th>Due</th>
                                <th>Status</th>
                                <th>Return</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($saleReturnList as $row): ?>
                            <tr>
                                <td>
                                    <?= esc($row['sales_date']) ?>
                                </td>
                                <td>
                                    <?= esc($row['sales_invoice']) ?>
                                </td>
                                <td>
                                    <?= esc($row['customer_name']) ?>
                                </td>
                                <td>
                                    <?= number_format($row['total_sale'], 2) ?>
                                </td>
                                <td>
                                    <?= number_format($row['productwiseVatPercnt'], 2) ?>
                                </td>
                                <td>
                                    <?= number_format($row['discountOnTotalPrice'], 2) ?>
                                </td>
                                <td>
                                    <?= number_format($row['vatOnTotalPrice'], 2) ?>
                                </td>
                                <td>
                                    <?= number_format($row['total_paid'], 2) ?>
                                </td>

                                <td>
                                    <?= number_format($row['customer_due'], 2) ?>
                                </td>
                                <td>
                                    <?php if ($row['payment_status'] === 'Fully Paid'): ?>
                                    <span class="badge bg-success text-white">Fully Paid</span>
                                    <?php else: ?>
                                    <span class="badge bg-danger text-white">Partially Paid</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <button class="btn btn-primary btn-sm btn-return"
                                        data-sales_invoice="<?= $row['sales_invoice'] ?>">
                                        <i class="fa fa-undo"></i> Return
                                    </button>
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

<!-- Return Modal -->
<!-- <div class="modal fade" id="returnModal" tabindex="-1">
    <div class="modal-dialog">
        <form id="returnForm" class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Sales Return</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="return_invoice" class="form-label">Invoice No</label>
                    <input type="text" id="return_invoice" name="return_invoice" class="form-control">
                </div>
                <div class="mb-3">
                    <label for="reason" class="form-label">Reason</label>
                    <textarea name="reason" class="form-control" required></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Process Return</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            </div>
        </form>
    </div>
</div> -->



<!-- Return Modal -->
<div class="modal fade" id="returnModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <form id="returnForm" class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Sales Return</h5>
                <!-- <button type="button" class="btn bg-danger" data-bs-dismiss="modal">Close</button> -->
            </div>
            <div class="modal-body">
                <input type="text" id="return_invoice" name="return_invoice">

                <div class="mb-3">
                    <label for="reason" class="form-label">Reason</label>
                    <textarea name="reason" class="form-control" required></textarea>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered" id="returnProductsTable">
                        <thead>
                            <tr>
                                <th>Product ID</th>
                                <th>Quantity Sold</th>
                                <th>Unit Price</th>
                                <th>Buy Price</th>
                                <th>Sale Price</th>
                                <th>Return Quantity</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Products will be appended here dynamically -->
                        </tbody>
                    </table>
                </div>

            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Process Return</button>
                <button type="button" class="btn btn-secondary text-white" data-bs-dismiss="modal">Cancel</button>
            </div>
        </form>
    </div>
</div>




<?= $this->endSection() ?>

<?= $this->section('scripts') ?>

<script src="<?= base_url('assets/js/plugins/jquery.dataTables.min.js') ?>"></script>
<script src="<?= base_url('assets/js/plugins/dataTables.bootstrap.min.js') ?>"></script>

<script>
$(document).ready(function() {
    $('#sampleTable').DataTable();


    ///////////////////////////
    $('.btn-return').on('click', function() {
        const invoice = $(this).data('sales_invoice');
        $('#return_invoice').val(invoice);

        // Fetch products for this invoice
        $.ajax({
            url: '<?= base_url("ReturnController/getProducts") ?>',
            method: 'GET',
            data: {
                invoice: invoice
            },
            dataType: 'json',
            success: function(products) {
                let html = '';
                products.forEach(p => {
                    html += `<tr>
                    <td>${p.product_id}</td>
                    <td>${p.product_quantity_sold}</td>
                    <td>${p.unit_price}</td>
                    <td>${p.total_buy_price}</td>
                    <td>${p.total_sale_price}</td>
                    <td>
                        <input type="number" name="return_qty[${p.product_id}]" 
                               max="${p.product_quantity_sold}" 
                               value="0" class="form-control" required>
                    </td>
                </tr>`;
                });
                $('#returnProductsTable tbody').html(html);
                $('#returnModal').modal('show');
            },
            error: function(xhr) {
                alert('Error fetching products: ' + xhr.responseText);
            }
        });
    });

    /////////////////////////////
    $('#returnForm').submit(function(e) {
        e.preventDefault();
        $.ajax({
            url: '<?= base_url('ReturnController/process') ?>',
            method: 'POST',
            data: $(this).serialize(),
            success: function(res) {
                if (res.status === 'success') {
                    alert(res.message);

                    // Close modal using Bootstrap 5 API
                    var modalEl = document.getElementById('returnModal');
                    var modal = bootstrap.Modal.getInstance(modalEl) || new bootstrap.Modal(
                        modalEl);
                    modal.hide();

                    location.reload();
                } else {
                    alert('Error: ' + res.message);
                }
            },
            error: function(xhr) {
                alert('Error: ' + xhr.responseText);
            }
        });
    });



    ////////////////////////////////

});
</script>

<?= $this->endSection() ?>