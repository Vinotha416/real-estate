<?php
// db.php
$host = 'localhost'; // Host of the database (for XAMPP, this is usually localhost)
$dbname = 'real_estate_db'; // Database name
$username = 'root'; // MySQL username (for XAMPP, default is root)
$password = ''; // MySQL password (for XAMPP, default is an empty string)

try {
    // Create PDO instance
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    // Set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // If connection fails, display error message
    die("Connection failed: " . $e->getMessage());
}
?>
