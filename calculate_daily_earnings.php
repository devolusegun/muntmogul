<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require 'config/config.php';

// Define ROI percentages
$plan_roi = [
    'gold' => 52 / 30,   // 1.7333% per day
    'copper' => 37 / 30, // 1.2333% per day
    'bronze' => 28 / 30, // 0.9333% per day
    'silver' => 20 / 30, // 0.6667% per day
];

// Fetch all active subscriptions
$stmt = $pdo->prepare("SELECT id, user_id, subscribed_plan, crypto_type, amount FROM cryptic_subscriptions WHERE status = 'active'");
$stmt->execute();
$subscriptions = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (!$subscriptions) {
    die("No active subscriptions found.");
}

// Insert daily earnings for each active subscription
foreach ($subscriptions as $sub) {
    $subscription_id = $sub['id'];
    $user_id = $sub['user_id'];
    $plan = $sub['subscribed_plan'];
    $crypto = $sub['crypto_type'];
    $amount = $sub['amount'];

    // Calculate daily earnings
    $daily_earning = $amount * ($plan_roi[$plan] / 100); // Convert ROI% to decimal

    // Insert earnings log
    $insert_stmt = $pdo->prepare("INSERT INTO earnings_log (user_id, subscription_id, daily_earning, crypto_type, earnings_date) VALUES (?, ?, ?, ?, NOW())");
    $insert_stmt->execute([$user_id, $subscription_id, $daily_earning, $crypto]);
    
    // Update user balance based on crypto type
    $updateBalanceQuery = "
    UPDATE crypticusers 
    SET {$crypto}_balance = COALESCE({$crypto}_balance, 0) + :daily_earning
    WHERE id = :user_id
    ";
    $updateStmt = $pdo->prepare($updateBalanceQuery);
    $updateStmt->execute([
        'daily_earning' => $daily_earning,
        'user_id' => $user_id
    ]);
}

echo "✅ Daily earnings calculated and recorded successfully.";
?>
