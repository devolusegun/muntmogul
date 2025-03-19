<?php
session_start();
require 'config/config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize inputs
    $full_name = htmlspecialchars(trim($_POST['full_name']));
    $dob = $_POST['dob'];
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $phone = htmlspecialchars(trim($_POST['phone']));
    $address = htmlspecialchars(trim($_POST['address']));
    $country = htmlspecialchars(trim($_POST['country']));
    $reason = htmlspecialchars(trim($_POST['reason']));
    $crypto_experience = $_POST['crypto_experience'] ?? 'No';
    
    // Correct crypto platforms field name
    $crypto_platforms = isset($_POST['crypto_platforms']) ? implode(", ", $_POST['crypto_platforms']) : 'None';
    $other_platform = htmlspecialchars(trim($_POST['other_platform'] ?? ""));
    
    $third_party = $_POST['third_party'] ?? 'No';
    $assist_investors = $_POST['assist_investors'] ?? 'No';

    //  Validate required fields
    if (!$full_name || !$dob || !$email || !$phone || !$address || !$country || !$reason) {
        echo "<script>alert('Please fill in all required fields.'); window.history.back();</script>";
        exit();
    }

    try {
        //  Check if email already exists
        $checkEmailStmt = $pdo->prepare("SELECT id FROM partners WHERE email = ?");
        $checkEmailStmt->execute([$email]);

        if ($checkEmailStmt->fetch()) {
            echo "<script>alert('This email is already registered. Please use another email or log in.'); window.history.back();</script>";
            exit();
        }

        //  Insert into database
        $stmt = $pdo->prepare("
            INSERT INTO partners (full_name, dob, email, phone, address, country, reason, crypto_experience, crypto_platforms, other_platform, third_party, assist_investors, status) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'pending')
        ");
        $stmt->execute([$full_name, $dob, $email, $phone, $address, $country, $reason, $crypto_experience, $crypto_platforms, $other_platform, $third_party, $assist_investors]);

        //  Send confirmation email
        $subject = "MuntMogul Partner Application Received";
        $message = "Thank you for applying to become a MuntMogul Certified Partner!\n\nWe will review your application and respond within 2 business days.\n\nIf you have any questions, contact us at partners@muntmogul.com.";
        $headers = "From: partners@muntmogul.com\r\nReply-To: partners@muntmogul.com\r\nContent-Type: text/plain; charset=UTF-8";
        mail($email, $subject, $message, $headers);

        //  Success Message and Redirect
        echo "<script>
                alert('Application submitted successfully! You will receive an email confirmation shortly.');
                window.location.href = 'index.html';
              </script>";
        exit();

    } catch (PDOException $e) {
        echo "<script>alert('An error occurred while processing your request. Please try again later.'); window.history.back();</script>";
    }
} else {
    echo "<script>alert('Invalid request method.'); window.history.back();</script>";
}
?>
