<?php
include_once("../configdb.php");

// Récupérer l'ID du projet à partir des paramètres GET
if (isset($_GET['project_id'])) {
  $project_id = $_GET['project_id'];
} else {
  http_response_code(400);
  exit();
}

// Préparer et exécuter la requête SQL pour récupérer les images liées au projet spécifique
$stmt = $pdo->prepare("SELECT * FROM Images WHERE project_id = :project_id");
$stmt->bindParam(':project_id', $project_id, PDO::PARAM_INT);
$stmt->execute();
$images = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Vérifier si des images ont été trouvées et retourner la réponse correspondante
if ($images) {
  http_response_code(200);
  echo json_encode($images);
} else {
  http_response_code(404);
  echo json_encode(["message" => "Aucune image trouvée pour ce projet"]);
}
