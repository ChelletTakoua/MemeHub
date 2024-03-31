<?php
namespace Mailing;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

class Mail{
    /**
     * Sends an email.
     *
     * @param string $to The recipient email address.
     * @param string $subject The subject of the email.
     * @param string $message The content of the email.
     * @throws Exception If an error occurs while sending the email.
     */
    static public function sendMail($to,$subject,$message){
        try {
            
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
            echo "Email sent successfully";
        } catch (Exception $e) {
            echo "Email could not be sent.";
        }  
    }  
    /**
     * Sends an email with content loaded from a file, where placeholders are replaced with provided attributes.
     *
     * @param string $to The recipient email address.
     * @param string $subject The subject of the email.
     * @param string $path The path to the file to be attached.
     * @param array $attributes Additional attributes to be replaced in the file content.
     * @throws Exception If an error occurs while sending the email.
     */

    static public function sendMailFile($to,$subject,$path,$attributes=[]){
        $file_content=file_get_contents( __DIR__.'/' .$path);
        foreach ($attributes as $attribut => $value) {
            $file_content = str_replace('{{'.$attribut.'}}', $value, $file_content);
        }
        Self::sendMail($to,$subject,$file_content);
    }
     /**
     * Sends a welcome email to a newly created account, containing a verification link.
     *
     * @param string $to The recipient email address.
     * @param string $username The username of the newly created account.
     * @throws Exception If an error occurs while sending the email.
     */

    static public function sendAccountCreatedMail($to,$username){
        Self::sendMailFile($to,"Welcome to Memehub !",'account-created.html',["username"=>$username]);
    }
    /**
     * Sends an email for password reset.
     *
     * @param string $to The recipient email address.
     * @param string $username The username associated with the account.
     * @throws Exception If an error occurs while sending the email.
     */
    static public function sendPasswordResetMail($to,$username){
        Self::sendMailFile($to,"password reset",'password-reset.html',["username"=>$username]);
    }

}