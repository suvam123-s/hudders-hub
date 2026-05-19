
<?php

$conn = oci_connect(
    "system",
    "SysPassword1",
    "localhost/freepdb1"
);

if ($conn) {
    echo "Oracle Connected Successfully!";
} else {
    $e = oci_error();
    echo "Connection failed: " . $e['message'];
}

?>