<?php
define( 'UP_INSTAGRAM_SECRET', 'hF$d3JA)D)42(c1*)q3bMsb!' );
function generateJwt($sharedKey, $payload) {
    $header = base64_encode(json_encode(['alg' => 'HS256', 'typ' => 'JWT']));
    $body = base64_encode(json_encode($payload));
    $signature = hash_hmac('sha256', "$header.$body", $sharedKey, true);
    return "$header.$body." . base64_encode($signature);
}

$sharedKey = UP_INSTAGRAM_SECRET;
$payload = [
    'timestamp' => time(),
    'nonce' => 'jititjtijij',
    'site_url' => 'https://localhost:4444/',
    'plugin_version' => '1.0.0'
];
$jwt = generateJwt($sharedKey, $payload);

// Send cURL request
$ch = curl_init('https://ig-connect.uphotel.agency');
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, ['up_instagram_pre_auth' => true,'token' => $jwt]);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);

// Handle cURL errors
if (curl_errno($ch)) {
    wp_send_json_error(['message' => 'cURL error: ' . curl_error($ch)]);
    curl_close($ch);
    return;
}

// Close cURL and send the response
curl_close($ch);

print_r($response);
