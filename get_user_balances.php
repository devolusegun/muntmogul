<?php
session_start();
require 'config/config.php';

if (!isset($_SESSION["user"])) {
    die(json_encode(["success" => false, "message" => "Unauthorized access."]));
}

$userId = $_SESSION["user"]["id"];

// ✅ Fetch balances from `crypticusers`
$stmt = $pdo->prepare("SELECT btc_balance, ltc_balance, eth_balance, doge_balance FROM crypticusers WHERE id = ?");
$stmt->execute([$userId]);
$userBalances = $stmt->fetch(PDO::FETCH_ASSOC);

if ($userBalances) {
    echo json_encode($userBalances);
} else {
    echo json_encode(["success" => false, "message" => "Balance not found."]);
}
?>
