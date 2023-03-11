<?php
include_once("../configdb.php");

// Récupérer les données de la requête PUT
$postdata = file_get_contents("php://input");

// Vérifier si les données ont été envoyées
if(isset($postdata) && !empty($postdata)){
    // Extraire les données de la requête
    $data = json_decode($postdata);

    // Vérifier si les données sont valides
    if (
        isset($data->id) &&
        isset($data->name) &&
        isset($data->description)
    ){
        // Préparer la requête SQL pour mettre à jour la catégorie de projet
        $query = "UPDATE Project_categories SET name=:name, description=:description WHERE id=:id";

        // Préparer la requête pour l'exécution
        $stmt = $pdo->prepare($query);

        // Binder les paramètres de la requête
        $stmt->bindParam(':id', $data->id, PDO::PARAM_INT);
        $stmt->bindParam(':name', $data->name, PDO::PARAM_STR);
        $stmt->bindParam(':description', $data->description, PDO::PARAM_STR);

        // Exécuter la requête
        if($stmt->execute()){
            http_response_code(204); // Succès, pas de contenu
        }
        else{
            http_response_code(422); // Erreur de traitement
        }
    }
    else{
        http_response_code(400); // Requête incomplète
    }
}
else{
    http_response_code(400); // Aucune donnée envoyée
}
?>
