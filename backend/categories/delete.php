<?php
include_once("../configdb.php");

// Vérifie que l'identifiant de la catégorie de projet a été envoyé via la méthode DELETE
if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
    // Récupère l'identifiant de la catégorie de projet depuis l'URL
    $id = $_GET['id'];
    
    // Requête DELETE pour supprimer la catégorie de projet correspondante
    $query = "DELETE FROM Project_categories WHERE id = :id";

    // Prépare la requête
    $stmt = $pdo->prepare($query);

    // Bind les valeurs des paramètres de la requête
    $stmt->bindParam(':id', $id);

    // Exécute la requête
    if ($stmt->execute()) {
        // Renvoie une réponse JSON pour indiquer que la catégorie de projet a été supprimée
        echo json_encode(array('message' => 'Catégorie de projet supprimée avec succès.'));
    } else {
        // Renvoie une réponse JSON pour indiquer qu'il y a eu une erreur lors de la suppression de la catégorie de projet
        echo json_encode(array('message' => 'Impossible de supprimer la catégorie de projet.'));
    }
} else {
    // Renvoie une réponse JSON pour indiquer que la méthode HTTP n'est pas autorisée
    echo json_encode(array('message' => 'Méthode HTTP non autorisée.'));
}
?>
