<?php
// Fixed donation amount
$amount = 1.00; // USD

// Merchant credentials
$merchantId = "keng.dara.online";
$apiSecret  = "YOUR_API_SECRET"; // ABA API secret key

// Dynamic request time and transaction ID
$reqTime = date('YmdHis');
$tranId  = date('YmdHis') . rand(1000, 9999);

// Callback URL (Base64)
$callbackUrl = base64_encode("https://yourdomain.com/notify");

// Prepare payload
$payload = [
    "req_time" => $reqTime,
    "merchant_id" => $merchantId,
    "tran_id" => $tranId,
    "first_name" => "Donor",
    "last_name" => "Anonymous",
    "email" => "donor@example.com",
    "phone" => "012345678",
    "amount" => $amount,
    "purchase_type" => "purchase",
    "payment_option" => "abapay_khqr",
    "currency" => "USD",
    "callback_url" => $callbackUrl,
    "return_deeplink" => null,
    "custom_fields" => null,
    "return_params" => null,
    "payout" => null,
    "lifetime" => 6,
    "qr_image_template" => "template3_color"
];

// Generate hash
$payload["hash"] = base64_encode(hash_hmac(
    'sha256',
    json_encode($payload, JSON_UNESCAPED_SLASHES),
    $apiSecret,
    true
));

// Initialize cURL
$curl = curl_init();
curl_setopt_array($curl, [
    CURLOPT_URL => 'https://checkout-sandbox.payway.com.kh/api/payment-gateway/v1/payments/generate-qr',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => json_encode($payload, JSON_UNESCAPED_SLASHES),
    CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
]);

$response = curl_exec($curl);
curl_close($curl);

$data = json_decode($response, true);
$qrImage = $data['qr_image'] ?? '';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Donation QR</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            padding: 50px;
            background: #f9f9f9;
        }

        .qr-box {
            display: inline-block;
            background: #fff;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        img.qr {
            border: 2px solid #eee;
            padding: 10px;
            border-radius: 10px;
        }
    </style>
</head>

<body>

    <div class="qr-box">
        <h2>Donate $<?= number_format($amount, 2) ?> via ABA QR</h2>
        <?php if ($qrImage): ?>
            <img class="qr" src="data:image/png;base64,<?= $qrImage ?>" alt="ABA QR Code">
        <?php else: ?>
            <p>Unable to generate QR code.</p>
        <?php endif; ?>
    </div>

</body>

</html>