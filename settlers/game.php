<?php
	session_start();	
	if(!isset($_SESSION['logged_in'])){
		header('Location: index.php');
		exit();
	}

?>
<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<title></title>
<script src="https://www.google.com/recaptcha/api.js?render=6Lf-WZ0UAAAAAJIpYpwRS811TJjYY4XenvCMfwUB"></script>
 
</head>

<body>

<?php

	echo "<p> Welcome ".$_SESSION['user'].'! [<a href="logout.php">Logout!</a>]</p>';
	echo "<p><b>Wood</b>: ".$_SESSION['wood'];
	echo "<p><b>Stone</b>: ".$_SESSION['stone'];
	echo "<p><b>Food</b>: ".$_SESSION['food'];
	echo "<p><b>Email</b>: ".$_SESSION['email'];
	echo "<p><b>Days Premium</b>: ".$_SESSION['dayspremium'];
?>

</body>
</html>
