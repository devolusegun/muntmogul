<?php
session_start();
require 'config/config.php';

if (!isset($_SESSION["user"])) {
    die(json_encode(["success" => false, "message" => "Unauthorized access."]));
}

$userId = $_SESSION["user"]["id"];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // ✅ Read JSON Data
    $data = json_decode(file_get_contents("php://input"), true);

    $currentPassword = $data["current_password"] ?? '';
    $newPassword = $data["new_password"] ?? '';
    $confirmPassword = $data["confirm_password"] ?? '';

    if (!$currentPassword || !$newPassword || !$confirmPassword) {
        die(json_encode(["success" => false, "message" => "All fields are required."]));
    }

    if ($newPassword !== $confirmPassword) {
        die(json_encode(["success" => false, "message" => "New passwords do not match."]));
    }

    if (strlen($newPassword) < 8 || !preg_match('/[A-Z]/', $newPassword) || !preg_match('/[0-9]/', $newPassword)) {
        die(json_encode(["success" => false, "message" => "Password must be at least 8 characters, include an uppercase letter and a number."]));
    }

    // ✅ Fetch user’s current password
    $stmt = $pdo->prepare("SELECT password FROM crypticusers WHERE id = ?");
    $stmt->execute([$userId]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user || !password_verify($currentPassword, $user["password"])) {
        die(json_encode(["success" => false, "message" => "Current password is incorrect."]));
    }

    // ✅ Hash new password & update
    $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);
    $updateStmt = $pdo->prepare("UPDATE crypticusers SET password = ? WHERE id = ?");
    $updateStmt->execute([$hashedPassword, $userId]);

    die(json_encode(["success" => true, "message" => "Password changed successfully!"]));
}
?>