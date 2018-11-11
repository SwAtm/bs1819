<?php
echo "<table width=100% border=1><tr>";
foreach ($po[0] as $k=>$v):
	if ($k=='item_id'):
	continue;
	endif;
echo "<td>".strtoupper($k)."</td>";
endforeach;
echo "<td>Order Qty</td></tr><tr>";
echo form_open('Po_Details/details_add');

foreach ($po as $k=>$pos):
	foreach ($pos as $key=>$val):
	if ($key=='item_id'):
	continue;
	endif;
	echo "<td>$val</td>";
	endforeach;
echo "<td>".form_input($po[$k]['item_id'],'0')."</td>";
echo "</tr><tr>";
endforeach;
echo form_hidden('Party', $party);

echo "<tr><td colspan=7 align=center>".form_submit('submit','Submit')."</td></tr>";
echo form_close();
?>
