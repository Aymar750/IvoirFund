<?php
include_once("../configdb.php");

// Requête SELECT pour récupérer toutes les catégories de projets
$query = "SELECT * FROM Project_categories";

// Exécute la requête
$stmt = $pdo->query($query);

// Tableau pour stocker les résultats
$categories = array();

// Parcours des résultats et stockage dans le tableau
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $categories[] = $row;
}

// Convertit le tableau en JSON et renvoie la réponse au client
echo json_encode($categories);
?>
