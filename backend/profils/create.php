<?php
include_once("../configdb.php");

// Récupérer les données de la requête POST
$postdata = file_get_contents("php://input");

// Si des données sont présentes dans la requête POST
if(isset($postdata) && !empty($postdata)){

    // Convertir les données JSON en tableau associatif PHP
    $data = json_decode($postdata, true);

    // Vérifier que toutes les données requises sont présentes
    if(
        isset($data['utilisateur_id']) &&
        isset($data['nom']) &&
        isset($_FILES['photo_profil'])
    ){
        
        try{
            // Vérifier si l'utilisateur avec l'ID donné existe dans la table Utilisateurs
            $sql = "SELECT COUNT(*) AS count FROM utilisateurs WHERE id = :utilisateur_id";
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(':utilisateur_id', $data['utilisateur_id']);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if($row['count'] == 0){
                // Si l'utilisateur n'existe pas, renvoyer une réponse JSON avec un message d'erreur correspondant
                echo json_encode(['error' => 'L\'utilisateur avec l\'ID donné n\'existe pas.']);
                exit();
        }

        // Vérifier si le fichier a été uploadé avec succès
        if($_FILES['photo_profil']['error'] != UPLOAD_ERR_OK){
            // Si l'upload a échoué, renvoyer une réponse JSON avec un message d'erreur correspondant
            echo json_encode(['error' => 'Une erreur s\'est produite lors de l\'upload du fichier.']);
            exit();
        }

        // Récupérer le contenu du fichier
        $fileContent = file_get_contents($_FILES['photo_profil']['tmp_name']);

        // Préparer la requête SQL pour insérer une nouvelle ligne dans la table Profils
        $sql = "INSERT INTO profils (utilisateur_id, nom, bio, photo_profil) 
                VALUES (:utilisateur_id, :nom, :bio, :photo_profil)";

        // Utiliser PDO pour préparer la requête SQL
        $stmt = $pdo->prepare($sql);

        // Lier les valeurs des paramètres avec les valeurs du tableau associatif PHP
        $stmt->bindValue(':utilisateur_id', $data['utilisateur_id']);
        $stmt->bindValue(':nom', $data['nom']);
        $stmt->bindValue(':bio', isset($data['bio']) ? $data['bio'] : null);
        $stmt->bindValue(':photo_profil', $fileContent, PDO::PARAM_LOB);

        // Exécuter la requête SQL préparée
        $stmt->execute();

        // Renvoyer une réponse JSON pour indiquer que la nouvelle ligne a été insérée avec succès
        echo json_encode(['message' => 'La nouvelle ligne a été insérée avec succès.']);
        
        } catch(PDOException $e){
        // Si une erreur se produit lors de l'exécution de la requête SQL, renvoyer une réponse JSON avec le message d'erreur correspondant
        echo json_encode([
                'error' => 'Une erreur s\'est produite lors de l\'exécution de la requête SQL.', 
                'details' => $e->getMessage()
            ]);
            exit();
        }
    } else {
        // Si toutes les données requises ne sont pas présentes, renvoyer une réponse JSON avec un message d'erreur correspondant
        echo json_encode(['error' => 'Toutes les données requises ne sont pas présentes.']);
        exit();
    }
} else {
    // Si aucune donnée n'est présente dans la requête POST, renvoyer une réponse JSON avec un message d'erreur correspondant
    echo json_encode(['error' => 'Aucune donnée n\'est présente dans la requête POST.']);
    exit();
}


