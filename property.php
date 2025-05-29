<?php
include 'db.php'; // Include database connection

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Handle Form Submission (Insert New Property)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $image_url = htmlspecialchars($_POST["image_url"]);
    $property_name = htmlspecialchars($_POST["property_name"]);
    $location = htmlspecialchars($_POST["location"]);
    $price = floatval($_POST["price"]);

    $sql = "INSERT INTO properties (image_url, property_name, location, price) VALUES (:image_url, :property_name, :location, :price)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['image_url' => $image_url, 'property_name' => $property_name, 'location' => $location, 'price' => $price]);

    echo "<script>alert('Property added successfully!'); window.location.href='property.php';</script>";
}

// Fetch Properties from Database
$sql = "SELECT * FROM properties";
$stmt = $pdo->query($sql);
$properties = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Property Management - Real Estate</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: url('https://source.unsplash.com/1920x1080/?real-estate,building') no-repeat center center/cover;
            margin: 0;
            padding: 0;
            text-align: center;
            color: white;
        }
        .container {
            max-width: 800px;
            margin: 50px auto;
            background: rgba(255, 255, 255, 0.9);
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.3);
            color: black;
        }
        h1 {
            color: #007bff;
        }
        .property-list {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            padding: 20px;
        }
        .property-card {
            background: white;
            padding: 15px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
            text-align: center;
        }
        .property-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 10px;
        }
        .property-card h2 {
            color: #007bff;
        }
        .options button {
            margin: 5px;
            padding: 12px 20px;
            background: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .options button:hover {
            background: #0056b3;
        }
        form {
            margin-top: 20px;
            padding: 20px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        input, button {
            width: 90%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .submit-btn {
            background-color: #28a745;
            color: white;
            cursor: pointer;
            font-size: 16px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🏡 Manage Real Estate Properties</h1>
        <p>Add new properties and view available listings.</p>

        <!-- Property Input Form -->
        <form method="POST" action="property.php">
            <h2>Add New Property</h2>
            <input type="text" name="image_url" placeholder="Image URL" required>
            <input type="text" name="property_name" placeholder="Property Name" required>
            <input type="text" name="location" placeholder="Location" required>
            <input type="number" name="price" placeholder="Price" required>
            <button type="submit" class="submit-btn">Add Property</button>
        </form>

        <!-- Property List -->
        <div class="property-list">
            <?php foreach ($properties as $property) { ?>
                <div class="property-card">
                    <img src="<?= htmlspecialchars($property['image_url']) ?>" alt="<?= htmlspecialchars($property['property_name']) ?>">
                    <h2><?= htmlspecialchars($property['property_name']) ?></h2>
                    <p><strong>Location:</strong> <?= htmlspecialchars($property['location']) ?></p>
                    <p><strong>Price:</strong> $<?= number_format($property['price'], 2) ?></p>
                    <div class="options">
                    <button onclick="window.location.href='http://localhost:8080/real_estate_db/payments.php'">Proceed to Payment</button>
                    </div>
                </div>
            <?php } ?>
        </div>
        <br>
            <div class="options">
        <button onclick="window.location.href='http://localhost:8080/real_estate_db/transactions.php'">Transactions</button>
        </div>
            </br>
    </div>
</body>
</html>
<?php $pdo = null; // Close connection ?>
