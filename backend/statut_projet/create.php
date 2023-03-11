<?php
include_once("../configdb.php");

// Récupérer les données de la requête POST
$postdata = file_get_contents("php://input");

if(isset($postdata) && !empty($postdata)) {
    // Convertir les données JSON en un tableau associatif PHP
    $data = json_decode($postdata, true);

    // Vérifier que les données requises sont présentes
    if(empty($data['name']) || empty($data['description'])) {
        http_response_code(400);
        echo json_encode(array("message" => "Des données sont manquantes."));
        exit;
    }

    // Préparer la requête SQL d'insertion dans la table Project_statuses
    $sql = "INSERT INTO project_statuses (name, description) VALUES (:name, :description)";
    $stmt = $pdo->prepare($sql);

    // Liaison des paramètres de la requête SQL avec les valeurs correspondantes
    $stmt->bindParam(":name", $data['name']);
    $stmt->bindParam(":description", $data['description']);

    // Exécuter la requête SQL d'insertion dans la table Project_statuses
    if($stmt->execute()) {
        http_response_code(201);
        echo json_encode(array("message" => "La nouvelle entrée a été ajoutée avec succès."));
    } else {
        http_response_code(500);
        echo json_encode(array("message" => "Une erreur est survenue lors de l'ajout de la nouvelle entrée."));
    }
} else {
    http_response_code(400);
    echo json_encode(array("message" => "Aucune donnée n'a été reçue."));
}
?>
