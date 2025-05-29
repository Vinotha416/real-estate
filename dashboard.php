<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_email'])) {
    header("Location: login.php"); // Redirect to login if not logged in
    exit;
}

echo "Welcome, " . $_SESSION['user_email'] . "!";  // Show welcome message
?>
