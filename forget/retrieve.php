<?php
	//author: Bao
	//get email and token
	if (isset($_SERVER["QUERY_STRING"]) && isset($_POST['change-password'])) {
		//double check password format
		require_once('../lib/validation/fanta_valid.php');
		$password = Fanta_Valid::sanitizeUserInput($_POST['change-password']);
		if (Fanta_Valid::isNullOrEmpty($password) || !count($password) === 32) {
	        $error = 'Please enable javaScript';
	    } else {
			$string = htmlspecialchars($_SERVER["QUERY_STRING"]);
			$position = strpos($string, htmlspecialchars('&&&&'));
	        //get email
	        $email = substr($string, 0, $position);
	        //get token
	        $token = substr($string, $position + 20);
			require_once('../lib/DatabaseAccess.php');
			require_once('../lib/publicLogin/default.php');
			$db = DatabaseAccess::getConnection();
			$publicLogin = new PublicLogin($db);
			$result = $publicLogin->retrievePass($email, $password, $token);
			if (!$result) {
				$error = 'Not a valid request';
			} else {
				if(!isset($_SESSION)){
				    session_start();
				}
				$_SESSION['user_name'] = $result['user_name'];
	            $_SESSION['user_id'] = $result['user_id'];
				header('Location: ../');
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
		<title>Change Password</title>
		<link href="../static/css/signup.css" rel="stylesheet" type="text/css">
	</head>
	<body>
        <div class="container-fluid">
			<?php
				include "../templates/header.php";
			?>
            <main id="main" class="row">
				<section class="retrieve col-md-6 col-md-offset-3 col-sm-6 col-sm-offset-3 col-xs-10 col-xs-offset-1">
					<form id="change-pass" method="POST" action="" >
						<h2>Retrieve Password</h2>
						<div class="form-group">
							<label for="change-password">Input your new password here:</label>
					    	<input type="password" class="form-control" id="change-password" name="change-password" placeholder="Password" >
						</div>
						<input type="submit" value="Submit" id="change-submit" class="btn btn-default" >
						<h5 id="change-message"><?php if (isset($error)) {echo $error;} ?></h5>
					</form>
				</section>
            </main>
        </div>
		<script type="text/javascript" src="../static/js/login/login.js"></script>
	</body>
</html>
