<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="refresh"/>
<div>
	<?php if (isset($extra1)):
	echo $extra1;
	endif;?>
	</div>

<?php 
foreach($css_files as $file): ?>
    <link type="text/css" rel="stylesheet" href="<?php echo $file; ?>" />
 
<?php endforeach; ?>
<?php foreach($js_files as $file): ?>
 
    <script src="<?php echo $file; ?>"></script>
<?php endforeach; ?>
<style type='text/css'>
body
{
    font-family: Arial;
    font-size: 14px;
}
a {
    color: blue;
    text-decoration: none;
    font-size: 14px;
}
a:hover
{
    text-decoration: underline;
}
</style>
</head>
<body>
	
<?php echo $output; ?>
 
    </div>
<div>
	<?php echo $extra?>
	</div>
    <div style='height:20px;'></div>  
    <div>

</body>
<script>
location.reload(true)
</script>
</html>
 
