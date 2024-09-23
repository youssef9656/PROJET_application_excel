<?php
include '../../config/connect_db.php';

$lot = $_GET['lot'] ?? '';

$sql = "SELECT DISTINCT sous_lot_name FROM operation WHERE lot_name = '" . $conn->real_escape_string($lot) . "'";
$result = $conn->query($sql);

$sous_lots = [];
while ($row = $result->fetch_assoc()) {
    $sous_lots[] = $row;
}

echo json_encode($sous_lots);
?>
