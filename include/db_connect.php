<?php
// =============================================
// Hudders Hub Market — Oracle DB Connection
// =============================================
// Fill in your Oracle credentials below.
// This file is included by all pages that need DB access.

define('DB_USERNAME', 'your_oracle_username');   // e.g. 'HHM_USER' or 'SYSTEM'
define('DB_PASSWORD', 'your_oracle_password');   // your Oracle password
define('DB_CONNECTION', 'localhost/XE');         // e.g. 'localhost/XE' for Oracle XE,
                                                 //  or '//host:1521/ORCL' for full Oracle

/**
 * Returns an OCI8 connection resource.
 * Call this at the top of any page/script that needs database access.
 */
function get_db_connection() {
    $conn = oci_connect(DB_USERNAME, DB_PASSWORD, DB_CONNECTION, 'AL32UTF8');

    if (!$conn) {
        $e = oci_error();
        error_log('Oracle DB Connection Failed: ' . $e['message']);
        die('<div style="font-family:sans-serif;padding:2rem;color:#c0392b;">
               <h2>Database Connection Error</h2>
               <p>Could not connect to the database. Please check your configuration in <code>include/db_connect.php</code>.</p>
               <pre>' . htmlspecialchars($e['message']) . '</pre>
             </div>');
    }

    return $conn;
}
?>
