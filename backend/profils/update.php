<?php

include_once("../configdb.php");

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Récupération des données du formulaire d'édition
$postdata = file_get_contents("php://input");
$request = json_decode($postdata);

// Vérification des champs obligatoires
if (!isset($request->id) || !isset($request->name) || !isset($request->bio) || !isset($request->user_id)) {
    http_response_code(400);
    echo json_encode(array("message" => "Tous les champs obligatoires doivent être renseignés."));
    exit();
}

// Vérification de l'existence de l'utilisateur associé au profil
$stmt = $pdo->prepare("SELECT * FROM Users WHERE id = ?");
$stmt->execute([$request->user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$user) {
    http_response_code(404);
    echo json_encode(array("message" => "L'utilisateur associé au profil n'existe pas."));
    exit();
}

// Vérification de l'existence du profil à modifier
$stmt = $pdo->prepare("SELECT * FROM Profiles WHERE id = ?");
$stmt->execute([$request->id]);
$profile = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$profile) {
    http_response_code(404);
    echo json_encode(array("message" => "Le profil à modifier n'existe pas."));
    exit();
}

// Mise à jour des données du profil
$stmt = $pdo->prepare("UPDATE Profiles SET name = ?, bio = ? WHERE id = ?");
$stmt->execute([$request->name, $request->bio, $request->id]);

// Vérification de l'existence d'un fichier uploadé
if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['size'] > 0) {
    // Récupération des informations sur le fichier uploadé
    $filename = $_FILES['profile_picture']['name'];
    $filetype = $_FILES['profile_picture']['type'];
    $tmp_name = $_FILES['profile_picture']['tmp_name'];
    $error = $_FILES['profile_picture']['error'];
    $size = $_FILES['profile_picture']['size'];
    
    // Vérification du type de fichier
    $allowed_types = array('image/jpeg', 'image/png', 'image/gif');
    if (!in_array($filetype, $allowed_types)) {
        http_response_code(400);
        echo json_encode(array("message" => "Le type de fichier n'est pas autorisé."));
        exit();
    }
    
    // Vérification de la taille du fichier
    $max_size = 2048 * 2048; // 1 Mo
    if ($size > $max_size) {
        http_response_code(400);
        echo json_encode(array("message" => "La taille du fichier est supérieure à 1 Mo."));
        exit();
    }
    
    // Déplacement du fichier vers le dossier de destination
    $upload_dir = "../uploads/profile_pictures/";
    $new_filename = uniqid('profile_') . "." . pathinfo($filename, PATHINFO_EXTENSION);
    $destination = $upload_dir . $new_filename;
    if (!move_uploaded_file($tmp_name, $destination)) {
        http_response_code(500);
        echo json_encode(array("message" => "Une erreur est survenue lors de l'upload du fichier."));
        exit();
    }
    // Mise à jour du nom de fichier dans la base de données
    $stmt = $pdo->prepare("UPDATE Profiles SET profile_picture = ? WHERE id = ?");
    $stmt->execute([$new_filename, $request->id]);
    }

    // Récupération des nouvelles données du profil pour retourner en réponse
    $stmt = $pdo->prepare("SELECT * FROM Profiles WHERE id = ?");
    $stmt->execute([$request->id]);
    $profile = $stmt->fetch(PDO::FETCH_ASSOC);

    // Retour de la réponse
    http_response_code(200);
    echo json_encode(array("message" => "Le profil a été mis à jour.", "profile" => $profile));

