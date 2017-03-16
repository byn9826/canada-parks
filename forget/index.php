<?php
	//author: Bao
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
