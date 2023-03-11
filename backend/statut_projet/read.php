<?php
include_once("../configdb.php");

// Préparer la requête SELECT
$query = "SELECT * FROM Project_statuses";

// Exécuter la requête
$stmt = $pdo->query($query);

// Récupérer les résultats de la requête
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Afficher les résultats au format JSON
echo json_encode($results);
