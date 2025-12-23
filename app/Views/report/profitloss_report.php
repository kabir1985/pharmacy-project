<?php
echo $this->extend('layout');
echo $this->section('content');
?>

<div class='app-title'>	
<div>
        <h1><i class='fa fa-th-list'></i>Profit Loss will show here</h1>

	</div>
</div>



<!---------------Data Table start Here----..............................................--------------------------->
<div class='row'>
    <div class='col-md-12'>
        <div class='tile collapseable show animate__animated  animate__fadeInUp'>
            <div class='tile-body'>
                <div class='table-responsive'>
                <form method='post' action="<?php echo site_url('/profitloss/profitlosspdfcreate') ?>"  target="_blank" accept-charset="utf-8" enctype="multipart/form-data">
                    <table class='table table-hover'>
                        <thead>
                            <tr>
                                <th><input type='text' required class='form-control datePicker' name="start_date" id='start_date' placeholder="Select Start Date"></th>
                                <th><input type='text' required class='form-control datePicker' name="end_date" id='end_date' placeholder="Select End Date">
                                 <th><button type='submit' class='btn btn-primary'>Profit & Loss</button> </th>
                            </tr>
                        </thead>

                        <!-- <tbody>
                                <tr>
                                   <td></td>
                                </tr>

                        </tbody> -->
                    </table>
                  </form>
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

<!-- Google analytics script-->
<script type='text/javascript'>

        // ...............For Date Show.............................
        $('.datePicker').datepicker({
            format: "dd-mm-yyyy",
            autoclose: true,
            todayHighlight: true
        });
        //.................For Date show end........................ 
</script>


<!-- For Calendar start -->

<!-- For Calendar End -->

<?php
echo $this->endSection();
?>