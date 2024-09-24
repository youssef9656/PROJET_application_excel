<?php

include '../../Config/connect_db.php';

$lot =  isset($_GET['lot']) ? $_GET['lot'] : '';

$query = "SELECT DISTINCT sous_lot_name FROM operation WHERE lot_name = ?  AND pj_operation='Bon sortie'";
$stmt = $conn->prepare($query);
$stmt->bind_param('s', $lot);
$stmt->execute();
$result = $stmt->get_result();

$sousLots = [];
while ($row = $result->fetch_assoc()) {
    $sousLots[] = $row;
}

echo json_encode($sousLots);

