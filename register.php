<?php
include 'db-config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get user input from the registration form
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Hash the password using Bcrypt
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    if ($connection->connect_error) {
        die("Connection failed: " . $connection->connect_error);
    }

    $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
    $stmt->bind_param("ss", $username, $hashedPassword);

    if ($stmt->execute()) {
        echo "Registration successful!";
    } else {
        echo "Registration failed.";
    }

    $stmt->close();
    $connection->close();
}
?>
