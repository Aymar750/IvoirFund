<?php
include_once("../configdb.php");

if($_SERVER['REQUEST_METHOD'] == 'PUT') {
    $data = json_decode(file_get_contents("php://input"));

    // Vérifier que le champ de la catégorie n'est pas vide
    if(!empty($data->nom_categorie)) {
        $nom_categorie = $data->nom_categorie;
        $id_categorie = $data->id_categorie;

        $stmt = $pdo->prepare("UPDATE categories SET nom_categorie=? WHERE id_categorie=?");
        $stmt->execute([$nom_categorie, $id_categorie]);

        // Retourne la catégorie mise à jour
        echo json_encode(['id' => $id_categorie, 'nom_categorie' => $nom_categorie]);
        exit;
    } else {
        // Si le champ est vide, retourne une erreur
        http_response_code(400);
        echo "Le champ de la catégorie ne doit pas être vide.";
        exit;
    }
}