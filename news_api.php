<?php
header("Content-Type: application/json");

// Sample static news (Replace with database query or external API call)
$news = [
    "Bitcoin Hits $83K! 🚀",
    "Ethereum Surges 10% 📈",
    "Dogecoin Partners with Tesla ⚡",
    "New Blockchain Regulations Announced 🏛️",
    "NFT Market Booms Again 🔥"
];

// Return JSON response
echo json_encode(["headlines" => $news]);
?>
