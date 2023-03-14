<?php

include_once("../configdb.php");

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit();
}
// Récupération des données du formulaire d'inscription
$postdata = file_get_contents("php://input");
$request = json_decode($postdata);

// Vérification que les données sont valides
if(isset($request->name) && isset($request->email) && isset($request->password)) {
    $name = htmlspecialchars($request->name) ;
    $email = htmlspecialchars($request->email) ;
    $password = password_hash($request->password, PASSWORD_DEFAULT);

    // Vérification que l'utilisateur n'existe pas déjà
    $query = $pdo->prepare("SELECT * FROM users WHERE name = :name OR email = :email");
    $query->execute(['name' => $name, 'email' => $email]);

    if($query->rowCount() > 0) {
        http_response_code(409);
        echo json_encode(['message' => 'Cet utilisateur existe déjà']);
        exit();
    }

    // Insertion des données de l'utilisateur dans la base de données
    $query = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (:name, :email, :password)");
    $result = $query->execute(['name' => $name, 'email' => $email, 'password' => $password]);

    if($result) {
        http_response_code(201);
        echo json_encode(['message' => 'Utilisateur créé avec succès']);
        // exit();
        return json_encode(['message' => 'Utilisateur créé avec succès']);
    } else {
        http_response_code(500);
        echo json_encode(['message' => 'Une erreur est survenue lors de la création de l\'utilisateur']);
        exit();
    }
} else {
    http_response_code(400);
    echo json_encode(['message' => 'Données invalides']);
    exit();
}
