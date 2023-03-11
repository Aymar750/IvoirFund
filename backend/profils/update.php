<?php
include_once("../configdb.php");

if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
    // Vérifier si l'ID de l'utilisateur est présent dans l'URL
    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        // Récupérer les données JSON de la requête PUT
        $putdata = file_get_contents("php://input");
        $data = json_decode($putdata, true);

        // Vérifier si les données requises sont présentes dans la requête PUT
        if (isset($data['nom']) && isset($data['bio'])) {
            $nom = $data['nom'];
            $bio = $data['bio'];

            // Vérifier si le champ photo_profil est présent dans la requête PUT
            if (isset($_FILES['photo_profil'])) {
                // Si le champ photo_profil est présent, traiter le fichier uploadé
                $upload_dir = 'uploads/';
                $photo_profil = $upload_dir . basename($_FILES['photo_profil']['name']);
                $photo_profil_tmp = $_FILES['photo_profil']['tmp_name'];

                // Déplacer le fichier uploadé vers le dossier de destination
                move_uploaded_file($photo_profil_tmp, $photo_profil);
            } else {
                // Si le champ photo_profil n'est pas présent, laisser le champ existant inchangé
                $stmt = $pdo->prepare('SELECT photo_profil FROM Profils WHERE utilisateur_id = :id');
                $stmt->execute(['id' => $id]);
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                $photo_profil = $row['photo_profil'];
            }

            try {
                // Mettre à jour le profil correspondant à l'ID de l'utilisateur avec les nouvelles données
                $stmt = $pdo->prepare('UPDATE Profils SET nom = :nom, bio = :bio, photo_profil = :photo_profil WHERE utilisateur_id = :id');
                $stmt->execute(['nom' => $nom, 'bio' => $bio, 'photo_profil' => $photo_profil, 'id' => $id]);

                // Récupérer le profil mis à jour pour renvoyer les données actualisées
                $stmt = $pdo->prepare('SELECT * FROM Profils WHERE utilisateur_id = :id');
                $stmt->execute(['id' => $id]);
                $profil = $stmt->fetch(PDO::FETCH_ASSOC);

                // Si le profil a été mis à jour avec succès, renvoyer une réponse JSON avec les données du profil actualisées
                echo json_encode(['profil' => $profil]);
                exit();
            } catch (PDOException $e) {
                // Si une exception PDO se produit, renvoyer une réponse JSON avec un message d'erreur correspondant
                echo json_encode(['error' => 'Erreur lors de la requête SQL.', 'details' => $e->getMessage()]);
                exit();
            }
        } else {
            // Si toutes les données requises ne sont pas présentes dans la requête PUT, renvoyer une réponse JSON avec un message d'erreur correspondant
            echo json_encode(['error' => 'Toutes les données requises ne sont pas présentes.']);
            exit();
        }
    } else {
        // Si l'ID de l'utilisateur n'est pas présent dans l'URL, renvoyer une réponse JSON avec un message d'erreur correspondant
        echo json_encode(['error' => 'ID de l\'utilisateur non spécifié dans l\'URL.']);
        exit();
    }
} else {
    // Si la méthode HTTP n'est pas PUT, renvoyer une réponse JSON avec un message d'erreur correspondant
    echo json_encode(['error' => 'Méthode HTTP non autorisée.']);
    exit();
}
?>