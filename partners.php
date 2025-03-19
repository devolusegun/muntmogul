<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MuntMogul Partner Registration</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body { background-color: #f8f9fa; }
        .container { max-width: 600px; margin-top: 50px; }
        .card { padding: 20px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="card shadow">
            <h3 class="text-center">Become a MuntMogul Partner</h3>
            <p class="text-center text-muted">Fill out the form below to apply.</p>
            <form id="partnerForm" action="process_partner.php" method="POST">
                
                <!-- Personal Information -->
                <div class="mb-3">
                    <label>Full Name</label>
                    <input type="text" class="form-control" name="full_name" required>
                </div>
                <div class="mb-3">
                    <label>Date of Birth</label>
                    <input type="date" class="form-control" name="dob" required>
                </div>
                <div class="mb-3">
                    <label>Email Address</label>
                    <input type="email" class="form-control" name="email" required>
                </div>
                <div class="mb-3">
                    <label>Phone Number</label>
                    <input type="tel" class="form-control" name="phone" required>
                </div>
                <div class="mb-3">
                    <label>Home Address</label>
                    <input type="text" class="form-control" name="address" required>
                </div>
                <div class="mb-3">
                    <label>Country of Residence</label>
                    <input type="text" class="form-control" name="country" required>
                </div>
                
                <!-- More Information -->
                <div class="mb-3">
                    <label>Why would you like to be a MuntMogul Partner?</label>
                    <textarea class="form-control" name="reason" required></textarea>
                </div>
                <div class="mb-3">
                    <label>Do you have experience buying/selling cryptocurrency?</label>
                    <select class="form-select" name="crypto_experience" required>
                        <option value="Yes">Yes</option>
                        <option value="No">No</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label>Which cryptocurrency platforms have you used?</label>
                    <select class="form-select" name="crypto_platforms" multiple required>
                        <option value="Crypto.com">Crypto.com</option>
                        <option value="Binance">Binance</option>
                        <option value="Coinbase">Coinbase</option>
                        <option value="Kraken">Kraken</option>
                        <option value="Other">Other (Specify Below)</option>
                    </select>
                    <input type="text" class="form-control mt-2" name="other_platform" placeholder="If Other, specify...">
                </div>
                <div class="mb-3">
                    <label>Have you ever facilitated third-party transactions in cryptocurrency?</label>
                    <select class="form-select" name="third_party" required>
                        <option value="Yes">Yes</option>
                        <option value="No">No</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label>Are you comfortable assisting investors with cryptocurrency purchases and deposits?</label>
                    <select class="form-select" name="assist_investors" required>
                        <option value="Yes">Yes</option>
                        <option value="No">No</option>
                    </select>
                </div>
                
                <button type="submit" class="btn btn-primary w-100">Submit Application</button>
            </form>
        </div>
    </div>
</body>
</html>
