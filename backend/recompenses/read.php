<?php
include_once("../configdb.php");

// Récupérer l'ID du projet à partir de la requête GET
$project_id = $_GET['project_id'];

// Sélectionner toutes les récompenses pour ce projet à partir de la base de données
$stmt = $pdo->prepare("SELECT * FROM Rewards WHERE project_id = :project_id");
$stmt->bindValue(':project_id', $project_id, PDO::PARAM_INT);
$stmt->execute();
$rewards = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Envoyer les récompenses au client sous forme de JSON
echo json_encode($rewards);
?>
