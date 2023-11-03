<?php
include 'db-config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Hash the password with bcrypt
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    // Insert user into the database
    $stmt = $connection->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
    $stmt->bind_param("ss", $username, $hashedPassword);

    if ($stmt->execute()) {
        header('Location: login.html');
        exit;
    } else {
        echo "Registration failed. Please try again.";
    }

    $stmt->close();
}
    $connection->close();

?>

