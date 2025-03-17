<?php
session_start();
require 'config/config.php';

// Ensure User is Logged In
if (!isset($_SESSION["user"]["id"])) {
    echo json_encode(["error" => "Unauthorized"]);
    exit();
}

$user_id = $_SESSION["user"]["id"];
$crypto_type = $_GET['crypto_type'] ?? 'BTC';

// Fetch Balance Dynamically
$stmt = $pdo->prepare("
    SELECT 
        COALESCE({$crypto_type}_balance, 0) AS balance
    FROM crypticusers
    WHERE id = ?
");
$stmt->execute([$user_id]);
$result = $stmt->fetch(PDO::FETCH_ASSOC);

// Return Balance as JSON
echo json_encode(["balance" => number_format($result['balance'] ?? 0, 8)]);
?>
