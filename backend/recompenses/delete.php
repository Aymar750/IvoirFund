<?php
include_once("../configdb.php");

// Récupérer l'ID du projet à partir de la requête GET
$project_id = $_GET['project_id'];

// Supprimer toutes les récompenses pour ce projet à partir de la base de données
$stmt = $pdo->prepare("DELETE FROM Rewards WHERE project_id = :project_id");
$stmt->bindValue(':project_id', $project_id, PDO::PARAM_INT);
$stmt->execute();

// Envoyer une réponse au client
echo json_encode(array('message' => 'Les récompenses ont été supprimées avec succès.'));
?>
