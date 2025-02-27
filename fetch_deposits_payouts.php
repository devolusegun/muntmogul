<?php
session_start();
require 'config/config.php';

if (!isset($_SESSION["user"])) {
    die(json_encode(["success" => false, "message" => "Unauthorized access."]));
}

$userId = $_SESSION["user"]["id"];

// Fetch Total Deposits (Approved)
$stmt = $pdo->prepare("SELECT SUM(amount) AS total_deposit FROM crypto_deposits WHERE user_id = ? AND status = 'approved'");
$stmt->execute([$userId]);
$totalDeposit = $stmt->fetch(PDO::FETCH_ASSOC)['total_deposit'] ?? 0;

// Fetch New Deposits (Pending)
$stmt = $pdo->prepare("SELECT SUM(amount) AS new_deposit FROM crypto_deposits WHERE user_id = ? AND status = 'pending'");
$stmt->execute([$userId]);
$newDeposit = $stmt->fetch(PDO::FETCH_ASSOC)['new_deposit'] ?? 0;

// Fetch Total Payouts (Approved) from `withdrawals`
$stmt = $pdo->prepare("SELECT SUM(amount) AS total_payouts FROM withdrawals WHERE user_id = ? AND status = 'approved'");
$stmt->execute([$userId]);
$totalPayouts = $stmt->fetch(PDO::FETCH_ASSOC)['total_payouts'] ?? 0;

// Fetch Pending Payouts from `withdrawals`
$stmt = $pdo->prepare("SELECT SUM(amount) AS pending_payouts FROM withdrawals WHERE user_id = ? AND status = 'pending'");
$stmt->execute([$userId]);
$pendingPayouts = $stmt->fetch(PDO::FETCH_ASSOC)['pending_payouts'] ?? 0;

// Return Data
echo json_encode([
    "success" => true,
    "total_deposit" => number_format($totalDeposit, 2),
    "new_deposit" => number_format($newDeposit, 2),
    "total_payouts" => number_format($totalPayouts, 2),
    "pending_payouts" => number_format($pendingPayouts, 2)
]);
?>
