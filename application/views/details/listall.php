<?php
//print_r($trantype);
echo "<table border=1 align=center width=50%)";
echo "<tr><td colspan=4 align=center>Entered Bill  ".$trantype->tr_code." - ".$trantype->tr_no."</td></tr>";
echo "<tr>";
foreach ($header as $k):
echo "<td>$k</td>";
endforeach;
echo "</tr><tr>";
foreach ($list as $list1):
	foreach ($list1 as $k=>$v):
	if ($k=='id'):
	continue;
	endif;
	echo "<td>".$v."</td>";
	endforeach;
	if (!empty($list)):
	echo "<td><a href= ".site_url('Details/edit/'.$list1['id']).">Edit</a></td>";
	echo "<td><a href=".site_url('Details/delete/'.$list1['id']).">Delete</a></td>";
	endif;
	echo "</tr><tr>";
endforeach;
echo "</tr>";

echo "<tr><td colspan=2><a href=".site_url('Details/add').">Add Item</a></td><td colspan=2><a href=".site_url('Details/complete').">Complete Bill</a></td></tr></table>";

?>


