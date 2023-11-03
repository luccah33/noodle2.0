<?php
include 'db-config.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $item_name = $_POST['item_name'];
    $item_quantity = $_POST['item_quantity'];
    $user_id = $_SESSION['user_id'];

    if ($connection->connect_error) {
        die("Connection failed: " . $connection->connect_error);
    }
    $stmt = $connection->prepare("INSERT INTO items (user_id, item_name, item_quantity) VALUES (?, ?, ?)");
    $stmt->bind_param("iss", $user_id, $item_name, $item_quantity);

    if ($stmt->execute()) {
        $stmt->close();
        $connection->close();
        header("Location: displayshoppinglist.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>