<?php
include 'db-config.php';
session_start();

// Function to check if the user is logged in
function isUserLoggedIn() {
    return isset($_SESSION['user']);
}
?>