<?php
include '../../config/connect_db.php';

$lot = $_GET['lot'] ?? '';

// Vérifier si un lot est sélectionné
if (!empty($lot)) {
    // Si un lot est sélectionné, filtrer par lot
    $sql = "SELECT DISTINCT sous_lot_name FROM operation WHERE lot_name = '" . $conn->real_escape_string($lot) . "'";
} else {
    // Si aucun lot n'est sélectionné, récupérer tous les sous-lots
    $sql = "SELECT DISTINCT sous_lot_name FROM operation";
}

$result = $conn->query($sql);

$sous_lots = [];
while ($row = $result->fetch_assoc()) {
    $sous_lots[] = $row;
}

echo json_encode($sous_lots);
?>
