<?php
include '../../Config/connect_db.php';

header('Content-Type: application/json');

$data = [
    'lot' => [],
    'sous_lot' => [],
    'article' => [],
    'fournisseur' => []
];

// استرجاع البيانات الخاصة بالـ 'lot'
$sql = "SELECT DISTINCT lot_name FROM operation WHERE  sortie_operation > 0";
$result = $conn->query($sql);
while ($row = $result->fetch_assoc()) {
    $data['lot'][] = ['value' => $row['lot_name'], 'text' => $row['lot_name']];
}

// استرجاع البيانات الخاصة بـ 'sous_lot'
$sql = "SELECT DISTINCT sous_lot_name FROM operation  WHERE  sortie_operation > 0";
$result = $conn->query($sql);
while ($row = $result->fetch_assoc()) {
    $data['sous_lot'][] = ['value' => $row['sous_lot_name'], 'text' => $row['sous_lot_name']];
}

// استرجاع البيانات الخاصة بـ 'article'
$sql = "SELECT DISTINCT nom_article FROM operation where  sortie_operation > 0";
$result = $conn->query($sql);
while ($row = $result->fetch_assoc()) {
    $data['article'][] = ['value' => $row['nom_article'], 'text' => $row['nom_article']];
}

// استرجاع البيانات الخاصة بـ 'fournisseur'
$sql = "SELECT DISTINCT nom_pre_fournisseur FROM operation  WHERE  sortie_operation > 0";
$result = $conn->query($sql);
while ($row = $result->fetch_assoc()) {
    $data['fournisseur'][] = ['value' => $row['nom_pre_fournisseur'], 'text' => $row['nom_pre_fournisseur']];
}

echo json_encode($data);
$conn->close();
?>
