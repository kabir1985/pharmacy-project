<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<div class="app-title">
    <div>
        <h1><i class="fa fa-th-list"></i> &nbsp;&nbsp; Sales List for Sales-Return</h1>
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
                                    <td class="text-end">
                                        <?= number_format($row['total_sale'], 2) ?>
                                    </td>

                                    <td class="text-end">
                                        <?= number_format($row['product_vat'], 2) ?>
                                    </td>

                                    <td class="text-end">
                                        <?= number_format($row['product_discount'], 2) ?>
                                    </td>

                                    <td class="text-end">
                                        <?= number_format($row['other_charge_on_all'], 2) ?>
                                    </td>

                                    <td class="text-end text-success">
                                        <?= number_format($row['total_paid'], 2) ?>
                                    </td>

                                    <td class="text-end text-danger">
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
                                        <!-- <button class="btn btn-primary btn-sm btn-return"
                                        data-sales_id="<?= $row['sales_id'] ?>">
                                        <i class="fa fa-undo"></i> Return
                                    </button> -->
                                        <button type="button" class="btn btn-primary btn-sm btn-return"
                                            data-sales-id="<?= esc($row['sales_id']) ?>"
                                            data-sales-invoice="<?= esc($row['sales_invoice']) ?>">
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
<div class="modal fade" id="returnModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <form id="returnForm" class="modal-content">
            <div class="modal-header">
                <!-- <h5 class="modal-title">Sales Return Invoice :<input type="text" id="return_invoice" name="return_invoice" readonly></h5> -->
                <div class="d-flex justify-content-between align-items-center w-100">
                    <h5 class="modal-title mb-0">Sales Return</h5>

                    <div class="fw-bold text-primary">
                        Sales Invoice: <span id="invoice_text"></span>
                    </div>

                    <input type="hidden" id="sales_id" name="sales_id">
                </div>

                <!-- <button type="button" class="btn btn-secondary text-white" data-dismiss="modal">X</button> -->
                <button type="button" class="btn btn-secondary text-white" data-dismiss="modal">X</button>
            </div>
            <div class="modal-body">

                <div class="mb-3">
                    <label for="reason" class="form-label">Reason</label>
                    <textarea name="reason" class="form-control" required></textarea>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered" id="returnProductsTable">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Sold</th>
                                <th>Returned</th>
                                <th>Available</th>
                                <th>Unit Price</th>
                                <th>Buy Price</th>
                                <th>Sale Price</th>
                                <th>Return Status</th>
                                <th>Return Qty</th>
                            </tr>
                        </thead>

                        <tbody>
                            <!-- Products will be appended dynamically -->
                        </tbody>
                    </table>
                </div>

            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Process Return</button>
                <button type="button" class="btn btn-secondary text-white" data-dismiss="modal">Cancel</button>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>


<script>
    $(document).ready(function () {

        $('#sampleTable').DataTable({
            responsive: true,
            pageLength: 15,
            order: [
                [0, 'desc']
            ]
        });

        ///////////////////////////

        $('body').on('click', '.btn-return', function () {

            const sales_id = $(this).data('sales-id');
            const sales_invoice = $(this).data('sales-invoice');

            console.log('Sales ID:', sales_id);
            console.log('Sales Invoice:', sales_invoice);

            // Set sales ID
            $('#sales_id').val(sales_id);

            // Display invoice number
            $('#invoice_text').text(sales_invoice);

            // Clear previous products
            $('#returnProductsTable tbody').empty();

            // Fetch products for this sale
            $.ajax({
                url: '<?= base_url("return/products") ?>',
                method: 'POST',
                data: {
                    sales_id: sales_id
                },
                dataType: 'json',

                success: function (products) {

                    console.log('Products:', products);

                    let html = '';

                    if (products.length === 0) {
                        html = `
                    <tr>
                        <td colspan="9" class="text-center text-muted">
                            No products available for return.
                        </td>
                    </tr>
                `;
                    } else {

                        products.forEach(p => {

                            const soldQty =
                                parseFloat(p.sold_qty) || 0;

                            const returnQty =
                                parseFloat(p.return_qty) || 0;

                            const remainingQty =
                                parseFloat(p.remaining_qty) || 0;

                            const unitPrice =
                                parseFloat(p.unit_price) || 0;

                            const buyPrice =
                                parseFloat(p.total_buy_price) || 0;

                            const salePrice =
                                parseFloat(p.total_sale_price) || 0;

                            html += `
                        <tr>

                            <td>
                                ${p.product_name}

                                <input type="hidden"
                                       name="sales_details_id[]"
                                       value="${p.sales_details_id}">

                                <input type="hidden"
                                       name="product_id[]"
                                       value="${p.product_id}">
                            </td>

                            <td class="text-end">
                                ${soldQty.toFixed(2)}
                            </td>

                            <td class="text-end">
                                ${returnQty.toFixed(2)}
                            </td>

                            <td class="text-end">
                                ${remainingQty.toFixed(2)}
                            </td>

                            <td class="text-end">
                                ${unitPrice.toFixed(2)}
                            </td>

                            <td class="text-end">
                                ${buyPrice.toFixed(2)}
                            </td>

                            <td class="text-end">
                                ${salePrice.toFixed(2)}
                            </td>

                            <td>
                                <span class="badge ${p.return_status === 'ACTIVE'
                                    ? 'bg-success'
                                    : 'bg-warning text-dark'
                                }">
                                    ${p.return_status}
                                </span>
                            </td>

                            <td>
                                <input
                                    type="number"
                                    name="return_qty[${p.sales_details_id}]"
                                    class="form-control return-qty"
                                    min="0"
                                    max="${remainingQty}"
                                    value="0"
                                    step="1"
                                    data-sales-details-id="${p.sales_details_id}"
                                    data-product-id="${p.product_id}"
                                    ${remainingQty <= 0 ? 'readonly' : ''}
                                >
                            </td>

                        </tr>
                    `;
                        });
                    }

                    $('#returnProductsTable tbody')
                        .html(html);

                    $('#returnModal').modal('show');
                },

                error: function (xhr) {

                    console.error(xhr.responseText);

                    alert(
                        'Error fetching products: ' +
                        xhr.responseText
                    );
                }
            });
        });


        $('#returnForm').on('submit', function (e) {
            e.preventDefault();

            let form = $(this);

            // ===========================
            // Validate Return Quantity
            // ===========================
            let hasReturnQty = false;

            $('input[name^="return_qty"]').each(function () {
                let qty = parseInt($(this).val()) || 0;

                if (qty > 0) {
                    hasReturnQty = true;
                    return false; // stop loop
                }
            });

            if (!hasReturnQty) {
                alert('Please enter at least one Return Quantity greater than 0.');
                return;
            }

            // ===========================
            // Ajax Submit
            // ===========================
            $.ajax({
                url: '<?= base_url("return/process") ?>',
                type: 'POST',
                data: form.serialize(),
                dataType: 'json',
                beforeSend: function () {
                    form.find('button[type="submit"]').prop('disabled', true);
                },
                success: function (res) {

                    if (res.status === 'success') {

                        alert(res.message);

                        $('#returnModal').modal('hide');
                        form[0].reset();

                        setTimeout(() => location.reload(), 500);

                    } else {
                        alert(res.message);
                    }

                },
                error: function (xhr) {
                    console.error(xhr.responseText);
                    alert('Server Error! Check console.');
                },
                complete: function () {
                    form.find('button[type="submit"]').prop('disabled', false);
                }
            });

        });

        //////////////////////////////////////////////////////////////////////

    });
</script>

<?= $this->endSection() ?>