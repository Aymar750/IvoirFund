<?php
include_once("../configdb.php");
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Credentials: true');
header("Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
header("Content-Type: application/json; charset=UTF-8");
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit();
}
// Récupérer l'id de l'utilisateur à afficher depuis la requête GET
$user_id = $_GET['id'];

// Préparer la requête SQL pour récupérer les informations de l'utilisateur avec l'id correspondant
$query = "SELECT * FROM Users WHERE id = :user_id";
$stmt = $pdo->prepare($query);
$stmt->bindParam(':user_id', $user_id);
$stmt->execute();

// Récupérer les données de l'utilisateur
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Vérifier si l'utilisateur a été trouvé dans la base de données
if (!$user) {
  http_response_code(404);
  echo json_encode(["message" => "L'utilisateur n'a pas été trouvé."]);
  exit();
}

// Afficher les données de l'utilisateur en format JSON
echo json_encode($user);
?>
