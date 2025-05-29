
<?php
include 'db_connect.php'; // Ensure this file handles database connection separately

// Handling Form Submission (Add or Edit)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $contact = $_POST["contact"];
    
    if (isset($_POST["client_id"]) && !empty($_POST["client_id"])) {
        // Update Client Details
        $client_id = $_POST["client_id"];
        $sql = "UPDATE clients SET name='$name', contact='$contact' WHERE id=$client_id";
    } else {
        // Insert New Client
        $sql = "INSERT INTO clients (name, contact) VALUES ('$name', '$contact')";
    }

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Client details saved successfully!'); window.location.href='client.php';</script>";
    } else {
        echo "<script>alert('Error: " . $conn->error . "');</script>";
    }
}

// Fetch Clients
$sql = "SELECT * FROM clients";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Client Management</title>
    <style>
        body {
            background: url('https://source.unsplash.com/1920x1080/?business,meeting') no-repeat center center/cover;
            font-family: Arial, sans-serif;
            color: white;
            text-align: center;
        }
        .container {
            max-width: 800px;
            margin: 50px auto;
            background: rgba(255, 255, 255, 0.9);
            padding: 20px;
            border-radius: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 10px;
            border: 1px solid #ccc;
            text-align: left;
        }
        th {
            background: #007BFF;
            color: white;
        }
        button {
            padding: 8px 15px;
            background: #28a745;
            color: white;
            border-radius: 5px;
            cursor: pointer;
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
        <h1>Manage Clients</h1>
        
        <!-- Client Table -->
        <table>
            <thead>
                <tr>
                    <th>Client ID</th>
                    <th>Full Name</th>
                    <th>Contact</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()) { ?>
                    <tr>
                        <td><?= $row["id"] ?></td>
                        <td><?= $row["name"] ?></td>
                        <td><?= $row["contact"] ?></td>
                        <td><button onclick="editClient('<?= $row["id"] ?>', '<?= $row["name"] ?>', '<?= $row["contact"] ?>')">Edit</button></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

        <!-- Add/Edit Client Form -->
        <h2>Add/Edit Client</h2>
        <form method="POST" action="client.php">
            <input type="hidden" id="client_id" name="client_id">
            <input type="text" id="client-name" name="name" placeholder="Full Name" required>
            <input type="text" id="client-contact" name="contact" placeholder="Contact" required>
            <button type="submit">Save Client</button>
        </form>
    </div>
</body>
</html>
<?php $conn->close(); ?>
