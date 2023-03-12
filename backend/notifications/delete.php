<?php
include_once("../configdb.php");

// Vérifier si l'id de la notification est spécifié dans l'URL
if(isset($_GET['id'])) {
    $id = $_GET['id'];

    // Préparer la requête SQL pour supprimer la notification correspondante
    $sql = "DELETE FROM Notifications WHERE id = :id";

    // Utiliser PDO pour préparer la requête
    $stmt = $pdo->prepare($sql);

    // Binder les paramètres de la requête
    $stmt->bindParam(':id', $id);

    // Exécuter la requête
    if($stmt->execute()) {
        // Notification supprimée avec succès
        echo json_encode(["success" => true, "message" => "Notification supprimée avec succès"]);
    } else {
        // Erreur lors de la suppression de la notification
        echo json_encode(["success" => false, "message" => "Erreur lors de la suppression de la notification"]);
    }
} else {
    // L'id de la notification n'est pas spécifié dans l'URL
    echo json_encode(["success" => false, "message" => "L'id de la notification n'est pas spécifié dans l'URL"]);
}
