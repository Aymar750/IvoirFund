<?php
include_once("../configdb.php");

// Récupérer les données de la requête POST
$postdata = file_get_contents("php://input");
$request = json_decode($postdata);

// Vérifier que toutes les données nécessaires sont présentes
if (!empty($request->user_id) && !empty($request->project_id) && !empty($request->amount)) {
  // Préparer la requête SQL
  $sql = "INSERT INTO Contributions (user_id, project_id, amount) VALUES (:user_id, :project_id, :amount)";

  // Préparer les valeurs à insérer dans la requête
  $values = [
    'user_id' => $request->user_id,
    'project_id' => $request->project_id,
    'amount' => $request->amount
  ];

  try {
    // Exécuter la requête SQL
    $query = $db->prepare($sql);
    $query->execute($values);

    // Retourner une réponse JSON avec l'ID de la nouvelle contribution créée
    $response = [
      'status' => 'success',
      'message' => 'Contribution created successfully',
      'contribution_id' => $db->lastInsertId()
    ];
    echo json_encode($response);
  } catch (PDOException $e) {
    // Retourner une réponse JSON en cas d'erreur lors de l'exécution de la requête SQL
    $response = [
      'status' => 'error',
      'message' => 'Failed to create contribution: ' . $e->getMessage()
    ];
    
    echo json_encode($response);
  }
} else {
  // Retourner une réponse JSON si toutes les données nécessaires ne sont pas présentes
  $response = [
    'status' => 'error',
    'message' => 'Please provide all required data'
  ];
  echo json_encode($response);
}
