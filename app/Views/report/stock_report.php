<?php
echo $this->extend('layout');
echo $this->section('content');
?>

<div class='app-title'>	
    <div>
        <h1><i class='fa fa-th-list'></i> Stock Report</h1>
    </div>
    <div class="mt-3 mb-3 d-flex gap-2">
        <button id="exportCsvBtn" class="btn btn-outline-success">
            <i class="fa fa-file-csv"></i> Export as CSV
        </button>
        <button id="exportPdfBtn" class="btn btn-outline-danger">
            <i class="fa fa-file-pdf"></i> Export as PDF
        </button>
    </div>
</div>

<div class='row'>
    <div class='col-md-12'>
        <div class='tile collapseable show animate__animated animate__fadeInUp'>
            <div class='tile-body'>
                <div class='table-responsive'>
                    <table class='table table-hover table-bordered' id='sampleTable'>
                        <thead>
                            <tr>
                                <th>Product Name</th>
                                <th>Purchase Price</th>
                                <th>Tax</th>
                                <th>Sales Price</th>
                                <th>Current Stock</th>
                                <th>Stock Value</th>
                                <th>purchase by</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($stock_report_show as $row): 
                                $total_stock = $row['initial_stock'] + $row['newPurchase'];
                                $current_stock = $total_stock - $row['TotalSale'];
                                $stock_value = $current_stock * $row['sellingPrice'];
                            ?>
                                <tr>
                                    <td><?= esc($row['product_name']); ?></td>
                                    <td><?= esc($row['buyingPrice']); ?></td>
                                    <td><?= esc($row['tAX']); ?></td>
                                    <td><?= esc($row['sellingPrice']); ?></td>
                                    <td><?= $current_stock; ?></td>
                                    <td><?= $stock_value; ?></td>
                                    <td><?= esc($row['purchaser_name']); ?></td>
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

<!-- DataTables -->
<script src="<?= base_url('assets/js/plugins/jquery.dataTables.min.js') ?>"></script>
<script src="<?= base_url('assets/js/plugins/dataTables.bootstrap.min.js') ?>"></script>

<!-- jsPDF & jsPDF-AutoTable from CDN -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.28/jspdf.plugin.autotable.min.js"></script>

<script>
$(document).ready(function() {
    $('#sampleTable').DataTable();

    // CSV Export function
    function downloadCSV(csv, filename) {
        var csvFile = new Blob([csv], { type: "text/csv" });
        var downloadLink = document.createElement("a");
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
                var data = cols[j].innerText.replace(/"/g, '""'); // Escape quotes
                row.push('"' + data + '"');
            }
            csv.push(row.join(","));
        }
        downloadCSV(csv.join("\n"), filename);
    }

    $('#exportCsvBtn').click(function () {
        exportTableToCSV('stock_report.csv');
    });

    // PDF Export
    $('#exportPdfBtn').click(function () {
        const { jsPDF } = window.jspdf;
        const doc = new jsPDF();

        doc.autoTable({
            html: '#sampleTable',
            styles: { fontSize: 8 },
            headStyles: { fillColor: [40, 116, 166] },
            margin: { top: 20 },
            didDrawPage: function (data) {
                doc.text("Stock Report", data.settings.margin.left, 10);
            }
        });

        doc.save('stock_report.pdf');
    });
});
</script>

<?php
echo $this->endSection();
?>
