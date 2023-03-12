//je veux récuperer toutes les notifications entre deux utilisateurs, triées par date d'envoi décroissante.

<?php
include_once("../configdb.php");

$user1_id = $_GET['user1_id'];
$user2_id = $_GET['user2_id'];

// Préparation de la requête SQL
$sql = "SELECT * FROM Notifications 
        WHERE (sender_id = :user1_id AND recipient_id = :user2_id)
           OR (sender_id = :user2_id AND recipient_id = :user1_id)
        ORDER BY send_date DESC";

$stmt = $pdo->prepare($sql);

// Exécution de la requête avec les paramètres
$stmt->execute(array(':user1_id' => $user1_id, ':user2_id' => $user2_id));

// Récupération des résultats sous forme d'objet
$notifications = $stmt->fetchAll(PDO::FETCH_OBJ);

// Encodage des résultats en JSON et envoi de la réponse
echo json_encode($notifications);
?>
