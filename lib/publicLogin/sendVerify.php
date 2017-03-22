<?php
//author Bao
if (isset($_POST['name']) && isset($_POST['email'])) {
    require_once('../email/Default.php');
    require_once('../../vendor/phpmailer/phpmailer/PHPMailerAutoload.php');
    $emailValid = new OutEmail();
    $address = $_POST['email'];
    $combine = $_POST['name'] . '-!+a4mc1uw]&' . $_POST['email'];
    $string = openssl_encrypt($combine, 'AES-128-ECB', 'hm!f$#abas&adsf');
    $subject = 'Verify your email address on Marvel Canada';
    $body = 'Please click the link below to verify your email address. <br/>';
    $body .= '<a style="font-size:20px; font-weight: bold; margin:10px 0" href="http://localhost/canada-parks/signup/valid.php?' . $string . '">Click here to verify your email address</a> <br/>';
    $body .= 'Please click the link below if the link above not working: <br/>';
    $body .= 'http://localhost/canada-parks/signup/valid.php?' . $string;
    $sent = $emailValid->validEmail($address , $subject, $body);
    //If can't send email
    if($sent == 0) {
        echo "Failed, please try later";
    }
    else {
        echo "Success, check your email";
    }
}
