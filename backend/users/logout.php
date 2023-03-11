<?php
include_once("../jwt.php");

// Récupération du jeton d'authentification dans l'en-tête de la requête
if (!isset($_SERVER['HTTP_AUTHORIZATION'])) {
    http_response_code(401);
    echo json_encode(['message' => 'Aucun jeton d\'authentification fourni']);
    exit;
}


$jwt_token = $_SERVER['HTTP_AUTHORIZATION'];

// Décodage du jeton d'authentification pour récupérer l'identifiant de l'utilisateur
try {
    $jwt_secret = bin2hex(random_bytes(32));
    $jwt_payload = jwt_decode($jwt_token, $jwt_secret);

    // Destruction du jeton d'authentification en mettant la date d'expiration dans le passé
    $jwt_payload['exp'] = time() - 1;
    $jwt_token = jwt_encode($jwt_payload, $jwt_secret);

    http_response_code(200);
    echo json_encode(['message' => 'Déconnexion réussie']);
} catch (Exception $e) {
    http_response_code(401);
    echo json_encode(['message' => 'Jeton d\'authentification invalide']);
}