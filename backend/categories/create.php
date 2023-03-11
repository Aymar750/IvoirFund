<?php
// Inclure le fichier de configuration de la base de données
include_once("../configdb.php");

// Vérifier si les données POST existent
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = json_decode(file_get_contents("php://input"));

    // Récupérer les valeurs des champs
    $name = $data->name;
    $description = $data->description;

    // Préparer la requête SQL d'insertion
    $query = "INSERT INTO Project_categories (name, description) VALUES (:name, :description)";

    // Préparer la requête pour l'exécution avec PDO
    $stmt = $pdo->prepare($query);

    // Liaison des valeurs aux paramètres de la requête
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':description', $description);

    // Exécuter la requête et vérifier le résultat
    if ($stmt->execute()) {
        http_response_code(201);
        echo json_encode(array("message" => "La catégorie de projet a été créée avec succès."));
    } else {
        http_response_code(503); // code d'erreur du service indisponible
        echo json_encode(array("message" => "Impossible de créer la catégorie de projet."));
    }
} else {
    http_response_code(400); // code d'erreur de la requête incorrecte
    echo json_encode(array("message" => "Les données de la requête sont incomplètes."));
}
