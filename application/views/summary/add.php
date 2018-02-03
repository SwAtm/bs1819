<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script src="<?php echo base_url('assets/grocery_crud/js/jquery-1.11.1.js')?>"></script>
<link type="text/css" rel="stylesheet" href="<?php echo base_url('assets/grocery_crud/css/ui/simple/jquery-ui-1.10.1.custom.min.css')?>"/>
<script src="<?php echo base_url('assets/grocery_crud/js/jquery_plugins/ui/jquery-ui-1.10.3.custom.min.js')?>"></script>

<script type="text/javascript">
$(document).ready(function() {
        $("	#dt").datepicker({
            dateFormat:"dd-mm-yy",
            
            }
        );
    });
</script>
</head>
<?php
echo validation_errors();
echo "<table border=1 align=center width=50%)";
echo "<tr><td colspan=2 align=center>Complete Transaction. Cash transactions will always be for today</td></tr>";
echo form_open('My_Summary/add');
echo "<tr><td>Select Transaction Type</td><td>".form_dropdown('tran_type_id',$transact,'5')."</td></tr>";
echo "<tr><td>Date</td><td>".form_input(array('name'=>'date','id'=>'dt'))."</td></tr>";
echo "<tr><td>Select Party</td><td>".form_dropdown('party_id',$party,'1048')."</td></tr>";
echo "<tr><td>Expenses</td><td>".form_input('expenses')."</td></tr>";
echo "<tr><td>Remark</td><td>".form_input(array('name'=>'remark','maxlength'=>30,'size'=>30))."</td></tr>";
echo "<tr><td colspan=2 align=center>".form_submit('submit','Submit')."</td></tr>";
echo "<tr><td>Cancelling will delet all entered details</td><td>".form_submit('cancel','Cancel')."</td></tr></table>";
print_r ($transact);
echo form_close();

?>
</html>
