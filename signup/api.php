<?php
//author bao
//response to resend email request, turn into correct server address no matter which file location it is

//if user click resend verify email
if (isset($_POST['name']) && isset($_POST['email'])) {
    require_once('../lib/email/default.php');
    require_once('../vendor/phpmailer/phpmailer/PHPMailerAutoload.php');
    $email = new AccountEmail();

    $string = $_POST['name'] . '-!+a4mc1uw]&' . $_POST['email'];
    $encrypted = openssl_encrypt($string, 'AES-128-ECB', 'hm!f$#abas&adsf');
    //send verify email
    $sent = $email->sendVerify($_POST['email'], $encrypted);
    if($sent == 0) {
        echo "Failed, please try later";
    }
    else {
        echo "Success, check your email";
    }
}
