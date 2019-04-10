<?php
	session_start();
	if(isset($_SESSION['logged_in']) && ($_SESSION['logged_in']==true)){
		header('Location: game.php');
		exit();
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
	<h2>Only dead have seen the end of the war - Plato</h2>
		<br />
	
	<form action="login.php" method="post">
		Login: <br /> <input type="text" name="login" /> <br />
		Password: <br /> <input type="password" name="password" /> <br />
		<input type="submit" value="Login" />
	</form>

<?php
	if(isset($_SESSION['error'])) echo $_SESSION['error'];
?>

</body>
</html>
