<?php

require 'include/mailer.php';

$otp = rand(100000,999999);

if (sendOtpEmail('smritishrestha767@gmail.com', $otp)) {
    echo "Mail Sent Successfully!";
} else
 {
    echo "Mail Failed to Send.";
}