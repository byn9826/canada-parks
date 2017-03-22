<?php
//author: Bao
    //Only have meaning to url contain query string
    if (isset($_SERVER["QUERY_STRING"])) {
        $string = htmlspecialchars($_SERVER["QUERY_STRING"]);
        //get origin string
        $decrypted = openssl_decrypt($string, "AES-128-ECB", "hm!f$#abas&adsf");
        //get secure string positon
        $position = strpos($decrypted, '-!+a4mc1uw]&');
        //get name
        $username = substr($decrypted, 0, $position);
        //get email
        $email = substr($decrypted, $position + 12);
        if ($position > 0) {
            require_once('../lib/DatabaseAccess.php');
            require_once('../lib/publicLogin/default.php');
            $db = DatabaseAccess::getConnection();
            $publicLogin = new PublicLogin($db);
            if (isset($_POST['valid-password'])) {
                $result = $publicLogin->conflictValid($username, $email, $_POST['valid-password'], $string);
                if ($result === 1) {
                    $message = "Email verified! Welcome, " . $result['user_name'];
                    session_start();
                    $_SESSION['user_name'] = $result['user_name'];
                    $_SESSION['user_id'] = $result['user_id'];
                } else {
                    $message = "Can't update info right now, please try later!";
                }
            } else {
                $result = $publicLogin->verifyEmail($username, $email, $string);
                if (!$result) {
                    $message = "Account doesn't exist";
                } else if ($result === 1) {
                    $message = "Email already verified before!";
                    session_start();
                    $_SESSION['user_name'] = $result['user_name'];
                    $_SESSION['user_id'] = $result['user_id'];
                } else if ($result === 0) {
                    $message = "Can't update info right now, please try later!";
                } else if ($result ===3) {
                    $message = "Change your password for secure concern";
                }
                else {
                    $message = "Email verified! Welcome, " . $result['user_name'];
                    session_start();
                    $_SESSION['user_name'] = $result['user_name'];
                    $_SESSION['user_id'] = $result['user_id'];
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
                    <?php if ($result != 3) { ?>
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
                    <?php } else { ?>
                        <h2>One step away:</h2>
                        <form id="repass" method="POST" action="" >
                            <label class="col-md-12"  for="password"><?php echo $message; ?></label>
                            <input  class="form-control col-md-12" id="validpage-Password" type="password" name="valid-password" />
                            <input id="valid-repass" type="button" class="btn btn-link" name="valid-submit" value="Submit" />
                        </form>
                    <?php } ?>
				</section>
            </main>
        </div>
	</body>
</html>
