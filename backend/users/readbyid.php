<?php
include_once("../configdb.php");

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
  http_response_code(200);
  exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $request = explode('/', trim($_SERVER['PATH_INFO'],'/'));
    $id = end($request);
    $stmt = $pdo->prepare("SELECT 
                        p.id AS project_id, p.title, p.description, p.creation_date, p.end_date, p.funding_goal,
                        c.id AS category_id, c.name AS category_name,
                        u.id AS user_id, u.name AS user_name, u.email, 
                        s.id AS status_id, s.name AS status_name,
                        co.id AS contribution_id, co.user_id AS contributor_id, co.amount, co.contribution_date,
                        r.id AS reward_id, r.title AS reward_title, r.description AS reward_description, r.minimum_amount, r.quantity_available,
                        cm.id AS comment_id, cm.user_id AS commenter_id, cm.content AS comment_content, cm.creation_date AS comment_date,
                        i.id AS image_id, i.filename, i.filetype, i.file_path, i.description AS image_description
                    FROM 
                        users u
                        LEFT JOIN projects p ON p.user_id = u.id
                        LEFT JOIN project_categories c ON p.category_id = c.id
                        LEFT JOIN project_statuses s ON p.project_status_id = s.id
                        LEFT JOIN contributions co ON p.id = co.project_id
                        LEFT JOIN rewards r ON p.id = r.project_id
                        LEFT JOIN comments cm ON p.id = cm.project_id
                        LEFT JOIN images i ON p.id = i.project_id
                    WHERE 
                        u.id = ?
  ");
    $stmt->execute([$id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($user) {
        echo json_encode($user);
    } else {
        http_response_code(404);
        echo json_encode(['error' => 'User not found']);
    }
} else {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
}
