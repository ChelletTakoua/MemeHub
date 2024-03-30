<?php
namespace Utils;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

class Mail{
    
    static public function sendMail($to,$subject,$message){
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

    static public function sendMailFile($to,$subject){
        $file_content=file_get_contents(__DIR__ . '/file.txt');
        $file_content = nl2br($file_content);
        Self::sendMail($to,$subject,$file_content);
    }
   
    static public function account_created($to,$username){
        $file_content=file_get_contents(__DIR__ . '/account-created.txt');
        $file_content = str_replace('{{username}}', $username, $file_content);
        $file_content = nl2br($file_content);
        Self::sendMail($to,"welcome to MemeHub !",$file_content);
    }

    static public function password_reset($to,$username){
        $file_content=file_get_contents(__DIR__ . '/password-reset.txt');
        $file_content = str_replace('{{username}}', $username, $file_content);
        $file_content = nl2br($file_content);
        Self::sendMail($to,"password reset",$file_content);
    }



}