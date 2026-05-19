<?php
session_start();
require_once __DIR__ . '/include/db_connect.php';

// Redirect if not POST
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: auth.php?tab=login");
    exit();
}

$email = trim($_POST["email"] ?? '');
$password = trim($_POST["password"] ?? '');

// ── Basic validation ───────────────────────────────────────────
if (empty($email) || empty($password)) {
    $_SESSION['auth_error'] = "Email and password are required.";
    header("Location: auth.php?tab=login");
    exit();
}

// ── Connect to Oracle ──────────────────────────────────────────
$conn = get_db_connection();

// ── Query user by email ────────────────────────────────────────
$sql = "SELECT user_ID, first_name, last_name, email, password, user_role
         FROM USER_ACCOUNT
         WHERE email = :email";

$stmt = oci_parse($conn, $sql);
oci_bind_by_name($stmt, ':email', $email);
$result = oci_execute($stmt);

if (!$result) {
    $e = oci_error($stmt);
    error_log("Login DB error: " . $e['message']);
    oci_free_statement($stmt);
    oci_close($conn);
    $_SESSION['auth_error'] = "A database error occurred. Please try again.";
    header("Location: auth.php?tab=login");
    exit();
}

$row = oci_fetch_assoc($stmt);
oci_free_statement($stmt);
oci_close($conn);

// ── Verify password ────────────────────────────────────────────
if ($row && password_verify($password, $row['PASSWORD'])) {

    // Store session data
    $_SESSION['user_id'] = $row['USER_ID'];
    $_SESSION['user_email'] = $row['EMAIL'];
    $_SESSION['user_name'] = $row['FIRST_NAME'] . ' ' . $row['LAST_NAME'];
    $_SESSION['user_role'] = $row['USER_ROLE'];

    // ── Redirect based on role ─────────────────────────────────
    if ($row['USER_ROLE'] === 'ADMIN') {
        header("Location: admin_dashboard.php");

    } elseif ($row['USER_ROLE'] === 'TRADER') {
        header("Location: http://localhost:8888/ords/r/huddershub_market/huddershub-market/trader-dashboard");

    } else {
        // Customer — go to where they came from, or homepage
        if (!empty($_SESSION['redirect_after_login'])) {
            $redirect = $_SESSION['redirect_after_login'];
            unset($_SESSION['redirect_after_login']);
            // Safety check: only allow relative redirects
            if (strpos($redirect, '/') !== 0 && strpos($redirect, 'http') !== 0) {
                header("Location: " . $redirect);
            } else {
                header("Location: index.php");
            }
        } else {
            header("Location: index.php");
        }
    }
    exit();

} else {
    // Wrong email or password
    $_SESSION['auth_error'] = "Invalid email or password. Please try again.";
    header("Location: auth.php?tab=login");
    exit();
}
?>