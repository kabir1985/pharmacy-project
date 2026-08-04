<?php
echo $this->extend('layout');
echo $this->section('content');
?>

<div class='app-title'>
    <div>
        <h1><i class='fa fa-th-list'></i> Stock / Purchse Report</h1>
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
                        <thead class="table-dark">
                            <tr>

                                <th width="50">SL</th>

                                <th>Product Name</th>

                                <th class="text-end">Opening</th>

                                <th class="text-end">Purchase</th>

                                <th class="text-end">Purchase Return</th>

                                <th class="text-end">Sale Return</th>

                                <th class="text-end">Stock In</th>

                                <th class="text-end">Sale</th>

                                <th class="text-end">Stock Out</th>

                                <th class="text-center">Current Stock</th>

                                <th class="text-end">Purchase Price</th>

                                <th class="text-end">Selling Price</th>

                                <th class="text-end">Stock Value</th>

                                <th class="text-center">Status</th>

                            </tr>
                        </thead>
                        <tbody>

                            <?php

$sl = 1;

$totalOpening = 0;
$totalPurchase = 0;
$totalPurchaseReturn = 0;
$totalSaleReturn = 0;
$totalStockIn = 0;
$totalSale = 0;
$totalStockOut = 0;
$totalCurrentStock = 0;
$totalStockValue = 0;

