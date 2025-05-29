<?php
include 'db.php'; // Include database connection

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Handle Form Submission (Insert New Property)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $image_url = htmlspecialchars($_POST["image_url"]);
    $property_name = htmlspecialchars($_POST["property_name"]);
    $location = htmlspecialchars($_POST["location"]);
    $price = floatval($_POST["price"]);

    $sql = "INSERT INTO property_reports (image_url, property_name, location, price) VALUES (:image_url, :property_name, :location, :price)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['image_url' => $image_url, 'property_name' => $property_name, 'location' => $location, 'price' => $price]);

    echo "<script>alert('Property added successfully!'); window.location.href='report.php';</script>";
}

// Fetch Properties from Database
$sql = "SELECT * FROM property_reports";
$stmt = $pdo->query($sql);
$properties = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Property Report - Real Estate Management</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 80%;
            margin: 30px auto;
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.8);
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(5px);
        }
        h1 {
            text-align: center;
            color: #007BFF;
        }
        p {
            text-align: center;
            color: #333;
            font-size: 18px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background: white;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
        }
        th {
            background-color: #007BFF;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        tr:hover {
            background-color: #ddd;
        }
        img {
            max-width: 100px;
            border-radius: 5px;
        }
        form {
            margin-top: 20px;
            padding: 20px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        input, button {
            width: 90%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            background-color: #28a745;
            color: white;
            cursor: pointer;
            font-size: 16px;
            transition: 0.3s;
        }
        button:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🏡 Real Estate Property Report</h1>
        <p>Detailed insights into our featured properties, including location, pricing, and images.</p>

        <!-- Property Entry Form -->
        <form method="POST" action="report.php">
            <h2>Add New Property</h2>
            <input type="text" name="image_url" placeholder="Image URL" required>
            <input type="text" name="property_name" placeholder="Property Name" required>
            <input type="text" name="location" placeholder="Location" required>
            <input type="number" name="price" placeholder="Price" required>
            <button type="submit">Add Property</button>
        </form>

        <!-- Property Table -->
        <table>
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Property Name</th>
                    <th>Location</th>
                    <th>Price ($)</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($properties as $property) { ?>
                    <tr>
                        <td><img src="<?= htmlspecialchars($property['image_url']) ?>" alt="<?= htmlspecialchars($property['property_name']) ?>"></td>
                        <td><?= htmlspecialchars($property['property_name']) ?></td>
                        <td><?= htmlspecialchars($property['location']) ?></td>
                        <td>$<?= number_format($property['price'], 2) ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</body>
</html>
<?php $pdo = null; // Close connection ?>
