<?php
include '../../Config/connect_db.php'; // تأكد من مسار الاتصال بقاعدة البيانات

header('Content-Type: application/json');


$startDate = isset($_GET['start_date']) ? $_GET['start_date'] : '';
$endDate = isset($_GET['end_date']) ? $_GET['end_date'] : '';
$lot = isset($_GET['lot']) ? $_GET['lot'] : '';
$sousLot = isset($_GET['sous_lot']) ? $_GET['sous_lot'] : '';
$article = isset($_GET['article']) ? $_GET['article'] : '';
$fournisseur = isset($_GET['fournisseur']) ? $_GET['fournisseur'] : '';

// إعداد استعلام أساسي
//$sql = "SELECT *  FROM operation WHERE 1=1 AND pj_operation='Bon sortie'";
//
//$sql = "SELECT
//    op.*,
//    totals.Total_Entry_Operations,
//    totals.Total_sortie_Operations
//FROM
//    operation op
//JOIN
//    (SELECT
//       ROUND(COALESCE(SUM(entree_operation), 0), 2) AS Total_Entry_Operations,
//        ROUND(COALESCE(SUM(sortie_operation), 0), 2) AS Total_sortie_Operations
//    FROM
//        operation
//    WHERE
//        pj_operation='Bon sortie') totals
//
//WHERE  1=1 AND  op.pj_operation='Bon sortie'";

$sql = "SELECT * FROM operation WHERE 1=1 AND pj_operation='Bon sortie' ";

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
    $sql .= " AND service_operation = ?";
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
