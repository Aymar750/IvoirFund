<?php

include_once("../configdb.php");

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit();
}

$postdata = file_get_contents("php://input");
$request = json_decode($postdata);

// Récupération des données du formulaire de création de profil

$user_id = $request->user_id;
$name = $request->name;
$bio = $request->bio;
$reseau_social = $request->reseau_social;
$site_web = $request->site_web;

// Vérification si le fichier a été téléchargé avec succès
if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] == UPLOAD_ERR_OK) {
    $filename = $_FILES['profile_picture']['name'];
    $filetmp = $_FILES['profile_picture']['tmp_name'];
    $filetype = $_FILES['profile_picture']['type'];
    $filepath = "../uploads/" . $filename;

    // Déplacement du fichier téléchargé vers le dossier d'upload
    if (move_uploaded_file($filetmp, $filepath)) {
        // Préparation de la requête SQL pour insérer les données dans la table Profiles
        $stmt = $pdo->prepare("INSERT INTO Profiles (user_id, name, bio, profile_picture, reseau_social, site_web) VALUES (:user_id, :name, :bio, :profile_picture, :reseau_social, :site_web)");

        // Lier les paramètres de la requête
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':bio', $bio);
        $stmt->bindParam(':profile_picture', $filepath);
        $stmt->bindParam(':reseau_social', $reseau_social);
        $stmt->bindParam(':site_web', $site_web);

    // Exécuter la requête SQL
        if ($stmt->execute()) {
            // Récupération de l'ID du profil créé
            $profile_id = $pdo->lastInsertId();

            // Préparation de la réponse JSON à envoyer
            $response = array(
                "status" => "success",
                "message" => "Profile created successfully",
                "data" => array(
                    "id" => $profile_id,
                    "user_id" => $user_id,
                    "name" => $name,
                    "bio" => $bio,
                    "profile_picture" => $filepath,
                    "reseau_social" => $reseau_social,
                    "site_web" => $site_web
                )
            );

            // Envoyer la réponse JSON
            header('Content-Type: application/json');
            echo json_encode($response);
        } else {
            // Préparation de la réponse JSON à envoyer en cas d'erreur
            $response = array(
                "status" => "error",
                "message" => "Error creating profile"
            );

            // Envoyer la réponse JSON avec le code d'erreur 500
            header('Content-Type: application/json');
            http_response_code(500);
            echo json_encode($response);
        }
} else {
    // Préparation de la réponse JSON à envoyer en cas d'erreur
    $response = array(
        "status" => "error",
        "message" => "Error uploading profile picture"
    );}
} 
?>