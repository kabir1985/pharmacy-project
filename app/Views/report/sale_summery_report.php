<?php
echo $this->extend('layout');
echo $this->section('content');
?>

<div class='app-title'>
    <div class="row mx-auto align-items-center">
        <div class="col-md-3">
<input type="text"
       id="startDate"
       class="form-control datePicker"
       placeholder="Start Date"
       value="<?= esc($startDate ?? '') ?>">
            </div>
        <div class="col-md-3">
<input type="text"
       id="endDate"
       class="form-control datePicker"
       placeholder="End Date"
       value="<?= esc($endDate ?? '') ?>">
            </div>
        <div class="col-md-2">
            <button type="button" id="searchSales" class="btn btn-outline-info w-100">
                Search Sales
            </button>
        </div>
        <div class="col-md-4 text-end">
            <button id="exportCsvBtn" class="btn btn-outline-success">
                <i class="fa fa-file-csv"></i> Export CSV
            </button>
            <button id="exportPdfBtn" class="btn btn-outline-danger">
                <i class="fa fa-file-pdf"></i> Export PDF
            </button>
        </div>
    </div>
</div>

<div class='row mt-3'>
    <div class='col-md-12'>
        <div class='tile collapseable show animate__animated animate__fadeInUp'>
            <div class='tile-body'>
                <div class='table-responsive'>
                    <table class='table table-hover table-bordered' id='sampleTable'>
                        <thead class="table-primary">
                            <tr>
                                <th>Date</th>
                                <th>Invoice</th>
                                <th>Customer</th>
                                <th>Seller</th>
                                <th>Items</th>
                                <th>Qty</th>
                                <th>Subtotal</th>
                                <th>Discount</th>
                                <th>VAT</th>
                                <th>Grand Total</th>
                                <th>Paid</th>
                                <th>Due</th>
                                <th>Status</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php foreach ($sales_summery_report_show as $row): ?>
                                <tr>

                                    <td><?= date('d-m-Y h:i A', strtotime($row['sales_date'])) ?></td>

                                    <td><?= esc($row['sales_invoice']) ?></td>

                                    <td><?= esc($row['customer_name']) ?></td>

                                    <td><?= esc($row['seller_name']) ?></td>

                                    <td class="text-center"><?= $row['total_items'] ?></td>

                                    <td class="text-end"><?= number_format($row['total_qty'], 2) ?></td>

                                    <td class="text-end"><?= number_format($row['subtotal'], 2) ?></td>

                                    <td class="text-end"><?= number_format($row['product_discount'], 2) ?></td>

                                    <td class="text-end"><?= number_format($row['product_vat'], 2) ?></td>

                                    <td class="text-end fw-bold"><?= number_format($row['grand_total'], 2) ?></td>

                                    <td class="text-end"><?= number_format($row['paid_amount'], 2) ?></td>

                                    <td class="text-end text-danger"><?= number_format($row['current_due'], 2) ?></td>

                                    <td class="text-center">
                                        <?php
                                        switch ($row['payment_status']) {
                                            case 'Paid':
                                                echo '<span class="badge bg-success">Paid</span>';
                                                break;

                                            case 'Partial':
                                                echo '<span class="badge bg-warning text-dark">Partial</span>';
                                                break;

                                            case 'Due':
                                                echo '<span class="badge bg-danger">Due</span>';
                                                break;

                                            default:
                                                echo '<span class="badge bg-secondary">' . esc($row['payment_status']) . '</span>';
                                        }
                                        ?>
                                    </td>

                                </tr>
                            <?php endforeach; ?>
                        </tbody>

                        <tfoot class="table-secondary fw-bold">
                            <tr>
                                <th colspan="4" class="text-end">Grand Total :</th>
                                <th id="ftItems" class="text-center"></th>
                                <th id="ftQty" class="text-end"></th>
                                <th id="ftSubtotal" class="text-end"></th>
                                <th id="ftDiscount" class="text-end"></th>
                                <th id="ftVat" class="text-end"></th>
                                <th id="ftGrandTotal" class="text-end"></th>
                                <th id="ftPaid" class="text-end"></th>
                                <th id="ftDue" class="text-end"></th>
                                <th></th>
                            </tr>
                        </tfoot>

                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
echo $this->endSection();
?>

<?php
echo $this->section('scripts');
?>

<script src="<?= base_url('assets/js/plugins/jquery.dataTables.min.js') ?>"></script>
<script src="<?= base_url('assets/js/plugins/dataTables.bootstrap.min.js') ?>"></script>
<script src="<?= base_url('assets/js/plugins/bootstrap-datepicker.min.js') ?>"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.28/jspdf.plugin.autotable.min.js"></script>

<script>
    $(document).ready(function () {
        $('.datePicker').datepicker({
    format: "dd/mm/yyyy",
    autoclose: true,
    todayHighlight: true
});

var table = $('#sampleTable').DataTable({

    footerCallback: function (row, data, start, end, display) {

        var api = this.api();

        var intVal = function (i) {
            if (typeof i === 'string') {
                return parseFloat(i.replace(/[\$,]/g, '')) || 0;
            } else if (typeof i === 'number') {
                return i;
            }
            return 0;
        };

        function columnTotal(index) {
            return api
                .column(index, { search: 'applied' })
                .data()
                .reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);
        }

        function format(num) {
            return num.toLocaleString(undefined, {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });
        }

        $('#ftItems').html(format(columnTotal(4)));
        $('#ftQty').html(format(columnTotal(5)));
        $('#ftSubtotal').html(format(columnTotal(6)));
        $('#ftDiscount').html(format(columnTotal(7)));
        $('#ftVat').html(format(columnTotal(8)));
        $('#ftGrandTotal').html(format(columnTotal(9)));
        $('#ftPaid').html(format(columnTotal(10)));
        $('#ftDue').html(format(columnTotal(11)));
    }

});





$('#searchSales').click(function () {

    let startDate = $('#startDate').val();
    let endDate = $('#endDate').val();

    if (startDate === '' || endDate === '') {
        alert('Please select both Start Date and End Date.');
        return;
    }

    window.location.href =
        "<?= site_url('reports/sales-summary') ?>" +
        "?startDate=" + encodeURIComponent(startDate) +
        "&endDate=" + encodeURIComponent(endDate);
});

        // ================= CSV EXPORT =================
        function exportTableToCSV(filename) {

            var csv = [];
            var rows = table.rows({ search: 'applied' }).nodes();

            $(rows).each(function (index, row) {
                var rowData = [];
                $(row).find("td").each(function () {
                    var data = $(this).text().replace(/"/g, '""');
                    rowData.push('"' + data + '"');
                });
                csv.push(rowData.join(","));
            });

            var csvFile = new Blob([csv.join("\n")], { type: "text/csv" });
            var downloadLink = document.createElement("a");
            downloadLink.download = filename;
            downloadLink.href = window.URL.createObjectURL(csvFile);
            downloadLink.click();
        }

        $("#exportCsvBtn").click(function () {
            exportTableToCSV("sales_summary_report.csv");
        });

        // ================= PDF EXPORT =================
        $("#exportPdfBtn").click(function () {

            const { jsPDF } = window.jspdf;
            const doc = new jsPDF('l'); // landscape

            doc.setFontSize(14);
            doc.text("Sales Summary Report", 14, 15);

            doc.autoTable({
                html: '#sampleTable',
                startY: 20,
                styles: { fontSize: 7 },
                headStyles: { fillColor: [52, 152, 219] }
            });

            doc.save('sales_summary_report.pdf');
        });

    });
</script>

<?php
echo $this->endSection();
?>