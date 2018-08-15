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
echo "<tr><td colspan=2 align=center>Edit Transaction</td></tr>";
$hidden=array ('id'=>$trantype->id,'tran_type_id'=>$trantype->tran_type_id,'tr_code'=>$trantype->tr_code,'tr_no'=>$trantype->tr_no, 'date'=>date('d-m-Y',strtotime($trantype->date)), 'party_id'=>$trantype->party_id);
echo form_open('My_Summary/edit/'.$hidden['id'],'',$hidden);
echo "<tr><td>Transaction Type</td><td>".$trantype->descrip_1." ".$trantype->descrip_2." ".$trantype->location." ".$trantype->tr_code." ".$trantype->tr_no."</td></tr>";
if (strtoupper($trantype->descrip_1)=="CASH"):
echo "<tr><td colspan=2 align=center>Date: ".date('d-m-Y',strtotime($trantype->date))."</td></tr>";
else:
echo "<tr><td>Date: ".date('d-m-Y',strtotime($trantype->date))."</td><td>".form_input(array('name'=>'date','id'=>'dt'))."</td></tr>";
endif;
if ((strtoupper($trantype->descrip_1)=="CASH")||(strtoupper($trantype->descrip_1)=="BANK")):
echo "<tr><td colspan=2 align=center>Party: Walk In Customre</td></tr>";
else:
echo "<tr><td>Select Party</td><td>".form_dropdown('party_id',$party,set_value('party_id',$trantype->party_id ))."</td></tr>";
endif;
//echo "<tr><td colspan=2 align=center>Party: ". $party."</td></tr>";
echo "<tr><td>Expenses</td><td>".form_input(array('name'=>'expenses', 'value'=>set_value('expenses',$trantype->expenses)))."</td></tr>";
echo "<tr><td>Remark</td><td>".form_input(array('name'=>'remark','maxlength'=>30,'size'=>30, 'value'=>set_value('remark',$trantype->remark)))."</td></tr>";
echo "<tr><td colspan=2 align=center>".form_submit('submit','Submit')."</td></tr>";
echo "</table>";
//print_r ($transact);
echo form_close();

?>
