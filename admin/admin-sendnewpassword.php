<?php
require_once "../templates/meta.php";
require_once "model/database.php";
require_once "model/admin.php";
$db = Database::getDB();
session_start();
//var_dump($_SESSION['user-need-new-password']);
//$actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$user = $_SESSION['user-need-new-password'];
$newpassword = randomPassword();
require '../vendor/phpmailer/phpmailer/PHPMailerAutoload.php';
$mail = new PHPMailer;
$mail->isSMTP();
$mail->SMTPDebug = 0;
$mail->Debugoutput = 'html';
$mail->Host = 'smtp.gmail.com';
$mail->SMTPAuth = true;
$mail->Username = 'canadanationalpark@gmail.com';
$mail->Password = 'canada123';
$mail->SMTPSecure = 'tls';
$mail->Port = 587;
$mail->setFrom('canadanationalpark@gmail.com', 'do-not-reply');
$mail->addAddress($user->user_email);
$mail->isHTML(true);
$mail->Subject = 'Password reset for Canada National Park website';
$mail->Body = "Dear <strong>$user->user_name</strong>,<br/>" .
    'Thank you so much for your support to out website.<br/>' .
    'Your new password is: <strong>' . $newpassword . '</strong><br/>' .
    'Please click on the link below to validate your new password to our website: <br/>' .
    '<a href='.substr($actual_link,0,strlen ($actual_link)-19) . 'validatepassword.php?email='.$user->user_email.'&pass='.$newpassword.
    '>Click here</a>'.
    '<br/> Please confirm the link within 24h from the moment!' .
    '<br/> Thank you so much!' .
    '<br/> Admin from Marvel team!' .
    '<br/> Duc Nguyen'
;
if(!$mail->send()) {
    echo "<div class=\"alert alert-danger\"> Mailer Error: $mail->ErrorInfo</div>";
}
else {
    AdminUser::updateActivation($db, $user->user_id, sha1($newpassword), date("Y-m-d"));

    echo "<div class=\"alert alert-success\"> Your new password is sent. Please check mail and validate your new password within the day</div>";
    echo "<a class='btn btn-default' href='index.php'>Back to Login page</a>";

}

function randomPassword() {
    $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
    $pass = array();
    $alphaLength = strlen($alphabet) - 1;
    for ($i = 0; $i < 8; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
    }
    return implode($pass);
}