<?php
require 'config/config.php';

// Fetch all active subscriptions
$stmt = $pdo->query("SELECT id, user_id, plan, crypto_type, amount FROM cryptic_subscriptions WHERE status = 'active'");
$subscriptions = $stmt->fetchAll(PDO::FETCH_ASSOC);

$roi_per_day = [
    'gold' => 1.7333 / 100, // 1.7333% per day
    'copper' => 1.2333 / 100, // 1.2333% per day
    'bronze' => 0.9333 / 100, // 0.9333% per day
    'silver' => 0.6667 / 100 // 0.6667% per day
];

foreach ($subscriptions as $sub) {
    $dailyEarning = $sub['amount'] * $roi_per_day[$sub['plan']];

    // Insert daily earnings record
    $stmt = $pdo->prepare("INSERT INTO earnings_log (user_id, subscription_id, daily_earning, crypto_type) VALUES (?, ?, ?, ?)");
    $stmt->execute([$sub['user_id'], $sub['id'], $dailyEarning, $sub['crypto_type']]);

    // Update user's crypto balance in `crypticusers`
    $updateStmt = $pdo->prepare("UPDATE crypticusers SET {$sub['crypto_type']}_balance = {$sub['crypto_type']}_balance + ? WHERE id = ?");
    $updateStmt->execute([$dailyEarning, $sub['user_id']]);
}

echo "Daily earnings updated successfully.";
?>
