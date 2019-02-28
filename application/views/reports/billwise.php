<html>
<head>
<style>
@page {
   margin-top: 1cm;
   margin-left: 2cm;
   margin-right: 0cm;		
}
</style>
</head>
<?php
echo "<table width=80% align=center border = 1 style='font-size: 12px; border-collapse: collapse'><tr>";
echo "<td colspan=11 align=center>Ramakrishna Mission Ashrama, Belgaum. Billwise report - ".$cs_ot." from ".$sdate." to ".$edate."</td></tr><tr>";
echo "<td colspan=2 align=center>Bill No</td><td colspan=2 align=center>Party</td><td>Books</td><td>Articles</td><td>Expenses</td><td>CGST</td><td>SGST</td><td>IGST</td><td>Total</td></tr>";

Foreach  ($billwise['details'] as $row):
echo "<tr><td>".$row['tr_code']."</td><td align=right>".$row['tr_no']."|</td><td align=right>".$row['code']."</td><td align=right width=12%>".$row['name']."-".$row['city']."|</td><td align=right>".$row['amount_b']."|</td><td align=right>".$row['amount_r']."|</td><td align=right>".$row['expenses']."|</td><td align=right>".$row['cgst']."|</td><td align=right>".$row['sgst']."|</td><td align=right>".$row['igst']."|</td><td align=right>".$row['total']."</td></tr>";
endforeach;
echo "</table>";
echo "<table width=80% align=center border=1 style='border-collapse: collapse'>";
echo "<tr><td colspan=8 align=center>Summary</td></tr>";
echo "<tr><td></td><td>Books</td><td>Articles</td><td>Expenses</td><td>CGST</td><td>SGST</td><td>IGST</td><td>Total</td></tr>";
foreach ($billwise['summary'] as $row):
echo "<tr><td>".$row['location']." - ".$row['descrip_1']." ".$row['descrip_2']."</td><td>".$row['amount_b']."</td><td>".$row['amount_r']."</td><td>".$row['expenses']."</td><td>".$row['cgst']."</td><td>".$row['sgst']."</td><td>".$row['igst']."</td><td>".$row['total']."</td></tr>";
endforeach;
echo "</table>";
?>
