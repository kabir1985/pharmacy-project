<?php
echo $this->extend('layout');
echo $this->section('content');
?>

<div class='app-title'>	
    <div class="row mx-auto">
        <div class="col-md-3">
           <input type='text' required class='form-control datePicker' placeholder="Start Date">
        </div>
        <div class="col-md-3">
           <input type='text' required class='form-control datePicker' placeholder="End Date">
        </div>
        <div class="col-md-2">
            <button type="button" class="btn btn-outline-info">Filter</button>
        </div>
    <div class="mt-0">
        <button id="exportCsvBtn" class="btn btn-outline-success">
            <i class="fa fa-file-csv"></i> Export as CSV
        </button>
        <button id="exportPdfBtn" class="btn btn-outline-danger">
            <i class="fa fa-file-pdf"></i> Export as PDF
        </button>
    </div>
    </div>
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
                                    <?= number_format($row['total_tax'], 2) ?>
                                </td>
                                <td>
                                    <?= number_format($row['discount'], 2) ?>
                                </td>
                                <td>
                                    <?= number_format($row['others_cost'], 2) ?>
                                </td>
                                <td>
                                    <?= number_format($row['total_paid'], 2) ?>
                                </td>
                          
                                <td>
                                    <?= number_format($row['customer_due'], 2) ?>
                                </td>
                                <td>
                                    <?= esc($row['seller_name']) ?>
                                </td>
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

<!---------------Data Table End Here-----------............................................-------------------->

<?php
echo $this->endSection();
?>

<?php
echo $this->section('scripts');
?>

<!-- Data table plugin-->
<script type='text/javascript' src="<?= base_url('assets/js/plugins/jquery.dataTables.min.js') ?>"></script>
<script type='text/javascript' src="<?= base_url('assets/js/plugins/dataTables.bootstrap.min.js') ?>"></script>
<script type='text/javascript' src="<?= base_url('assets/js/plugins/bootstrap-datepicker.min.js') ?>"></script>

<!-- jsPDF & jsPDF-AutoTable CDN -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.28/jspdf.plugin.autotable.min.js"></script>

<script>
$(document).ready(function() {
    $('#sampleTable').DataTable();

    $('.datePicker').datepicker({
        format: "dd/mm/yyyy",
        autoclose: true,
        todayHighlight: true
    });

    // CSV export helper functions
    function downloadCSV(csv, filename) {
        var csvFile;
        var downloadLink;

        csvFile = new Blob([csv], {type: "text/csv"});

        downloadLink = document.createElement("a");

        downloadLink.download = filename;

        downloadLink.href = window.URL.createObjectURL(csvFile);

        downloadLink.style.display = "none";

        document.body.appendChild(downloadLink);

        downloadLink.click();

        document.body.removeChild(downloadLink);
    }

    function exportTableToCSV(filename) {
        var csv = [];
        var rows = document.querySelectorAll("#sampleTable tr");

        for (var i = 0; i < rows.length; i++) {
            var row = [], cols = rows[i].querySelectorAll("td, th");

            for (var j = 0; j < cols.length; j++) {
                // Escape double quotes by doubling them, wrap field in quotes
                var data = cols[j].innerText.replace(/"/g, '""');
                row.push('"' + data + '"');
            }

            csv.push(row.join(","));
        }

        downloadCSV(csv.join("\n"), filename);
    }

    document.getElementById("exportCsvBtn").addEventListener("click", function () {
        exportTableToCSV("sales_summary_report.csv");
    });

    // PDF export using jsPDF & AutoTable
    document.getElementById("exportPdfBtn").addEventListener("click", function () {
        const { jsPDF } = window.jspdf;
        const doc = new jsPDF();

        doc.autoTable({ 
            html: '#sampleTable',
            styles: { fontSize: 8 },
            headStyles: { fillColor: [40, 116, 166] },
            margin: { top: 20 },
            didDrawPage: function (data) {
                doc.text("Sales Summary Report", data.settings.margin.left, 10);
            }
        });

        doc.save('sales_summary_report.pdf');
    });

});
</script>

<?php
echo $this->endSection();
?>
