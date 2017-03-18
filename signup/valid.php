<?php
//author: Bao
    if (isset($_SERVER["QUERY_STRING"])) {
        $string = htmlspecialchars($_SERVER["QUERY_STRING"]);
        //get origin string
        $decrypted = openssl_decrypt($string, "AES-128-ECB", "hm!f$#aba=s)&adsf");
        //get secure string positon
        $position = strpos($decrypted, '(-!+am)cuw]&');
        if ($position > 0) {
            //get name
            $username = substr($decrypted, 0, $position);
            //get email
            $email = substr($decrypted, $position + 12);
            require_once('../lib/DatabaseAccess.php');
    		require_once('../lib/publicLogin/default.php');
            $db = DatabaseAccess::getConnection();
    		$publicLogin = new PublicLogin($db);
            $result = $publicLogin->verifyEmail($username, $email);
            if (!$result) {
                $message = "Account doesn't exist";
            } else if ($result === 1) {
                $message = "Email already verified before!";
                session_start();
                $_SESSION['user_name'] = $result->user_name;
                $_SESSION['user_id'] = $result->user_id;
            } else if ($result === 0) {
                $message = "Can't update info right now, please try later!";
            } else {
                $message = "Email verified! Welcome, " . $result->user_name;
                session_start();
                $_SESSION['user_name'] = $result->user_name;
                $_SESSION['user_id'] = $result->user_id;
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
					<h2>
                        <?php
                            //show error if the link doesn't contain email and username information
                            if (!isset($username)) {
                                echo 'Your verify Link is invalid!';
                            } else {
                                echo 'Verify your email';
                            }
                        ?>
                    </h2>
                    <h4 id="verify-result">
                        <?php
                            if (isset($message)) {
                                echo $message;
                            }
                        ?>
                    </h4>
                    <a href="../"><button type="button" class="btn btn-primary verify-button">Go back to homepage</button></a>
                    <a href="../forget"><button type="button" class="btn btn-warning verify-button">Retrieve your password</button></a>
				</section>
            </main>
        </div>
	</body>
</html>
