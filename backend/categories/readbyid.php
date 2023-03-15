<?php
include_once("../configdb.php");

// Récupérer l'id de la catégorie à afficher depuis la requête GET
$category_id = $_GET['id'];

// Préparer la requête SQL pour récupérer les informations de la catégorie avec l'id correspondant
$query = "SELECT * FROM Project_categories WHERE id = :category_id";
$stmt = $pdo->prepare($query);
$stmt->bindParam(':category_id', $category_id);
$stmt->execute();

// Récupérer les données de la catégorie
$category = $stmt->fetch(PDO::FETCH_ASSOC);

// Vérifier si la catégorie a été trouvée dans la base de données
if (!$category) {
  http_response_code(404);
  echo json_encode(["message" => "La catégorie n'a pas été trouvée."]);
  exit();
}

// Afficher les données de la catégorie en format JSON
echo json_encode($category);
?>
