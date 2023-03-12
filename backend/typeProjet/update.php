<?php
include_once("../configdb.php");

// Récupérer les données de la requête POST
$postdata = file_get_contents("php://input");

if(isset($postdata) && !empty($postdata)) {
    // Convertir les données reçues en format JSON en un tableau associatif PHP
    $request = json_decode($postdata, true);

    // Vérifier que toutes les données nécessaires ont été envoyées
    if(empty($request['id']) || empty($request['name'])) {
        // Si toutes les données nécessaires ne sont pas envoyées, renvoyer une réponse avec un code de statut "mauvaise requête"
        http_response_code(400);
        echo json_encode(array("message" => "Impossible de mettre à jour le type de financement. Les données sont incomplètes."));
    }
    else {
        // Préparer une requête UPDATE pour mettre à jour le type de financement
        $sql = "UPDATE funding_type SET name=:name WHERE id=:id";

        // Préparer la requête pour l'exécution avec PDO
        $stmt = $pdo->prepare($sql);

        // Lier les valeurs des paramètres à la requête préparée
        $stmt->bindValue(':id', $request['id'], PDO::PARAM_INT);
        $stmt->bindValue(':name', $request['name'], PDO::PARAM_STR);

        // Exécuter la requête préparée
        if($stmt->execute()) {
            // Si la requête s'est exécutée avec succès, renvoyer une réponse avec un code de statut "OK"
            http_response_code(200);
            echo json_encode(array("message" => "Le type de financement a été mis à jour avec succès."));
        }
        else {
            // Si la requête n'a pas pu s'exécuter, renvoyer une réponse avec un code de statut "erreur interne du serveur"
            http_response_code(500);
            echo json_encode(array("message" => "Impossible de mettre à jour le type de financement. Une erreur interne du serveur est survenue."));
        }
    }
}
else {
    // Si aucune donnée n'a été envoyée dans la requête, renvoyer une réponse avec un code de statut "mauvaise requête"
    http_response_code(400);
    echo json_encode(array("message" => "Impossible de mettre à jour le type de financement. Aucune donnée n'a été envoyée."));
}
?>
