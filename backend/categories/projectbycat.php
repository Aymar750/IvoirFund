<?php
include_once("../configdb.php");

// Préparer la requête SQL pour récupérer le nombre de projets par catégorie
$query = "SELECT c.id AS category_id, c.name AS category_name, COUNT(p.id) AS project_count
            FROM project_categories c
            LEFT JOIN projects p ON c.id = p.category_id
            GROUP BY c.id, c.name;
";
$stmt = $pdo->prepare($query);
$stmt->execute();

// Récupérer les données de la requête
$num_projects_by_category = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Afficher les données en format JSON
echo json_encode($num_projects_by_category);
?>
