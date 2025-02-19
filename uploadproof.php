<?php
session_start();
require 'config/config.php';

if (!isset($_SESSION["user"])) {
    header("Location: login");
    exit();
}

$error = "";
$success = "";

// ✅ Handle Proof Upload
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION["user"]["id"];
    $crypto_type = $_POST["crypto_type"];
    $network = $_POST["network"];
    $amount = $_POST["amount"];
    $tx_id = $_POST["tx_id"];
    $wallet_address = $_POST["wallet_address"];

    // ✅ Validate Image Upload
    $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];
    $upload_dir = "uploads/";
    $file_name = basename($_FILES["proof_image"]["name"]);
    $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

    if (!in_array($file_ext, $allowed_extensions)) {
        $error = "Only JPG, PNG, and GIF files are allowed.";
    } else {
        $proof_image = $upload_dir . uniqid() . "." . $file_ext;
        move_uploaded_file($_FILES["proof_image"]["tmp_name"], $proof_image);

        // ✅ Insert into `crypto_deposits` Table
        $stmt = $pdo->prepare("INSERT INTO crypto_deposits (user_id, crypto_type, network, amount, tx_id, wallet_address, proof_image) VALUES (?, ?, ?, ?, ?, ?, ?)");
        
        if ($stmt->execute([$user_id, $crypto_type, $network, $amount, $tx_id, $wallet_address, $proof_image])) {
            $success = "Deposit submitted successfully! Waiting for admin approval.";
        } else {
            $error = "Failed to submit deposit.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Upload Payment Proof</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .form-group { margin-bottom: 15px; }
        label { display: block; font-weight: bold; }
        input, select { width: 100%; padding: 8px; margin-top: 5px; }
        button { padding: 10px 15px; background-color: #007bff; color: white; border: none; cursor: pointer; }
        button:hover { background-color: #0056b3; }
    </style>
</head>
<body>

    <h2>Upload Payment Proof</h2>
    <?php if ($error) echo "<p style='color:red;'>$error</p>"; ?>
    <?php if ($success) echo "<p style='color:green;'>$success</p>"; ?>

    <form method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label>Select Cryptocurrency:</label>
            <select name="crypto_type" required>
                <option value="BTC">Bitcoin (BTC)</option>
                <option value="ETH">Ethereum (ETH)</option>
                <option value="LTC">Litecoin (LTC)</option>
                <option value="DOGE">Dogecoin (DOGE)</option>
            </select>
        </div>

        <div class="form-group">
            <label>Select Network:</label>
            <select name="network" required>
                <option value="BSC">Binance Smart Chain (BSC)</option>
                <option value="ERC20">Ethereum (ERC20)</option>
                <option value="TRC20">Tron (TRC20)</option>
                <option value="NATIVE">Native Blockchain</option>
            </select>
        </div>

        <div class="form-group">
            <label>Transaction ID:</label>
            <input type="text" name="tx_id" required>
        </div>
        
        <div class="form-group">
            <label>Amount:</label>
            <input type="number" step="0.00000001" name="amount" required>
        </div>
        
        <div class="form-group">
            <label>Your Wallet Address:</label>
            <input type="text" name="wallet_address" required>
        </div>

        <div class="form-group">
            <label>Upload Screenshot:</label>
            <input type="file" name="proof_image" accept="image/*" required>
        </div>

        <button type="submit">Submit Proof</button>
    </form>

</body>
</html>
