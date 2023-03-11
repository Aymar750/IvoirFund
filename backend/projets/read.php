<?php
include_once("../configdb.php");

// Récupérer les données de l'utilisateur dont on veut les projets associés
$user_id = $_GET['user_id'];

// Préparation de la requête SELECT pour récupérer les projets liés à l'utilisateur
$sql = "SELECT Projects.id, Projects.title, Projects.description, Projects.creation_date, Projects.end_date, Projects.funding_goal, Project_statuses.name as status_name, Project_categories.name as category_name
        FROM Projects
        INNER JOIN Project_statuses ON Projects.project_status_id = Project_statuses.id
        INNER JOIN Project_categories ON Projects.category_id = Project_categories.id
        WHERE Projects.user_id = :user_id
        ORDER BY Projects.creation_date DESC";

// Préparation de la requête préparée
$stmt = $pdo->prepare($sql);

// Liaison des paramètres
$stmt->bindParam(':user_id', $user_id);

// Exécution de la requête préparée
$stmt->execute();

// Récupération des résultats sous forme de tableau associatif
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Envoi de la réponse au format JSON
header('Content-Type: application/json');
echo json_encode($results);
