<?php
//session_start();
require 'config/config.php';
if (!isset($_SESSION["user"])) {
    die(json_encode(["success" => false, "message" => "Unauthorized access."]));
}

function getLiveCryptoPrices()
{
    $apiUrl = "https://api.coingecko.com/api/v3/simple/price?ids=bitcoin,ethereum,litecoin,dogecoin&vs_currencies=usd";

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $apiUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($httpCode === 200) {
        return json_decode($response, true);
    }

    return [];
}

$userId = $_SESSION["user"]["id"];
$inputData = json_decode(file_get_contents("php://input"), true);
$selectedPlan = $inputData["plan"] ?? null;
$selectedCrypto = $inputData["crypto"] ?? null;

if (!$selectedPlan || !$selectedCrypto) {
    die(json_encode(["success" => false, "message" => "Invalid selection."]));
}

// Define Plan Details (Ensure correct min deposit values)
$plans = [
    "gold" => 50000,
    "copper" => 15000,
    "bronze" => 5000,
    "silver" => 2000
];

if (!isset($plans[$selectedPlan])) {
    die(json_encode(["success" => false, "message" => "Invalid plan."]));
}

$minDeposit = $plans[$selectedPlan];

// Fetch User Balance from `crypticusers`
$stmt = $pdo->prepare("SELECT btc_balance, ltc_balance, eth_balance, doge_balance FROM crypticusers WHERE id = ?");
$stmt->execute([$userId]);
$userData = $stmt->fetch(PDO::FETCH_ASSOC);


// Check if this plan is already active for the user
$stmt = $pdo->prepare("SELECT COUNT(*) FROM cryptic_subscriptions WHERE user_id = ? AND subscribed_plan = ? AND status = 'active'");
$stmt->execute([$userId, $selectedPlan]);
$planExists = $stmt->fetchColumn();

if ($planExists) {
    die(json_encode([
        "success" => false,
        "message" => "You already have an active subscription for the '$selectedPlan' plan."
    ]));
}

// Check If User Has Sufficient Balance
$cryptoColumn = strtolower($selectedCrypto) . "_balance"; //  btc_balance, ltc_balance
$userBalance = $userData[$cryptoColumn] ?? 0;
$cryptoPrices = getLiveCryptoPrices();

$conversionMap = [
    "BTC" => $cryptoPrices["bitcoin"]["usd"] ?? 0,
    "ETH" => $cryptoPrices["ethereum"]["usd"] ?? 0,
    "LTC" => $cryptoPrices["litecoin"]["usd"] ?? 0,
    "DOGE" => $cryptoPrices["dogecoin"]["usd"] ?? 0
];

$currentPrice = $conversionMap[strtoupper($selectedCrypto)] ?? 0;

if ($currentPrice <= 0) {
    die(json_encode(["success" => false, "message" => "Unable to retrieve crypto price. Please try again."]));
}

// Convert minDeposit in USD to crypto equivalent
$requiredCryptoAmount = $minDeposit / $currentPrice;

if ($userBalance < $requiredCryptoAmount) {
    die(json_encode(["success" => false, "message" => "Insufficient balance for this plan."]));
}

//Deduct Balance & Insert Subscription Record
//$newBalance = $userBalance - $minDeposit;
$newBalance = $userBalance - $requiredCryptoAmount;
$pdo->beginTransaction();
try {
    //Update User Balance in `crypticusers`
    $stmt = $pdo->prepare("UPDATE crypticusers SET $cryptoColumn = ? WHERE id = ?");
    $stmt->execute([$newBalance, $userId]);

    //Insert Subscription Record into `cryptic_subscriptions`
    /*$stmt = $pdo->prepare("
        INSERT INTO cryptic_subscriptions (user_id, subscribed_plan, crypto_type, amount, status, created_at) 
        VALUES (?, ?, ?, ?, 'active', NOW())
    ");
    $stmt->execute([$userId, $selectedPlan, $selectedCrypto, $minDeposit]);*/
    $stmt = $pdo->prepare("INSERT INTO cryptic_subscriptions (user_id, subscribed_plan, crypto_type, amount, status, created_at) 
    VALUES (?, ?, ?, ?, 'active', NOW())");
    $stmt->execute([$userId, $selectedPlan, $selectedCrypto, $requiredCryptoAmount]);

    $pdo->commit();

    // Fetch Updated Subscription for UI Display
    $stmt = $pdo->prepare("SELECT subscribed_plan FROM cryptic_subscriptions WHERE user_id = ? ORDER BY created_at DESC LIMIT 1");
    $stmt->execute([$userId]);
    $latestSubscription = $stmt->fetch(PDO::FETCH_ASSOC);

    die(json_encode([
        "success" => true,
        "message" => "Subscription successful!",
        "new_balance" => $newBalance,
        "subscribed_plan" => $latestSubscription['subscribed_plan']
    ]));
} catch (Exception $e) {
    $pdo->rollBack();
    die(json_encode(["success" => false, "message" => "Error processing subscription: " . $e->getMessage()]));
}
