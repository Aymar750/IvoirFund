<?php
include_once("../configdb.php");

// Requête SQL pour sélectionner tous les projets
$sql = "SELECT * FROM Projects";

// Exécution de la requête
$stmt = $pdo->query($sql);

// Récupération des résultats de la requête
$projects = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Affichage des résultats
echo json_encode($projects);
?>
