<?php
echo validation_errors();
//print_r($item);
echo "<table border=1 align=center width=50%)";
echo "<tr><td colspan=2 align=center>Add Item</td></tr>";
echo form_open('details/add');
echo "<tr><td>Select Item</td><td>".form_dropdown('item_id',$item)."</td></tr>";
//echo "<tr><td>Date</td><td>".form_input(array('name'=>'date','id'=>'dt'))."</td></tr>";
//echo "<tr><td>Select Party</td><td>".form_dropdown('party_id',$party)."</td></tr>";
echo "<tr><td>Quantity</td><td>".form_input('quantity',$quantity)."</td></tr>";
echo "<tr><td>Discount</td><td>".form_input('discount',$discount)."</td></tr>";
echo "<tr><td>Cash Discount</td><td>".form_input('cashdisc',$cashdisc)."</td></tr>";
echo "<tr><td align=center colspan=2>".form_submit('save','Save')."</td></tr>";
echo "</table>";
echo form_close();
?>
