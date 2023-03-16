<?php
include_once("../configdb.php");
include_once("../jwt.php");

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit();
}
// Récupération des données envoyées en POST
$postdata = file_get_contents("php://input");
$request = json_decode($postdata);

// Vérification que les champs name et password sont présents dans la requête
if (!isset($request->name) || !isset($request->password)) {
    http_response_code(400);
    echo json_encode(['message' => 'Veuillez saisir un nom d\'utilisateur et un mot de passe']);

}

// Récupération des données utilisateur correspondant au nom d'utilisateur fourni
$name = $request->name;
$query = "SELECT 
p.id AS project_id, p.title, p.description, p.creation_date, p.end_date, p.funding_goal,
c.id AS category_id, c.name AS category_name,
u.id AS user_id, u.name AS user_name, u.email,u.password,
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
u.name = ?";
$result = $pdo->prepare($query);
$result->execute([$name]);
$user = $result->fetch(PDO::FETCH_ASSOC);


if ($user) {
    // Vérification que le mot de passe est correct
    if (password_verify($request->password, $user['password'])) {
        // Création d'un jeton d'authentification
        $jwt_secret = bin2hex(random_bytes(32));
        $jwt_payload = array(
            "iss" => "localhost",
            "iat" => time(),
            "exp" => time() + (7 * 24 * 60 * 60), // Expire dans une semaine
            "sub" => $user['user_id'],
            "name" => $user['user_name']
        );
        $jwt_token = jwt_encode($jwt_payload, $jwt_secret);

        http_response_code(200);
        echo json_encode(['token' => $jwt_token,
                        'data'=>$user]);
    } else {
        // Mot de passe incorrect
        http_response_code(401);
        echo json_encode(['message' => 'Mot de passe incorrect']);
    }
} else {
    // Utilisateur non trouvé
    http_response_code(404);
    echo json_encode(['message' => 'Utilisateur non trouvé']);
}
