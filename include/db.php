<?php
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Show errors during development
error_reporting(E_ALL);
ini_set('display_errors', '1');

// ============================================
// ORACLE DATABASE CONNECTION
// ============================================
$db_user = 'system';              // schema that owns all tables
$db_pass = 'SysPassword1';        // password
$db_conn = 'localhost/freepdb1';  // service name

// Check OCI8 extension
if (!function_exists('oci_connect')) {
    die('OCI8 extension not loaded. Enable extension=oci8_19 in php.ini and restart Apache.');
}

// Connect
$conn = oci_connect($db_user, $db_pass, $db_conn, 'AL32UTF8');

if (!$conn) {
    $e = oci_error();
    die('Database connection failed: ' . htmlspecialchars($e['message']));
}

// Switch to SMRITII schema so all unqualified table names resolve correctly
$s = oci_parse($conn, "ALTER SESSION SET CURRENT_SCHEMA = SMRITII");
oci_execute($s);
oci_free_statement($s);
?>