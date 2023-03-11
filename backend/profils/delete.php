<?php
include_once("../configdb.php");

if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
  // Vérifier si l'ID de l'utilisateur est présent dans l'URL
    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        try {
            // Supprimer le profil correspondant à l'ID de l'utilisateur
            $stmt = $pdo->prepare('DELETE FROM Profiles WHERE utilisateur_id = :id');
            $stmt->execute(['id' => $id]);

            // Vérifier si des lignes ont été affectées par la suppression
            if ($stmt->rowCount() > 0) {
                // Si le profil a été supprimé avec succès, renvoyer une réponse JSON avec un message de succès
                echo json_encode(['success' => 'Le profil a été supprimé avec succès.']);
                exit();
            } else {
                // Si le profil n'a pas été trouvé, renvoyer une réponse JSON avec un message d'erreur correspondant
                echo json_encode(['error' => 'Le profil n\'a pas été trouvé.']);
                exit();
            }
        } catch (PDOException $e) {
            // Si une exception PDO se produit, renvoyer une réponse JSON avec un message d'erreur correspondant
            echo json_encode(['error' => 'Erreur lors de la requête SQL.', 'details' => $e->getMessage()]);
            exit();
        }
    } else {
        // Si l'ID de l'utilisateur n'est pas présent dans l'URL, renvoyer une réponse JSON avec un message d'erreur correspondant
        echo json_encode(['error' => 'ID de l\'utilisateur manquant.']);
        exit();
    }
}
