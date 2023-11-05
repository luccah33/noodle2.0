<?php
include 'db-config.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Retrieve user's hashed password from the database
    $stmt = $connection->prepare("SELECT id, username, password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($id, $dbUsername, $dbPassword);

    if ($stmt->fetch() && password_verify($password, $dbPassword)) {
        session_start();
        $_SESSION['user_id'] = $id;
        $_SESSION['username'] = $dbUsername;
        header('Location: welcome.php');
    } else {
        echo "Login failed. Please check your credentials.";
    }

    $stmt->close();
    $connection->close();
}
?>

