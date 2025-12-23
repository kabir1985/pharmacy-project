<?php
echo $this->extend('layout');
echo $this->section('content');
?>

<div class='app-title'>
    <h1><i class='fa fa-th-list'></i> Expense Report</h1>

    <form method="post" action="<?php echo site_url('/expensereport') ?>"
        style="background: #f9f9f9; padding: 8px; border: 1px solid #ccc; border-radius: 8px; max-width: 1000px; margin: 20px auto; display: flex; flex-wrap: wrap; align-items: center; gap: 10px;">
        <label style="font-weight: bold;">Start Date:</label>
        <input type="date" name="start_date" value="<?= esc($start_date) ?>" required
            style="padding: 6px; border: 1px solid #aaa; border-radius: 4px;">

        <label style="font-weight: bold;">End Date:</label>
        <input type="date" name="end_date" value="<?= esc($end_date) ?>" required
            style="padding: 6px; border: 1px solid #aaa; border-radius: 4px;">

        <button type="submit"
            style="background: #007BFF; color: white; padding: 8px 16px; border: none; border-radius: 4px; cursor: pointer;">
            Filter
        </button>
    </form>

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
                    <table class='table table-hover' id='expenseTable'>
                        <?php if (!empty($expenses)): ?>
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Ref No</th>
                                <th>Category</th>
                                <th>Subcategory</th>
                                <th>What For</th>
                                <th>Amount</th>
                                <th>Note</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1;
                            foreach ($expenses as $exp): ?>
                            <tr>
                                <td><?= $i++ ?></td>
                                <td><?= esc($exp->expense_ref_no) ?></td>
                                <td><?= esc($exp->expense_category_name) ?></td>
                                <td><?= esc($exp->expense_sub_category_name) ?></td>
                                <td><?= esc($exp->expense_what_for) ?></td>
                                <td><?= number_format($exp->expense_amount, 2) ?></td>
                                <td><?= esc($exp->expense_note) ?></td>
                                <td><?= esc($exp->expense_date) ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <?php else: ?>
                        <tbody>
                            <tr>
                                <td colspan="8">No expenses found in selected date range.</td>
                            </tr>
                        </tbody>
                        <?php endif; ?>
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

<!-- jsPDF & AutoTable -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.28/jspdf.plugin.autotable.min.js"></script>

<script>
$(document).ready(function() {
    function getFormattedDateTime() {
        const now = new Date();
        return now.toISOString().replace(/[:\-T]/g, '_').split('.')[0];
    }

    // CSV Download
    function downloadCSV(csv, filename) {
        var csvFile = new Blob(["\ufeff" + csv], { type: "text/csv" });
        var downloadLink = document.createElement("a");
        downloadLink.download = filename;
        downloadLink.href = window.URL.createObjectURL(csvFile);
        document.body.appendChild(downloadLink);
        downloadLink.click();
        document.body.removeChild(downloadLink);
    }

    function exportTableToCSV(filename) {
        var csv = [];
        var rows = document.querySelectorAll("#expenseTable tr");

        for (var i = 0; i < rows.length; i++) {
            var row = [], cols = rows[i].querySelectorAll("td, th");
            for (var j = 0; j < cols.length; j++) {
                var data = cols[j].innerText.replace(/"/g, '""');
                row.push('"' + data + '"');
            }
            csv.push(row.join(","));
        }
        downloadCSV(csv.join("\n"), filename);
    }

    $('#exportCsvBtn').click(function() {
        exportTableToCSV(`expense_report_${getFormattedDateTime()}.csv`);
    });

    // PDF Download
    $('#exportPdfBtn').click(function() {
        const { jsPDF } = window.jspdf;
        const doc = new jsPDF();

        doc.autoTable({
            html: '#expenseTable',
            styles: { fontSize: 8 },
            headStyles: { fillColor: [40, 116, 166] },
            margin: { top: 20 },
            didDrawPage: function(data) {
                doc.text("Expense Report", data.settings.margin.left, 10);
                var pageCount = doc.internal.getNumberOfPages();
                doc.text(`Page ${pageCount}`, data.settings.margin.left, doc.internal.pageSize.height - 10);
            }
        });

        doc.save(`expense_report_${getFormattedDateTime()}.pdf`);
    });
});
</script>

<?php
echo $this->endSection();
?>
