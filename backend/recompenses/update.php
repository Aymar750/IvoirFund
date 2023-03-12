<?php
include_once("../configdb.php");

// Récupérer les données de la requête PUT
$postdata = file_get_contents("php://input");
$request = json_decode($postdata);

// Vérifier que les données requises sont présentes
if (!isset($request->id) || !isset($request->title) || !isset($request->description) || !isset($request->minimum_amount) || !isset($request->quantity_available) || !isset($request->project_id)) {
    http_response_code(400);
    echo json_encode(array("message" => "Impossible de mettre à jour la récompense. Les données sont incomplètes."));
    exit();
}

// Préparer la requête SQL
$sql = "UPDATE Rewards SET title = :title, description = :description, minimum_amount = :minimum_amount, quantity_available = :quantity_available, project_id = :project_id WHERE id = :id";

// Préparer les valeurs de la requête
$id = intval($request->id);
$title = $request->title;
$description = $request->description;
$minimum_amount = floatval($request->minimum_amount);
$quantity_available = intval($request->quantity_available);
$project_id = intval($request->project_id);

// Exécuter la requête SQL
$stmt = $pdo->prepare($sql);
$stmt->bindParam(":id", $id);
$stmt->bindParam(":title", $title);
$stmt->bindParam(":description", $description);
$stmt->bindParam(":minimum_amount", $minimum_amount);
$stmt->bindParam(":quantity_available", $quantity_available);
$stmt->bindParam(":project_id", $project_id);
if ($stmt->execute()) {
    http_response_code(200);
    echo json_encode(array("message" => "Récompense mise à jour avec succès."));
} else {
    http_response_code(500);
    echo json_encode(array("message" => "Impossible de mettre à jour la récompense."));
}
