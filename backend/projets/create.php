<?php
include_once("../configdb.php");


// Récupérer les données de la requête POST
$postdata = file_get_contents("php://input");

echo json_encode($postdata);
// Vérifier si les données sont valides
if(isset($postdata) && !empty($postdata)) {
    // Convertir les données en objet PHP
    $data = json_decode($postdata);
    $data->user_id= 5;
    $data->title= "Projet Y";
    $data->description= "je";
    $data->category_name= "Sport";
    $data->end_date="2023-05-06";
    $data->funding_goal="5000000";
    $data->project_status_name="En cours";
    $data->funding_type_name="Financement en capital";

    // Vérifier si toutes les données nécessaires sont présentes
    if (
        isset($data->user_id)
        && isset($data->title)
        && isset($data->description)
        && isset($data->category_name)
        && isset($data->end_date)
        && isset($data->funding_goal)
        && isset($data->project_status_name)
        && isset($data->funding_type_name)

    ) {

        
        $query_category = "SELECT id FROM project_categories WHERE name = :category_name";
        $stmt_category = $pdo->prepare($query_category);
        $stmt_category->bindParam(':category_name', $data->category_name, PDO::PARAM_STR);
        $stmt_category->execute();
        $category_id = $stmt_category->fetchColumn();
    
        $query_project_status = "SELECT id FROM project_statuses WHERE name = :project_status_name";
        $stmt_statut = $pdo->prepare($query_project_status);
        $stmt_statut->bindParam(':project_status_name', $data->project_status_name);
        $stmt_statut->execute();
        $statut_id = $stmt_statut->fetchColumn();

        $query_fund = "SELECT id FROM funding_types WHERE name =:funding_type_name";
        $stmt_fund = $pdo->prepare($query_fund);
        $stmt_fund->bindParam(':funding_type_name',$data->funding_type_name);
        $stmt_fund->execute();
        $fund_id = $stmt_fund->fetchColumn();

        // Préparer la requête SQL d'insertion dans la table Projects
        $sql = "INSERT INTO Projects (user_id, title, description, category_id, end_date, funding_goal, project_status_id,funding_type_id)
                VALUES (:user_id, :title, :description, :category_id, :end_date, :funding_goal, :project_status_id,:funding_type_id)";

        try {
            // Préparer la requête SQL avec PDO
            $stmt = $pdo->prepare($sql);

            // Lier les paramètres à la requête SQL
            $stmt->bindParam(":user_id", $data->user_id, PDO::PARAM_INT);
            $stmt->bindParam(":title", $data->title, PDO::PARAM_STR);
            $stmt->bindParam(":description", $data->description, PDO::PARAM_STR);
            $stmt->bindParam(":category_id", $category_id , PDO::PARAM_INT);
            $stmt->bindParam(":end_date", $data->end_date, PDO::PARAM_STR);
            $stmt->bindParam(":funding_goal", $data->funding_goal, PDO::PARAM_STR);
            $stmt->bindParam(":project_status_id", $statut_id , PDO::PARAM_INT);
            $stmt->bindParam(":funding_type_id", $fund_id, PDO::PARAM_INT);

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

