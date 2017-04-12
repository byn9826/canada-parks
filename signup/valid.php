<?php
//author: Bao
    //Only response to url contain query string
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
            require_once('../lib/account/default.php');
            $db = DatabaseAccess::getConnection();
            $account = new Account($db);
            if (isset($_POST['valid-password'])) {
                //if user has been required to retype password, double check password
                require_once('../lib/validation/fanta_valid.php');
        		$password = Fanta_Valid::sanitizeUserInput($_POST['valid-password']);
        		if (Fanta_Valid::isNullOrEmpty($password) || !count($password) === 32) {
        	        $error = 'Please enable javaScript';
        	    } else {
                    require_once('../lib/publicLogin/default.php');
                    $publicLogin = new PublicLogin($db);
                    $result = $publicLogin->conflictValid($username, $email, $password, $string);
                    if ($result === 0) {
                        $message = "Can't update info right now, please try later!";
                    } else {
                        $message = "Email verified! Welcome, " . $result[0];
                        session_start();
                        $_SESSION['user_name'] = $result[0];
                        $_SESSION['user_id'] = $result[1];
                    }
                }
            } else {
                //users go to this page, verify everything by default
                //search all related records to this email first
                $records = $account->searchEmails($email);
                //no record exist, not a valid requst
                if (count($records) == 0) {
                    $message = "Account doesn't exist";
                } else if (count($records) == 1) {
                    if ($records[0]['email_valid'] == '1') {
                        //if email already valid, login user
                        $message = "Email already verified before!";
                        session_start();
                        $_SESSION['user_name'] = $records[0]['user_name'];
                        $_SESSION['user_id'] = $records[0]['user_id'];
                    } else {
                        //if email not valid, valid email first
                        $valid = $account->validEmail($email, $username);
                        if ($valid == '0') {
                            $message = "Can't update info right now, please try later!";
                        } else {
                            $id = $records[0]['user_id'];
                            $reg = date('Y-m-d H:i:s');
                            //insert into user detail table for email valid
                            $detail = $account->createDetail($id, $username, $reg, 'default.png');
                            $message = "Email verified! Welcome, " . $records[0]['user_name'];
                            //verify success,login
                            session_start();
                            $_SESSION['user_name'] = $records[0]['user_name'];
                            $_SESSION['user_id'] = $records[0]['user_id'];
                        }
                    }
                } else {
                    //if several record exist, force password change
                    $message = "Change your password for secure concern";
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
                    <?php if ($message != 'Change your password for secure concern') { ?>
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
                            <h4 id="repass-error">
                                <?php if (isset($error)) { echo $error; }?>
                            </h4>
                        </form>
                    <?php } ?>
				</section>
            </main>
        </div>
	</body>
</html>
