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
			$_eSESSION['e_nick']="Nickname must contain only letters and numbers";
		}
		
		$email = $_POST['email'];
		$emailSafe = filter_var($email, FILTER_SANITIZE_EMAIL);
		
		if((filter_var($emailSafe, FILTER_VALIDATE_EMAIL)==false) || ($emailSafe!=$email)){
			$everything_OK = false;
			$_SESSION['e_email']="You cannot register with invalid email :(";
		}

		if($everything_OK==true){
			//Perfect! All tests have been passed!
			echo "Validation Successful";	
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
		Repeat password: <br /> <input type="password" name="secondPass" /> <br />
		<label>
			<input type="checkbox" name="termsOfService"> Accept Terms of Service   </label>

  <div class="g-recaptcha" data-sitekey="6Ld2W50UAAAAABDiWfU5_LPy2cFL0cLQKrvJyUPc"></div>
	<input type="submit" value="Register" />
	</form>

</body>
</html>
