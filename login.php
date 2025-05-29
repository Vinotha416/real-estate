<?php
session_start();
require 'db.php'; // Ensure this file connects to your database

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get email and password from the login form
    $email = $_POST['email'];
    $password = $_POST['password'];

    try {
        // Insert login data into the 'users' table
        $stmt = $pdo->prepare("INSERT INTO users (email, password, login_time) VALUES (?, ?, NOW())");
        $stmt->execute([$email, $password]);

        // Store the email in the session for use on the dashboard
        $_SESSION['user'] = $email;

        // Redirect to dashboard.html
        header("Location: property.html");
        exit;
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - Real Estate Management</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: url('https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQRlxq7nIxCT0TD6udqSRVRltbcnwn2xxumNQ&s') no-repeat center center/cover;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            color: white;
        }

        .nav {
            position: absolute;
            top: 0;
            width: 100%;
            background-color: rgba(0, 0, 139, 0.9);
            padding: 10px 0;
            text-align: center;
        }

        .nav a {
            margin: 0 15px;
            color: white;
            font-weight: bold;
            text-decoration: none;
        }

        .nav a:hover {
            text-decoration: underline;
        }

        .login-container {
            background: rgba(173, 216, 230, 0.9);
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.5);
            text-align: center;
            width: 300px;
        }

        h1 {
            margin-bottom: 20px;
            font-size: 1.8rem;
        }

        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 1rem;
        }

        button {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 5px;
            font-size: 1rem;
            font-weight: bold;
            cursor: pointer;
            background-color: #00008b;
            color: white;
        }

        button:hover {
            background-color: #0000cd;
        }

        a {
            color: black;
            text-decoration: none;
            font-size: 0.9rem;
        }
    </style>
</head>
<body>
    <div class="nav">
        <a href="home.html">Home</a>
        <a href="about.html">About</a>
        <a href="contact.php">Contact</a>
    </div>
    <div class="headline" style="position: absolute; top: 50px; width: 100%; text-align: center; color: white; font-size: 1rem; font-weight: bold;">
        <h2>Welcome to Real Estate Management</h2>
    </div>

    <div class="login-container">
        <h1>Login</h1>
        <form method="post">
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>
        <br>
    <div class="options">
    <button onclick="window.location.href='http://localhost:8080/real_estate_db/dashboard.html'">Welcome To Dashboard</button>
    </div>
    </br>
    </div>
</body>
</html>
