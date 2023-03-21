<?
include_once("../configdb.php");

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit();
}

if($_SERVER['REQUEST_METHOD'] == 'GET') {
    // Récupérer l'id de l'utilisateur
    $user_id = $_GET['user_id'];

    // Vérifier si l'utilisateur existe
    $query = "SELECT COUNT(*) FROM Users WHERE id = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$user_id]);
    $user_exists = ($stmt->fetchColumn() > 0);

    if ($user_exists) {
        // Récupérer le profil de l'utilisateur
        $query = "SELECT * FROM Profiles WHERE user_id = ?";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$user_id]);
        $profile = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($profile) {
            // Retourner le profil de l'utilisateur
            header('Content-Type: application/json');
            echo json_encode($profile);
        } else {
            // Le profil n'a pas été trouvé pour cet utilisateur
            http_response_code(404);
            echo json_encode(array("message" => "Le profil n'a pas été trouvé pour cet utilisateur."));
        }
    } else {
        // L'utilisateur n'existe pas
        http_response_code(404);
        echo json_encode(array("message" => "L'utilisateur n'a pas été trouvé."));
    }
} else {
    // La méthode HTTP n'est pas autorisée
    http_response_code(405);
    echo json_encode(array("message" => "Méthode non autorisée."));
}
?>