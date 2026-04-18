<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);

    // Dummy check (replace with DB query later)
    $dummyUser = [
        "email" => "test@example.com",
        "password" => "123456"
    ];

    if ($email === $dummyUser["email"] && $password === $dummyUser["password"]) {
        $_SESSION["user"] = $email;
        echo "<h2>Login Successful</h2>";
        echo "<p>Welcome back, " . htmlspecialchars($email) . "!</p>";
        echo "<p><a href='index.php'>Go to homepage</a></p>";
    } else {
        echo "<h2>Login Failed</h2>";
        echo "<p>Invalid email or password.</p>";
        echo "<p><a href='login.php'>Try again</a></p>";
    }
} else {
    header("Location: login.php");
    exit();
}
?>

