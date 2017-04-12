<?php
//author: Bao
//get email name from query string
$string = htmlspecialchars(str_replace("email=","",$_SERVER["QUERY_STRING"]));
$position = strpos($string, htmlspecialchars('&name='));
$email = substr($string, 0, $position);
$name = substr($string, $position + 10);
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<?php
			include "../templates/meta.php";
		?>
		<meta name="author" content="Baozier">
		<title>Verify Email</title>
		<link href="../static/css/signup.css" rel="stylesheet" type="text/css">
	</head>
	<body>
        <div class="container-fluid">
			<?php
				include "../templates/header.php";
			?>
            <main id="main" class="row">
				<section id="signup" class="col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3 col-xs-10 col-xs-offset-1">
					<h2>Please verify your email!</h2>
                    <a href="<?php echo 'http://' . $email ; ?>">
                        <span id="email-verify" class="glyphicon glyphicon-envelope"></span>
                    </a>
					<form method="POST">
						<input type="hidden" id="hide-name" value="<?php echo $name; ?>" />
						<input type="hidden" id="hide-email" value="<?php echo $email; ?>" />
						<button id="confirm-resend" type="button" class="btn btn-primary">Click to resend the link</button>
					</form>
				</section>
            </main>
        </div>
		<script type="text/javascript" src="../static/js/login/login.js"></script>
	</body>
</html>
