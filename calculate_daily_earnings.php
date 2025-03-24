<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Set timezone (important for CURDATE comparisons)
date_default_timezone_set('UTC');

require 'config/config.php';

// Define ROI percentages per day (30-day cycle)
$plan_roi = [
    'gold'   => 52 / 30,   // ~1.7333%
    'copper' => 37 / 30,   // ~1.2333%
    'bronze' => 28 / 30,   // ~0.9333%
    'silver' => 20 / 30    // ~0.6667%
];

try {
    // Begin Transaction
    $pdo->beginTransaction();

    // Fetch all active subscriptions
    $stmt = $pdo->prepare("SELECT id, user_id, subscribed_plan, crypto_type, amount FROM cryptic_subscriptions WHERE status = 'active'");
    $stmt->execute();
    $subscriptions = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (!$subscriptions) {
        echo "No active subscriptions found.\n";
        exit;
    }

    $processed = 0;
    $skipped = 0;

    foreach ($subscriptions as $sub) {
        $subscription_id = $sub['id'];
        $user_id = $sub['user_id'];
        $plan = strtolower($sub['subscribed_plan']);
        $crypto = strtoupper($sub['crypto_type']);
        $amount = $sub['amount'];

        // Avoid processing unknown plans
        if (!isset($plan_roi[$plan])) {
            echo "⚠️ Unknown plan '$plan' for subscription ID $subscription_id. Skipping.\n";
            $skipped++;
            continue;
        }

        // Check if already logged for today
        $check_stmt = $pdo->prepare("SELECT COUNT(*) FROM earnings_log WHERE subscription_id = ? AND DATE(earnings_date) = CURDATE()");
        $check_stmt->execute([$subscription_id]);
        if ($check_stmt->fetchColumn() > 0) {
            $skipped++;
            continue;
        }

        // Calculate daily earning
        $daily_earning = $amount * ($plan_roi[$plan] / 100);  // ROI% to decimal

        // Insert earnings_log
        $insert_stmt = $pdo->prepare("
            INSERT INTO earnings_log (user_id, subscription_id, daily_earning, crypto_type, earnings_date)
            VALUES (?, ?, ?, ?, NOW())
        ");
        $insert_stmt->execute([$user_id, $subscription_id, $daily_earning, $crypto]);

        // Update user's crypto balance
        $update_stmt = $pdo->prepare("
            UPDATE crypticusers 
            SET {$crypto}_balance = COALESCE({$crypto}_balance, 0) + :earning
            WHERE id = :user_id
        ");
        $update_stmt->execute([
            'earning' => $daily_earning,
            'user_id' => $user_id
        ]);

        $processed++;
    }

    // Commit if all goes well
    $pdo->commit();

    echo "✅ Daily earnings recorded successfully.\n";
    echo "Processed: $processed, Skipped (already recorded): $skipped\n";

} catch (Exception $e) {
    $pdo->rollBack();
    echo "❌ Error: " . $e->getMessage() . "\n";
}
?>