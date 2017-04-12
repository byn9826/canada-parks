<?php
//Author Bao

class AccountEmail {
    private $host = 'smtp-mail.outlook.com';
    private $smtpAuth = true;
    private $username = 'marvelcanada@outlook.com';
    private $password = 'hb2017cms';
    private $smtpSecure = 'tls';
    private $port = 587;
    private $from = 'marvelcanada@outlook.com';

    //send validation email
    public function sendVerify($address, $encrypted) {
        $path = str_replace("index.php", "valid.php", $_SERVER['PHP_SELF']);
        $path1 = str_replace("api.php", "valid.php", $path);
        $path2 = $_SERVER['HTTP_HOST'] . $path1;
        $mail = new PHPMailer;
        $mail->isSMTP();
        $mail->Host = $this->host;
        $mail->SMTPAuth = $this->smtpAuth;
        $mail->Username = $this->username;
        $mail->Password = $this->password;
        $mail->SMTPSecure = $this->smtpSecure;
        $mail->Port = $this->port;
        $mail->setFrom($this->from, 'Mailer');
        $mail->addAddress($address);
        $mail->isHTML(true);
        $subject = 'Verify your email address on Marvel Canada';
        $mail->Subject = $subject;
        $body = 'Please click the link below to verify your email address. <br/>';
        $body .= '<a style="font-size:20px; font-weight: bold; margin:10px 0" href="http://' . $path2 . '?' . $encrypted . '">Click here to verify your email address</a> <br/>';
        $body .= 'Please click the link below if the link above not working: <br/>';
        $body .= 'http://' . $path2 . '?' . $encrypted;
        $mail->Body = $body;
        if(!$mail->send()) {
            return '0';
        } else {
            return '1';
        }
    }
}
