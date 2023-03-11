<?php
include_once("../configdb.php");

// Récupérer les données de la requête POST
$postdata = file_get_contents("php://input");
$request = json_decode($postdata);

// Vérifier que toutes les données sont présentes
if (isset($request->id) && isset($request->user_id) && isset($request->project_id) && isset($request->amount)) {
    // Préparer la requête SQL
    $sql = "UPDATE Contributions SET user_id = :user_id, project_id = :project_id, amount = :amount WHERE id = :id";
    
    // Exécuter la requête
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':user_id', $request->user_id, PDO::PARAM_INT);
    $stmt->bindValue(':project_id', $request->project_id, PDO::PARAM_INT);
    $stmt->bindValue(':amount', $request->amount, PDO::PARAM_STR);
    $stmt->bindValue(':id', $request->id, PDO::PARAM_INT);
    $result = $stmt->execute();
    
    // Vérifier si la requête a été exécutée avec succès
    if ($result) {
        // Retourner un message de succès
        http_response_code(200);
        echo json_encode(array("message" => "La contribution a été mise à jour avec succès."));
    } else {
        // Retourner un message d'erreur
        http_response_code(500);
        echo json_encode(array("message" => "Impossible de mettre à jour la contribution."));
    }
} else {
    // Retourner un message d'erreur si les données sont incomplètes
    http_response_code(400);
    echo json_encode(array("message" => "Impossible de mettre à jour la contribution. Données incomplètes."));
}
