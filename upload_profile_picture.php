<?php
session_start();
require 'config/config.php';

if (!isset($_SESSION["user"])) {
    die(json_encode(["success" => false, "message" => "Unauthorized access."]));
}

$userId = $_SESSION["user"]["id"];

if (!isset($_FILES["profile_picture"])) {
    die(json_encode(["success" => false, "message" => "No file uploaded."]));
}

$uploadDir = "uploads/profile_pictures/";
if (!file_exists($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

$fileTmpPath = $_FILES["profile_picture"]["tmp_name"];
$imageSize = getimagesize($fileTmpPath);

if ($imageSize) {
    $width = $imageSize[0];
    $height = $imageSize[1];

    if ($width > 150 || $height > 150) {
        die(json_encode(["success" => false, "message" => "Error: Image must be 150x150 pixels or smaller."]));
    }
} else {
    die(json_encode(["success" => false, "message" => "Invalid image file."]));
}

$fileName = "profile_" . $userId . "_" . time() . ".jpg";
$uploadFile = $uploadDir . $fileName;

if (move_uploaded_file($fileTmpPath, $uploadFile)) {
    $stmt = $pdo->prepare("UPDATE crypticusers SET profile_picture = ? WHERE id = ?");
    $stmt->execute([$uploadFile, $userId]);

    die(json_encode(["success" => true, "message" => "Profile picture updated!", "image_url" => $uploadFile]));
} else {
    die(json_encode(["success" => false, "message" => "File upload failed."]));
}
?>
