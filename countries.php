<?php
require 'config/config.php';

$api_url = "https://restcountries.com/v3.1/all";
$response = file_get_contents($api_url);
$countries = json_decode($response, true);

foreach ($countries as $country) {
    $country_name = $country['name']['common'];
    $stmt = $pdo->prepare("INSERT IGNORE INTO countries (name) VALUES (?)");
    $stmt->execute([$country_name]);
}

echo "Countries inserted successfully!";
?>
