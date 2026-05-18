<?php
// google_callback.php
session_start();
require_once 'include/db_connect.php';
require_once 'google_config.php';

if (isset($_GET['error'])) {
    $_SESSION['login_error'] = "Google Login was cancelled or failed.";
    header("Location: Login.php");
    exit();
}

if (!isset($_GET['code'])) {
    header("Location: Login.php");
    exit();
}

$code = $_GET['code'];

// 1. Exchange the authorization code for an access token
$token_url = 'https://oauth2.googleapis.com/token';
$post_fields = [
    'code'          => $code,
    'client_id'     => GOOGLE_CLIENT_ID,
    'client_secret' => GOOGLE_CLIENT_SECRET,
    'redirect_uri'  => GOOGLE_REDIRECT_URI,
    'grant_type'    => 'authorization_code'
];

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $token_url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post_fields));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // For local dev
$response = curl_exec($ch);
curl_close($ch);

$token_data = json_decode($response, true);

if (isset($token_data['error']) || !isset($token_data['access_token'])) {
    $_SESSION['login_error'] = "Failed to obtain access token from Google. Check your Client ID/Secret.";
    header("Location: Login.php");
    exit();
}

$access_token = $token_data['access_token'];

// 2. Fetch the user's profile information
$profile_url = 'https://www.googleapis.com/oauth2/v2/userinfo';
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $profile_url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Authorization: Bearer ' . $access_token]);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
$profile_res = curl_exec($ch);
curl_close($ch);

$profile_data = json_decode($profile_res, true);

if (!isset($profile_data['email'])) {
    $_SESSION['login_error'] = "Failed to retrieve email from Google profile.";
    header("Location: Login.php");
    exit();
}

$google_email = $profile_data['email'];

// 3. Connect to Oracle and look up the user by email
$conn = get_db_connection();

if (!$conn) {
    $_SESSION['login_error'] = "Database connection failed.";
    header("Location: Login.php");
    exit();
}

$sql = "SELECT user_ID, first_name, last_name, email, user_role 
        FROM USER_ACCOUNT 
        WHERE email = :email";

$stmt = oci_parse($conn, $sql);
oci_bind_by_name($stmt, ':email', $google_email);
$result = oci_execute($stmt);

if (!$result) {
    $_SESSION['login_error'] = "A database error occurred during Google Login.";
    oci_free_statement($stmt);
    oci_close($conn);
    header("Location: Login.php");
    exit();
}

$row = oci_fetch_assoc($stmt);

if ($row) {
    // User exists, log them in
    $_SESSION['user_id']    = $row['USER_ID'];
    $_SESSION['user_email'] = $row['EMAIL'];
    $_SESSION['user_name']  = $row['FIRST_NAME'] . ' ' . $row['LAST_NAME'];
    $_SESSION['user_role']  = $row['USER_ROLE'];

    oci_free_statement($stmt);
    oci_close($conn);

    // Redirect based on role
    if ($row['USER_ROLE'] === 'ADMIN') {
        header("Location: admin_dashboard.php");
    } elseif ($row['USER_ROLE'] === 'TRADER') {
        header("Location: Trader/Traderdashboard.php");
    } else {
        if (isset($_SESSION['redirect_after_login'])) {
            $redirect = $_SESSION['redirect_after_login'];
            unset($_SESSION['redirect_after_login']);
            header("Location: " . $redirect);
        } else {
            header("Location: index.php");
        }
    }
    exit();
} else {
    // User does not exist in our database. 
    // We could auto-register them, but for security, let's prompt them to register.
    oci_free_statement($stmt);
    oci_close($conn);

    $_SESSION['login_error'] = "No account found for $google_email. Please sign up first.";
    header("Location: Register.php?email=" . urlencode($google_email) . "&fname=" . urlencode($profile_data['given_name'] ?? '') . "&lname=" . urlencode($profile_data['family_name'] ?? ''));
    exit();
}
?>
