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
echo "<tr><td rowspan=3 align=left style = 'width:10%'><img src=".IMGPATH."logo.jpg ></td><td style='width:90%' align=right>".$company->name.", ".$company->add1.", ".$company->city."</td><tr>";
echo "<td style='width:45%'>Transfer ID No: ".$trnf_summary['id']."</td><td style='width:45%'>Date: ".date_format(date_create_from_format('Y-m-d',$trnf_summary['date']),'d-m-Y')."</td></tr><tr><td style='width:45%'>From: ".$trnf_summary['loc_from']."</td><td style='width:45%'>To: ".$trnf_summary['loc_to']."</td></tr>";
echo "</table>";
?>
<table style="width:100%; border-collapse:collapse; align:center" border=1>;
<?php
echo "<tr><td>Title</td><td>Rate</td><td>Quantity</td></tr>";
foreach ($trnf_details as $detail):
echo "<tr><td>".$detail['title']."</td><td>".$detail['rate']."</td><td>".$detail['quantity']."</td></tr>";
endforeach;
echo "</table>";
?>
