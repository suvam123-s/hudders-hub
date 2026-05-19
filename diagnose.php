<?php
/**
 * diagnose.php — Database Diagnostic Script
 * Visit: http://localhost/hudders-hub/diagnose.php
 * DELETE this file after fixing.
 */
error_reporting(E_ALL);
ini_set('display_errors', '1');

echo "<!DOCTYPE html><html><head><title>DB Diagnose</title>";
echo "<style>body{font-family:monospace;background:#1a1a2e;color:#eee;padding:20px;}
      h2{color:#e94560;} .ok{color:#4ecca3;} .err{color:#ff6b6b;} .info{color:#f6c90e;}
      pre{background:#16213e;padding:15px;border-radius:8px;}</style></head><body>";
echo "<h2>🔍 Hudders-Hub Oracle Diagnostic</h2><pre>";

// Step 1 — OCI8 loaded?
if (!function_exists('oci_connect')) {
    echo "<span class='err'>❌ OCI8 extension NOT loaded in PHP!</span>\n";
    echo "Fix: open php.ini, find and uncomment: extension=oci8_19\n";
    echo "Then restart Apache.\n</pre></body></html>";
    exit;
}
echo "<span class='ok'>✅ OCI8 extension is loaded</span>\n\n";

// Step 2 — Try connecting as SYSTEM
$conn = @oci_connect("system", "SysPassword1", "localhost/freepdb1", "AL32UTF8");
if (!$conn) {
    $e = oci_error();
    echo "<span class='err'>❌ SYSTEM connect failed: " . htmlspecialchars($e['message']) . "</span>\n";
} else {
    echo "<span class='ok'>✅ Connected as SYSTEM to localhost/freepdb1</span>\n\n";

    // Who am I?
    $s = oci_parse($conn, "SELECT USER FROM DUAL");
    oci_execute($s);
    $r = oci_fetch_assoc($s);
    echo "<span class='info'>Current DB User: " . $r['USER'] . "</span>\n\n";

    // Find who owns PRODUCT_CATEGORY
    echo "--- Searching for PRODUCT_CATEGORY owner ---\n";
    $s2 = oci_parse($conn, "SELECT OWNER, TABLE_NAME FROM ALL_TABLES WHERE TABLE_NAME = 'PRODUCT_CATEGORY' ORDER BY OWNER");
    oci_execute($s2);
    $found = false;
    while ($row = oci_fetch_assoc($s2)) {
        echo "<span class='ok'>✅ Found PRODUCT_CATEGORY in schema: " . $row['OWNER'] . "</span>\n";
        $found = true;
    }
    if (!$found) {
        echo "<span class='err'>❌ PRODUCT_CATEGORY does not exist in ANY schema!</span>\n";
        echo "   → You need to run HHM.sql first!\n";
    }

    // Find who owns PRODUCT
    echo "\n--- Searching for PRODUCT table owner ---\n";
    $s3 = oci_parse($conn, "SELECT OWNER FROM ALL_TABLES WHERE TABLE_NAME = 'PRODUCT' ORDER BY OWNER");
    oci_execute($s3);
    while ($row = oci_fetch_assoc($s3)) {
        echo "<span class='ok'>✅ Found PRODUCT in schema: " . $row['OWNER'] . "</span>\n";
    }

    // Find who owns USER_ACCOUNT
    echo "\n--- Searching for USER_ACCOUNT table owner ---\n";
    $s4 = oci_parse($conn, "SELECT OWNER FROM ALL_TABLES WHERE TABLE_NAME = 'USER_ACCOUNT' ORDER BY OWNER");
    oci_execute($s4);
    while ($row = oci_fetch_assoc($s4)) {
        echo "<span class='ok'>✅ Found USER_ACCOUNT in schema: " . $row['OWNER'] . "</span>\n";
    }

    // List all non-system schemas with tables
    echo "\n--- All non-system schemas with tables ---\n";
    $s5 = oci_parse($conn, "SELECT DISTINCT OWNER FROM ALL_TABLES WHERE OWNER NOT IN ('SYS','SYSTEM','APEX_230200','APEX_240200','MDSYS','CTXSYS','XDB','DBSNMP','ORDDATA','ORDSYS','WMSYS','LBACSYS','DVSYS','OJVMSYS','GSMADMIN_INTERNAL') ORDER BY OWNER");
    oci_execute($s5);
    while ($row = oci_fetch_assoc($s5)) {
        echo "<span class='info'>  → Schema: " . $row['OWNER'] . "</span>\n";
    }

    // Can we SELECT from PRODUCT_CATEGORY as SYSTEM?
    echo "\n--- Test SELECT from PRODUCT_CATEGORY ---\n";
    $test = @oci_parse($conn, "SELECT COUNT(*) AS C FROM PRODUCT_CATEGORY");
    $ok = @oci_execute($test);
    if ($ok) {
        $tr = oci_fetch_assoc($test);
        echo "<span class='ok'>✅ SELECT works! Row count: " . $tr['C'] . "</span>\n";
    } else {
        $e2 = oci_error($test);
        echo "<span class='err'>❌ SELECT failed: " . htmlspecialchars($e2['message']) . "</span>\n";
    }

    oci_close($conn);
}

echo "\n\n<b>⚠️ DELETE diagnose.php after you're done!</b>";
echo "</pre></body></html>";
?>