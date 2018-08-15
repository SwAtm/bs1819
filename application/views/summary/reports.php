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
    
    $(function() {
    $("#dt1").datepicker({
		dateFormat:"dd-mm-yy",
		
		}		
               );
});
</script>
</head>
<?php
echo validation_errors();
echo "<table width=75% align=center border=1><tr><td colspan=3 align=center>Generate Report</td></tr><tr><td>";
echo form_open('My_Summary/reports');
//echo "Please select</td><td>Billwise: ".form_radio('wise','Bill',true)."</td><td>Datewise: ".form_radio('wise','Date',false)."</td></tr><tr><td>";
echo "Please select</td><td>Cash: ".form_radio('cs_ot','Cash',true)."</td><td>Other: ".form_radio('cs_ot','Other',false)."</td>";
echo "<tr><td>Date</td><td>Starting".form_input(array('name'=>'sdate','id'=>'dt'))."</td><td>Endig".form_input(array('name'=>'edate','id'=>'dt1'));

echo "</tr><tr><td colspan=3 align=center>".form_submit('submit','Submit')."</td></tr>";
echo "</tr><tr><td colspan=3 align=center><a href=".site_url().">Go Home</a></td></tr>";
echo form_close();
echo "</table>";
?>
</html>
