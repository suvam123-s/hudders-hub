<?php
session_start();
require_once __DIR__ . '/include/db_connect.php';

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: Register.php");
    exit();
}

$fname  = trim($_POST["fname"]  ?? '');
$lname  = trim($_POST["lname"]  ?? '');
$email  = trim($_POST["email"]  ?? '');
$phone  = trim($_POST["phone"]  ?? '');
$password = trim($_POST["password"] ?? '');
$terms  = isset($_POST["terms"]);

// ── Validation ──────────────────────────────────────────────────
$errors = [];

if (empty($fname) || empty($lname))                  $errors[] = "Full name is required.";
if (!filter_var($email, FILTER_VALIDATE_EMAIL))       $errors[] = "A valid email is required.";
if (empty($phone))                                    $errors[] = "Phone number is required.";
if (strlen($password) < 6)                            $errors[] = "Password must be at least 6 characters.";
if (!$terms)                                          $errors[] = "You must agree to the terms and privacy policy.";

if (count($errors) > 0) {
    $_SESSION['register_errors'] = $errors;
    $_SESSION['register_old']    = ['fname'=>$fname,'lname'=>$lname,'email'=>$email,'phone'=>$phone];
    header("Location: Register.php");
    exit();
}

// ── Connect to Oracle ────────────────────────────────────────────
$conn = get_db_connection();

// ── Check if email already exists ───────────────────────────────
$chk = oci_parse($conn, "SELECT COUNT(*) AS cnt FROM USER_ACCOUNT WHERE email = :email");
oci_bind_by_name($chk, ':email', $email);
oci_execute($chk);
$chk_row = oci_fetch_assoc($chk);
oci_free_statement($chk);

if ((int)$chk_row['CNT'] > 0) {
    oci_close($conn);
    $_SESSION['register_errors'] = ["An account with that email already exists."];
    $_SESSION['register_old']    = ['fname'=>$fname,'lname'=>$lname,'email'=>$email,'phone'=>$phone];
    header("Location: Register.php");
    exit();
}

// ── Hash password & insert user ──────────────────────────────────
$hashed = password_hash($password, PASSWORD_DEFAULT);
$role   = 'CUSTOMER';

$sql = "INSERT INTO USER_ACCOUNT
            (first_name, last_name, phonenumber, email, password, user_role, user_name, created_date)
        VALUES
            (:fname, :lname, :phone, :email, :password, :role, :uname, SYSDATE)";

$stmt = oci_parse($conn, $sql);
$uname = strtolower(substr($fname, 0, 1) . $lname);   // e.g. jsmith
oci_bind_by_name($stmt, ':fname',    $fname);
oci_bind_by_name($stmt, ':lname',    $lname);
oci_bind_by_name($stmt, ':phone',    $phone);
oci_bind_by_name($stmt, ':email',    $email);
oci_bind_by_name($stmt, ':password', $hashed);
oci_bind_by_name($stmt, ':role',     $role);
oci_bind_by_name($stmt, ':uname',    $uname);

$result = oci_execute($stmt, OCI_COMMIT_ON_SUCCESS);

oci_free_statement($stmt);
oci_close($conn);

if ($result) {
    $_SESSION['auth_success'] = "Account created! Please log in.";
    header("Location: auth.php?tab=login");
    exit();
} else {
    $e = oci_error($stmt);
    error_log("Register insert error: " . $e['message']);
    $_SESSION['register_errors'] = ["Registration failed. Please try again."];
    header("Location: Register.php");
    exit();
}
?>