<?php
//error_reporting(E_ALL);
//ini_set('display_errors', 1);
require 'config/config.php';

// Ensure `.env` loads first
require_once __DIR__ . '/load_env.php';
loadEnv(__DIR__ . '/.env');

require 'src/Exception.php';
require 'src/PHPMailer.php';
require 'src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Fetch SMTP credentials from .env
$smtp_host = getenv('SMTP_HOST') ?: $_ENV['SMTP_HOST'];
$smtp_user = getenv('SMTP_USER') ?: $_ENV['SMTP_USER'];
$smtp_pass = getenv('SMTP_PASS') ?: $_ENV['SMTP_PASS'];
$smtp_port = getenv('SMTP_PORT') ?: $_ENV['SMTP_PORT'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['verified_email'])) {
    $userEmail = $_POST['verified_email'];
    
    // Fetch user first name (you may already have it from earlier)
    $stmt = $pdo->prepare("SELECT first_name FROM crypticusers WHERE email = ?");
    $stmt->execute([$userEmail]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    $first_name = $user['first_name'] ?? 'there';

    // Send follow-up email
    $mail = new PHPMailer(true);
    try {
        $mail->CharSet = 'UTF-8';
        
        $mail->isSMTP();
        $mail->Host       = $smtp_host;
        $mail->SMTPAuth   = true;
        $mail->Username   = $smtp_user;
        $mail->Password   = $smtp_pass;
        $mail->SMTPSecure = 'tls';
        $mail->Port       = $smtp_port;

        $mail->setFrom(getenv('MAIL_FROM_ADDRESS') ?: $_ENV['MAIL_FROM_ADDRESS'], getenv('MAIL_FROM_NAME') ?: $_ENV['MAIL_FROM_NAME']);
        $mail->addAddress($userEmail, $first_name);

        $mail->isHTML(true);
        $mail->Subject = "You're Verified — Here's What’s Next at MuntMogul ✅";

        $mail->Body = "
            <p>Hi $first_name,</p><br>
            
            <p>Welcome once again to <strong>MuntMogul</strong> — you’ve successfully verified your email, and you’re just a few simple steps away from starting your investment journey.</p><br>

            <p>Here’s what to do next:</p>
            <hr/>
            <p>🔹 <strong>1. Complete Your Profile</strong><br>Add your basic details so we can secure your account and set up your dashboard.</p>
            
            <p>🔹 <strong>2. Deposit Funds</strong><br>Transfer your investment amount to the designated account shown on your dashboard. (Don’t worry — it’s fast and secure.)</p>
            
            <p>🔹 <strong>3. Upload Deposit Proof</strong><br>Once your funds are sent, upload a screenshot or receipt so we can match and verify it.</p>
            
            <p>🔹 <strong>4. Wait for Approval</strong><br>Our team (or your assigned Partner) will review and approve the deposit — usually within 1–3 hours.</p>
            
            <p>🔹 <strong>5. Choose an Investment Plan</strong><br>Browse our available plans and subscribe to the one that best fits your goals.</p>
            <hr/>

            <p>💡 Need help with anything along the way? Just reply to this email or reach out to support at <a href='mailto:support@muntmogul.com'>support@muntmogul.com</a> — we’re always here to assist.</p>

            <p>Let’s get started — your investment journey begins now.</p>

            <p><strong>MuntMogul Team</strong></p>
        ";

        $mail->send();
        
        $_SESSION['message'] = "🎉 You're verified! Next steps have been sent to your Email.";

        // Redirect after email is sent
        header("Location: login");
        exit;
    } catch (Exception $e) {
        error_log("Follow-up email error: " . $mail->ErrorInfo, 3, __DIR__ . '/logs/email_errors.log');
        //die("Mailer Error: " . $mail->ErrorInfo);
        // Optional: Show an error message or allow login anyway
        header("Location: login");
        exit;
    }
}


$verificationMessage = "";
$buttonText = "Go to Login";
$buttonLink = "login";

if (isset($_GET['code'])) {
    $code = $_GET['code'];
    $stmt = $pdo->prepare("SELECT * FROM crypticusers WHERE verification_code = ?");
    $stmt->execute([$code]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        $updateStmt = $pdo->prepare("UPDATE crypticusers SET is_verified = 1, verification_code = NULL WHERE verification_code = ?");
        $updateStmt->execute([$code]);
        $verificationMessage = "✅ Your email has been successfully verified! You can now log in.";
    } else {
        $verificationMessage = "❌ Invalid or expired verification link!";
        $buttonText = "Return to Homepage";
        $buttonLink = "index.html";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Verification</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <style>
        body {
            background-color: #f4f7f6;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            font-family: Arial, sans-serif;
        }

        .verification-container {
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            width: 400px;
        }

        .verification-container h2 {
            color: #333;
        }

        .message {
            font-size: 18px;
            margin: 20px 0;
            color: #555;
        }

        .btn-custom {
            background-color: #28a745;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            display: inline-block;
            font-weight: bold;
            transition: 0.3s ease;
        }

        .btn-custom:hover {
            background-color: #218838;
        }
    </style>
</head>

<body>
<div class="verification-container">
        <h2>Email Verification</h2>
        <p class="message"><?php echo $verificationMessage; ?></p>
        <?php if (!empty($user['email'])): ?>
            <form method="post">
                <input type="hidden" name="verified_email" value="<?php echo $user['email']; ?>">
                <button type="submit" class="btn-custom"><?php echo $buttonText; ?></button>
            </form>
        <?php else: ?>
            <a href="<?php echo $buttonLink; ?>" class="btn-custom"><?php echo $buttonText; ?></a>
        <?php endif; ?>
    </div>

</body>

</html>