<?php
// Load JSON file
$json_data = file_get_contents('config/crypto_addresses.json');
$crypto_addresses = json_decode($json_data, true);

// Get selected Crypto Type & Network
$crypto = $_GET["crypto"];
$network = $_GET["network"];

// Check if data exists in JSON
if (isset($crypto_addresses[$crypto][$network])) {
    echo json_encode($crypto_addresses[$crypto][$network]);
} else {
    echo json_encode(["error" => "Invalid selection"]);
}
?>
