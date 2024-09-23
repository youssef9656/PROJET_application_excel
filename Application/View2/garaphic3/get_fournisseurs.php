<?php
include '../../config/connect_db.php';

$sous_lot = $_GET['sous_lot'] ?? '';

$sql = "SELECT DISTINCT nom_pre_fournisseur FROM operation WHERE sous_lot_name = '" . $conn->real_escape_string($sous_lot) . "'";
$result = $conn->query($sql);

$fournisseurs = [];
while ($row = $result->fetch_assoc()) {
    $fournisseurs[] = $row;
}

echo json_encode($fournisseurs);
?>
