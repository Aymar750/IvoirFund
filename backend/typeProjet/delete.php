<?php
include_once("../configdb.php");

// Vérifier que l'ID est fourni dans la requête DELETE
if(isset($_GET['id'])){
    $id = $_GET['id'];
    
    // Préparer et exécuter la requête DELETE
    $query = "DELETE FROM funding_type WHERE id = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$id]);

    // Vérifier si la requête a affecté une ligne
    if($stmt->rowCount() > 0){
        http_response_code(204); // Code 204 pour "No Content"
    } else {
        http_response_code(404); // Code 404 pour "Not Found"
    }
} else {
    http_response_code(400); // Code 400 pour "Bad Request"
}
?>
