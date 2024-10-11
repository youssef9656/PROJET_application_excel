<?php

// Afficher les erreurs pour le débogage
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Inclusion du fichier de connexion à la base de données
include '../../Config/connect_db.php';

// Récupérer l'ID de l'utilisateur et les mots de passe depuis la requête GET
$user_id = $_GET['id'];
$currentPassword = $_GET['currentPassword'];
$newPassword = $_GET['newPassword'];

try {
    // Vérifier si l'utilisateur existe et si le mot de passe actuel est correct
    $stmt = mysqli_prepare($conn, "SELECT password FROM users WHERE id = ?");
    mysqli_stmt_bind_param($stmt, 'i', $user_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $storedPassword);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);

    // Comparer le mot de passe actuel (sans hachage)
    if ($storedPassword && $currentPassword === $storedPassword) {
        // Mettre à jour le mot de passe dans la base de données
        $stmt = mysqli_prepare($conn, "UPDATE users SET password = ? WHERE id = ?");
        mysqli_stmt_bind_param($stmt, 'si', $newPassword, $user_id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        // Renvoyer une réponse réussie
        echo json_encode(['status' => 'success', 'message' => 'Mot de passe mis à jour avec succès']);
    } else {
        // Mot de passe incorrect ou utilisateur non trouvé
        echo json_encode(['status' => 'error', 'message' => 'Mot de passe actuel incorrect']);
    }
} catch (Exception $e) {
    // En cas d'erreur, renvoyer une réponse d'erreur
    echo json_encode(['status' => 'error', 'message' => 'Erreur lors de la mise à jour du mot de passe : ' . $e->getMessage()]);
}

// Fermer la connexion
mysqli_close($conn);

?>
