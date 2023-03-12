<?php
include_once("../configdb.php");

// Récupérer les données de la requête POST
$postdata = file_get_contents("php://input");

// Vérifier que les données ont bien été récupérées
if(isset($postdata) && !empty($postdata)) {
    // Convertir les données JSON en tableau associatif PHP
    $request = json_decode($postdata, true);

    // Vérifier que toutes les données requises sont présentes dans la requête
    if(isset($request['user_id'])
        && isset($request['project_id'])
        && isset($request['content'])) {
        
        // Préparer la requête SQL pour insérer un nouveau commentaire
        $sql = "INSERT INTO Comments (user_id, project_id, content) VALUES (:user_id, :project_id, :content)";

        // Préparer et exécuter la requête avec PDO
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':user_id', $request['user_id']);
        $stmt->bindParam(':project_id', $request['project_id']);
        $stmt->bindParam(':content', $request['content']);
        $stmt->execute();

        // Récupérer l'ID du nouveau commentaire inséré
        $comment_id = $pdo->lastInsertId();

        // Récupérer les informations sur le commentaire inséré et les renvoyer au client sous forme de JSON
        $sql = "SELECT * FROM Comments WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $comment_id);
        $stmt->execute();
        $comment = $stmt->fetch(PDO::FETCH_ASSOC);
        echo json_encode($comment);

    } else {
        // Si des données requises sont manquantes, renvoyer une erreur
        http_response_code(400);
        echo "Missing required data.";
    }
} else {
    // Si la requête POST est vide, renvoyer une erreur
    http_response_code(400);
    echo "Empty request.";
}
?>
