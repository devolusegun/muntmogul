<?php
session_start();
require 'config/config.php';

if (!isset($_SESSION["user"])) {
    die(json_encode(["success" => false, "message" => "Unauthorized access."]));
}

$userId = $_SESSION["user"]["id"];

// Fetch today's earnings
$stmt = $pdo->prepare("SELECT crypto_type, SUM(amount) AS earnings FROM earnings WHERE user_id = ? AND DATE(created_at) = CURDATE() GROUP BY crypto_type");
$stmt->execute([$userId]);
$todayEarnings = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch this week's earnings
$stmt = $pdo->prepare("SELECT crypto_type, SUM(amount) AS earnings FROM earnings WHERE user_id = ? AND WEEK(created_at) = WEEK(CURDATE()) GROUP BY crypto_type");
$stmt->execute([$userId]);
$weekEarnings = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Send JSON Response
echo json_encode([
    "success" => true,
    "todayEarnings" => $todayEarnings,
    "weekEarnings" => $weekEarnings
]);
?>
