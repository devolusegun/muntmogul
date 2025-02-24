<?php
session_start();
require 'config/config.php';

// ✅ Ensure User is Logged In
if (!isset($_SESSION["user"]["id"])) {
    echo json_encode(["error" => "Unauthorized"]);
    exit();
}

$user_id = $_SESSION["user"]["id"];
$crypto_type = $_GET['crypto_type'] ?? 'BTC';

// ✅ Fetch Balance Dynamically
$stmt = $pdo->prepare("
    SELECT 
        COALESCE(SUM(CASE WHEN transaction_type = 'deposit' AND status = 'approved' THEN amount ELSE 0 END), 0) 
        - 
        COALESCE(SUM(CASE WHEN transaction_type = 'withdrawal' AND status = 'approved' THEN amount ELSE 0 END), 0) 
    AS balance
    FROM crypto_transactions
    WHERE user_id = ? AND crypto_type = ?
");
$stmt->execute([$user_id, $crypto_type]);
$result = $stmt->fetch(PDO::FETCH_ASSOC);

// ✅ Return Balance as JSON
echo json_encode(["balance" => number_format($result['balance'] ?? 0, 8)]);
?>
