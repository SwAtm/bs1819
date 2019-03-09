<!doctype=html>
<html>
<head>
</head>
<body>
<h2>
<?php print $summarydet->location." ".$summarydet->descrip_1." ".$summarydet->descrip_2."--";
print $summarydet->tr_code." ".$summarydet->tr_no."   Date: ".date('d-m-Y',strtotime($summarydet->date))."<br>";
?>
</h2><h3><?php
echo "<table border=1 width=100%>";
echo "<tr><td>Code</td><td>Rate</td><td>Title</td><td>Quantity</td><td>Cash Discount</td><td>Discount</td><td>GST Rate</td><td>HSN Code</td></tr>";
foreach ($det_item as $det):
echo "<tr><td>".$det['code']."</td><td>".$det['rate']."</td><td>".$det['title']."</td><td>".$det['quantity']."</td><td>".$det['cashdisc']."</td><td>".$det['discount']."</td><td>".$det['grate']."<td></tr>";
endforeach;
echo "</table>";
?></h3><?php
echo"<a href=".site_url('Summary/summary').">Go to List</a><br>";
?>
</body>
</html>
