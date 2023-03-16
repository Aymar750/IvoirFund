<?php
include_once("../configdb.php");

// Requête SELECT pour récupérer toutes les catégories de projets
$query = "SELECT p.id AS project_id, p.title, p.description, p.creation_date, p.end_date, p.funding_goal,
                c.id AS category_id, c.name AS category_name,
                u.id AS user_id, u.name AS user_name, u.email, 
                t.id AS type_id, t.name AS type_name, 
                s.id AS status_id, s.name AS status_name,
                co.id AS contribution_id, co.user_id AS contributor_id, co.amount, co.contribution_date,
                r.id AS reward_id, r.title AS reward_title, r.description AS reward_description, r.minimum_amount, r.quantity_available,
                cm.id AS comment_id, cm.user_id AS commenter_id, cm.content AS comment_content, cm.creation_date AS comment_date,
                i.id AS image_id, i.filename, i.filetype, i.file_path, i.description AS image_description
                FROM projects p
                LEFT JOIN project_categories c ON p.category_id = c.id
                LEFT JOIN users u ON p.user_id = u.id
                LEFT JOIN funding_types t ON p.funding_type_id = t.id
                LEFT JOIN project_statuses s ON p.project_status_id = s.id
                LEFT JOIN contributions co ON p.id = co.project_id
                LEFT JOIN rewards r ON p.id = r.project_id
                LEFT JOIN comments cm ON p.id = cm.project_id
                LEFT JOIN images i ON p.id = i.project_id;


                ";

// Exécute la requête
$stmt = $pdo->query($query);

// Tableau pour stocker les résultats
$projets = array();

// Parcours des résultats et stockage dans le tableau
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $projets[] = $row;
}

// Convertit le tableau en JSON et renvoie la réponse au client
echo json_encode($projets);
?>
