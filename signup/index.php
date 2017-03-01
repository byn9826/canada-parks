<?php
session_start();
if(isset($_POST['newname'])) {
	require_once('../lib/DatabaseAccess.php');
	require_once('../lib/publicLogin/default.php');
	$db = DatabaseAccess::getConnection();
	$publicLogin = new PublicLogin($db);
	$success = $publicLogin->signUp($_POST['newname'], $_POST['newpassword'], $_POST['newemail']);
	echo $success;
	if ($success == 1) {
		$_SESSION['user_name'] = $_POST['newname'];
		header("Location: ../");
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
					<form id="user-signup" method="POST" action="" >
						<div id="form-name" class="form-group">
							<label for="InputName">Username must be <= 10 characters</label>
						    <input type="text" class="form-control" id="input-name" name="newname" placeholder="Username">
					  	</div>
						<div class="form-group">
							<label for="InputEmail">Email will be used for retrieve password</label>
					    	<input type="email" class="form-control" id="input-email" name="newemail" placeholder="Email">
						</div>
						<div class="form-group">
							<label for="InputPassword">Password must be 8 - 16 characters</label>
					    	<input type="password" class="form-control" id="input-password" name="newpassword" placeholder="Password">
					  	</div>
						<h5 id="signup-error">Test Error message, will hide later</h5>
						<input id="signup-button" type="button" name="signup-button" value="Submit" class="btn btn-default" />
					</form>
					<h6>By signing up, you agree to the Terms of Service and Privacy Policy</h6>
				</section>
            </main>
        </div>
	</body>
</html>
