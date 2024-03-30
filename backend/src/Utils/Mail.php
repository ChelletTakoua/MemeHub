<?php
namespace Utils;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

class Mail{

    //TODO: @takoua,
    // save the following values in a config file in the config folder (you can name it mail.php for example):
    //    Host
    //    SMTPAuth
    //    Username
    //    Password
    //    SMTPSecure
    //    Port
    // You can use the exemple of the database config file, it's used in the DatabaseConnection class line 19
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

    // TODO: @takoua, rename path to file that only takes the file name.
    //  move the class to a new folder called Mailing under src folder.
    //  All the script files should be in the same folder so the base path is always the same and you can set the path as a constant in this class.
    //  change script file extension to .html

    static public function sendMailFile($to,$subject,$path,$attributes=[]){//a path to a file in Utils is like  __DIR__ . '/file.txt'
        $file_content=file_get_contents($path);
        foreach ($attributes as $attribut => $value) {
            $file_content = str_replace('{{'.$attribut.'}}', $value, $file_content);
        }
        $file_content = nl2br($file_content);
        Self::sendMail($to,$subject,$file_content);
    }

    static public function account_created($to,$username){
        Self::sendMailFile($to,"Welcome to Memehub !",__DIR__ . '/account-created.txt',["username"=>$username]);
    }

    static public function password_reset($to,$username){
        Self::sendMailFile($to,"password reset",__DIR__ . '/password-reset.txt',["username"=>$username]);
    }

}