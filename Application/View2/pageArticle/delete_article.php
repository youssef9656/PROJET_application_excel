<?php
include '../../Config/connect_db.php';

if (isset($_POST['id_article'])) {
    $id_article = $_POST['id_article'];

    // Préparer la requête SQL pour supprimer l'article
    $sql = "DELETE FROM article WHERE id_article = ?";

    // Vérifie si la préparation de la requête est correcte
    if ($stmt = $conn->prepare($sql)) {
        // Lier les paramètres à la requête préparée
        $stmt->bind_param("i", $id_article);

        // Exécuter la requête
        if ($stmt->execute()) {
            echo json_encode(["success" => true, "message" => "Article supprimé avec succès"]);
        } else {
            // Erreur lors de l'exécution de la requête
            echo json_encode(["success" => false, "message" => "Erreur lors de la suppression de l'article : " . $stmt->error]);
        }

        // Fermer la déclaration préparée
        $stmt->close();
    } else {
        // Si la préparation échoue, afficher l'erreur
        echo json_encode(["success" => false, "message" => "Échec de la préparation de la requête : " . $conn->error]);
    }
} else {
    // Si l'ID de l'article n'a pas été fourni
    echo json_encode(["success" => false, "message" => "ID de l'article non fourni"]);
}

// Fermer la connexion à la base de données
$conn->close();
?>
