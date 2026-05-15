<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}

require_once 'include/db_connect.php';
$conn = get_db_connection();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name = trim($_POST['full_name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $dob = trim($_POST['dob'] ?? '');
    $user_id = $_SESSION['user_id'];

    // Split full name into first and last
    $name_parts = explode(' ', $full_name, 2);
    $first_name = $name_parts[0] ?: '';
    $last_name = $name_parts[1] ?? '';

    // If DOB is provided, format it.
    // Oracle expects TO_DATE(:dob, 'YYYY-MM-DD')
    
    // Update Query
    // We are skipping the profile image since there's no column for it in the schema.
    $sql = "UPDATE USER_ACCOUNT SET 
            first_name = :first_name, 
            last_name = :last_name, 
            email = :email, 
            phonenumber = :phone";
            
    if (!empty($dob)) {
        $sql .= ", DOB = TO_DATE(:dob, 'YYYY-MM-DD')";
    }
    
    $sql .= " WHERE user_ID = :user_id";

    $stmt = oci_parse($conn, $sql);
    
    oci_bind_by_name($stmt, ':first_name', $first_name);
    oci_bind_by_name($stmt, ':last_name', $last_name);
    oci_bind_by_name($stmt, ':email', $email);
    oci_bind_by_name($stmt, ':phone', $phone);
    oci_bind_by_name($stmt, ':user_id', $user_id);
    
    if (!empty($dob)) {
        oci_bind_by_name($stmt, ':dob', $dob);
    }

    if (oci_execute($stmt, OCI_COMMIT_ON_SUCCESS)) {
        // Update session variables if they changed
        $_SESSION['user_name'] = $first_name . ' ' . $last_name;
        $_SESSION['user_email'] = $email;
        
        oci_free_statement($stmt);
        oci_close($conn);
        
        // Redirect back to profile
        header('Location: user_profile.php?updated=1');
        exit;
    } else {
        $e = oci_error($stmt);
        echo "Error updating profile: " . htmlentities($e['message']);
        oci_free_statement($stmt);
        oci_close($conn);
        exit;
    }
} else {
    // Not a post request
    header('Location: update_profile.php');
    exit;
}
?>
