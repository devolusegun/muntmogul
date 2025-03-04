<?php
session_start();
require 'config/config.php';  // Include database connection

// Handle JSON request
$data = json_decode(file_get_contents("php://input"), true);
$email = filter_var($data["email"], FILTER_SANITIZE_EMAIL);

// Validate Email
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    die(json_encode(["success" => false, "message" => "Invalid email format."]));
}

// Check if Email Already Exists
$stmt = $pdo->prepare("SELECT id FROM newsletter_subscribers WHERE email = ?");
$stmt->execute([$email]);
if ($stmt->rowCount() > 0) {
    die(json_encode(["success" => false, "message" => "You're already subscribed."]));
}

// Insert New Subscription
$stmt = $pdo->prepare("INSERT INTO newsletter_subscribers (email) VALUES (?)");
if ($stmt->execute([$email])) {
    echo json_encode(["success" => true, "message" => "Subscription successful!"]);
} else {
    echo json_encode(["success" => false, "message" => "Something went wrong, try again."]);
}
?>
