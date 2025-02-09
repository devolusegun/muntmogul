<?php
require 'src/config.php';

if (isset($_GET['code'])) {
    $code = $_GET['code'];
    $stmt = $pdo->prepare("SELECT * FROM crypticusers WHERE verification_code = ?");
    $stmt->execute([$code]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        $updateStmt = $pdo->prepare("UPDATE crypticusers SET is_verified = 1 WHERE verification_code = ?");
        $updateStmt->execute([$code]);
        echo "Your email has been successfully verified! You can now <a href='login.php'>Login</a>.";
    } else {
        echo "Invalid verification link!";
    }
}
?>
