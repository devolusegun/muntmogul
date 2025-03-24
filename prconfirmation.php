<?php
//session_start();
require 'config/config.php';

if (!isset($_SESSION["user"])) {
    header("Location: login");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Withdrawal Confirmation</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  
  <!-- Bootstrap & Animation CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: #f4f7fe;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      font-family: 'Segoe UI', sans-serif;
    }

    .confirmation-card {
      background: #ffffff;
      padding: 40px 30px;
      border-radius: 12px;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
      text-align: center;
      max-width: 400px;
      width: 90%;
      animation: fadeInUp 0.6s ease;
    }

    .checkmark-circle {
      width: 80px;
      height: 80px;
      border-radius: 50%;
      display: inline-block;
      background: #28a745;
      color: #fff;
      font-size: 40px;
      line-height: 80px;
      margin-bottom: 20px;
    }

    @keyframes fadeInUp {
      from {
        transform: translateY(30px);
        opacity: 0;
      }
      to {
        transform: translateY(0);
        opacity: 1;
      }
    }

    .spinner-border {
      width: 2rem;
      height: 2rem;
    }

    .redirecting {
      font-size: 0.9rem;
      color: #777;
      margin-top: 10px;
    }
  </style>
</head>
<body>

  <div class="confirmation-card">
    <div class="checkmark-circle">
      ✔
    </div>
    <h4 class="text-success">Withdrawal Request Sent</h4>
    <p class="mb-3">Your request is being processed. You'll be notified once approved.</p>
    <div class="spinner-border text-success" role="status">
      <span class="visually-hidden">Loading...</span>
    </div>
    <div class="redirecting">Redirecting to dashboard...</div>
  </div>

  <!-- Redirect to dashboard -->
  <script>
    setTimeout(function () {
      window.location.href = "dashboard";
    }, 4000); // Redirect after 4 seconds
  </script>

</body>
</html>
