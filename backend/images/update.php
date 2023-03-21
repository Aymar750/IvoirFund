<?php
include_once("../configdb.php");

// Vérification de la méthode de la requête
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Vérification de l'ID de l'image
if (!isset($_GET['id'])) {
    http_response_code(400);
    echo json_encode(array("message" => "L'ID de l'image est requis."));
    exit();
}
$image_id = $_GET['id'];

// Vérification de l'existence de l'image dans la base de données
$stmt = $pdo->prepare("SELECT * FROM Images WHERE id = :id");
$stmt->bindParam(':id', $image_id, PDO::PARAM_INT);
$stmt->execute();
$image = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$image) {
    http_response_code(404);
    echo json_encode(array("message" => "L'image n'existe pas."));
    exit();
}

// Traitement de la requête
$data = json_decode(file_get_contents("php://input"));
if (isset($data->file_path)) {
    $file_path = $data->file_path;
} else {
    $file_path = $image['file_path'];
}

if (isset($data->description)) {
    $description = $data->description;
} else {
    $description = $image['description'];
}

$stmt = $pdo->prepare("UPDATE Images SET file_path = :file_path, description = :description WHERE id = :id");
$stmt->bindParam(':file_path', $file_path, PDO::PARAM_STR);
$stmt->bindParam(':description', $description, PDO::PARAM_STR);
$stmt->bindParam(':id', $image_id, PDO::PARAM_INT);

if ($stmt->execute()) {
    http_response_code(200);
    echo json_encode(array("message" => "L'image a été mise à jour."));
} else {
    http_response_code(500);
    echo json_encode(array("message" => "Impossible de mettre à jour l'image."));
}
?>
