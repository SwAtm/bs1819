<?php
echo "<table width=100%>";
echo "<tr><td>Purchase Order No: ".$party['id']."</td><td>Date: ".$party['date']."</td></tr>";
echo "<tr><td colspan=2>To: ".$party['name']."</td></tr>";
echo "<tr><td colspan=2>".$party['add1']."</td></tr>";
echo "<tr><td colspan=2>".$party['city']."</td></tr>";
echo "</table>";
echo "<table width=100% border=1>";
echo "<tr><td>Code</td><td>Rate</td><td>Title</td><td>Quantity</td></tr>";
foreach ($porder as $pord):
echo "<tr><td>".$pord['code']."</td><td>".$pord['rate']."</td><td>".$pord['title']."</td><td>".$pord['quantity']."</td></tr>";
endforeach;
echo "</table>";


?>
