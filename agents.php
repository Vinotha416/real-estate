<?php
include 'db.php';

// Insert agent if form submitted
if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $contact = $_POST['contact'];
    $role = $_POST['role'];
    $image = $_POST['image'];

    try {
        $stmt = $pdo->prepare("INSERT INTO agents (name, contact, role, image) VALUES (?, ?, ?, ?)");
        $stmt->execute([$name, $contact, $role, $image]);
        header("Location: agents.php");
        exit;
    } catch (PDOException $e) {
        echo "<p style='color:red;'>Error: " . $e->getMessage() . "</p>";
    }
}

// Fetch agents
$stmt = $pdo->query("SELECT * FROM agents");
$agents = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Agent Management</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Arial', sans-serif;
            color: #333;
            background: url('https://images.unsplash.com/photo-1600585154340-be6161a56a0c') no-repeat center center fixed;
            background-size: cover;
        }
        .container {
            max-width: 1200px;
            margin: 20px auto;
            background: rgba(255, 255, 255, 0.95);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
        }
        .heading {
            text-align: center;
            margin-bottom: 20px;
        }
        .agents {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
        }
        .agent-card {
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            text-align: center;
        }
        .agent-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }
        .agent-card .info {
            padding: 15px;
        }
        .form-container {
            margin-top: 40px;
            background: #f9f9f9;
            padding: 20px;
            border-radius: 8px;
        }
        form input[type="text"], form input[type="url"] {
            width: 100%;
            padding: 10px;
            margin-top: 8px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 6px;
        }
        form input[type="submit"] {
            background-color: #007BFF;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }
        form input[type="submit"]:hover {
            background-color: #0056b3;
        }
        .options {
            text-align: center;
            margin-top: 20px;
        }
        .options button {
            background-color: #007BFF;
            color: white;
            padding: 10px 20px;
            font-size: 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .options button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="heading">
        <h1>Meet Our Trusted Agents</h1>
        <p>Our experienced agents are here to help you find the perfect property.</p>
    </div>

    <!-- Agent List -->
    <div class="agents">
        <?php foreach ($agents as $agent): ?>
            <div class="agent-card">
                <img src="<?= htmlspecialchars($agent['image']) ?>" alt="Agent Image">
                <div class="info">
                    <h2><?= htmlspecialchars($agent['name']) ?></h2>
                    <p>Contact: <?= htmlspecialchars($agent['contact']) ?></p>
                    <p>Role: <?= htmlspecialchars($agent['role']) ?></p>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- Form to Add Agent -->
    <div class="form-container">
        <h2>Add New Agent</h2>
        <form method="POST" action="agents.php">
            <label>Name:</label>
            <input type="text" name="name" required>

            <label>Contact:</label>
            <input type="text" name="contact" required>

            <label>Role:</label>
            <input type="text" name="role" required>

            <label>Image URL:</label>
            <input type="url" name="image" required>

            <input type="submit" name="submit" value="Add Agent">
        </form>
    </div>

    <!-- Navigation Button -->
    <div class="options">
        <button onclick="window.location.href='http://localhost:8080/real_estate_db/property.php'">Property Listings</button>
    </div>
</div>
</body>
</html>
