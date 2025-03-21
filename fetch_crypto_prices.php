<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

$cache_file = 'crypto_cache.json';
$cache_time = 60; // Cache duration in seconds (1 min)

if (file_exists($cache_file) && (time() - filemtime($cache_file) < $cache_time)) {
    echo file_get_contents($cache_file);
    exit();
}

// CoinPaprika API Endpoint
$api_url = "https://api.coinpaprika.com/v1/tickers";

// Fetch API response
$response = @file_get_contents($api_url);

if ($response) {
    $data = json_decode($response, true);
    
    // Map CoinPaprika IDs to standard symbols
    $crypto_map = [
        "btc-bitcoin" => "BTC",
        "eth-ethereum" => "ETH",
        "ltc-litecoin" => "LTC",
        "doge-dogecoin" => "DOGE"
    ];

    $filtered_prices = [];

    foreach ($data as $crypto) {
        if (isset($crypto_map[$crypto["id"]])) {
            $symbol = $crypto_map[$crypto["id"]];
            $filtered_prices[$symbol] = $crypto["quotes"]["USD"]["price"];
        }
    }

    $json_response = json_encode(["prices" => $filtered_prices]);
    file_put_contents($cache_file, $json_response);
    echo $json_response;

} else {
    echo json_encode(["error" => "Failed to fetch crypto prices"]);
}

// Return JSON response
echo json_encode(["prices" => $prices]);

/*header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

$cache_file = 'crypto_cache.json';
$cache_time = 60; // Cache duration in seconds (1 min)

if (file_exists($cache_file) && (time() - filemtime($cache_file) < $cache_time)) {
    echo file_get_contents($cache_file);
} else {
    $api_url = "https://api.coingecko.com/api/v3/simple/price?ids=bitcoin,litecoin,ethereum,dogecoin&vs_currencies=usd";
    $response = file_get_contents($api_url);
    
    if ($response) {
        file_put_contents($cache_file, $response);
        echo $response;
    } else {
        echo json_encode(["error" => "Failed to fetch crypto prices"]);
    }
}*/
?>
