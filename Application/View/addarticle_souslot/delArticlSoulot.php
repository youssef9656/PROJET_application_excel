<?php
// Inclure le fichier de connexion à la base de données
include '../../Config/connect_db.php';

// Vérifier si l'article_id est passé via GET
if (isset($_GET['article_id'])) {
    $article_id = $_GET['article_id'];

    // Préparer la requête de suppression
    $sql = $conn->prepare("DELETE FROM `sous_lot_articles` WHERE `article_id` = ?");
    $sql->bind_param("i", $article_id);

    // Exécuter la requête de suppression
    if ($sql->execute()) {
        echo json_encode(['message' => 'Enregistrement supprimé avec succès']);
    } else {
        echo json_encode(['message' => 'Erreur : ' . $sql->error]);
    }

    // Fermer la requête
    $sql->close();
} else {
    echo json_encode(['message' => 'Paramètre article_id manquant']);
}

// Fermer la connexion
$conn->close();
?>
