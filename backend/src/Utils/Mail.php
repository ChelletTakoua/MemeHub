<?php
namespace Utils;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

class Mail{
    
    public function sendMail($to,$subject,$message){
    $mail=new PHPMailer(true);

    $mail->isSMTP();
    $mail->Host='smtp.gmail.com';
    $mail->SMTPAuth=true;
    $mail->Username='chellettakoua@gmail.com';
    $mail->Password='wqvbhyxgjvrhwkzp';
    $mail->SMTPSecure='tls';
    $mail->Port=587;
    $mail->setFrom('chellettakoua@gmail.com');

    $mail->addAddress($to);
    $mail->Subject=$subject;
    $mail->Body=$message;
    $mail->isHTML(true);

    $mail->send();
    echo "Mail sent";
    }

}