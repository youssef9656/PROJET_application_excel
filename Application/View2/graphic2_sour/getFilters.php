<?php
include '../../Config/connect_db.php'; // تأكد من مسار الاتصال بقاعدة البيانات

$filters = [];

$lotQuery = "SELECT DISTINCT lot_name FROM operation WHERE  pj_operation='Bon sortie'";
$sousLotQuery = "SELECT DISTINCT sous_lot_name FROM operation WHERE  pj_operation='Bon sortie'";
$articleQuery = "SELECT DISTINCT nom_article FROM operation WHERE  pj_operation='Bon sortie'";
$fournisseurQuery = "SELECT DISTINCT service_operation FROM operation WHERE  pj_operation='Bon sortie'";

$filters['lot'] = $conn->query($lotQuery)->fetch_all(MYSQLI_ASSOC);
$filters['sous_lot'] = $conn->query($sousLotQuery)->fetch_all(MYSQLI_ASSOC);
$filters['article'] = $conn->query($articleQuery)->fetch_all(MYSQLI_ASSOC);
$filters['fournisseur'] = $conn->query($fournisseurQuery)->fetch_all(MYSQLI_ASSOC);

header('Content-Type: application/json');
echo json_encode($filters);

$conn->close();
?>
