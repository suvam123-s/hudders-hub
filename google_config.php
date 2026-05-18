<?php
// google_config.php
// Replace these values with your actual Google OAuth 2.0 credentials.
// You can create them at https://console.cloud.google.com/apis/credentials

define('GOOGLE_CLIENT_ID', 'YOUR_GOOGLE_CLIENT_ID_HERE');
define('GOOGLE_CLIENT_SECRET', 'YOUR_GOOGLE_CLIENT_SECRET_HERE');

// The redirect URI must exactly match the one configured in your Google Cloud Console.
// Adjust the domain/path if your local setup is different.
define('GOOGLE_REDIRECT_URI', 'http://localhost/hudders-hub/google_callback.php');
?>
