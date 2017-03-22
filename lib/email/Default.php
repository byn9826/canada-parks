<?php
//Author Bao
class OutEmail {
    private $host = 'smtp-mail.outlook.com';
    private $smtpAuth = true;
    private $username = 'marvelcanada@outlook.com';
    private $password = 'hb2017cms';
    private $smtpSecure = 'tls';
    private $port = 587;
    private $from = 'marvelcanada@outlook.com';

    //send validation email
    public function validEmail($address, $subject, $body) {
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
        $mail->Subject = $subject;
        $mail->Body = $body;
        if(!$mail->send()) {
            return 0;
        } else {
            return 1;
        }
    }
}
