<?= $this->extend('layout'); ?>
<?= $this->section('content'); ?>

<div class="app-title">
    <div>
        <h1><i class="fa fa-money"></i> Customer Payment Report</h1>
    </div>

    <div class="mt-3 mb-3">
        <button id="exportCsvBtn" class="btn btn-success btn-sm">
            <i class="fa fa-file-csv"></i> Export CSV
        </button>

        <button id="exportPdfBtn" class="btn btn-danger btn-sm">
            <i class="fa fa-file-pdf"></i> Export PDF
        </button>
    </div>
</div>

<div class="row">
    <div class="col-md-12">

        <div class="tile collapseable show animate__animated animate__fadeInUp">

            <div class="tile-body">

                <div class="table-responsive">

                    <table class="table table-bordered table-hover" id="sampleTable">

                        <thead class="table-primary">

                            <tr>

                                <th>ID</th>

                                <th>Customer</th>

                                <th>Phone</th>

                                <th class="text-end">Total Due</th>

                                <th class="text-end">Total Paid</th>

                                <th class="text-end">Balance</th>

                                <th>Status</th>

                            </tr>

                        </thead>

                        <tbody>

                            <?php
                            $grandDue = 0;
                            $grandPaid = 0;
                            $grandBalance = 0;
                            ?>

                            <?php foreach ($customers as $row): ?>

                                <?php

                                $totalDue = $row->total_due ?? 0;
                                $totalPaid = $row->total_paid ?? 0;
                                $balance = $row->current_balance ?? 0;

                                $grandDue += $totalDue;
                                $grandPaid += $totalPaid;
                                $grandBalance += $balance;

                                ?>

                                <tr>

                                    <td><?= $row->customer_id ?></td>

                                    <td><?= esc($row->customer_name) ?></td>

                                    <td><?= esc($row->cus_phone) ?></td>

                                    <td class="text-end">
                                        <?= number_format($totalDue, 2) ?>
                                    </td>

                                    <td class="text-end text-success">
                                        <?= number_format($totalPaid, 2) ?>
                                    </td>

                                    <td class="text-end">

                                        <?php if ($balance > 0): ?>

                                            <span class="badge bg-danger text-white">
                                                <?= number_format($balance, 2) ?>
                                            </span>

                                        <?php else: ?>

                                            <span class="badge bg-success">
                                                0.00
                                            </span>

                                        <?php endif; ?>

                                    </td>

                                    <td>

                                        <?php if ($balance > 0): ?>

                                            <span class="badge bg-warning text-dark">
                                                Due
                                            </span>

                                        <?php else: ?>

                                            <span class="badge bg-success">
                                                Paid
                                            </span>

                                        <?php endif; ?>

                                    </td>

                                </tr>

                            <?php endforeach; ?>

                        </tbody>

                        <tfoot>

                            <tr class="table-info fw-bold">

                                <td colspan="3" class="text-end">

                                    Grand Total

                                </td>

                                <td class="text-end">

                                    <?= number_format($grandDue, 2) ?>

                                </td>

                                <td class="text-end">

                                    <?= number_format($grandPaid, 2) ?>

                                </td>

                                <td class="text-end">

                                    <?= number_format($grandBalance, 2) ?>

                                </td>

                                <td></td>

                            </tr>

                        </tfoot>

                    </table>

                </div>

            </div>

        </div>

    </div>
</div>

<?= $this->endSection(); ?>

<?= $this->section('scripts'); ?>

<script src="<?= base_url('assets/js/plugins/jquery.dataTables.min.js') ?>"></script>
<script src="<?= base_url('assets/js/plugins/dataTables.bootstrap.min.js') ?>"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.28/jspdf.plugin.autotable.min.js"></script>

<script>
$(function(){

    $('#sampleTable').DataTable({

        responsive:true,

        autoWidth:false,

        pageLength:25,

        order:[[0,'asc']]

    });


    // ================= CSV ===================

    function downloadCSV(csv, filename){

        let csvFile = new Blob([csv], {type:'text/csv'});

        let downloadLink = document.createElement('a');

        downloadLink.download = filename;

        downloadLink.href = URL.createObjectURL(csvFile);

        downloadLink.style.display='none';

        document.body.appendChild(downloadLink);

        downloadLink.click();

        document.body.removeChild(downloadLink);

    }


    function exportTableToCSV(filename){

        let csv=[];

        let rows=document.querySelectorAll('#sampleTable tr');

        rows.forEach(function(row){

            let cols=row.querySelectorAll('td,th');

            let data=[];

            cols.forEach(function(col){

                data.push('"' + col.innerText.replace(/"/g,'""') + '"');

            });

            csv.push(data.join(','));

        });

        downloadCSV(csv.join('\n'),filename);

    }


    $('#exportCsvBtn').click(function(){

        exportTableToCSV('customer_payment_report.csv');

    });



    // ================= PDF ===================

    $('#exportPdfBtn').click(function(){

        const {jsPDF}=window.jspdf;

        let doc=new jsPDF('l','mm','a4');

        doc.setFontSize(16);

        doc.text('Customer Payment Report',14,15);

        doc.autoTable({

            html:'#sampleTable',

            startY:22,

            theme:'grid',

            styles:{

                fontSize:8,

                cellPadding:2

            },

            headStyles:{

                fillColor:[40,116,166],

                textColor:255

            }

        });

        doc.save('customer_payment_report.pdf');

    });

});
</script>

<?= $this->endSection(); ?>