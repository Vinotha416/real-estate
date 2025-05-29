<?php
// transactions.php

ini_set('display_errors', 1);
error_reporting(E_ALL);

require 'db.php'; // Ensure this file is configured correctly and is in the same folder

$message = ""; // Message to display after form submission

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and sanitize input data
    $client_name = trim(htmlspecialchars($_POST['client_name']));
    $property    = trim(htmlspecialchars($_POST['property']));
    $amount      = trim($_POST['amount']); // Numeric input (consider additional validation)
    $status      = trim(htmlspecialchars($_POST['status']));
    $transaction_type = trim(htmlspecialchars($_POST['transaction_type']));

    // Check that all fields are provided
    if (empty($client_name) || empty($property) || empty($amount) || empty($status) || empty($transaction_type)) {
        $message = "Please fill in all the required fields.";
    } else {
        try {
            // Prepare the INSERT statement
            $stmt = $pdo->prepare("INSERT INTO transactions (client_name, property, amount, status, transaction_type) VALUES (?, ?, ?, ?, ?)");
            if ($stmt->execute([$client_name, $property, $amount, $status, $transaction_type])) {
                $message = "Transaction saved successfully!";
            } else {
                $errorInfo = $stmt->errorInfo();
                $message = "Failed to save transaction: " . $errorInfo[2];
            }
        } catch (PDOException $e) {
            $message = "Error: " . $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Transaction</title>
  <style>
    body {
      margin: 0;
      padding: 0;
      background-image: url('https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTRp61sGkymvnf75Gcg-ymlvfI6B060ePA1Aw&s');
      background-size: cover;
      background-position: center;
      font-family: 'Roboto', sans-serif;
      color: #333;
    }
    .container {
      max-width: 600px;
      margin: 50px auto;
      background: rgba(255, 255, 255, 0.95);
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0 4px 8px rgba(0,0,0,0.2);
    }
    h1 {
      text-align: center;
      color: #333;
    }
    form label {
      display: block;
      margin-bottom: 8px;
      font-weight: bold;
    }
    form input, form select, form button {
      width: 100%;
      padding: 10px;
      margin-bottom: 15px;
      border: 1px solid #ccc;
      border-radius: 5px;
      font-size: 16px;
    }
    form button {
      background-color: #007BFF;
      color: white;
      border: none;
      cursor: pointer;
    }
    form button:hover {
      background-color: #0056b3;
    }
    .message {
      text-align: center;
      margin-bottom: 15px;
      font-size: 18px;
      font-weight: bold;
    }
    .error {
      color: red;
    }
    .success {
      color: green;
    }
    .options {
      text-align: center;
      margin-top: 20px;
    }
    .payments-button {
      background-color: #007BFF;
      color: white;
      padding: 10px 20px;
      border: none;
      border-radius: 5px;
      font-size: 16px;
      cursor: pointer;
    }
    .payments-button:hover {
      background-color: #0056b3;
    }
  </style>
</head>
<body>
  <div class="container">
    <h1>Transaction</h1>
    <h2>Add New Transaction</h2>
    <?php if (!empty($message)): ?>
      <div class="message <?php echo (strpos($message, 'successfully') !== false ? 'success' : 'error'); ?>">
         <?php echo $message; ?>
      </div>
    <?php endif; ?>
    <form method="post" action="transactions.php">
      <label for="client_name">Client Name:</label>
      <input type="text" name="client_name" id="client_name" placeholder="Enter client name" required>

      <label for="property">Property:</label>
      <input type="text" name="property" id="property" placeholder="Enter property" required>

      <label for="amount">Amount (INR):</label>
      <input type="number" step="0.01" name="amount" id="amount" placeholder="Enter amount" required>

      <label for="status">Status:</label>
      <select name="status" id="status" required>
         <option value="">Select Status</option>
         <option value="Pending">Pending</option>
         <option value="Completed">Completed</option>
         <option value="In Progress">In Progress</option>
      </select>

      <label for="transaction_type">Transaction Type:</label>
      <select name="transaction_type" id="transaction_type" required>
        <option value="">Select Type</option>
        <option value="Buy">Buy</option>
        <option value="Sell">Sell</option>
        <option value="Rent">Rent</option>
      </select>

      <button type="submit">Submit Transaction</button>
    </form>
    <div class="options">
      <button class="payments-button" onclick="window.location.href='http://localhost:8080/real_estate_db/payments.php'">Payments</button>
    </div>
  </div>
</body>
</html>
