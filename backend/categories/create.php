<?php 
include_once("../configdb.php");

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $data = json_decode(file_get_contents("php://input"));

    // Vérifier que le champ de la catégorie n'est pas vide
    if(!empty($data->nom_categorie)) {
        $nom_categorie = $data->nom_categorie;
        $stmt = $pdo->prepare("INSERT INTO categories (nom_categorie) VALUES (?)");
        $stmt->execute([$nom_categorie]);

        // Retourner l'ID de la catégorie nouvellement créée
        $lastInsertId = $pdo->lastInsertId();
        echo json_encode(['id' => $lastInsertId, 'nom_categorie' => $nom_categorie]);
        exit;
    } else {
        // Si le champ est vide, retourner une erreur
        http_response_code(400);
        echo "Le champ de la catégorie ne doit pas être vide.";
        exit;
    }
}