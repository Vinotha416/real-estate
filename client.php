<?php
include 'db.php'; // Include the database connection

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Handle Form Submission (Add or Edit)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST["name"]);
    $contact = htmlspecialchars($_POST["contact"]);

    if (!empty($_POST["client_id"])) {
        $client_id = intval($_POST["client_id"]);
        $sql = "UPDATE clients SET name=:name, contact=:contact WHERE id=:client_id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['name' => $name, 'contact' => $contact, 'client_id' => $client_id]);
    } else {
        $sql = "INSERT INTO clients (name, contact) VALUES (:name, :contact)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['name' => $name, 'contact' => $contact]);
    }

    echo "<script>alert('Client details saved successfully!'); window.location.href='client.php';</script>";
}

// Fetch Clients from Database
$sql = "SELECT * FROM clients";
$stmt = $pdo->query($sql);
$clients = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Real Estate Management System - Client Management</title>
    <style>
        /* General Styling */
        body {
            background: url('https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTpbcoWyN3YagoJpoZn5y58V-DCOXgL1tzzfw&') no-repeat center center/cover;
            background-size: cover;
            font-family: Arial, sans-serif;
            color: white;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        /* Transparent Container */
        .container {
            max-width: 800px;
            width: 100%;
            background: rgba(255, 255, 255, 0.3); /* Lower opacity to show background */
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
            text-align: center;
            backdrop-filter: blur(10px); /* Adds a blur effect */
        }

        h1 {
            font-size: 30px;
            font-weight: bold;
            color: #007BFF;
            margin-bottom: 10px;
        }

        .subtitle {
            font-size: 18px;
            color: white;
            margin-bottom: 20px;
            font-weight: bold;
            text-shadow: 2px 2px 5px black;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ccc;
            color: white;
            text-shadow: 1px 1px 3px black; /* Improves text visibility */
        }

        td:first-child {
            font-weight: bold;
        }

        button {
            padding: 10px 20px;
            background-color: #28a745;
            border: none;
            color: white;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: 0.3s;
        }

        button:hover {
            background-color: #218838;
        }

        input {
            width: 90%;
            padding: 8px;
            margin: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
    </style>
    <script>
        function editClient(id, name, contact) {
            document.getElementById("client_id").value = id;
            document.getElementById("client-name").value = name;
            document.getElementById("client-contact").value = contact;
        }
    </script>
</head>
<body>
    <div class="container">
        <h1>🏡 Real Estate Management System</h1>
        <h2>Efficiently Manage Clients & Enhance Property Transactions</h2>
        <p class="subtitle">
            Welcome to our comprehensive real estate management platform! <br> 
            Track clients, streamline property transactions, and optimize operations effortlessly.
        </p>

        <table>
            <tbody>
                <?php foreach ($clients as $client) { ?>
                    <tr>
                        <td><?= htmlspecialchars($client["name"]) ?></td>
                        <td><?= htmlspecialchars($client["contact"]) ?></td>
                        <td><button onclick="editClient('<?= $client["id"] ?>', '<?= $client["name"] ?>', '<?= $client["contact"] ?>')">Edit</button></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

        <!-- Add/Edit Client Form -->
        <h2>Manage Clients</h2>
        <form method="POST" action="client.php">
            <input type="hidden" id="client_id" name="client_id">
            <input type="text" id="client-name" name="name" placeholder="Full Name" required>
            <input type="text" id="client-contact" name="contact" placeholder="Contact" required>
            <button type="submit">Save Client</button>
        </form>
        <br>
            <div class="options">
        <button onclick="window.location.href='http://localhost:8080/real_estate_db/agents.php'">Agent</button>
        </div>
            </br>
    </div>
</body>
</html>
<?php $pdo = null; // Close connection ?>
