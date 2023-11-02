<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get user input from the login form
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Retrieve the hashed password from the database
    $conn = new mysqli("localhost", "root", "root", "noodle_dhbw");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("SELECT password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($hashedPassword);
    $stmt->fetch();

    if (password_verify($password, $hashedPassword)) {
        echo "Login successful!";
    } else {
        echo "Login failed.";
    }

    $stmt->close();
    $conn->close();
}
?>