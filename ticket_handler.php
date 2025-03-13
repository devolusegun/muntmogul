<?php
session_start();
require 'config/config.php'; // Include database connection

header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Handle Ticket Submission
    if (!isset($_SESSION["user"]["id"])) {
        echo json_encode(["success" => false, "message" => "User not logged in."]);
        exit();
    }

    $user_id = $_SESSION["user"]["id"];
    $subject = trim($_POST["subject"]);
    $message = trim($_POST["message"]);

    if (empty($subject) || empty($message)) {
        echo json_encode(["success" => false, "message" => "Subject and message cannot be empty."]);
        exit();
    }

    $stmt = $pdo->prepare("INSERT INTO support_tickets (user_id, subject, message) VALUES (?, ?, ?)");
    $stmt->execute([$user_id, $subject, $message]);

    if ($stmt->rowCount()) {
        echo json_encode(["success" => true, "message" => "Ticket submitted successfully."]);
    } else {
        echo json_encode(["success" => false, "message" => "Failed to submit ticket."]);
    }
    exit();
}

// Handle Fetching User Tickets
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (!isset($_SESSION["user"]["id"])) {
        echo json_encode(["success" => false, "message" => "User not logged in."]);
        exit();
    }

    $user_id = $_SESSION["user"]["id"];
    $stmt = $pdo->prepare("SELECT id, subject, status, created_at FROM support_tickets WHERE user_id = ? ORDER BY created_at DESC");
    $stmt->execute([$user_id]);
    $tickets = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode(["success" => true, "tickets" => $tickets]);
    exit();
}

// If neither GET nor POST
echo json_encode(["success" => false, "message" => "Invalid request."]);
?>
