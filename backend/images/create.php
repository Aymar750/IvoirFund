<?php 
include_once("../configdb.php");

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Vérification si les champs requis existent
if (!isset($_POST['project_id']) || !isset($_FILES['file'])) {
    http_response_code(400);
    echo json_encode(["message" => "Missing required field(s)"]);
    exit();
}

// Récupération des données envoyées
$project_id = $_POST['project_id'];
$file = $_FILES['file'];

// Vérification si le projet existe
$stmt = $pdo->prepare("SELECT * FROM Projects WHERE id = ?");
$stmt->execute([$project_id]);
if (!$stmt->fetch()) {
    http_response_code(404);
    echo json_encode(["message" => "Project not found"]);
    exit();
}

// Vérification si le fichier est une image
if (!in_array($file['type'], ['image/jpeg', 'image/png', 'image/gif'])) {
    http_response_code(400);
    echo json_encode(["message" => "Invalid file type"]);
    exit();
}

// Génération d'un nom unique pour le fichier
$filename = uniqid() . '-' . $file['name'];

// Déplacement du fichier dans le répertoire de destination
if (!move_uploaded_file($file['tmp_name'], "../uploads/$filename")) {
    http_response_code(500);
    echo json_encode(["message" => "Error uploading file"]);
    exit();
}

// Insertion de l'image dans la base de données
$stmt = $pdo->prepare("INSERT INTO Images (project_id, filename, filetype, file_path, description) VALUES (?, ?, ?, ?, ?)");
$filetype = $file['type'];
$file_path = "uploads/$filename";
$description = isset($_POST['description']) ? $_POST['description'] : null;
$stmt->execute([$project_id, $filename, $filetype, $file_path, $description]);

// Récupération de l'ID de l'image insérée
$image_id = $pdo->lastInsertId();

// Récupération de l'image insérée
$stmt = $pdo->prepare("SELECT * FROM Images WHERE id = ?");
$stmt->execute([$image_id]);
$image = $stmt->fetch(PDO::FETCH_ASSOC);

// Réponse avec l'image insérée
http_response_code(201);
echo json_encode($image);

?>