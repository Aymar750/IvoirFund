<?php
include_once("../configdb.php");

// Récupérer l'ID du commentaire à supprimer depuis la requête GET
$comment_id = $_GET['id'];

// Vérifier si le commentaire existe dans la base de données
$stmt = $pdo->prepare("SELECT * FROM Comments WHERE id = :id");
$stmt->bindValue(':id', $comment_id, PDO::PARAM_INT);
$stmt->execute();
$comment = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$comment) {
    // Le commentaire n'existe pas
    http_response_code(404);
    echo json_encode(array("message" => "Le commentaire n'existe pas."));
} else {
    // Vérifier si l'utilisateur est autorisé à supprimer le commentaire
    $user_id = $comment['user_id'];
    $project_id = $comment['project_id'];
    $stmt = $pdo->prepare("SELECT * FROM Projects WHERE id = :id AND user_id = :user_id");
    $stmt->bindValue(':id', $project_id, PDO::PARAM_INT);
    $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->execute();
    $project = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$project) {
        // L'utilisateur n'est pas autorisé à supprimer le commentaire
        http_response_code(403);
        echo json_encode(array("message" => "Vous n'êtes pas autorisé à supprimer ce commentaire."));
    } else {
        // Supprimer le commentaire de la base de données
        $stmt = $pdo->prepare("DELETE FROM Comments WHERE id = :id");
        $stmt->bindValue(':id', $comment_id, PDO::PARAM_INT);
        $stmt->execute();
        
        // Envoyer une réponse JSON avec un message de confirmation
        http_response_code(200);
        echo json_encode(array("message" => "Le commentaire a été supprimé avec succès."));
    }
}
?>
