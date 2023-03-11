<?php
include_once("../configdb.php");

// Récupérer les données de la requête POST
$postdata = file_get_contents("php://input");
$request = json_decode($postdata);

// Récupérer les valeurs à mettre à jour
$id = $request->id;
$title = $request->title;
$description = $request->description;
$category_id = $request->category_id;
$end_date = $request->end_date;
$funding_goal = $request->funding_goal;
$project_status_id = $request->project_status_id;

// Préparer la requête SQL pour mettre à jour le projet
$sql = "UPDATE Projects SET 
            title = :title,
            description = :description,
            category_id = :category_id,
            end_date = :end_date,
            funding_goal = :funding_goal,
            project_status_id = :project_status_id
        WHERE id = :id";

// Préparer et exécuter la requête préparée
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':title', $title, PDO::PARAM_STR);
$stmt->bindValue(':description', $description, PDO::PARAM_STR);
$stmt->bindValue(':category_id', $category_id, PDO::PARAM_INT);
$stmt->bindValue(':end_date', $end_date, PDO::PARAM_STR);
$stmt->bindValue(':funding_goal', $funding_goal, PDO::PARAM_STR);
$stmt->bindValue(':project_status_id', $project_status_id, PDO::PARAM_INT);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$stmt->execute();

// Vérifier si la mise à jour a été effectuée avec succès
if ($stmt->rowCount() > 0) {
    http_response_code(200);
    echo json_encode(array("message" => "Le projet a été mis à jour avec succès."));
} else {
    http_response_code(404);
    echo json_encode(array("message" => "Impossible de mettre à jour le projet."));
}
?>
