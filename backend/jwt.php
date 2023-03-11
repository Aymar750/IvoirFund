<?php
// Encode un tableau associatif en jeton JWT
function jwt_encode($payload, $secret) {
    $header = base64_encode(json_encode(['typ' => 'JWT', 'alg' => 'HS256']));
    $payload = base64_encode(json_encode($payload));
    $signature = hash_hmac('sha256', "$header.$payload", $secret, true);
    $signature = base64_encode($signature);
    return "$header.$payload.$signature";
}

// Decode un jeton JWT et retourne le tableau associatif correspondant
function jwt_decode($token, $secret) {
    $parts = explode('.', $token);
    $header = base64_decode($parts[0]);
    $payload = base64_decode($parts[1]);
    $signature = $parts[2];

    // Vérification de la signature
    $expected_signature = hash_hmac('sha256', "$parts[0].$parts[1]", $secret, true);
    $expected_signature = base64_encode($expected_signature);
    if($signature !== $expected_signature) {
        return null;
    }

    return json_decode($payload, true);
}
