<?php
// payments.php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require 'db.php'; // Ensure this file exists and sets up $pdo correctly

$paymentSuccess = false;
$errorMessage = "";

// Process form submission when POST data is available
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and trim input data
    $name             = trim(htmlspecialchars($_POST['name']));
    $email            = trim(htmlspecialchars($_POST['email']));
    $property         = trim(htmlspecialchars($_POST['property']));
    $amount           = trim($_POST['amount']);
    $payment_method   = trim(htmlspecialchars($_POST['payment-method']));
    $transaction_type = trim(htmlspecialchars($_POST['transaction_type'])); // New field

    // Validate that all fields are non-empty
    if (!empty($name) && !empty($email) && !empty($property) && !empty($amount) && !empty($payment_method) && !empty($transaction_type)) {
        try {
            // Prepare the INSERT query to store payment details
            $stmt = $pdo->prepare("INSERT INTO payments (name, email, property, amount, payment_method, transaction_type) VALUES (?, ?, ?, ?, ?, ?)");
            if (!$stmt) {
                $errorMessage = "Failed to prepare the SQL statement.";
            } else {
                if ($stmt->execute([$name, $email, $property, $amount, $payment_method, $transaction_type])) {
                    $paymentSuccess = true;
                } else {
                    $errorInfo = $stmt->errorInfo();
                    $errorMessage = "Execution failed: " . $errorInfo[2];
                }
            }
        } catch (PDOException $e) {
            $errorMessage = "PDOException: " . $e->getMessage();
        }
    } else {
        $errorMessage = "Please fill in all the required fields.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Payment Page with Confirmation</title>
  <style>
    body {
      background: url('https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSin06w7FKURifHWu_wwB7_hLadU7I_h2_lIw&s') no-repeat center center/cover;
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
      color: white;
    }
    .container {
      width: 50%;
      margin: 50px auto;
      padding: 20px;
      background-color: rgba(255, 255, 255, 0.9);
      border-radius: 8px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      color: #333;
    }
    h1 {
      text-align: center;
      color: #333;
    }
    label {
      display: block;
      margin-bottom: 8px;
      font-weight: bold;
      color: #555;
    }
    input, select, button {
      width: 100%;
      padding: 10px;
      margin-bottom: 15px;
      border: 1px solid #ccc;
      border-radius: 4px;
      font-size: 16px;
    }
    button {
      background-color: #4CAF50;
      color: white;
      border: none;
      cursor: pointer;
    }
    button:hover {
      background-color: #45a049;
    }
    .message {
      text-align: center;
      margin-top: 20px;
      font-size: 18px;
      font-weight: bold;
    }
    .error {
      color: red;
    }
    .success {
      color: #4CAF50;
    }
  </style>
</head>
<body>
  <div class="container">
    <h1>Payment Page</h1>
    <?php if ($paymentSuccess): ?>
      <div class="message success">
        Thank you! Your payment has been successfully submitted.
      </div>
    <?php else: ?>
      <?php if (!empty($errorMessage)): ?>
        <div class="message error">
          <?php echo $errorMessage; ?>
        </div>
      <?php endif; ?>
      <form method="post" action="payments.php">
        <label for="name">Full Name:</label>
        <input type="text" id="name" name="name" placeholder="Enter your full name" required>

        <label for="email">Email Address:</label>
        <input type="email" id="email" name="email" placeholder="Enter your email" required>

        <label for="property">Property Name:</label>
        <input type="text" id="property" name="property" placeholder="Enter the property name" required>

        <label for="amount">Payment Amount (INR):</label>
        <input type="number" id="amount" name="amount" placeholder="Enter the amount" required>

        <label for="payment-method">Payment Method:</label>
        <select id="payment-method" name="payment-method" required>
          <option value="">Select Method</option>
          <option value="credit-card">Credit Card</option>
          <option value="debit-card">Debit Card</option>
          <option value="net-banking">Net Banking</option>
          <option value="upi">UPI</option>
        </select>

        <label for="transaction_type">Transaction Type:</label>
        <select id="transaction_type" name="transaction_type" required>
          <option value="">Select Type</option>
          <option value="Buy">Buy</option>
          <option value="Rent">Rent</option>
          <option value="Sell">Sell</option>
        </select>

        <button type="submit">Pay Now</button>
      </form>
    <?php endif; ?>
    <div class="options">
      <button onclick="window.location.href='http://localhost:8080/real_estate_db/report.php'">Reports</button>
    </div>
  </div>
</body>
</html>
