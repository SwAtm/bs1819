<?php
//echo "to print1<br>";
/*mpdf
require_once(APPPATH.'libraries/MPDF57/mpdf.php');
$mpdf=NEW mPDF();
//mpdf*/

echo "<table width 75% border=2px align=center><tr>";
echo "<td colspan=11 align=center>".$toprint1->location.": ".$toprint1->descrip_1." ".$toprint1->descrip_2."</td><tr>";
echo "<td colspan=11 align=center>".$toprint1->tr_code.": ".$toprint1->tr_no."  Date: ".$toprint1->date." || Expenses: ".$toprint1->expenses."</td><tr>";
echo "<td colspan=11 align=center>Party: ".$toprint1->code."||  Name: ".$toprint1->name."  ||City: ".$toprint1->city."||  GST No.: ".$toprint1->gstno."</td></tr>";

//print_r($toprint1);

echo "<td>Code</td><td>Rate</td><td>Title</td><td>Quantity</td><td>C Disc</td><td>% Disc</td><td>HSN</td><td>G Rate</td><td>Tr Val</td><td>GST</td><td>Total</td>";
echo "</tr>";
echo "<br>";

foreach ($toprint2 as $p):
/*
$val=($p->rate-$p->cashdisc)*$p->quantity-(($p->rate-$p->cashdisc)*$p->quantity*($p->discount/100));
$tr_val=round($val/(100+$p->grate)*100,2);
$gst=round($val/(100+$p->grate)*$p->grate,2);
*/
//$gst=($p->rate-$p->cashdisc)*$p->quantity-(($p->rate-$p->cashdisc)*$p->quantity*($p->discount/100));
echo "<tr><td>".$p['code']."</td><td>".$p['rate']."</td><td>".$p['title']."</td><td>".$p['quantity']."</td><td>".$p['cashdisc']."</td><td>".$p['discount']."</td><td>".$p['hsn']."</td><td>".number_format($p['grate'],2)."</td><td>".number_format($p['tr_val'],2)."</td><td>".number_format($p['gst'],2)."</td><td>".number_format($p['val'],2)."</td></tr>";
endforeach;
echo "<tr><td colspan=6>Value of Books: ".number_format($toprint3['amountb'],2)."</td><td colspan=5>Value of Articles: ".number_format($toprint3['amountr'],2)."</td></tr>";
echo "</table>";
echo "<table align=center border=2>";
echo "<tr><td colspan=11 align=center>Summary:</td></tr>";
echo "<tr><td>GST Rate</td><td>Tr_Val</td><td>GST</td><td>Total</td></tr>";
foreach ($temp_bill as $tbill):
	echo "<tr><td>".$tbill['grate']."<td>".$tbill['tr_val']."</td><td>".$tbill['gst']."</td><td>".$tbill['val']."</td></tr>";
endforeach;

echo "<tr><td colspan=11 align=center><a href=".site_url('Summary/summary').">GO to List</a></td></tr>";
echo "</table>";

/*mpdf
$html=ob_get_contents();
ob_end_clean();
$mpdf->WriteHTML($html);
$mpdf->Output();
//mpdf*/
/*echo "to print2<br>";
print_r($toprint2);
echo "<br>";
echo "to print3<br>";
print_r($toprint3);*/
?>
