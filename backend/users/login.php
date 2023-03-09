<?php
include_once("../configdb.php");

$postdata = file_get_contents("php://input");
$request = json_decode($postdata);

if(isset($postdata) && !empty($postdata)) {

  // Extraire les données du formulaire de connexion
  $nom_utilisateur = trim($request->nom_utilisateur);
  $mot_de_passe = trim($request->mot_de_passe);

  // Vérifier que les champs du formulaire ne sont pas vides
  if(!empty($nom_utilisateur) && !empty($mot_de_passe)) {
    
    // Préparer la requête SQL pour récupérer l'utilisateur avec le nom d'utilisateur fourni
    $query = "SELECT * FROM utilisateurs WHERE nom_utilisateur = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$nom_utilisateur]);

    // Vérifier si l'utilisateur existe
    if($stmt->rowCount() == 1) {

      // Récupérer les informations de l'utilisateur
      $user = $stmt->fetch(PDO::FETCH_ASSOC);

      // Vérifier si le mot de passe est correct
      if(password_verify($mot_de_passe, $user['mot_de_passe'])) {
        
        // Si le mot de passe est correct, créer une session pour l'utilisateur et rediriger vers la page d'accueil
        session_start();
        $_SESSION['id_utilisateur'] = $user['id_utilisateur'];
        $_SESSION['nom_utilisateur'] = $user['nom_utilisateur'];
        $_SESSION['email_utilisateur'] = $user['email_utilisateur'];

        // Retourner un code de succès et les informations de l'utilisateur
        http_response_code(200);
        echo 'Bienvenue'.$user['nom_utilisateur'];
        echo json_encode($user);
        exit;
      }
      else {
        // Si le mot de passe est incorrect, retourner une erreur de connexion
        http_response_code(401);
        echo "Mot de passe incorrect.";
        exit;
      }
    }
    else {
      // Si l'utilisateur n'existe pas, retourner une erreur de connexion
      http_response_code(401);
      echo "Nom d'utilisateur incorrect.";
      exit;
    }
  }
  else {
    // Si l'un des champs du formulaire est vide, retourner une erreur de connexion
    http_response_code(400);
    echo "Veuillez remplir tous les champs.";
    exit;
  }
}
?>
