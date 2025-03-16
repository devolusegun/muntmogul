<?php
header("Access-Control-Allow-Origin: *");
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
}
?>
