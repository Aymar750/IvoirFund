<?php
include_once("../configdb.php");

$postdata = file_get_contents("php://input");
$request = json_decode($postdata);

if(isset($postdata) && !empty($postdata)) {

  // Extraire les données du formulaire d'inscription
  $nom_utilisateur = trim($request->nom_utilisateur);
  $email_utilisateur = trim($request->email_utilisateur);
  $mot_de_passe = trim($request->mot_de_passe);

  // Vérifier que les champs du formulaire ne sont pas vides
  if(!empty($nom_utilisateur) && !empty($email_utilisateur) && !empty($mot_de_passe)) {
    
    // Vérifier si l'utilisateur avec le nom d'utilisateur ou l'adresse email_utilisateur fourni existe déjà
    $query = "SELECT * FROM utilisateurs WHERE email_utilisateur = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([ $email_utilisateur]);

    // Si l'utilisateur existe déjà, retourner une erreur
    if($stmt->rowCount() > 0) {
      http_response_code(400);
      echo "L'utilisateur existe déjà.";
      exit;
    }

    // Si l'utilisateur n'existe pas, créer un nouvel utilisateur avec les informations fournies
    $query = "INSERT INTO utilisateurs (nom_utilisateur, email_utilisateur, mot_de_passe,date_inscription) VALUES (?, ?, ? , now())";
    $stmt = $pdo->prepare($query);

    // Hasher le mot de passe avec la fonction password_hash() de PHP
    $hashed_password = password_hash($mot_de_passe, PASSWORD_DEFAULT);

    // Exécuter la requête pour créer l'utilisateur
    if($stmt->execute([$nom_utilisateur, $email_utilisateur, $hashed_password])) {

      // Si l'utilisateur est créé avec succès, retourner les informations de l'utilisateur en tant que réponse JSON
      $user_id = $pdo->lastInsertId();
      $user = array(
        "id_utilisateur" => $user_id,
        "nom_utilisateur" => $nom_utilisateur,
        "email_utilisateur" => $email_utilisateur
      );
      http_response_code(201);
      echo json_encode($user);
      exit;
    }
    else {
      // Si la création de l'utilisateur échoue, retourner une erreur
      http_response_code(400);
      echo "Erreur de création de l'utilisateur.";
      exit;
    }
  }
  else {
    // Si l'un des champs du formulaire est vide, retourner une erreur
    http_response_code(400);
    echo "Veuillez remplir tous les champs.";
    exit;
  }
}
?>
