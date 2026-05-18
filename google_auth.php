<?php
// google_auth.php
require_once 'google_config.php';

// Generate the Google OAuth login URL
$params = [
    'client_id'     => GOOGLE_CLIENT_ID,
    'redirect_uri'  => GOOGLE_REDIRECT_URI,
    'response_type' => 'code',
    'scope'         => 'email profile',
    'access_type'   => 'online',
    'prompt'        => 'select_account consent'
];

$authUrl = 'https://accounts.google.com/o/oauth2/v2/auth?' . http_build_query($params);

// Redirect the user to Google's authentication page
header('Location: ' . filter_var($authUrl, FILTER_SANITIZE_URL));
exit();
?>
