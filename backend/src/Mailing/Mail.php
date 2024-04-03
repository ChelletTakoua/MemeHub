<?php
namespace Mailing;

use Authentication\AuthKeyGenerator;
use Exceptions\HttpExceptions\MailException;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Utils\JWT;
use Models\User;

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
     *
     * @throws MailException
     */
    static public function sendMail(string $to, string $subject, string $message): void{

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
            $mail->setFrom($config['From']);

            $mail->addAddress($to);
            $mail->Subject=$subject;
            $mail->Body=$message;
            $mail->isHTML(true);

            $mail->send();

        }catch (Exception $e){
            throw new MailException("An error occurred while sending the email");

        }

    }


    /**
     * Sends an email with content loaded from a file, where placeholders are replaced with provided attributes.
     *
     * @param string $to The recipient email address.
     * @param string $subject The subject of the email.
     * @param string $path The path to the file to be attached.
     * @param array $attributes Additional attributes to be replaced in the file content.
     * @throws MailException If an error occurs while sending the email.
     */

    static public function sendMailFile(string $to, string $subject, string $path, array $attributes = []): void{
        $file_content=file_get_contents( __DIR__.'/' .$path);
        foreach ($attributes as $attribut => $value) {
            $file_content = str_replace('{{'.$attribut.'}}', $value, $file_content);
        }
        Self::sendMail($to,$subject,$file_content);
    }


     /**
     * Sends a welcome email to a newly created account, containing a verification link.
     *
     * @param User $user The user to send the email to.
      * @throws MailException If an error occurs while sending the email.
     */
    static public function sendAccountCreatedMail(User $user): void{

        $frontConfig = include __DIR__ . '/../config/frontend.php';
        $host = $frontConfig['frontend_host'];
        $port = $frontConfig['frontend_port'];

        $link = "http://$host:$port/verifyEmail?token=" .AuthKeyGenerator::encodeJWK($user, 3600);

        Self::sendMailFile($user->getEmail(), "Welcome to Memehub !", 'account-created.html', [
            "username" => $user->getUsername(),
            "link" => $link
        ]);
    }


    /**
     * Sends an email for password reset.
     *
     * @param User $user The user to send the email to.
     * @throws MailException If an error occurs while sending the email.
     */
    static public function sendPasswordResetMail(User $user): void {

        $frontConfig = include __DIR__ . '/../config/frontend.php';
        $host = $frontConfig['frontend_host'];
        $port = $frontConfig['frontend_port'];

        $link = "http://$host:$port/resetPassword?token=".AuthKeyGenerator::encodeJWK($user, 3600);

        Self::sendMailFile($user->getEmail(), "password reset", 'password-reset.html', [
            "username" => $user->getUsername(),
            "link" => $link
        ]);
    }

}