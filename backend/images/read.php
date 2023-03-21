<?php
include_once("../configdb.php");

// Vérifier si l'id du projet est passé en paramètre
if (!isset($_GET['project_id'])) {
    http_response_code(400);
    echo json_encode(array("message" => "L'id du projet est requis."));
    exit();
}

// Requête pour récupérer toutes les images pour le projet spécifié
$query = "SELECT * FROM Images WHERE project_id = ?";
$stmt = $pdo->prepare($query);
$stmt->execute(array($_GET['project_id']));
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Vérifier si le résultat est vide
if (empty($result)) {
    http_response_code(404);
    echo json_encode(array("message" => "Aucune image trouvée pour le projet spécifié."));
    exit();
}

// Afficher les résultats sous forme de JSON
http_response_code(200);
echo json_encode($result);
?>
