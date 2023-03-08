<?php
require('./backend/configdb.php');

// récupération des données de l'utilisateur depuis le formulaire
$username = $_POST['username'];
$password = $_POST['password'];

// vérification des données de l'utilisateur dans la base de données
try {
    $stmt = $pdo->prepare("SELECT * FROM utilisateurs WHERE nom_utilisateur = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['mot_de_passe'])) {
        echo "Connexion réussie !";
    } else {
        echo "Nom d'utilisateur ou mot de passe incorrect !";
    }
} catch (PDOException $e) {
    echo "La connexion a échoué : " . $e->getMessage();
}
?>
