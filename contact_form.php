<?php
header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request.']);
    exit;
}

$name = $_POST['full_name'] ?? '';
$email = $_POST['email'] ?? '';
$subject = $_POST['subject'] ?? 'No subject';
$message = $_POST['message'] ?? '';

if (!$name || !$email || !$message) {
    echo json_encode(['status' => 'error', 'message' => 'Please fill all required fields.']);
    exit;
}

// Email setup
$to = 'hello@muntmogul.com';  // Destination email
$headers = "From: $name <$email>\r\n";
$headers .= "Reply-To: $email\r\n";
$headers .= "Content-type: text/html; charset=UTF-8\r\n";

$body = "
    <h3>New Contact Submission</h3>
    <p><strong>Name:</strong> $name</p>
    <p><strong>Email:</strong> $email</p>
    <p><strong>Subject:</strong> $subject</p>
    <p><strong>Message:</strong><br>$message</p>
";

$sent = mail($to, "New Form Submission: $subject", $body, $headers);

if ($sent) {
    echo json_encode(['status' => 'success', 'message' => 'Message sent successfully!']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Something went wrong. Please try again later.']);
}
