<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: verify_otp.php");
    exit();
}

$otp = $_POST['full_otp'] ?? '';

// Basic validation: Check if it's 6 digits
if (strlen($otp) === 6 && is_numeric($otp)) {
    // SUCCESS: Accept any 6-digit OTP
    
    // Clear pending OTP session data
    unset($_SESSION['otp_pending_email']);
    unset($_SESSION['otp_pending_name']);
    
    // Redirect to login with success message
    $_SESSION['auth_success'] = "Email verified successfully! You can now log in.";
    header("Location: auth.php?tab=login");
    exit();
} else {
    // FAILURE: Invalid format
    $_SESSION['otp_error'] = "Please enter a valid 6-digit code.";
    header("Location: verify_otp.php");
    exit();
}
