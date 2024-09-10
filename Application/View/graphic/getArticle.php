<?php
include '../../Config/connect_db.php';

$sousLot = $_GET['sous_lot'] ?? '';

$query = "SELECT DISTINCT nom_article FROM operation WHERE sous_lot_name = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('s', $sousLot);
$stmt->execute();
$result = $stmt->get_result();

$articles = [];
while ($row = $result->fetch_assoc()) {
    $articles[] = $row;
}

echo json_encode($articles);
?>
