<?php
include_once("../configdb.php");

// Récupérer l'ID de la requête GET
$id = $_GET['id'];

// Préparer la requête DELETE
$query = "DELETE FROM Project_statuses WHERE id = :id";

// Préparer la requête à l'aide de PDO
$stmt = $pdo->prepare($query);

// Binder les paramètres de la requête
$stmt->bindParam(':id', $id);

// Exécuter la requête
if ($stmt->execute()) {
  // Afficher un message de succès
  echo "L'entrée a été supprimée avec succès.";
} else {
  // Afficher un message d'erreur
  echo "Une erreur s'est produite lors de la suppression de l'entrée.";
}
