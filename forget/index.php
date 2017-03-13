<?php
	//ini_set('SMTP', 'smtp-mail.outlook.com');
	//ini_set('smtp_port', '587');
	//ini_set('sendmail_from', 'marvelcanada@outlook.com');
	//ini_set('auth_username', 'marvelcanada@outlook.com');
	//ini_set('auth_password', 'Humbercollege');
	//echo 'SMTP: ' . ini_get('SMTP') . " - ";
	//echo 'smtp_port: ' . ini_get('smtp_port') . " - ";
	//echo 'send from: ' . ini_get('sendmail_from') . " - ";
	//echo 'send path: ' . ini_get('sendmail_path') . " - ";
	//echo 'authname: ' . ini_get('auth_username') . " - ";
	//echo 'authpassword: ' . ini_get('auth_password') . " - ";
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
				<section class="retrieve col-md-4 col-md-offset-1 col-sm-6 col-sm-offset-3 col-xs-10 col-xs-offset-1">
					<form id="forget-username" method="POST" >
						<h2>Forget Username?</h2>
						<div class="form-group">
							<label for="InputEmail">Provide your email here.</label>
					    	<input type="email" class="form-control" id="get-email" name="email" placeholder="Email">
						</div>
						<input type="submit" value="Submit" class="btn btn-default" />
						<h5 id="back-username">Test error message, will hide later</h5>
					</form>
				</section>
				<section class="retrieve col-md-4 col-md-offset-1 col-sm-6 col-sm-offset-3 col-xs-10 col-xs-offset-1">
					<form id="forget-password" method="POST" >
						<h2>Forget Password?</h2>
						<div class="form-group">
							<label for="InputPassword">Provide your password here.</label>
					    	<input type="email" class="form-control" id="get-email" name="useremail" placeholder="Email">
						</div>
						<input type="submit" value="Submit" class="btn btn-default" />
						<h5 id="back-password">Test error message, will hide later</h5>
					</form>
				</section>
            </main>
        </div>
	</body>
</html>