foreach ($stock_report_show as $row):

    $stockValue = (float) $row['current_stock'] * (float) $row['purchase_price'];

    $totalOpening += (float) $row['opening_stock'];
    $totalPurchase += (float) $row['purchase_stock'];
    $totalPurchaseReturn += (float) $row['purchase_return_stock'];
    $totalSaleReturn += (float) $row['sale_return_stock'];
    $totalStockIn += (float) $row['stock_in'];
    $totalSale += (float) $row['sale_stock'];
    $totalStockOut += (float) $row['stock_out'];
    $totalCurrentStock += (float) $row['current_stock'];
    $totalStockValue += $stockValue;

    ?>

                            <tr>

                                <!-- SL -->
                                <td class="text-center">
                                    <?=$sl++?>
                                </td>

                                <!-- Product -->
                                <td>
                                    <strong><?=esc($row['product_name'])?></strong><br>

                                    <small class="text-muted">
                                        <?=esc($row['category_name'])?>

                                        <?php if (!empty($row['product_brand_name'])): ?>
                                        | <?=esc($row['product_brand_name'])?>
                                        <?php endif; ?>

                                        <?php if (!empty($row['group_name'])): ?>
                                        | <?=esc($row['group_name'])?>
                                        <?php endif; ?>
                                    </small>
                                </td>

                                <!-- Opening -->
                                <td class="text-end">
                                    <?=number_format($row['opening_stock'], 2)?>
                                </td>

                                <!-- Purchase -->
                                <td class="text-end text-success">
                                    <?=number_format($row['purchase_stock'], 2)?>
                                </td>

                                <!-- Purchase Return -->
                                <td class="text-end text-danger">
                                    <?=number_format($row['purchase_return_stock'], 2)?>
                                </td>

                                <!-- Sale Return -->
                                <td class="text-end text-success">
                                    <?=number_format($row['sale_return_stock'], 2)?>
                                </td>

                                <!-- Stock In -->
                                <td class="text-end text-primary">
                                    <?=number_format($row['stock_in'], 2)?>
                                </td>

                                <!-- Sale -->
                                <td class="text-end text-danger">
                                    <?=number_format($row['sale_stock'], 2)?>
                                </td>

                                <!-- Stock Out -->
                                <td class="text-end text-warning">
                                    <?=number_format($row['stock_out'], 2)?>
                                </td>

                                <!-- Current Stock -->
                                <td class="text-center">

                                    <?php if ($row['current_stock'] > 0): ?>

                                    <span class="badge bg-success">
                                        <?=number_format($row['current_stock'], 2)?>
                                    </span>

                                    <?php elseif ($row['current_stock'] == 0): ?>

                                    <span class="badge bg-secondary">
                                        0.00
                                    </span>

                                    <?php else: ?>

                                    <span class="badge bg-danger">
                                        <?=number_format($row['current_stock'], 2)?>
                                    </span>

                                    <?php endif; ?>

                                </td>

                                <!-- Purchase Price -->
                                <td class="text-end">
                                    <?=number_format($row['purchase_price'], 2)?>
                                </td>

                                <!-- Selling Price -->
                                <td class="text-end">
                                    <?=number_format($row['selling_price'], 2)?>
                                </td>

                                <!-- Stock Value -->
                                <td class="text-end fw-bold">
                                    <?=number_format($stockValue, 2)?>
                                </td>

                                <!-- Status -->
                                <td class="text-center">

                                    <?php if ($row['current_stock'] > 0): ?>

                                    <span class="badge bg-success">
                                        In Stock
                                    </span>

                                    <?php elseif ($row['current_stock'] == 0): ?>

                                    <span class="badge bg-secondary">
                                        Out of Stock
                                    </span>

                                    <?php else: ?>

                                    <span class="badge bg-danger">
                                        Negative
                                    </span>

                                    <?php endif; ?>

                                </td>

                            </tr>

                            <?php endforeach; ?>

                        </tbody>
                        <tfoot class="table-dark">
                            <tr>

                                <!-- SL -->
                                <th></th>

                                <!-- Grand Total -->
                                <th class="text-end">Grand Total</th>

                                <!-- Opening -->
                                <th class="text-end">
                                    <?=number_format($totalOpening, 2)?>
                                </th>

                                <!-- Purchase -->
                                <th class="text-end">
                                    <?=number_format($totalPurchase, 2)?>
                                </th>

                                <!-- Purchase Return -->
                                <th class="text-end">
                                    <?=number_format($totalPurchaseReturn, 2)?>
                                </th>

                                <!-- Sale Return -->
                                <th class="text-end">
                                    <?=number_format($totalSaleReturn, 2)?>
                                </th>

                                <!-- Stock In -->
                                <th class="text-end">
                                    <?=number_format($totalStockIn, 2)?>
                                </th>

                                <!-- Sale -->
                                <th class="text-end">
                                    <?=number_format($totalSale, 2)?>
                                </th>

                                <!-- Stock Out -->
                                <th class="text-end">
                                    <?=number_format($totalStockOut, 2)?>
                                </th>

                                <!-- Current Stock -->
                                <th class="text-center">
                                    <span class="badge bg-warning text-dark">
                                        <?=number_format($totalCurrentStock, 2)?>
                                    </span>
                                </th>

                                <!-- Purchase Price -->
                                <th></th>

                                <!-- Selling Price -->
                                <th></th>

                                <!-- Stock Value -->
                                <th class="text-end fw-bold">
                                    <?=number_format($totalStockValue, 2)?>
                                </th>

                                <!-- Status -->
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

<!-- DataTables -->

<!-- jsPDF & jsPDF-AutoTable from CDN -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.28/jspdf.plugin.autotable.min.js"></script>

<script>
$(document).ready(function() {
    $('#sampleTable').DataTable();

    // CSV Export function
    function downloadCSV(csv, filename) {
        var csvFile = new Blob([csv], {
            type: "text/csv"
        });
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
            var row = [],
                cols = rows[i].querySelectorAll("td, th");

            for (var j = 0; j < cols.length; j++) {
                var data = cols[j].innerText.replace(/"/g, '""'); // Escape quotes
                row.push('"' + data + '"');
            }
            csv.push(row.join(","));
        }
        downloadCSV(csv.join("\n"), filename);
    }

    $('#exportCsvBtn').click(function() {
        exportTableToCSV('stock_report.csv');
    });

    // PDF Export
    $('#exportPdfBtn').click(function() {
        const {
            jsPDF
        } = window.jspdf;
        const doc = new jsPDF();

        doc.autoTable({
            html: '#sampleTable',
            styles: {
                fontSize: 8
            },
            headStyles: {
                fillColor: [40, 116, 166]
            },
            margin: {
                top: 20
            },
            didDrawPage: function(data) {
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