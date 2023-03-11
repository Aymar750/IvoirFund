<?php
include_once("../configdb.php");

// Récupérer les données de la requête POST
$postdata = file_get_contents("php://input");

if(isset($postdata) && !empty($postdata)) {
    // Convertir les données de la requête en objet
    $request = json_decode($postdata);

    // Vérifier que toutes les données requises sont présentes
    if(!empty($request->project_id) && !empty($request->filename) && !empty($request->filetype) && !empty($request->file_path)) {

        // Préparer la requête SQL pour insérer une nouvelle image dans la table Images
        $sql = "INSERT INTO Images (project_id, filename, filetype, file_path, description) VALUES (:project_id, :filename, :filetype, :file_path, :description)";

        // Préparer les données à insérer dans la requête
        $params = [
        ':project_id' => $request->project_id,
        ':filename' => $request->filename,
        ':filetype' => $request->filetype,
        ':file_path' => $request->file_path,
        ':description' => isset($request->description) ? $request->description : null,
        ];

        try {
            // Exécuter la requête SQL avec les données
            $stmt = $pdo->prepare($sql);
            $stmt->execute($params);

            // Renvoyer une réponse indiquant que la création a réussi
            http_response_code(201);
            echo json_encode(['message' => 'L\'image a été créée avec succès']);
        } catch (PDOException $e) {
            // Renvoyer une réponse indiquant que la création a échoué et afficher l'erreur
            http_response_code(500);
            echo json_encode(['message' => 'La création de l\'image a échoué: ' . $e->getMessage()]);
        }

    } else {
        // Renvoyer une réponse indiquant que les données requises sont manquantes
        http_response_code(400);
        echo json_encode(['message' => 'Toutes les données requises doivent être fournies']);
    }
} else {
  // Renvoyer une réponse indiquant que la requête est incorrecte
  http_response_code(400);
  echo json_encode(['message' => 'La requête est incorrecte']);
}
