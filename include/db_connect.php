<?php

function get_db_connection()
{
    $conn = oci_connect(
        "system",
        "SysPassword1",
        "localhost/freepdb1",
        "AL32UTF8"
    );

    if (!$conn) {
        $e = oci_error();
        die("Connection failed: " . $e['message']);
    }

    // Switch session to SMRITII schema so all table names resolve correctly
    $schema_stmt = oci_parse($conn, "ALTER SESSION SET CURRENT_SCHEMA = SMRITII");
    oci_execute($schema_stmt);
    oci_free_statement($schema_stmt);

    return $conn;
}
?>