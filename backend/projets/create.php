<?php
include_once("../configdb.php");

// Récupérer les données de la requête POST
$postdata = file_get_contents("php://input");

// Vérifier si les données sont valides
if(isset($postdata) && !empty($postdata)) {
    // Convertir les données en objet PHP
    $data = json_decode($postdata);

    // Vérifier si toutes les données nécessaires sont présentes
    if (
        isset($data->user_id)
        && isset($data->title)
        && isset($data->description)
        && isset($data->category_id)
        && isset($data->end_date)
        && isset($data->funding_goal)
        && isset($data->project_status_id)
    ) {
        // Préparer la requête SQL d'insertion dans la table Projects
        $sql = "INSERT INTO Projects (user_id, title, description, category_id, end_date, funding_goal, project_status_id)
                VALUES (:user_id, :title, :description, :category_id, :end_date, :funding_goal, :project_status_id)";

        try {
            // Préparer la requête SQL avec PDO
            $stmt = $pdo->prepare($sql);

            // Lier les paramètres à la requête SQL
            $stmt->bindParam(":user_id", $data->user_id, PDO::PARAM_INT);
            $stmt->bindParam(":title", $data->title, PDO::PARAM_STR);
            $stmt->bindParam(":description", $data->description, PDO::PARAM_STR);
            $stmt->bindParam(":category_id", $data->category_id, PDO::PARAM_INT);
            $stmt->bindParam(":end_date", $data->end_date, PDO::PARAM_STR);
            $stmt->bindParam(":funding_goal", $data->funding_goal, PDO::PARAM_STR);
            $stmt->bindParam(":project_status_id", $data->project_status_id, PDO::PARAM_INT);

            // Exécuter la requête SQL
            $stmt->execute();

            // Récupérer l'ID du nouveau projet inséré
            $project_id = $pdo->lastInsertId();

            // Envoyer une réponse JSON avec l'ID du nouveau projet inséré
            echo json_encode(array('message' => 'Le projet a été créé avec succès', 'project_id' => $project_id));
        } catch(PDOException $e) {
            // Envoyer une réponse JSON avec l'erreur rencontrée
            echo json_encode(array('message' => 'Erreur lors de la création du projet : ' . $e->getMessage()));
        }
    } else {
        // Envoyer une réponse JSON avec un message d'erreur
        echo json_encode(array('message' => 'Toutes les données nécessaires n\'ont pas été fournies'));
    }
} else {
    // Envoyer une réponse JSON avec un message d'erreur
    echo json_encode(array('message' => 'Aucune donnée n\'a été fournie'));
}
