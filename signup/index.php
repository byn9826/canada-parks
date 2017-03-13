<?php
session_start();
if(isset($_POST['newname'])) {
	require_once('../lib/validation/fanta_valid.php');
	//Validate input in php
	$name = $_POST['newname'];
	$password = $_POST['newpassword'];
	$email = $_POST['newemail'];
	$name = Fanta_Valid::sanitizeUserInput($name);
	$email = Fanta_Valid::sanitizeUserInput($email);
    $password = Fanta_Valid::sanitizeUserInput($password);
	if (Fanta_Valid::isNullOrEmpty($name) ||Fanta_Valid::isNullOrEmpty($email) || Fanta_Valid::isNullOrEmpty($password) || !Fanta_Valid::isBelowMaxLength($name, 10) || !Fanta_Valid::isEmailValid($email) || !count($password) === 32) {
        $error_message = 'Please enable javaScript';
    } else {
		require_once('../lib/DatabaseAccess.php');
		require_once('../lib/publicLogin/default.php');
		$db = DatabaseAccess::getConnection();
		$publicLogin = new PublicLogin($db);
		$result = $publicLogin->signUp($_POST['newname'], $_POST['newpassword'], $_POST['newemail']);
		if ($result == 'duplicate') {
			$error_message = 'Email address has already been used';
		} else if ($result == 1) {
			$_SESSION['user_name'] = $_POST['newname'];
			header("Location: ../");
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
