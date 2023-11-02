<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "noodle_dhbw";

$connection = new mysqli($servername, $username, $password, $database);

if ($connection->connect_error) {
    die("Conn failed: " . $connection->connect_error);
}
?>
