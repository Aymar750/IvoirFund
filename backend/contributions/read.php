<?php
include_once("../configdb.php");

// Préparation de la requête SELECT pour récupérer toutes les contributions
$sql = "SELECT Contributions.id, Users.name as user_name, Projects.title as project_title, Contributions.amount, Contributions.contribution_date
        FROM Contributions
        INNER JOIN Users ON Contributions.user_id = Users.id
        INNER JOIN Projects ON Contributions.project_id = Projects.id
        ORDER BY Contributions.contribution_date DESC";

// Exécution de la requête préparée
$stmt = $pdo->query($sql);

// Récupération des résultats sous forme de tableau associatif
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Envoi de la réponse au format JSON
echo json_encode($results);
