<?php
include '../../Config/connect_db.php';

header('Content-Type: application/json');

$type = $_GET['type'];
$lot = isset($_GET['lot']) ? $_GET['lot'] : '';
$sousLot = isset($_GET['sous_lot']) ? $_GET['sous_lot'] : '';

$data = [];

if ($type === 'sous_lot') {
    $sql = "SELECT DISTINCT sous_lot_name FROM operation WHERE lot_name = ?  AND pj_operation='Bon entrée'";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $lot);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $data[] = ['value' => $row['sous_lot_name'], 'text' => $row['sous_lot_name']];
    }
} elseif ($type === 'article') {
    $sql = "SELECT DISTINCT nom_article FROM operation WHERE lot_name = ? AND sous_lot_name = ? AND pj_operation='Bon entrée'";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ss', $lot, $sousLot);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $data[] = ['value' => $row['nom_article'], 'text' => $row['nom_article']];
    }
}

echo json_encode($data);
$conn->close();
?>
