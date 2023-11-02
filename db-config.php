<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "noodle";

$connection = new mysqli($servername, $username, $password, $database);

if ($connection->connect_error) {
    die("Conn failed: " . $connection->connect_error);
}
?>
