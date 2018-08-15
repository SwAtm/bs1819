<html>
<table style = "width:100%; border-collapse:collapse; align:center" border=1>
<?php
echo "<tr><td align=center>Party: ".trim($party['name']).",".$party['add1'].", ".$party['city']."</td></tr>";
echo "</table>";	
echo "<table width=100% border=1 style='border-collapse:collapse'>";
echo "<tr><td>Item Code</td><td>Title</td><td>Rate</td><td>Out</td><td>In</td><td>Balance</td><td>Amount</td></tr>";
$tbal=0;

foreach ($balance as $bal):
echo "<tr><td>".$bal['item_id']."</td><td>".$bal['title']."</td><td>".number_format($bal['rate'],2)."</td><td>".$bal['qout']."</td><td>".$bal['qin']."</td><td>".$bal['bal']."</td><td>".number_format($bal['bal']*$bal['rate'],2)."</td></tr>";
endforeach;
echo "<tr><td colspan=7 align=center>Total: ".number_format($tbalance,2)."</td></tr>";
echo "</table>";
echo "<table width=100% border=1><tr><td>";
echo "<a href = ".site_url('Profo_Summary/balance').">Go to Proforma Summary Balance list</a></td></tr>";
echo form_open('Profo_Details/convert');
echo "<tr><td> Convert to Sales Invoice and settle for amount:".form_input('settleamt',number_format($tbalance,2)).form_submit('submit','Convert')."</td></tr></table>";
echo form_hidden($balance);
echo form_hidden('pid',$party['pid']);
echo form_hidden('tbalance', $tbalance);
echo form_close();
?>
</html>
