<?php
include_once("../configdb.php");

// Récupérer l'ID de l'image à supprimer
$image_id = $_GET['id'];

// Préparer la requête SQL DELETE
$sql = "DELETE FROM Images WHERE id=:id";

// Préparer la requête PDO
$stmt = $pdo->prepare($sql);

// Liaison des paramètres
$stmt->bindParam(':id', $image_id);

// Exécuter la requête
if ($stmt->execute()) {
    // Envoyer une réponse HTTP 200 (OK)
    http_response_code(200);
    echo json_encode(array("message" => "L'image a été supprimée."));
} else {
    // Envoyer une réponse HTTP 500 (Internal Server Error)
    http_response_code(500);
    echo json_encode(array("message" => "Impossible de supprimer l'image."));
}
?>
