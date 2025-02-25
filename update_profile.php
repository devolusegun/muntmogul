<?php
session_start();
require 'config/config.php';

if (!isset($_SESSION["user"])) {
    die(json_encode(["success" => false, "message" => "Unauthorized access."]));
}

$userId = $_SESSION["user"]["id"];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    try {
        // ✅ Handle Profile Picture Upload (if provided)
        if (isset($_FILES["profile_picture"]) && $_FILES["profile_picture"]["error"] === UPLOAD_ERR_OK) {
            $allowedTypes = ["image/jpeg", "image/png"];
            $maxFileSize = 2 * 1024 * 1024; // 2MB

            $fileType = mime_content_type($_FILES["profile_picture"]["tmp_name"]);
            $fileSize = $_FILES["profile_picture"]["size"];

            if (!in_array($fileType, $allowedTypes)) {
                die(json_encode(["success" => false, "message" => "Only PNG and JPG files are allowed."]));
            }

            if ($fileSize > $maxFileSize) {
                die(json_encode(["success" => false, "message" => "File size must be less than 2MB."]));
            }

            // ✅ Secure Filename
            $fileExtension = pathinfo($_FILES["profile_picture"]["name"], PATHINFO_EXTENSION);
            $newFileName = "profile_" . $userId . "_" . time() . "." . $fileExtension;
            $uploadDir = "uploads/profile_pictures/";
            $uploadPath = $uploadDir . $newFileName;

            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            if (move_uploaded_file($_FILES["profile_picture"]["tmp_name"], $uploadPath)) {
                // ✅ Store only the filename instead of the full path
                $stmt = $pdo->prepare("UPDATE crypticusers SET profile_picture = ? WHERE id = ?");
                $stmt->execute([$newFileName, $userId]);

                die(json_encode(["success" => true, "message" => "Profile picture updated successfully!", "image_path" => $uploadPath]));
            } else {
                die(json_encode(["success" => false, "message" => "Error uploading file. Try again."]));
            }
        }

        //  Handle Address Update with Transaction PIN Verification
        $transactionPin = trim($_POST["transaction_pin"] ?? '');
        $address = trim($_POST["address"] ?? '');
        $city = trim($_POST["city"] ?? '');
        $state = trim($_POST["state"] ?? '');
        $country = trim($_POST["country"] ?? '');

        if (empty($transactionPin) || empty($address) || empty($city) || empty($state) || empty($country)) {
            die(json_encode(["success" => false, "message" => "All fields are required."]));
        }

        //  Validate Inputs (Max 100 chars)
        if (strlen($address) > 100 || strlen($city) > 100 || strlen($state) > 100 || strlen($country) > 100) {
            die(json_encode(["success" => false, "message" => "Input values exceed character limit."]));
        }

        //  Verify Transaction PIN
        $stmt = $pdo->prepare("SELECT transaction_pin FROM crypticusers WHERE id = ?");
        $stmt->execute([$userId]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user || !password_verify($transactionPin, $user["transaction_pin"])) {
            die(json_encode(["success" => false, "message" => "Invalid Transaction PIN."]));
        }

        //  Update Address, City, State, Country
        $updateStmt = $pdo->prepare("UPDATE crypticusers SET address = ?, city = ?, state = ?, country = ? WHERE id = ?");
        if ($updateStmt->execute([$address, $city, $state, $country, $userId])) {
            //  Log the Profile Change (Audit Logging)
            $logStmt = $pdo->prepare("INSERT INTO user_profile_changes (user_id, changed_at, details) VALUES (?, NOW(), ?)");
            $logStmt->execute([$userId, json_encode(["address" => $address, "city" => $city, "state" => $state, "country" => $country])]);

            die(json_encode(["success" => true, "message" => "Profile updated successfully!"]));
        } else {
            die(json_encode(["success" => false, "message" => "Database update failed."]));
        }
    } catch (Exception $e) {
        die(json_encode(["success" => false, "message" => "Unexpected error occurred. Please try again later."]));
    }
}
?>
