<?php
echo $this->extend('layout');
echo $this->section('content');
?>

<div class='app-title'>
    <div class="row mx-auto align-items-center">
        <div class="col-md-3">
            <input type='text' id="startDate" class='form-control datePicker' placeholder="Start Date">
        </div>
        <div class="col-md-3">
            <input type='text' id="endDate" class='form-control datePicker' placeholder="End Date">
        </div>
        <div class="col-md-2">
            <button type="button" id="filterBtn" class="btn btn-outline-info w-100">
                Filter
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
                                <th>Seller by</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($sales_summery_report_show as $row): ?>
                            <tr>
                                <td><?= esc($row['sales_date']) ?></td>
                                <td><?= esc($row['sales_invoice']) ?></td>
                                <td><?= esc($row['customer_name']) ?></td>
                                <td><?= number_format($row['total_sale'], 2) ?></td>
                                <td><?= number_format($row['productwiseVatPercnt'], 2) ?></td>
                                <td><?= number_format($row['discountOnTotalPrice'], 2) ?></td>
                                <td><?= number_format($row['vatOnTotalPrice'], 2) ?></td>
                                <td><?= number_format($row['total_paid'], 2) ?></td>
                                <td><?= number_format($row['customer_due'], 2) ?></td>
                                <td><?= esc($row['seller_name']) ?></td>
                                <td>
                                    <?php if ($row['payment_status'] === 'Fully Paid'): ?>
                                        <span class="badge bg-success text-white">Fully Paid</span>
                                    <?php else: ?>
                                        <span class="badge bg-danger text-white">Partially Paid</span>
                                    <?php endif; ?>
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
$(document).ready(function() {

    var table = $('#sampleTable').DataTable();

    $('.datePicker').datepicker({
        format: "dd/mm/yyyy",
        autoclose: true,
        todayHighlight: true
    });

    // ================= CSV EXPORT =================
    function exportTableToCSV(filename) {

        var csv = [];
        var rows = table.rows({ search: 'applied' }).nodes();

        $(rows).each(function(index, row) {
            var rowData = [];
            $(row).find("td").each(function() {
                var data = $(this).text().replace(/"/g, '""');
                rowData.push('"' + data + '"');
            });
            csv.push(rowData.join(","));
        });

        var csvFile = new Blob([csv.join("\n")], {type: "text/csv"});
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
