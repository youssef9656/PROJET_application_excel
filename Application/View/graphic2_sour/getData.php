<?php
include '../../Config/connect_db.php'; // تأكد من مسار الاتصال بقاعدة البيانات

header('Content-Type: application/json');

$startDate = $_GET['start_date'] ?? '';
$endDate = $_GET['end_date'] ?? '';
$lot = $_GET['lot'] ?? '';
$sousLot = $_GET['sous_lot'] ?? '';
$article = $_GET['article'] ?? '';
$fournisseur = $_GET['fournisseur'] ?? '';

// إعداد استعلام أساسي
$sql = "SELECT * FROM operation WHERE 1=1 AND sortie_operation > 0 ";
$params = [];
$types = '';

if ($startDate) {
    $sql .= " AND date_operation >= ? ";
    $params[] = $startDate;
    $types .= 's';
}

if ($endDate) {
    $sql .= " AND date_operation <= ?";
    $params[] = $endDate;
    $types .= 's';
}

if ($lot) {
    $sql .= " AND lot_name = ?";
    $params[] = $lot;
    $types .= 's';
}

if ($sousLot) {
    $sql .= " AND sous_lot_name = ?";
    $params[] = $sousLot;
    $types .= 's';
}

if ($article) {
    $sql .= " AND nom_article = ?";
    $params[] = $article;
    $types .= 's';
}

if ($fournisseur) {
    $sql .= " AND nom_pre_fournisseur = ?";
    $params[] = $fournisseur;
    $types .= 's';
}

// إعداد الاستعلام
$stmt = $conn->prepare($sql);
if ($stmt) {
    // ربط المعلمات
    if ($params) {
        $stmt->bind_param($types, ...$params);
    }

    $stmt->execute();
    $result = $stmt->get_result();

    $data = array();
    if ($result->num_rows > 0) {
        $data = $result->fetch_all(MYSQLI_ASSOC);
    }

    echo json_encode($data);
    $stmt->close();
} else {
    echo json_encode(['error' => 'فشل إعداد الاستعلام']);
}

$conn->close();
?>
