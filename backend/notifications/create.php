<?php

include_once("../configdb.php");

// Récupérer les données de la requête POST
$postdata = file_get_contents("php://input");

// Vérifier si les données sont présentes et non vides
if(isset($postdata) && !empty($postdata)) {
    // Convertir les données JSON en tableau associatif PHP
    $data = json_decode($postdata, true);

    // Vérifier si toutes les données requises sont présentes
    if(isset($data['sender_id']) && isset($data['recipient_id']) && isset($data['content'])) {
        // Préparer la requête SQL d'insertion
        $sql = "INSERT INTO Notifications (sender_id, recipient_id, content) VALUES (:sender_id, :recipient_id, :content)";

        // Préparer les valeurs à insérer dans la requête SQL
        $sender_id = intval($data['sender_id']);
        $recipient_id = intval($data['recipient_id']);
        $content = htmlspecialchars($data['content']);

        // Préparer la requête PDO
        $stmt = $pdo->prepare($sql);

        // Associer les valeurs aux paramètres de la requête PDO
        $stmt->bindParam(':sender_id', $sender_id, PDO::PARAM_INT);
        $stmt->bindParam(':recipient_id', $recipient_id, PDO::PARAM_INT);
        $stmt->bindParam(':content', $content, PDO::PARAM_STR);

        // Exécuter la requête PDO
        if($stmt->execute()) {
            // Récupérer l'ID de la notification insérée
            $notification_id = $pdo->lastInsertId();

            // Récupérer la notification insérée depuis la base de données
            $sql = "SELECT * FROM Notifications WHERE id = :notification_id LIMIT 1";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':notification_id', $notification_id, PDO::PARAM_INT);
            $stmt->execute();
            $notification = $stmt->fetch(PDO::FETCH_ASSOC);

            // Retourner la notification insérée en tant que JSON
            http_response_code(201);
            echo json_encode($notification);
        }
        else {
            // Erreur lors de l'exécution de la requête PDO
            http_response_code(500);
            echo json_encode(array('message' => 'Une erreur est survenue lors de l\'ajout de la notification.'));
        }
    }
    else {
        // Données requises manquantes
        http_response_code(400);
        echo json_encode(array('message' => 'Toutes les données requises doivent être fournies.'));
    }
}
else {
    // Données non présentes ou vides
    http_response_code(400);
    echo json_encode(array('message' => 'Aucune donnée n\'a été fournie.'));
}
