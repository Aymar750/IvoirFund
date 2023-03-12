<?php
include_once("../configdb.php");

// Récupérer l'identifiant du projet à partir de la requête GET
$project_id = $_GET['project_id'];

// Requête SQL pour récupérer les commentaires et les informations de l'utilisateur qui a posté chaque commentaire
$sql = "SELECT c.id, c.user_id, u.name as user_name, c.project_id, c.content, c.creation_date
        FROM Comments c
        JOIN Users u ON c.user_id = u.id
        WHERE c.project_id = :project_id";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':project_id', $project_id, PDO::PARAM_INT);
$stmt->execute();
$comments = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Retourner les commentaires en format JSON
echo json_encode($comments);
?>
