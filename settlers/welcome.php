<?php
	session_start();
	if(!isset($_SESSION['registered'])){
		header('Location: index.php');
		exit();
	} else{
		unset($_SESSION['registered']);
	}
?>
<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<title>Settlers - Browser Game</title>
</head>

<body>
	<h2>Thank you for the registration! Your account is ready and waiting for you!</h2>
		<br />
	<a href="index.php"> Login now and destroy your enemies!</a>
	

<?php
	if(isset($_SESSION['error'])) echo $_SESSION['error'];
?>

</body>
</html>
