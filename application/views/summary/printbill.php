<html>
<head>
<style>
@page {
   margin-top: 1cm;
   margin-left: 1cm;
   margin-right: 1cm;		
}
</style>
</head>


<table style = "width:100%" align = center>
<?php
echo "<tr><td rowspan=4 align=left style = 'width:10%'><img src=".IMGPATH."logo.jpg ></td><td align=right>".$company->name.", ".$company->add1.", ".$company->city." GST No: ".$company->gstno."</td></tr><tr>";

//echo "<img src=".IMGPATH."logo.jpg style='floa: center'/>";
//print_r($company);
echo "<td align=right>".$toprint1->location.": ".$toprint1->descrip_1." ".$toprint1->descrip_2." Bill No: ".$toprint1->tr_code.": ".$toprint1->tr_no."  Date: ".date_format(date_create_from_format('Y-m-d',$toprint1->date),'d-m-Y')."</td></tr><tr>";
echo "<td align=right>Billed To: ".$toprint1->name.", ".$toprint1->city."</td></tr><tr><td align=right>GST No.: ".$toprint1->gstno."</td></tr></table";
?>
<table  style="width:100%; font-size: 12px; font-stretch: condensed; font-family: sans-serif; align:center; border-collapse: collapse" border=1>
<?php
echo "<tr><td>Code</td><td>HSN</td><td>Title</td><td>Rate</td><td>Qty</td><td>C Disc</td><td>% Disc</td><td>Tr Val</td><td>SG Rate</td><td>SGST</td><td>CG Rate</td><td>CGST</td><td>IG Rate</td><td>IGST</td><td>Total</td>";
echo "</tr>";
echo "<br>";

foreach ($toprint2 as $p):
echo "<tr><td>".$p['code']."</td><td>".$p['hsn']."</td><td width=20%>".substr($p['title'],0,15)."</td><td>".$p['rate']."</td><td>".$p['quantity']."</td><td>".number_format($p['cashdisc'],2)."</td><td>".number_format($p['discount'],2)."</td><td>".number_format($p['tr_val'],2)."</td><td>".number_format($p['sgrate'],2)."</td><td>".number_format($p['sgst'],2)."</td><td>".number_format($p['cgrate'],2)."</td><td>".number_format($p['cgst'],2)."</td><td>".number_format($p['igrate'],2)."</td><td>".number_format($p['igst'],2)."</td><td>".number_format($p['val'],2)."</td></tr>";
endforeach;
echo "<tr><td colspan=7>Total : </td><td>".number_format($tr_val_total,2)."<td></td><td>".number_format($sgst_total,2)."</td><td></td><td>".number_format($cgst_total,2)."</td><td ></td><td>".number_format($igst_total,2)."</td><td>".number_format($val_total,2)."</td></tr>";
echo "<tr><td colspan=3>Value of Books: ".number_format($amountb,2)."</td><td colspan=4>Value of Articles: ".number_format($amountr,2)."</td><td colspan=4>Expenses: ".$toprint1->expenses."</td><td colspan=4>Gr Total: ".number_format($gt,2)."</td></tr>";
echo "<tr><td colspan=6 align=center><a href=".site_url('Summary/summary').">GO to List</a></td><td colspan=9 align=center><a href=".site_url('temp_details/add').">Continue with new bill</a></td></tr>";
echo "</table>";
/*
echo "</table>";
echo "<table align=center border=0 width=75% >";
echo "<tr><td colspan=6 align=center>Summary:</td></tr>";
echo "<tr><td>GST Rate</td><td>Tr_Val</td><td>CGST</td><td>SGST</td><td>IGST</td><td>Total</td></tr>";
foreach ($temp_bill as $tbill):
	echo "<tr><td>".$tbill['grate']."<td>".$tbill['tr_val']."</td><td>".number_format($tbill['cgst'],2)."</td><td>".number_format($tbill['sgst'],2)."</td><td>".number_format($tbill['igst'],2)."</td><td>".$tbill['val']."</td></tr>";
endforeach;
echo "<tr><td colspan=6 align=center>Grand Total: ".number_format($gt,2)."</td></tr>";


*/
?>
</html>
