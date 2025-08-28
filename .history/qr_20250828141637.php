<?php
$qrImage = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $amount = floatval($_POST['amount']);
    if ($amount <= 0) {
        $error = "Please enter a valid donation amount.";
    } else {
        // Merchant credentials
        $merchantId = "keng.dara.online";
        $apiSecret  = "YOUR_API_SECRET";

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

        // cURL request
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => 'https://checkout-sandbox.payway.com.kh/api/payment-gateway/v1/payments/generate-qr',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => json_encode($payload, JSON_UNESCAPED_SLASHES),
            CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
        ]);

        $response = curl_exec($curl);
        if (curl_errno($curl)) {
            $error = 'Curl error: ' . curl_error($curl);
        } else {
            $data = json_decode($response, true);
            if (isset($data['qr_image'])) {
                $qrImage = $data['qr_image'];
            } else {
                $error = 'Error generating QR: ' . $response;
            }
        }
        curl_close($curl);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Donate via ABA QR</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f9f9f9;
            text-align: center;
            padding: 50px;
        }

        .donate-box {
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            display: inline-block;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        input[type=number] {
            padding: 10px;
            width: 150px;
            font-size: 16px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        button {
            padding: 10px 20px;
            font-size: 16px;
            background: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background: #45a049;
        }

        .error {
            color: red;
            margin: 10px 0;
        }

        img.qr {
            margin-top: 20px;
            border: 2px solid #eee;
            padding: 10px;
            border-radius: 10px;
        }
    </style>
</head>

<body>

    <div class="donate-box">
        <h2>Donate via ABA QR</h2>
        <?php if ($error): ?>
            <div class="error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        <form method="post">
            <input type="number" step="0.01" name="amount" placeholder="Enter amount USD" required>
            <button type="submit">Generate QR</button>
        </form>

        <?php if ($qrImage): ?>
            <h3>Scan this QR to donate:</h3>
            <img class="qr" src="data:image/png;base64,<?= $qrImage ?>" alt="ABA QR Code">
        <?php endif; ?>
    </div>

</body>

</html>