<?php
include_once("../configdb.php");

// Récupérer l'id de la contribution à supprimer depuis les paramètres de la requête
$contribution_id = $_GET['id'];

// Préparation de la requête DELETE pour supprimer la contribution correspondante
$sql = "DELETE FROM Contributions WHERE id = :contribution_id";

// Préparation de la requête PDO
$stmt = $pdo->prepare($sql);

// Assignation des valeurs aux paramètres de la requête
$stmt->bindValue(':contribution_id', $contribution_id, PDO::PARAM_INT);

// Exécution de la requête
$stmt->execute();

// Vérification si la requête a réussi
if ($stmt->rowCount() > 0) {
  // La contribution a été supprimée avec succès
  echo json_encode(['message' => 'La contribution a été supprimée avec succès']);
} else {
  // La contribution n'a pas pu être supprimée
  echo json_encode(['message' => 'La contribution n\'a pas pu être supprimée']);
}
