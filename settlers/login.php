<?php
	
	session_start();
	if((!isset($_POST['login'])) || (!isset($_POST['password']))){
	header('Location: index.php');
	exit();	
	}

	require_once "connect.php";

	$connection = @new mysqli($host, $db_user, $db_password, $db_name);
	if($connection->connect_errno!=0){
		echo "Error: ".$connection->connect_errno;
	}
	else{
	$login = $_POST['login'];
	$password = $_POST['password'];

	$login = htmlentities($login, ENT_QUOTES, "UTF-8");
	$password = htmlentities($password, ENT_QUOTES, "UTF-8");

	//mysqli_real_escape_string defends against the sqlinjection
	$query = "SELECT * FROM users WHERE user='$login' AND pass='$password'";
	if($queryResult = @$connection->query(
	sprintf("SELECT * FROM users WHERE user='%s' AND pass='%s'",
	mysqli_real_escape_string($connection, $login),
	mysqli_real_escape_string($connection, $password)))){
			$user_amount = $queryResult->num_rows;
			if($user_amount>0){
				$_SESSION['logged_in'] = true;

				$column = $queryResult->fetch_assoc();
				$_SESSION['id'] = $column['id'];
				$_SESSION['user'] = $column['user'];
				$_SESSION['wood'] = $column['wood'];
				$_SESSION['stone'] = $column['stone'];
				$_SESSION['food'] = $column['food'];
				$_SESSION['email'] = $column['email'];
				$_SESSION['dayspremium'] = $column['dayspremium'];
				
				unset($_SESSION['error']);
				$queryResult->close();
				header('Location: game.php');
			} else{
				$_SESSION['error'] = '<span style="color:red"> Wrong login or password! </span>';
				header('Location: index.php');
			}

	}
	$connection->close();	
	}
?>
