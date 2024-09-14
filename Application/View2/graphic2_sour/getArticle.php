<?php
include '../../Config/connect_db.php';

$sousLot =  isset($_GET['sous_lot']) ? $_GET['sous_lot'] : '';

$query = "SELECT DISTINCT nom_article FROM operation WHERE sous_lot_name = ?  AND sortie_operation > 0";
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
