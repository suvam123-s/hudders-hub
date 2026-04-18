<?php
// Simple placeholder for registration handling
// Later you will connect this to Oracle DB

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fname     = trim($_POST["fname"]);
    $lname     = trim($_POST["lname"]);
    $email     = trim($_POST["email"]);
    $phone     = trim($_POST["phone"]);
    $password  = trim($_POST["password"]);
    $terms     = isset($_POST["terms"]);

    // Basic validation
    $errors = [];

    if (empty($fname) || empty($lname)) {
        $errors[] = "Full name is required.";
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Valid email is required.";
    }
    if (empty($phone)) {
        $errors[] = "Phone number is required.";
    }
    if (strlen($password) < 6) {
        $errors[] = "Password must be at least 6 characters.";
    }
    if (!$terms) {
        $errors[] = "You must agree to the terms and privacy policy.";
    }

    if (count($errors) > 0) {
        // Show errors
        echo "<h2>Registration Failed</h2>";
        echo "<ul>";
        foreach ($errors as $error) {
            echo "<li>" . htmlspecialchars($error) . "</li>";
        }
        echo "</ul>";
        echo "<p><a href='register.php'>Go back</a></p>";
    } else {
        // Placeholder success (later insert into DB)
        echo "<h2>Registration Successful</h2>";
        echo "<p>Welcome, " . htmlspecialchars($fname) . " " . htmlspecialchars($lname) . "!</p>";
        echo "<p>Your account has been created (simulation only).</p>";
        echo "<p><a href='login.php'>Login here</a></p>";
    }
} else {
    // If accessed directly
    header("Location: register.php");
    exit();
}
?>
