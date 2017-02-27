<?php
if(isset($_POST['submit'])) {
	require_once('../lib/DatabaseAccess.php');
	require_once('../lib/publicLogin/default.php');
	$db = DatabaseAccess::getConnection();
	$publicLogin = new PublicLogin($db);
	$success = $publicLogin->signUp($_POST['username'], $_POST['password'], $_POST['email']);
	echo $success;
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
				<section id="signup" class="col-md-4 col-md-offset-4">
					<h2>Join today, explore Marvel!</h2>
					<form method="POST" action="">
						<div id="form-name" class="form-group">
						    <input type="text" class="form-control" id="exampleInputName" name="username" placeholder="Username">
					  	</div>
						<div class="form-group">
					    	<input type="email" class="form-control" id="exampleInputEmail" name="email" placeholder="Email">
						</div>
						<div class="form-group">
					    	<input type="password" class="form-control" id="exampleInputPassword" name="password" placeholder="Password">
					  	</div>
						<button type="submit" name="submit" class="btn btn-default">Submit</button>
					</form>
				</section>
            </main>
			<?php
				include "../templates/footer.php";
			?>
        </div>
	</body>
</html>
