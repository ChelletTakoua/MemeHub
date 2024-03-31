<?php
namespace Mailing;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

class Mail{

    static public function sendMail($to,$subject,$message){
        $config = include __DIR__ . '/../config/mailing.php';
        $mail=new PHPMailer(true);

        $mail->isSMTP();
        $mail->Host=$config['Host'];
        $mail->SMTPAuth=$config['SMTPAuth'];
        $mail->Username=$config['Username'];
        $mail->Password=$config['Password'];
        $mail->SMTPSecure=$config['SMTPSecure'];
        $mail->Port=$config['Port'];
        $mail->setFrom('chellettakoua@gmail.com');

        $mail->addAddress($to);
        $mail->Subject=$subject;
        $mail->Body=$message;
        $mail->isHTML(true);

        $mail->send();
        echo "Mail sent";
    }

    static public function sendMailFile($to,$subject,$path,$attributes=[]){
        $file_content=file_get_contents( __DIR__.'/' .$path);
        foreach ($attributes as $attribut => $value) {
            $file_content = str_replace('{{'.$attribut.'}}', $value, $file_content);
        }
        Self::sendMail($to,$subject,$file_content);
    }

    static public function account_created($to,$username){
        Self::sendMailFile($to,"Welcome to Memehub !",'account-created.html',["username"=>$username]);
    }

    static public function password_reset($to,$username){
        Self::sendMailFile($to,"password reset",'password-reset.html',["username"=>$username]);
    }

}