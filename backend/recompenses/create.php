<?php
include_once("../configdb.php");

// Récupérer les données de la requête POST
$postdata = file_get_contents("php://input");
$request = json_decode($postdata);

// Vérifier que toutes les données requises sont présentes
if (!isset($request->project_id) || !isset($request->title) || !isset($request->description) || !isset($request->minimum_amount) || !isset($request->quantity_available)) {
    http_response_code(400);
    echo json_encode(array("message" => "Toutes les données requises doivent être fournies."));
    exit;
}

// Préparer la requête SQL d'insertion
$sql = "INSERT INTO rewards (project_id, title, description, minimum_amount, quantity_available) VALUES (:project_id, :title, :description, :minimum_amount, :quantity_available)";
$stmt = $pdo->prepare($sql);

// Bind des paramètres de la requête
$stmt->bindParam(":project_id", $request->project_id, PDO::PARAM_INT);
$stmt->bindParam(":title", $request->title, PDO::PARAM_STR);
$stmt->bindParam(":description", $request->description, PDO::PARAM_STR);
$stmt->bindParam(":minimum_amount", $request->minimum_amount, PDO::PARAM_STR);
$stmt->bindParam(":quantity_available", $request->quantity_available, PDO::PARAM_INT);

// Exécution de la requête
if ($stmt->execute()) {
    http_response_code(201);
    echo json_encode(array("message" => "La récompense a été créée avec succès."));
} else {
    http_response_code(500);
    echo json_encode(array("message" => "Impossible de créer la récompense."));
}
