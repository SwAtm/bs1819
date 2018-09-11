<?php
echo "<pre>";
//print_r($stck_summ);
//print_r($item);
echo "</pre>";
echo "<table width=100% border=1><tr><td align=center>".$item->code." ".$item->title." ".$item->rate."</td></tr></table>";
echo "<table width=100% border=1>";
echo "<tr><td>Location</td><td>Opening Stock</td><td>Purchase/Sale Return</td><td>Sales/Purchase Return</td><td>Trnf In</td><td>Trnf Out</td><td>Balance</td></tr>";
foreach ($stck_summ as $row):
$balance=$row['opstck']+$row['purchase']+$row['qin']-$row['sales']-$row['qout'];
echo "<tr><td>".$row['description']."</td><td>".$row['opstck']."</td><td>".$row['purchase']."</td><td>".$row['sales']."</td><td>".$row['qin']."</td><td>".$row['qout']."</td><td>".$balance."</td><td><a href=".site_url('Item/det_stck/'.$row['id'].'/'.$item->id).">Show Details</a></td></tr>";
endforeach;
echo "<tr><td colspan=8 align=center><a href=".site_url('Item/item').">Go to Item List</a></td></tr>";
echo "</table>";
//echo $row['opstck']+$row['purchase']+$row['qin']-$row['sales']-$row['qout'];
?>
