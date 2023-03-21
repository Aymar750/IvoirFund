<?php
include_once("../configdb.php");

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Vérifier si la méthode HTTP est POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Récupérer les données du formulaire
    $user_id = $_POST['user_id'];
    $name = $_POST['name'];
    $bio = $_POST['bio'];

    // Vérifier si le champ profile_picture est défini
    if (isset($_FILES['profile_picture'])) {
        $file_name = $_FILES['profile_picture']['name'];
        $file_tmp = $_FILES['profile_picture']['tmp_name'];
        $file_size = $_FILES['profile_picture']['size'];
        $file_type = $_FILES['profile_picture']['type'];

        // Vérifier si le fichier est une image
        $valid_extensions = array('jpeg', 'jpg', 'png');
        $file_extension = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        if (in_array($file_extension, $valid_extensions)) {
            // Enregistrer le fichier dans le dossier uploads
            $upload_dir = '../uploads/';
            $file_path = $upload_dir . $file_name;
            move_uploaded_file($file_tmp, $file_path);

            // Insérer les données dans la base de données
            $sql = "INSERT INTO Profiles (user_id, name, bio, profile_picture) VALUES (:user_id, :name, :bio, :profile_picture)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                'user_id' => $user_id,
                'name' => $name,
                'bio' => $bio,
                'profile_picture' => $file_path
            ]);

            // Renvoyer la réponse en JSON
            $response = [
                'status' => 'success',
                'message' => 'Profile created successfully'
            ];
            echo json_encode($response);
        } else {
            http_response_code(400);
            echo json_encode(['status' => 'error', 'message' => 'Invalid file type']);
        }
    } else {
        // Si le champ profile_picture n'est pas défini, insérer les données sans l'image
        $sql = "INSERT INTO Profiles (user_id, name, bio) VALUES (:user_id, :name, :bio)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'user_id' => $user_id,
            'name' => $name,
            'bio' => $bio
        ]);

        // Renvoyer la réponse en JSON
        $response = [
            'status' => 'success',
            'message' => 'Profile created successfully'
        ];
        echo json_encode($response);
    }
} else {
    http_response_code(405);
    echo json_encode(['status' => 'error', 'message' => 'Method not allowed']);
}
