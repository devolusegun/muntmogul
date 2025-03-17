<?php
require 'config/config.php';

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
        $buttonLink = "index.php";
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
    <a href="<?php echo $buttonLink; ?>" class="btn-custom"><?php echo $buttonText; ?></a>
</div>

</body>
</html>
