<?php
include_once("../configdb.php");

// Récupérer l'ID de la notification à mettre à jour
$id = $_GET['id'];

// Récupérer les données de la requête PUT
$postdata = file_get_contents("php://input");
$request = json_decode($postdata);

// Vérifier que toutes les données requises sont présentes
if (isset($request->content) && isset($request->recipient_id) && isset($request->sender_id)) {

    // Récupérer les données de la notification à mettre à jour
    $query = "SELECT * FROM notifications WHERE id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $notification = $stmt->fetch(PDO::FETCH_ASSOC);

    // Vérifier que la notification existe
    if ($notification) {

        // Mettre à jour la notification dans la base de données
        $query = "UPDATE notifications SET content = :content, recipient_id = :recipient_id, sender_id = :sender_id WHERE id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':content', $request->content);
        $stmt->bindParam(':recipient_id', $request->recipient_id);
        $stmt->bindParam(':sender_id', $request->sender_id);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        // Retourner la notification mise à jour
        $query = "SELECT * FROM notifications WHERE id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $notification = $stmt->fetch(PDO::FETCH_ASSOC);

        http_response_code(200);
        echo json_encode($notification);
    } else {
        http_response_code(404);
        echo json_encode(array("message" => "La notification n'existe pas."));
    }
} else {
    http_response_code(400);
    echo json_encode(array("message" => "Impossible de mettre à jour la notification. Des données sont manquantes."));
}
?>
