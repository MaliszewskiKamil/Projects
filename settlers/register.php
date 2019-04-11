<?php
	session_start();

	if(isset($_POST['email'])){
		//Success validation? Let's say yes!
		$everything_OK=true;

		//Check if nickname is correct
		$nickname = $_POST['nickname'];
		
		//nickname length
		if(strlen($nickname)<3 || (strlen($nickname)>20)){
			$everything_OK=false;
			$_SESSION['e_nickname']="Nickname must have between 3 and 20 characters!";
			}
			
		if(ctype_alnum($nickname)==false){
			$everything_OK=false;
			$_eSESSION['e_nickname']="Nickname must contain only letters and numbers";
		}
		
		//checking if email is correct
		$email = $_POST['email'];
		$emailSafe = filter_var($email, FILTER_SANITIZE_EMAIL);
		
		if((filter_var($emailSafe, FILTER_VALIDATE_EMAIL)==false) || ($emailSafe!=$email)){
			$everything_OK = false;
			$_SESSION['e_email']="You cannot register with invalid email :(";
		}
		
		//checking password
		$firstPass = $_POST['firstPass'];
		$secondPass = $_POST['secondPass'];
		
		if((strlen($firstPass)<8) || (strlen($secondPass)>20)){
			$everything_OK = false;
			$_SESSION['e_pass']="Password must contain between 8 and 20 characters!";
		}
		
		if($firstPass != $secondPass){
			$everything_OK = false;
			$_SESSION['e_pass']="Passwords must be the same!";
		}
		
		$pass_hash = password_hash($firstPass, PASSWORD_DEFAULT);
		
		//checking ToS
		if(!isset($_POST['termsOfService'])){
			$_SESSION['e_termsOfService']="In order to register, Terms of Service must be confirmed!";
		}
		
		//Bot or not? Recaptcha mechanics
		$secret_key = "";
		$check = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secret_key.'&response='.$_POST['g-recaptcha-response']);
		$response = json_decode($check);
		
		if($response->success==false){
			$everything_OK = false;
			$_SESSION['e_bot']="Confirm that you are not a robot! (Or add a secret key to code)";
		}
		
		require_once "connect.php";
		
		mysqli_report(MYSQLI_REPORT_STRICT);
		
		try{
			$connection = new mysqli($host, $db_user, $db_password, $db_name);
			if($connection->connect_errno!=0){
				throw new Exception(mysqli_connect_errno());
			} else{
				//Does email already exist?
				$result = $connection->query("SELECT id FROM users WHERE email='$email'");
				if(!$result) throw new Exception($connection->error);
				
				$mails_amount = $result->num_rows;
				if($mails_amount>0){
					$everything_OK=false;
					$_SESSION['e_email']="That email adres is already used!";
				}
				//Does nickname already exist?
				$result = $connection->query("SELECT id FROM users WHERE user='$nickname'");
				if(!$result) throw new Exception($connection->error);
				
				$nicknames_amount = $result->num_rows;
				if($nicknames_amount>0){
					$everything_OK=false;
					$_SESSION['e_nickname']="That email nickname is already taken! Select another one >:)";
				}
				
				if($everything_OK==true){
				//Perfect! All tests have been passed!
					if($connection->query("INSERT INTO users VALUES(NULL, '$nickname', '$pass_hash', '$email', 100, 100, 100, 14)")){
						$_SESSION['registered']=true;
						header('Location: welcome.php');
					} else{
						throw new Exception($connection->error);
					}
		}
				$connection->close();
			}
			
		} catch(Exception $ex){
			echo '<span style="color:red;">Server error! Sorry for the problems caused by that. Please register later!</span>';
			echo '<br />Dev info: '.$ex;
		}
		
		
	
	}
?>
<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<title></title>
  <script src="https://www.google.com/recaptcha/api.js" async defer></script>
	
	<style>
		.error{
			color:red;
			margin-top: 10px;
			margin-bottom: 10px;
		}
	</style>
</head>

<body>
	<h2> Register Account </h2>
	<form method="post">
		Nickname: <br /> <input type="text" name="nickname" /> <br />
		
		<?php
			if(isset($_SESSION['e_nickname'])){
				echo '<div class="error">'.$_SESSION['e_nickname'].'</div>';
				unset($_SESSION['e_nickname']);
			}
		?>

		E-mail: <br /> <input type="text" name="email" /> <br />
		
		<?php
			if(isset($_SESSION['e_email'])){
				echo '<div class="error">'.$_SESSION['e_email'].'</div>';
				unset($_SESSION['e_email']);
			}
		?>
		Password: <br /> <input type="password" name="firstPass" /> <br />
		<?php
			if(isset($_SESSION['e_pass'])){
				echo '<div class="error">'.$_SESSION['e_pass'].'</div>';
				unset($_SESSION['e_pass']);
			}
		?>
		Repeat password: <br /> <input type="password" name="secondPass" /> <br />
		<label>
			<input type="checkbox" name="termsOfService"> Accept Terms of Service   </label>
		<?php
			if(isset($_SESSION['e_termsOfService'])){
				echo '<div class="error">'.$_SESSION['e_termsOfService'].'</div>';
				unset($_SESSION['e_termsOfService']);
			}
		?>
  <div class="g-recaptcha" data-sitekey="6Ld2W50UAAAAABDiWfU5_LPy2cFL0cLQKrvJyUPc"></div>
  
		<?php
			if(isset($_SESSION['e_bot'])){
				echo '<div class="error">'.$_SESSION['e_bot'].'</div>';
				unset($_SESSION['e_bot']);
			}
		?>
	<input type="submit" value="Register" />
	</form>

</body>
</html>
