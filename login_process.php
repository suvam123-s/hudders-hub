<?php
session_start();
require_once 'include/db_connect.php';

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: Login.php");
    exit();
}

$email    = trim($_POST["email"] ?? '');
$password = trim($_POST["password"] ?? '');

// Basic input validation
if (empty($email) || empty($password)) {
    $_SESSION['login_error'] = "Email and password are required.";
    header("Location: Login.php");
    exit();
}

// Connect to Oracle
$conn = get_db_connection();

// Query user by email
$sql = "SELECT user_ID, first_name, last_name, email, password, user_role
        FROM USER_ACCOUNT
        WHERE email = :email";

$stmt = oci_parse($conn, $sql);
oci_bind_by_name($stmt, ':email', $email);

$result = oci_execute($stmt);

if (!$result) {
    $e = oci_error($stmt);
    error_log('Login query error: ' . $e['message']);
    $_SESSION['login_error'] = "A database error occurred. Please try again.";
    oci_free_statement($stmt);
    oci_close($conn);
    header("Location: Login.php");
    exit();
}

$row = oci_fetch_assoc($stmt);

if ($row && password_verify($password, $row['PASSWORD'])) {
    // Successful login — store session data
    $_SESSION['user_id']    = $row['USER_ID'];
    $_SESSION['user_email'] = $row['EMAIL'];
    $_SESSION['user_name']  = $row['FIRST_NAME'] . ' ' . $row['LAST_NAME'];
    $_SESSION['user_role']  = $row['USER_ROLE'];

    oci_free_statement($stmt);
    oci_close($conn);

    // Redirect based on role
    if ($row['USER_ROLE'] === 'ADMIN') {
        header("Location: admin_dashboard.php");
    } else {
        header("Location: index.php");
    }
    exit();
} else {
    // Invalid credentials
    $_SESSION['login_error'] = "Invalid email or password. Please try again.";
    oci_free_statement($stmt);
    oci_close($conn);
    header("Location: Login.php");
    exit();
}
?>
