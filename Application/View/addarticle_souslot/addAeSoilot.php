<?php
// Inclure le fichier de connexion à la base de données
include '../../Config/connect_db.php';

// Vérifier si les paramètres sont bien passés via GET
if (isset($_GET['sous_lot_name']) && isset($_GET['article_id'])) {

    $sous_lot_name = $_GET['sous_lot_name'];
    $article_id = $_GET['article_id'];

    // Rechercher l'ID du sous-lot
    $sqle1 = $conn->prepare("SELECT sous_lot_id FROM `sous_lots` WHERE sous_lot_name = ?");
    $sqle1->bind_param("s", $sous_lot_name);
    $sqle1->execute();
    $sqle1->bind_result($sous_lot_id);
    $sqle1->fetch();
    $sqle1->close();

    // Vérifiez si le sous-lot a été trouvé
    if ($sous_lot_id) {
        // Préparer la requête d'insertion
        $sql = $conn->prepare("INSERT INTO `sous_lot_articles` (`sous_lot_id`, `article_id`) VALUES (?, ?)");
        $sql->bind_param("ii", $sous_lot_id, $article_id);

        // Exécuter la requête d'insertion
        if ($sql->execute()) {
            echo json_encode(['message' => 'Nouvel enregistrement créé avec succès']);
        } else {
            echo json_encode(['message' => 'Erreur : ' . $sql->error]);
        }

        // Fermer la requête d'insertion
        $sql->close();
    } else {
        echo json_encode(['message' => 'Sous-lot non trouvé']);
    }

} else {
    echo json_encode(['message' => 'Paramètres manquants']);
}

// Fermer la connexion
$conn->close();
?>
