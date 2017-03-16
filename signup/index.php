<?php
//author: Bao
//sign up page for /signup

//use session
session_start();

//will directly write image to db later
//echo $_SESSION["google_profile"];

if(isset($_POST['newname'])) {
	require_once('../lib/validation/fanta_valid.php');
	//Validate input in php
	$name = $_POST['newname'];
	$password = $_POST['newpassword'];
	$email = $_POST['newemail'];
	$name = Fanta_Valid::sanitizeUserInput($name);
	$email = Fanta_Valid::sanitizeUserInput($email);
    $password = Fanta_Valid::sanitizeUserInput($password);
	//Double check user input in php
	if (Fanta_Valid::isNullOrEmpty($name) ||Fanta_Valid::isNullOrEmpty($email) || Fanta_Valid::isNullOrEmpty($password) || !Fanta_Valid::isBelowMaxLength($name, 10) || !Fanta_Valid::isEmailValid($email) || !count($password) === 32) {
        $error_message = 'Please enable javaScript';
    }
	// if input is valid
	else {
		require_once('../lib/DatabaseAccess.php');
		require_once('../lib/publicLogin/default.php');
		$db = DatabaseAccess::getConnection();
		$publicLogin = new PublicLogin($db);
		$result = $publicLogin->signUp($_POST['newname'], $_POST['newpassword'], $_POST['newemail']);
		//if email already taken
		if ($result == 'duplicate') {
			$error_message = 'Email address has already been used';
		}
		//if there's error
		else if ($result == 0) {
			$error_message = 'Something wrong, please try again';
		}
		//sign up success, write into session, redirect to homepage
		else {
			//get phpmailer, send verification mail
			//test only will write logic later
			require_once('../vendor/phpmailer/phpmailer/PHPMailerAutoload.php');
			$mail = new PHPMailer;
			$mail->isSMTP();
			$mail->Host = 'smtp-mail.outlook.com';
			$mail->SMTPAuth = true;
			$mail->Username = 'marvelcanada@outlook.com';
			$mail->Password = 'hb2017cms';
			$mail->SMTPSecure = tls;
			$mail->Port = 587;
			$mail->setFrom('marvelcanada@outlook.com', 'Mailer');
			$mail->addAddress($_POST['newemail']);
			$mail->isHTML(true);
			$mail->Subject = 'Test';
			$mail->Body = 'Test only.';
			if(!$mail->send()) {
			    echo 'Message could not be sent.';
			    echo 'Mailer Error: ' . $mail->ErrorInfo;
			} else {
				//If mail successfully sent, will write logic later
				$_SESSION['user_name'] = $_POST['newname'];
				$error_message = $result;
				$_SESSION['user_id'] = $result;
				header("Location: ../");
			}
		}
	}
}
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<?php
			include "../templates/meta.php";
		?>
		<meta name="author" content="Baozier">
		<title>Sign up</title>
		<link href="../static/css/signup.css" rel="stylesheet" type="text/css">
	</head>
	<body>
        <div class="container-fluid">
			<?php
				include "../templates/header.php";
			?>
            <main id="main" class="row">
				<section id="signup" class="col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3 col-xs-10 col-xs-offset-1">
					<h2>Join today, explore Marvel!</h2>
					<?php
						//show google profile for google login user
						if (isset($_SESSION['google_id'])) {
							echo "<img id='signup-profile' src='" . $_SESSION["google_profile"] . "' />";
						}
					?>
					<form id="user-signup" method="POST" action="" >
						<div id="form-name" class="form-group">
							<label for="InputName">Username must be <= 10 characters</label>
						    <input type="text" class="form-control" id="input-name" name="newname" placeholder="Username" value="<?php if (isset($_SESSION['google_id'])) {echo $_SESSION['google_name'];} ?>" >
					  	</div>
						<div class="form-group">
							<label for="InputEmail">Email will be used for retrieve password</label>
					    	<input type="email" class="form-control" id="input-email" name="newemail" placeholder="Email" value="<?php if (isset($_SESSION['google_id'])) {echo $_SESSION['google_email'];} ?>" >
						</div>
						<div class="form-group">
							<label for="InputPassword">Password must be 8 - 16 characters</label>
					    	<input type="password" class="form-control" id="input-password" name="newpassword" placeholder="Password">
					  	</div>
						<div class="checkbox">
							<label>
						    	<input id="input-check" name="check" type="checkbox"> By signing up, you agree to the Terms of Service and Privacy Policy
						    </label>
						</div>
						<h5 id="signup-error">
							<?php
								//show error message
								if( isset($error_message)) {
									echo $error_message;
								} else {
									echo 'Test Error message, will hide later';
								}
							?>
						</h5>
						<input id="signup-button" type="button" name="signup-button" value="Submit" class="btn btn-default" />
					</form>
				</section>
            </main>
        </div>
	</body>
</html>
