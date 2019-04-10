<!DOCTYPE HTML>
<html lang="pl">
<head>
<meta charset="utf-8" />
</head>

<body>	
<?php
	$donuts = $_POST['donuts'];
	$donutPrice = 0.99;
	$breads = $_POST['breads'];
	$breadPrice = 1.29;
	$price = ($donuts*$donutPrice)+($breads*$breadPrice); 

echo<<<END
	
	<h2> Order Summary </h2>
	<table border="1" cellpadding="10" cellspacing="0">
			<tr>
		<td>Donut ($$donutPrice)</td> <td>$$donuts</td>
	</tr>
	<tr>
		<td>Bread ($$breadPrice)</td> <td>$$breads</td>
	</tr>
	<tr>
		<td>Price</td> <td>$$price</td>
	</tr>
	</table>
	<br /><a href="index.php">Go back to homepage</a>
END;

?>
</body>
</html>
