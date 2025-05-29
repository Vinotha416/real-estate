<?php
// Enable error reporting for debugging (turn off in production)
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Require your database connection file (adjust the file name and path as needed)
require 'db.php';

$success_message = '';
$error_message = '';

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize input data
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $message = htmlspecialchars($_POST['message']);

    // Check that all fields are filled
    if (!empty($name) && !empty($email) && !empty($message)) {
        try {
            // Prepare and execute an INSERT statement to store data in the 'queries' table
            $stmt = $pdo->prepare("INSERT INTO contact (name, email, message) VALUES (?, ?, ?)");
            $stmt->execute([$name, $email, $message]);

            $success_message = "Thank you, $name! Your message has been received.";
        } catch (PDOException $e) {
            // Handle any errors during the database operation
            $error_message = "❗ Failed to submit your query: " . $e->getMessage();
        }
    } else {
        $error_message = "Please fill in all the required fields.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - Real Estate Management</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: url('https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRP9eystmiO9btzTUEmx_1f7LJ2NpIG21NjZ6CE8nQhc8b3b5iU0NuPxCc&s') no-repeat center center/cover;
            color: white;
            height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        header {
            background: rgba(0, 0, 0, 0.6);
            color: white;
            padding: 20px 10px;
            text-align: center;
        }

        nav ul {
            list-style: none;
            padding: 0;
            margin: 0;
            text-align: center;
        }

        nav ul li {
            display: inline;
            margin: 0 15px;
        }

        nav ul li a {
            color: white;
            text-decoration: none;
            font-weight: bold;
        }

        section {
            text-align: center;
            padding: 30px;
            flex-grow: 1;
        }

        h1 {
            font-size: 3rem;
            margin-bottom: 20px;
            text-shadow: 2px 2px 5px rgba(0,0,0,0.7);
        }

        .contact-info p {
            font-size: 1.2rem;
            text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.6);
        }

        .success-message {
            color: green;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .error-message {
            color: red;
            font-weight: bold;
            margin-bottom: 20px;
        }

        form {
            max-width: 400px;
            margin: 0 auto;
            text-align: left;
        }

        form label {
            display: block;
            margin-top: 15px;
        }

        form input,
        form textarea {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 1rem;
        }

        form button {
            margin-top: 20px;
            padding: 10px 20px;
            background: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        form button:hover {
            background: #0056b3;
        }

        footer {
            background: rgba(0, 0, 0, 0.6);
            color: white;
            text-align: center;
            padding: 10px 0;
        }
    </style>
</head>
<body>
    <header>
        <h1>Contact Us</h1>
        <nav>
            <ul>
                <li><a href="index.html">Home</a></li>
                <li><a href="about.html">About Us</a></li>
                <li><a href="contact.php">Contact Us</a></li>
            </ul>
        </nav>
    </header>
    <section>
        <h1>Get in Touch</h1>
        <div class="contact-info">
            <p><strong>Admin Name:</strong> Vinotha P</p>
            <p><strong>Mobile Number:</strong> +91 8825506519</p>
            <p>If you have any queries, feel free to reach out to us or submit the form below!</p>
        </div>

        <!-- Display Success or Error Messages -->
        <?php if (!empty($success_message)): ?>
            <div class="success-message"><?php echo $success_message; ?></div>
        <?php endif; ?>

        <?php if (!empty($error_message)): ?>
            <div class="error-message"><?php echo $error_message; ?></div>
        <?php endif; ?>

        <!-- Contact Form -->
        <form method="post" action="contact.php">
            <label for="name">Your Name</label>
            <input type="text" id="name" name="name" placeholder="Enter your name" required>
            <label for="email">Your Email</label>
            <input type="email" id="email" name="email" placeholder="Enter your email" required>
            <label for="message">Message / Query</label>
            <textarea id="message" name="message" rows="5" placeholder="Type your message here" required></textarea>
            <button type="submit">Submit</button>
        </form>
    </section>
    <footer>
        <p>&copy; 2025 Real Estate Management System. All rights reserved.</p>
    </footer>
</body>
</html>
