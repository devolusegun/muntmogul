<?php
session_start();
require '../config/config.php';
require '../vendor/autoload.php'; // Ensure PHPMailer is installed via Composer

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// ✅ Protect Admin Actions
if (!isset($_SESSION["admin_id"])) {
    header("Location: admin_login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET["id"]) && isset($_GET["action"])) {
    $withdrawalId = $_GET["id"];
    $action = $_GET["action"];

    // ✅ Get Withdrawal Details
    $stmt = $pdo->prepare("SELECT withdrawals.*, crypticusers.email, crypticusers.first_name, crypticusers.last_name 
                           FROM withdrawals 
                           JOIN crypticusers ON withdrawals.user_id = crypticusers.id 
                           WHERE withdrawals.id = ? AND withdrawals.status = 'pending'");
    $stmt->execute([$withdrawalId]);
    $withdrawal = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$withdrawal) {
        header("Location: admin_withdrawals.php");
        exit();
    }

    $userEmail = $withdrawal['email'];
    $userName = $withdrawal['first_name'] . " " . $withdrawal['last_name'];

    if ($action == "approve") {
        // ✅ Approve Withdrawal Request
        $updateStmt = $pdo->prepare("UPDATE withdrawals SET status = 'approved', approved_at = NOW(), admin_id = ? WHERE id = ?");
        $updateStmt->execute([$_SESSION["admin_id"], $withdrawalId]);

        $subject = "Withdrawal Approved";
        $message = "Hello $userName,\n\nYour withdrawal request of {$withdrawal['amount']} BTC has been approved and is being processed.";

    } elseif ($action == "reject") {
        // ✅ Reject Withdrawal Request
        $updateStmt = $pdo->prepare("UPDATE withdrawals SET status = 'rejected', approved_at = NOW(), admin_id = ?, rejection_reason = NULL WHERE id = ?");
        $updateStmt->execute([$_SESSION["admin_id"], $withdrawalId]);

        $subject = "Withdrawal Rejected";
        $message = "Hello $userName,\n\nYour withdrawal request of {$withdrawal['amount']} BTC has been rejected. Please contact support for further details.";
    }

    // ✅ Send Email Notification
    sendEmailNotification($userEmail, $userName, $subject, $message);
    header("Location: admin_withdrawals.php");
    exit();
}

// ✅ Handle POST Request for Rejection with Reason
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["withdrawal_id"]) && isset($_POST["rejection_reason"])) {
    $withdrawalId = $_POST["withdrawal_id"];
    $rejectionReason = trim($_POST["rejection_reason"]);

    // ✅ Get Withdrawal Details
    $stmt = $pdo->prepare("SELECT withdrawals.*, crypticusers.email, crypticusers.first_name, crypticusers.last_name 
                           FROM withdrawals 
                           JOIN crypticusers ON withdrawals.user_id = crypticusers.id 
                           WHERE withdrawals.id = ?");
    $stmt->execute([$withdrawalId]);
    $withdrawal = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$withdrawal) {
        header("Location: admin_withdrawals.php");
        exit();
    }

    $userEmail = $withdrawal['email'];
    $userName = $withdrawal['first_name'] . " " . $withdrawal['last_name'];

    // ✅ Reject Withdrawal and Store Reason
    $updateStmt = $pdo->prepare("UPDATE withdrawals SET status = 'rejected', approved_at = NOW(), admin_id = ?, rejection_reason = ? WHERE id = ?");
    $updateStmt->execute([$_SESSION["admin_id"], $rejectionReason, $withdrawalId]);

    // ✅ Prepare Email with Rejection Reason
    $subject = "Withdrawal Rejected";
    $message = "Hello $userName,\n\nYour withdrawal request of {$withdrawal['amount']} BTC has been rejected.\n\nReason: $rejectionReason\n\nPlease contact support if you need further details.";

    // ✅ Send Email Notification
    sendEmailNotification($userEmail, $userName, $subject, $message);
    header("Location: admin_withdrawals.php");
    exit();
}

// ✅ Function to Send Email
function sendEmailNotification($to, $name, $subject, $message) {
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host       = getenv('MAIL_HOST');
        $mail->SMTPAuth   = true;
        $mail->Username   = getenv('MAIL_USERNAME');
        $mail->Password   = getenv('MAIL_PASSWORD');
        $mail->SMTPSecure = getenv('MAIL_ENCRYPTION');
        $mail->Port       = getenv('MAIL_PORT');

        $mail->setFrom(getenv('MAIL_FROM_ADDRESS'), getenv('MAIL_FROM_NAME'));
        $mail->addAddress($to, $name);
        $mail->Subject = $subject;
        $mail->Body    = $message;

        $mail->send();
    } catch (Exception $e) {
        error_log("Email notification failed: " . $mail->ErrorInfo);
    }
}
?>
