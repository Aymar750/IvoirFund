<?php
include_once("../configdb.php");

// Récupérer les données de la requête POST
$postdata = file_get_contents("php://input");

if(isset($postdata) && !empty($postdata)) {
    // Convertir les données JSON en objet PHP
    $request = json_decode($postdata);

    // Vérifier que les champs obligatoires sont présents
    if(empty($request->id) || empty($request->content)) {
        http_response_code(400);
        echo json_encode(array("message" => "Champs obligatoires manquants."));
    }
    else {
        try {
            // Préparer la requête SQL
            $sql = "UPDATE comments SET content = :content WHERE id = :id";

            // Préparer la requête PDO
            $stmt = $pdo->prepare($sql);

            // Bind des valeurs
            $stmt->bindValue(':id', $request->id, PDO::PARAM_INT);
            $stmt->bindValue(':content', $request->content, PDO::PARAM_STR);

            // Exécution de la requête
            $stmt->execute();

            // Envoyer une réponse 200 OK au client
            http_response_code(200);
            echo json_encode(array("message" => "Le commentaire a été mis à jour."));
        }
        catch(PDOException $e) {
            // Envoyer une réponse 500 Internal Server Error au client en cas d'erreur PDO
            http_response_code(500);
            echo json_encode(array("message" => "Impossible de mettre à jour le commentaire : " . $e->getMessage()));
        }
    }
}
else {
    // Envoyer une réponse 400 Bad Request au client en cas de données manquantes
    http_response_code(400);
    echo json_encode(array("message" => "Aucune donnée reçue."));
}
