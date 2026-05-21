<?php

require_once __DIR__ . '/../vendor/phpmailer/src/Exception.php';
require_once __DIR__ . '/../vendor/phpmailer/src/PHPMailer.php';
require_once __DIR__ . '/../vendor/phpmailer/src/SMTP.php';

require_once __DIR__ . '/mail_config.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function sendOtpEmail($to, $otp)
{
    $mail = new PHPMailer(true);

    try {

        // SMTP Settings
        $mail->isSMTP();
        $mail->Host       = MAIL_HOST;
        $mail->SMTPAuth   = true;
        $mail->Username   = 'smritishrestha767@gmail.com';
        $mail->Password   = 'ryfn lhje znbe jwgj';
        $mail->SMTPSecure = MAIL_ENCRYPTION;
        $mail->Port       = MAIL_PORT;

        // Sender
        $mail->setFrom(MAIL_FROM_EMAIL, MAIL_FROM_NAME);

        // Receiver
        $mail->addAddress($to);

        // Email Content
        $mail->isHTML(true);
        $mail->Subject = 'OTP Verification';

        $mail->Body = "
            <h2>Your OTP Code</h2>
            <h1>$otp</h1>
            <p>This code expires in 10 minutes.</p>
        ";

        $mail->send();

        echo "Mail Sent Successfully";

    } catch (Exception $e) {

        echo "Mailer Error: " . $mail->ErrorInfo;
    }
}