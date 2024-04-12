<?php
require 'vendor/autoload.php';
require_once 'config.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

/**
 * @throws Exception
 */
function sendMail($email, $subject, $message)
{
    $mail = new PHPMailer(true);
    $mail->isSMTP();
    $mail->SMTPAuth = true;
    $mail->Host = $_ENV['MAILHOST'];
    $mail->Username = $_ENV['USER_NAME'];
    $mail->Password = $_ENV['PASSWORD'];
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    $mail->setFrom($_ENV['SEND_FROM'], $_ENV['SEND_FROM_NAME']);
    $mail->addAddress($email);
    $mail->addReplyTo($_ENV['REPLY_TO'], $_ENV['REPLY_TO_NAME']);

    $mail->isHTML(true);
    $mail->Subject = $subject;
    $mail->Body = $message;
    $mail->AltBody = $message;

    if(!$mail->send())
    {
        return "failed";
    }else{
        return "success";
    }
}

try {
    $response = sendMail("indranileiindia2019@gmail.com", "Test", "Test Message");
    echo  $response;
} catch (Exception $e)
{
    echo $e->getMessage();
}

//if(isset($_POST['submit']))
//{
//    try {
//        $response = sendMail($_POST['email'], $_POST['subject'], $_POST['message']);
//        if(@$response == "success")
//        {
//            echo "success";
//        }else{
//            echo "failed";
//        }
//    } catch (Exception $e) {
//        print_r($e->getMessage());
//    }
//}