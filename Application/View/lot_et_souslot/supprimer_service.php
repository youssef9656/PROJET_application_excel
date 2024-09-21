<?php
include '../../config/connect_db.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Vérification si l'ID a été envoyé via la requête POST
if (isset($_POST['id'])) {
    $id = $_POST['id'];

    // Préparer la requête pour supprimer l'enregistrement
    $stmt = $conn->prepare("DELETE FROM service_zone WHERE id = ?");
    $stmt->bind_param("i", $id);

    // Exécuter la requête
    if ($stmt->execute()) {
        // Retourner une réponse de succès
        echo json_encode(['status' => 'success', 'message' => 'Service supprimé avec succès']);
    } else {
        // Retourner une réponse d'erreur
        echo json_encode(['status' => 'error', 'message' => 'Erreur lors de la suppression : ' . $stmt->error]);
    }

    // Fermer la requête
    $stmt->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'Aucun ID fourni']);
}

// Fermer la connexion
$conn->close();
?>
