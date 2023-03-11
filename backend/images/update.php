<?php
include_once("../configdb.php");

// Récupérer l'ID de l'image à partir des paramètres GET
if (isset($_GET['id'])) {
    $image_id = $_GET['id'];
} else {
    http_response_code(400);
    exit();
}

// Récupérer les données de la requête POST
$postdata = file_get_contents("php://input");
if(isset($postdata) && !empty($postdata)) {
    $request = json_decode($postdata);

    // Vérifier que toutes les données requises ont été fournies
    if (!isset($request->filename) || !isset($request->filetype) || !isset($request->file_path)) {
        http_response_code(400);
        exit();
    }

    // Préparer et exécuter la requête SQL pour mettre à jour l'image spécifique
    $stmt = $pdo->prepare("UPDATE Images SET filename = :filename, filetype = :filetype, file_path = :file_path, description = :description WHERE id = :id");
    $stmt->bindParam(':id', $image_id, PDO::PARAM_INT);
    $stmt->bindParam(':filename', $request->filename, PDO::PARAM_STR);
    $stmt->bindParam(':filetype', $request->filetype, PDO::PARAM_STR);
    $stmt->bindParam(':file_path', $request->file_path, PDO::PARAM_STR);
    $stmt->bindParam(':description', $request->description, PDO::PARAM_STR);
    $stmt->execute();

    // Vérifier si l'image a été mise à jour et retourner la réponse correspondante
    if ($stmt->rowCount() > 0) {
        http_response_code(200);
        echo json_encode(["message" => "L'image a été mise à jour avec succès"]);
    } else {
        http_response_code(404);
        echo json_encode(["message" => "Aucune image trouvée avec cet ID"]);
    }
} else {
  http_response_code(400);
  exit();
}
