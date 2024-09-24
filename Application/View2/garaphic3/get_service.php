<?php
include '../../config/connect_db.php';

$sous_lot = $_GET['sous_lot'] ?? '';

$sql = "SELECT DISTINCT service_operation FROM operation WHERE sous_lot_name = '" . $conn->real_escape_string($sous_lot) . "'";
$result = $conn->query($sql);

$service = [];
while ($row = $result->fetch_assoc()) {
    $service[] = $row;
}

echo json_encode($service);
?>
