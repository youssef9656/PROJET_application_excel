<?php

include '../../Config/connect_db.php';

$lot = $_GET['lot'] ?? '';

$query = "SELECT DISTINCT sous_lot_name FROM operation WHERE lot_name = ?  AND entree_operation > 0";
$stmt = $conn->prepare($query);
$stmt->bind_param('s', $lot);
$stmt->execute();
$result = $stmt->get_result();

$sousLots = [];
while ($row = $result->fetch_assoc()) {
    $sousLots[] = $row;
}

echo json_encode($sousLots);

