<?php 
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Credentials: true');
header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header("Content-Type: application/json; charset=UTF-8");

$host = 'localhost';
$dbname = 'ivoirfund';
$user = 'postgres';
$password = 12136270;

// Connexion à la base de données PostgreSQL avec PDO
try {
  $pdo = new PDO("pgsql:host=$host;dbname=$dbname", $user, $password);
  // Activer les erreurs PDO pour afficher les erreurs de requête SQL
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  echo "Connecté à la base de données.";
} catch(PDOException $e) {
  // Afficher l'erreur PDO
  echo "Erreur de connexion à la base de données: " . $e->getMessage();
}

?>