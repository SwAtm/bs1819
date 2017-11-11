<?php
echo validation_errors();
echo "<table border=1 align=center width=50%)";
echo "<tr><td colspan=2 align=center>Complete Transaction</td></tr>";
echo form_open('My_Summary/edit_summary');
print_r($trantype);
/*echo "<tr><td>Transaction Type</td><td>".form_dropdown('tran_type_id',$transact,'5')."</td></tr>";
echo "<tr><td>Date</td><td>".form_input(array('name'=>'date','id'=>'dt'))."</td></tr>";
echo "<tr><td>Select Party</td><td>".form_dropdown('party_id',$party)."</td></tr>";
echo "<tr><td>Expenses</td><td>".form_input('expenses')."</td></tr>";
echo "<tr><td>Remark</td><td>".form_input(array('name'=>'remark','maxlength'=>30,'size'=>30))."</td></tr>";
echo "<tr><td colspan=2 align=center>".form_submit('submit','Submit')."</td></tr>";
echo "<tr><td>Cancelling will delet all entered details</td><td>".form_submit('cancel','Cancel')."</td></tr></table>";
print_r ($transact);
echo form_close();
*/
?>
