<?php
include_once("../configdb.php");

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
    parse_str(file_get_contents("php://input"), $put_vars);
    
    // Vérification des champs obligatoires
    if (!isset($put_vars['id']) || !isset($put_vars['user_id']) || !isset($put_vars['name'])) {
        http_response_code(400);
        echo json_encode(array("message" => "Tous les champs obligatoires doivent être renseignés"));
        exit();
    }
    
    $id = $put_vars['id'];
    $user_id = $put_vars['user_id'];
    $name = $put_vars['name'];
    $bio = $put_vars['bio'] ?? null;
    
    // Vérification de l'existence de l'utilisateur
    $query_check_user = "SELECT COUNT(*) as count FROM Users WHERE id=:user_id";
    $stmt_check_user = $conn->prepare($query_check_user);
    $stmt_check_user->bindParam(':user_id', $user_id);
    $stmt_check_user->execute();
    $row_check_user = $stmt_check_user->fetch(PDO::FETCH_ASSOC);
    if ($row_check_user['count'] == 0) {
        http_response_code(404);
        echo json_encode(array("message" => "L'utilisateur n'existe pas"));
        exit();
    }
    
    // Mise à jour du profil
    $query_update_profile = "UPDATE Profiles SET user_id=:user_id, name=:name, bio=:bio WHERE id=:id";
    $stmt_update_profile = $conn->prepare($query_update_profile);
    $stmt_update_profile->bindParam(':user_id', $user_id);
    $stmt_update_profile->bindParam(':name', $name);
    $stmt_update_profile->bindParam(':bio', $bio);
    $stmt_update_profile->bindParam(':id', $id);
    
    if ($stmt_update_profile->execute()) {
        http_response_code(200);
        echo json_encode(array("message" => "Le profil a été mis à jour avec succès"));
    } else {
        http_response_code(503);
        echo json_encode(array("message" => "Impossible de mettre à jour le profil"));
    }
} else {
    http_response_code(405);
    echo json_encode(array("message" => "Méthode non autorisée"));
}
?>
