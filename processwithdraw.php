<?php
session_start();
require 'config/config.php';

if (!isset($_SESSION["user"])) {
    header("Location: login");
    exit();
}

// Check if Form Submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userId = $_SESSION["user"]["id"];
    $paymentMode = $_POST["payment_mode"];
    $accountId = trim($_POST["account_id"]);
    $amount = floatval($_POST["amount"]);

    // Validate Withdrawal Amount
    $stmt = $pdo->prepare("SELECT btc_balance FROM crypticusers WHERE id = ?");
    $stmt->execute([$userId]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user || $user["btc_balance"] < $amount) {
        die("Insufficient balance for withdrawal.");
    }

    // Insert Withdrawal Request
    $stmt = $pdo->prepare("INSERT INTO withdrawals (user_id, payment_mode, account_id, amount, status, created_at) 
                           VALUES (?, ?, ?, ?, 'pending', NOW())");
    $stmt->execute([$userId, $paymentMode, $accountId, $amount]);

    // Redirect to Confirmation Page
    header("Location: withdrawal_confirmation.php");
    exit();
}
?>