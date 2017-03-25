<?php
	//author: Bao
	if (isset($_POST['user-email'])) {
		//valid email in php
		require_once('../lib/validation/fanta_valid.php');
		$email = Fanta_Valid::sanitizeUserInput($_POST['user-email']);
		if (!Fanta_Valid::isEmailValid($email)) {
			$error = "Please enable javaScript";
		} else {
			require_once('../lib/DatabaseAccess.php');
			require_once('../lib/publicLogin/default.php');
			$db = DatabaseAccess::getConnection();
			$publicLogin = new PublicLogin($db);
			$result = $publicLogin->forgetPass($email);
			if ($result == 0) {
				$error = "Account not exist, please sign up.";
			} else if ($result == 2) {
				$error = "Email not verified, please sign up again!";
			} else if ($result == 3) {
				$error = "Server error, please try later";
			} else {
				require_once('../lib/email/Default.php');
				require_once('../vendor/phpmailer/phpmailer/PHPMailerAutoload.php');
				$emailValid = new OutEmail();
				$address = $email;
				$token = $email . "&&&&" . $result;
				$subject = 'Retrieve your password on Marvel Canada';
				$body = 'Please click the link below to change your password. <br/>';
				$body .= '<a style="font-size:20px; font-weight: bold; margin:10px 0" href="http://localhost/canada-parks/forget/retrieve.php?' . $token . '">Click here to verify your email address</a> <br/>';
				$body .= 'Please click the link below if the link above not working: <br/>';
				$body .= 'http://localhost/canada-parks/forget/retrieve.php?' . $token;
				$sent = $emailValid->validEmail($address , $subject, $body);
				//If can't send email
				if($sent == 0) {
					$error = "Something wrong, try later";
				}
				else {
					$error = "Success, please check your email";
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
		<title>Retrieve Password</title>
		<link href="../static/css/signup.css" rel="stylesheet" type="text/css">
	</head>
	<body>
        <div class="container-fluid">
			<?php
				include "../templates/header.php";
			?>
            <main id="main" class="row">
				<section class="retrieve col-md-6 col-md-offset-3 col-sm-6 col-sm-offset-3 col-xs-10 col-xs-offset-1">
					<form id="forget-password" method="POST" action="" >
						<h2>Forget Password?</h2>
						<div class="form-group">
							<label for="forget-email">Provide your Email here:</label>
					    	<input type="email" class="form-control" id="forget-email" name="user-email" placeholder="Email" >
						</div>
						<input type="submit" value="Submit" id="forget-submit" class="btn btn-default" >
						<h5 id="forget-message"><?php if (isset($error)) {echo $error;} ?></h5>
					</form>
				</section>
            </main>
        </div>
		<script type="text/javascript" src="../static/js/login/login.js"></script>
	</body>
</html>
