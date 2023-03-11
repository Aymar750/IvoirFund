<?php
include_once("../configdb.php");

// Récupérer l'ID du projet à supprimer
$id = $_GET['id'];

// Requête SQL pour supprimer le projet correspondant à l'ID
$sql = "DELETE FROM Projects WHERE id = :id";

// Préparation de la requête
$stmt = $pdo->prepare($sql);

// Exécution de la requête avec la valeur de l'ID en paramètre
$stmt->execute(['id' => $id]);

// Vérification du nombre de lignes affectées par la suppression
if ($stmt->rowCount() > 0) {
    // Le projet a été supprimé avec succès
    echo json_encode(['message' => 'Le projet a été supprimé avec succès']);
} else {
    // Aucune ligne n'a été supprimée
    echo json_encode(['message' => 'La suppression a échoué']);
}
?>
