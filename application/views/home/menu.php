<!DOCTYPE html>
<html>
<head>

<script src="<?php echo base_url('application/third_party/jquery.jss')?>" type="text/javascript"></script>
<link href="<?php echo base_url('application/third_party/menu-verticle.css')?>" rel="stylesheet" type="text/css" />
<script src="<?php echo base_url('application/third_party/menu-verticle.js')?>" type="text/javascript"></script>
</head>
<body>
<ul id="menu-v">
    <li><a href="<?php echo site_url('party/party')?>">Add/Edit Party</a></li>
    <li><a href="<?php echo site_url('item/item')?>">Add/Edit Item</a></li>
    
    
    
    <li><a href="#">Transactions</a>
        <ul class="sub">
            <li><a href="<?php echo site_url('temp_details/add')?>">Add Transaction</a></li>
            <li><a href="<?php echo site_url('summary/summary')?>">Edit Transaction</a></li>
        </ul>
    </li>
    <li><a href="#">Item 3</a>
        <ul class="sub">
            <li><a href="#">Sub Item 3.1</a></li>
            <li><a href="#">Sub Item 3.2</a></li>
            <li><a href="#">Sub Item 3.3</a></li>
            <li><a href="#">Sub Item 3.4</a></li>
            <li><a href="#">Sub Item 3.5</a></li>
        </ul>
    </li>
    <li><a href="#">Item 4</a></li>
    <li><a href="#">Item 5</a>
        <ul class="sub">
            <li><a href="#">Sub Item 5.1</a></li>
            <li><a href="#">Sub Item 5.2</a>
                <ul class="sub">
                    <li><a href="#521">Vertical Menu 5.2.1</a></li>
                    <li><a href="#522">Vertical Menu 5.2.2</a></li>
                    <li><a href="#523">Vertical Menu 5.2.3</a></li>
                    <li><a href="#524">Vertical Menu 5.2.4</a></li>
                    <li><a href="#525">Vertical Menu 5.2.5</a></li>
                </ul>
            </li>
            <li><a href="#">Sub Item 5.3</a>
                <ul class="sub">
                    <li><a href="#">Sub Item 5.3.1</a></li>
                    <li><a href="#">Sub Item 5.3.2</a></li>
                    <li><a href="#">Sub Item 5.3.3</a></li>
                    <li><a href="#">Sub Item 5.3.4</a></li>
                    <li><a href="#">Sub Item 5.3.5</a></li>
                    <li><a href="#">Sub Item 5.3.6</a></li>
                    <li><a href="#537">Vertical Menus 5.3.7</a></li>
                    <li><a href="#538">Vertical Menus 5.3.8</a></li>
                </ul>
            </li>
        </ul>
    </li>
    <li><a href="#">Item 6</a></li>
</ul>
</body>
</html>
