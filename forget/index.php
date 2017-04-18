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
			require_once('../lib/account/default.php');
			$db = DatabaseAccess::getConnection();
			$account = new Account($db);
			//search all account related to this email address first
			$search = $account->searchEmails($email);
			if (count($search) == 0) {
				$error = "Account not exist, please sign up.";
			} else if (count($search) >1) {
				$error = "Email not verified, please sign up again!";
			} else {
				if ($search[0]['email_valid'] != '1') {
					$error = "Email not verified, please sign up again!";
				} else {
					//create a secure token
					$date = new DateTime();
	                $random = $date->getTimestamp();
	                $combine = 'dc*yqw@dcasg' . $random . 'ibndw$528t*';
	                $string = sha1(md5($combine));
					$set = $account->setForget($string, $email);
					if ($set == '0') {
						$error = "Server error, please try later";
					} else {
						require_once('../lib/email/Default.php');
						require_once('../vendor/phpmailer/phpmailer/PHPMailerAutoload.php');
						$service = new AccountEmail();
						//send retrieve password email
						$token = $email . "&&&&" . $string;
						$sent = $service->sendForget($email, $token);
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
