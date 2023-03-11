<?php
include_once("../configdb.php");

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    // Vérifier si l'ID de l'utilisateur est présent dans l'URL
    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        try {
        // Récupérer le profil correspondant à l'ID de l'utilisateur
        $stmt = $pdo->prepare('SELECT * FROM Profils WHERE utilisateur_id = :id');
        $stmt->execute(['id' => $id]);
        $profil = $stmt->fetch(PDO::FETCH_ASSOC);

        // Vérifier si un profil a été trouvé pour cet utilisateur
        if ($profil) {
            // Si un profil a été trouvé, renvoyer une réponse JSON avec les données du profil
            echo json_encode(['profil' => $profil]);
            exit();
        } else {
            // Si aucun profil n'a été trouvé pour cet utilisateur, renvoyer une réponse JSON avec un message d'erreur correspondant
            echo json_encode(['error' => 'Aucun profil trouvé pour cet utilisateur.']);
            exit();
        }
        } catch (PDOException $e) {
        // Si une exception PDO se produit, renvoyer une réponse JSON avec un message d'erreur correspondant
        echo json_encode(['error' => 'Erreur lors de la requête SQL.', 'details' => $e->getMessage()]);
        exit();
        }
    } else {
        // Si l'ID de l'utilisateur n'est pas présent dans l'URL, renvoyer une réponse JSON avec un message d'erreur correspondant
        echo json_encode(['error' => 'ID utilisateur non spécifié dans l\'URL.']);
        exit();
    }
} else {
    // Si la méthode de la requête n'est pas GET, renvoyer une réponse JSON avec un message d'erreur correspondant
    echo json_encode(['error' => 'Méthode non autorisée. Utilisez la méthode GET.']);
    exit();
}
