<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include '../../config/connect_db.php';

// Récupérer l'ID du sous-lot à partir des paramètres GET
$sousLotId = isset($_GET['sous_lot_id']) ? intval($_GET['sous_lot_id']) : 0;

if ($sousLotId > 0) {
    $query = "SELECT a.id_article, a.nom FROM article a
              JOIN sous_lot_articles sla ON a.id_article = sla.article_id
              WHERE sla.sous_lot_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $sousLotId);
    $stmt->execute();
    $result = $stmt->get_result();

    $articles = [];
    while ($row = $result->fetch_assoc()) {
        $articles[] = $row;
    }

    echo json_encode($articles);
} else {
    echo json_encode([]);
}

$conn->close();
?>
