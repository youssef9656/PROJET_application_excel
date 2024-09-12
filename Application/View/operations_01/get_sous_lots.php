<?php
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);
include '../../config/connect_db.php';

// Récupérer l'ID du lot à partir des paramètres GET
$lotId = isset($_GET['lot_id']) ? intval($_GET['lot_id']) : 0;

if ($lotId > 0) {
    $query = "SELECT sous_lot_id, sous_lot_name FROM sous_lots WHERE lot_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $lotId);
    $stmt->execute();
    $result = $stmt->get_result();

    $sousLots = [];
    while ($row = $result->fetch_assoc()) {
        $sousLots[] = $row;
    }

    echo json_encode($sousLots);
} else {
    echo json_encode([]);
}

$conn->close();
?>
