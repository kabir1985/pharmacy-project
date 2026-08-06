<?php
echo $this->extend('layout');
echo $this->section('content');

$totalExpense = 0;
?>

<div class="app-title">
    <div>
        <h1><i class="fa fa-money"></i> Expense Report</h1>
    </div>
</div>

<div class="tile">

    <form method="get" action="<?= site_url('reports/expense') ?>">

        <div class="row">

            <div class="col-md-3">
                <label><b>Start Date</b></label>
                <input type="date" class="form-control" name="start_date" value="<?= esc($start_date) ?>" required>
            </div>

            <div class="col-md-3">
                <label><b>End Date</b></label>
                <input type="date" class="form-control" name="end_date" value="<?= esc($end_date) ?>" required>
            </div>

            <div class="col-md-2 mt-4">
                <button class="btn btn-primary">
                    <i class="fa fa-search"></i>
                    Filter
                </button>
            </div>

            <div class="col-md-4 mt-4 text-end">

                <button type="button" id="exportCsvBtn" class="btn btn-success">

                    <i class="fa fa-file-excel"></i>
                    Export CSV

                </button>

                <button type="button" id="exportPdfBtn" class="btn btn-danger">

                    <i class="fa fa-file-pdf"></i>
                    Export PDF

                </button>

            </div>

        </div>

    </form>

</div>


<?php if(!empty($expenses)): ?>

<div class="alert alert-info mt-3">

    <strong>Expense Report</strong>

    <br>

    From

    <strong><?= date('d M Y',strtotime($start_date)); ?></strong>

    To

    <strong><?= date('d M Y',strtotime($end_date)); ?></strong>

</div>

<?php endif; ?>


<div class="tile">

    <div class="table-responsive">

        <table class="table table-bordered table-striped table-hover" id="expenseTable">

            <thead class="table-dark">

                <tr>

                    <th width="5%">SL</th>

                    <th>Reference</th>

                    <th>Category</th>

                    <th>Sub Category</th>

                    <th>Expense For</th>

                    <th width="12%">Amount</th>

                    <th>Note</th>

                    <th width="12%">Date</th>

                </tr>

            </thead>

            <tbody>

                <?php if(!empty($expenses)): ?>

                <?php $i=1; ?>

                <?php foreach($expenses as $exp): ?>

                <?php $totalExpense += $exp->expense_amount; ?>

                <tr>

                    <td><?= $i++ ?></td>

                    <td><?= esc($exp->expense_ref_no) ?></td>

                    <td><?= esc($exp->expense_category_name) ?></td>

                    <td><?= esc($exp->expense_sub_category_name) ?></td>

                    <td><?= esc($exp->expense_what_for) ?></td>

                    <td class="text-end">

                        <?= number_format($exp->expense_amount,2) ?>

                    </td>

                    <td><?= esc($exp->expense_note) ?></td>

                    <td>

                        <?= date('d-m-Y',strtotime($exp->expense_date)) ?>

                    </td>

                </tr>

                <?php endforeach; ?>

                <?php else: ?>

                <tr>

                    <td colspan="8" class="text-center text-danger">

                        No expense records found.

                    </td>

                </tr>

                <?php endif; ?>

            </tbody>

            <?php if(!empty($expenses)): ?>

            <tfoot>

                <tr style="background:#f5f5f5;font-weight:bold;">

                    <td colspan="5" class="text-end">

                        Total Expense

                    </td>

                    <td class="text-end">

                        <?= number_format($totalExpense,2) ?>

                    </td>

                    <td colspan="2"></td>

                </tr>

            </tfoot>

            <?php endif; ?>

        </table>

    </div>

</div>

<?php
echo $this->endSection();
?>


<?php
echo $this->section('scripts');
?>

<link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/jquery.dataTables.min.css">

<script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.31/jspdf.plugin.autotable.min.js"></script>

<script>
$(function() {

    $('#expenseTable').DataTable({

        pageLength: 25,

        responsive: true,

        ordering: true,

        searching: true,

        info: true,

        lengthMenu: [
            [10, 25, 50, 100, -1],
            [10, 25, 50, 100, "All"]
        ]

    });

});

function getFormattedDateTime() {

    const now = new Date();

    return now.toISOString()

        .replace(/[:\-T]/g, "_")

        .split(".")[0];

}

function downloadCSV(csv, filename) {

    let blob = new Blob(

        ["\ufeff" + csv],

        {

            type: "text/csv;charset=utf-8;"

        }

    );

    let link = document.createElement("a");

    link.href = URL.createObjectURL(blob);

    link.download = filename;

    document.body.appendChild(link);

    link.click();

    document.body.removeChild(link);

}

function exportTableToCSV(filename) {

    let csv = [];

    let rows = document.querySelectorAll("#expenseTable tr");

    rows.forEach(function(row) {

        let cols = row.querySelectorAll("td,th");

        let data = [];

        cols.forEach(function(col) {

            data.push('"' +

                col.innerText.replace(/"/g, '""')

                +
                '"');

        });

        csv.push(data.join(","));

    });

    downloadCSV(csv.join("\n"), filename);

}

$("#exportCsvBtn").click(function() {

    exportTableToCSV(

        "Expense_Report_<?= $start_date ?>_To_<?= $end_date ?>_" +

        getFormattedDateTime() +

        ".csv"

    );

});

$("#exportPdfBtn").click(function() {

    const {
        jsPDF
    } = window.jspdf;

    let doc = new jsPDF("p", "mm", "a4");

    doc.setFontSize(16);

    doc.text("Expense Report", 14, 12);

    doc.setFontSize(10);

    doc.text(

        "From: <?= $start_date ?>    To: <?= $end_date ?>",

        14,

        18

    );

    doc.autoTable({

        html: "#expenseTable",

        startY: 24,

        theme: "grid",

        styles: {

            fontSize: 8

        },

        headStyles: {

            fillColor: [41, 128, 185]

        }

    });

    doc.save(

        "Expense_Report_<?= $start_date ?>_To_<?= $end_date ?>.pdf"

    );

});
</script>

<?php
echo $this->endSection();