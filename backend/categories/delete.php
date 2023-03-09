<?php
include_once("../configdb.php");

if($_SERVER['REQUEST_METHOD'] == 'DELETE') {
    parse_str($_SERVER['QUERY_STRING'], $params);
    $id_categorie = $params['id_categorie'];

    $stmt = $pdo->prepare("DELETE FROM categories WHERE id_categorie=?");
    $stmt->execute([$id_categorie]);

    // Retourne un message indiquant que la catégorie a été supprimée
    echo "La catégorie a été supprimée.";
    exit;
}
?>