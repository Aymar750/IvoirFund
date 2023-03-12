<?php
include_once("../configdb.php");

// Récupérer les données de la requête POST
$postdata = file_get_contents("php://input");
$request = json_decode($postdata);

// Vérifier que les champs obligatoires ont été renseignés
if (!isset($request->name)) {
    http_response_code(400);
    echo json_encode(["message" => "Le champ 'name' est obligatoire"]);
    exit();
}

// Créer la requête SQL pour insérer un nouvel enregistrement
$sql = "INSERT INTO funding_type (name) VALUES (:name)";
$stmt = $pdo->prepare($sql);

// Binder les paramètres de la requête
$stmt->bindParam(":name", $request->name);

// Exécuter la requête
if ($stmt->execute()) {
    // Retourner la nouvelle ressource créée
    $id = $pdo->lastInsertId();
    http_response_code(201);
    echo json_encode(["id" => $id]);
} else {
    // Retourner une erreur en cas d'échec de l'exécution de la requête
    http_response_code(500);
    echo json_encode(["message" => "Une erreur est survenue lors de la création de la ressource"]);
}
?>
