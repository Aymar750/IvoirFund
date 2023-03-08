<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Credentials: true");
header("Access-control-Allow-Methods: PUT,POST,GET,DELETE");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-type, Accept");
header("Content-type: application/json");

// Variables de connexion
$host = 'localhost';
$dbname = 'ivoirfund';
$user = 'postgres';
$password = 12136270;

// Connexion à la base de données
try {
    $dsn = "pgsql:host=$host;dbname=$dbname";
    $conn = new PDO($dsn, $user, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connexion réussie !";
} catch (PDOException $e) {
    echo "Connexion échouée : " . $e->getMessage();
}

// Fermer la connexion
$conn = null;
?>
