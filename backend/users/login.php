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
$query = "SELECT id, name, password FROM users WHERE name = ?";
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
            "sub" => $user['id'],
            "name" => $user['name']
        );
        $jwt_token = jwt_encode($jwt_payload, $jwt_secret);

        http_response_code(200);
        echo json_encode(['token' => $jwt_token,
                        'data'=>[
                            "name"=>$user['name'],
                            "id"=>$user['id'],
                                ]]);
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
