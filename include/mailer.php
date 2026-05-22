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
<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
</head>
<body style='margin:0; padding:0; background-color:#f0f2f5; font-family:Arial, Helvetica, sans-serif;'>
    <table role='presentation' width='100%' cellpadding='0' cellspacing='0' style='background-color:#f0f2f5; padding:30px 0;'>
        <tr>
            <td align='center'>
                <table role='presentation' width='600' cellpadding='0' cellspacing='0' style='max-width:600px; width:100%; background-color:#ffffff; border-radius:12px; overflow:hidden; box-shadow:0 4px 20px rgba(0,0,0,0.06);'>

                    <!-- Header / Brand bar -->
                    <tr>
                        <td style='background:linear-gradient(135deg, #1a2a6c 0%, #2c5364 100%); padding:30px 40px; text-align:center;'>
                            <h1 style='margin:0; color:#ffffff; font-size:26px; letter-spacing:1px; font-weight:bold;'>
                                HUDDERS <span style='color:#ffd166;'>HUB</span>
                            </h1>
                            <p style='margin:6px 0 0; color:#cdd9e5; font-size:13px;'>Your Shopping Destination</p>
                        </td>
                    </tr>

                    <!-- Body -->
                    <tr>
                        <td style='padding:40px 40px 20px;'>
                            <h2 style='margin:0 0 12px; color:#1a2a6c; font-size:22px;'>Verify Your Account</h2>
                            <p style='margin:0 0 8px; color:#444444; font-size:15px; line-height:1.6;'>Hello,</p>
                            <p style='margin:0 0 24px; color:#444444; font-size:15px; line-height:1.6;'>
                                Use the verification code below to complete your request. Keep it private — our team will never ask you for this code.
                            </p>

                            <!-- OTP Box -->
                            <div style='text-align:center; margin:0 0 28px;'>
                                <div style='display:inline-block; background-color:#f4f7fb; border:2px dashed #1a2a6c; border-radius:10px; padding:18px 40px;'>
                                    <span style='font-size:34px; font-weight:bold; letter-spacing:8px; color:#1a2a6c;'>$otp</span>
                                </div>
                            </div>

                            <p style='margin:0 0 8px; color:#666666; font-size:14px; line-height:1.6; text-align:center;'>
                                ⏱ This code expires in <strong>10 minutes</strong>.
                            </p>
                            <p style='margin:0; color:#999999; font-size:13px; line-height:1.6; text-align:center;'>
                                If you didn't request this, you can safely ignore this email.
                            </p>
                        </td>
                    </tr>

                    <!-- Divider -->
                    <tr>
                        <td style='padding:0 40px;'>
                            <hr style='border:none; border-top:1px solid #eeeeee; margin:0;'>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style='padding:24px 40px 32px; text-align:center;'>
                            <p style='margin:0 0 6px; color:#888888; font-size:13px;'>Need help? Contact us at 
                                <a href='mailto:support@huddershub.com' style='color:#1a2a6c; text-decoration:none;'>support@huddershub.com</a>
                            </p>
                            <p style='margin:0 0 10px; color:#aaaaaa; font-size:12px;'>
                                &copy; " . date('Y') . " " . MAIL_FROM_NAME . ". All rights reserved.
                            </p>
                            <p style='margin:0; color:#bbbbbb; font-size:11px;'>
                                This is an automated message, please do not reply.
                            </p>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>
</body>
</html>
";


        $mail->send();
        return true;

    } catch (Exception $e) {
        return false;
    }
}