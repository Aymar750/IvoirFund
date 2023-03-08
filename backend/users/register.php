<?php
include_once('../configdb.php');

// récupération des données de l'utilisateur depuis le formulaire
$username = $_POST['username'];
$email = $_POST['email'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT); // hachage du mot de passe

// insertion des données de l'utilisateur dans la base de données
try {
    $stmt = $pdo->prepare("INSERT INTO users (nom_utilisateur, email_utilisateur, mot_de_passe,date_inscription) VALUES (?, ?, ?, now");
    $stmt->execute([$username, $email, $password]);
    echo "Inscription réussie !";
} catch (PDOException $e) {
    echo "L'inscription a échoué : " . $e->getMessage();
}
?>
