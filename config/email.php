<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require 'PHPMailer/src/Exception.php';

// Load `.env` Variables
require_once 'config/config.php';

// Get Mail Settings from `.env`
$smtp_host = getenv("MAIL_HOST");
$smtp_user = getenv("MAIL_USERNAME");
$smtp_pass = getenv("MAIL_PASSWORD");
$smtp_port = getenv("MAIL_PORT");
$smtp_from = getenv("MAIL_FROM_ADDRESS");

function sendEmail($to, $subject, $message) {
    global $smtp_host, $smtp_user, $smtp_pass, $smtp_port, $smtp_from;

    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = $smtp_host;
        $mail->SMTPAuth = true;
        $mail->Username = $smtp_user;
        $mail->Password = $smtp_pass;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = $smtp_port;

        $mail->setFrom($smtp_from, 'Crypto Platform');
        $mail->addAddress($to);

        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $message;

        $mail->send();
    } catch (Exception $e) {
        error_log("Email Error: " . $mail->ErrorInfo);
    }
}
?>
