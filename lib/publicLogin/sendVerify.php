<?php
//author Bao
if (isset($_POST['name']) && isset($_POST['email'])) {
    require_once('../../vendor/phpmailer/phpmailer/PHPMailerAutoload.php');
    $mail = new PHPMailer;
    $mail->isSMTP();
    $mail->Host = 'smtp-mail.outlook.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'marvelcanada@outlook.com';
    $mail->Password = 'hb2017cms';
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;
    $mail->setFrom('marvelcanada@outlook.com', 'Mailer');
    $mail->addAddress($_POST['email']);
    $mail->isHTML(true);
    $mail->Subject = 'Verify your email address on Marvel Canada';
    //encrypt a secure string with username, email pair
    $string = $_POST['name'] . '(-!+am)cuw]&' . $_POST['email'];
    $encrypted = openssl_encrypt($string, "AES-128-ECB", "hm!f$#aba=s)&adsf");
    $mail->Body = 'Please click the link below to verify your email address. <br/>';
    $mail->Body .= '<a style="font-size:20px; font-weight: bold; margin:10px 0" href="http://localhost/canada-parks/signup/valid.php?' . $encrypted . '">Click here to verify your email address</a> <br/>';
    $mail->Body .= 'Please click the link below if the link above not working: <br/>';
    $mail->Body .= 'http://localhost/canada-parks/signup/valid.php?' . $encrypted;
    if(!$mail->send()) {
        echo "Failed, please try later";
    }
    //redirect to require email valid page
    else {
        //If mail successfully sent, will write logic later
        echo "Success, check your email";
    }
}
