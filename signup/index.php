<?php
//author: Bao
if(isset($_POST['newname'])) {
	require_once('../lib/validation/fanta_valid.php');
	//Validate input in php
	$name = $_POST['newname'];
	$password = $_POST['newpassword'];
	$email = $_POST['newemail'];
	$name = Fanta_Valid::sanitizeUserInput($name);
	$email = Fanta_Valid::sanitizeUserInput($email);
    $password = Fanta_Valid::sanitizeUserInput($password);
	//secure password
	$password = sha1($password);
	//get current date
	$reg = date('Y-m-d H:i:s');
	//Double check user input in php
	if (Fanta_Valid::isNullOrEmpty($name) ||Fanta_Valid::isNullOrEmpty($email) || Fanta_Valid::isNullOrEmpty($password) || !Fanta_Valid::isBelowMaxLength($name, 10) || !Fanta_Valid::isEmailValid($email) || !count($password) === 32) {
        $error_message = 'Please enable javaScript';
    } else {
		// if input is valid
		require_once('../lib/DatabaseAccess.php');
		require_once('../lib/account/default.php');
		$db = DatabaseAccess::getConnection();
		$account = new Account($db);
		//get all related email accounts
		$records = $account->searchEmails($email);
		if(!isset($_SESSION)) {session_start();}
		if (!isset($_SESSION['google_id'])) {
			//for people not sign up from google button
			if(count($records) == 1 && $records[0]['email_valid'] == 1) {
				$error_message = 'Email address has already been used';
			} else {
				//create record and send verify email for situations below:
	            //1. rowCount() =1, email_valid !=1 2. rowCount() =0 3. rowCount() > 1
				$string = $name . '-!+a4mc1uw]&' . $email;
				$encrypted = openssl_encrypt($string, 'AES-128-ECB', 'hm!f$#abas&adsf');
				$create = $account->createRecord($name, $password, $email, $reg, $encrypted, null);
				//db error
				if ($create == '0') {
					$error_message = 'Something wrong, please try again';
				} else {
					require_once('../lib/email/default.php');
					require_once('../vendor/phpmailer/phpmailer/PHPMailerAutoload.php');
					$email = new AccountEmail();
					//send verify email
					$sent = $email->sendVerify($_POST['newemail'], $encrypted);
					if($sent == '0') {
						//can't send email
					    $error_message = "Can't send email right now, try later";
					} else {
						//redirect to require email valid page
						header('Location: confirm.php?email=' . $_POST['newemail'] . '&name=' . $_POST['newname']);
					}
				}
			}
		} else {
			//delete all account first if account registered but not valid email before
			if (count($records) != 0) {
				$delete = $account->deleteRecord($email);
				if ($delete == '0') {
					//db error
					$error_message = 'Something wrong, please try again';
					return false;
				}
			}
			//directly insert a new row with email Validate
			$google = $_SESSION['google_id'];
			$create = $account->createRecord($name, $password, $email, $reg, 1, $google);
			if ($create == '0') {
				//db error
				$error_message = 'Something wrong, please try again';
			} else {
				//insert into user detail table
				$id = intval($create);
				$detail = $account->createDetail($id, $name, $reg, $_SESSION["google_profile"]);
				if ($detail == '0') {
					//db error
					$error_message = 'Something wrong, please try again';
				} else {
					//login success write user name and id into session
					$_SESSION['user_name'] = $name;
					$_SESSION['user_id'] = $id;
					header('Location: ../');
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
									echo '';
								}
							?>
						</h5>
						<input id="signup-button" type="button" name="signup-button" value="Submit" class="btn btn-default" />
					</form>
				</section>
            </main>
			<?php
				include "../templates/footer.php";
			?>
        </div>
	</body>
</html>
