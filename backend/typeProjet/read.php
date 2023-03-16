<?php
include_once("../configdb.php");

// Requête SQL pour récupérer tous les types de financement
$sql = "SELECT * FROM funding_types";

// Préparation de la requête
$stmt = $pdo->prepare($sql);

// Exécution de la requête
if ($stmt->execute()) {
    // Récupération des résultats
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Affichage des résultats en JSON
    echo json_encode($results);
} else {
    // En cas d'erreur
    http_response_code(404);
    echo json_encode(array("message" => "Aucun type de financement trouvé."));
}
?>
