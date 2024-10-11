<?php
include '../../Config/connect_db.php'; // تأكد من مسار الاتصال بقاعدة البيانات

// جلب القيم الفريدة لكل فلتر
$filters = [];

$lotQuery = "SELECT DISTINCT lot_name FROM operation WHERE   pj_operation='Bon entrée'";
$sousLotQuery = "SELECT DISTINCT sous_lot_name FROM operation WHERE   pj_operation='Bon entrée'";
$articleQuery = "SELECT DISTINCT nom_article FROM operation WHERE   pj_operation='Bon entrée'";
$fournisseurQuery = " SELECT DISTINCT o.nom_pre_fournisseur 
        FROM operation o
        JOIN fournisseurs f ON o.nom_pre_fournisseur = CONCAT(f.nom_fournisseur, ' ', f.prenom_fournisseur)
        WHERE f.action_A_D = 1 
        AND o.pj_operation = 'Bon entrée' ";

$filters['lot'] = $conn->query($lotQuery)->fetch_all(MYSQLI_ASSOC);
$filters['sous_lot'] = $conn->query($sousLotQuery)->fetch_all(MYSQLI_ASSOC);
$filters['article'] = $conn->query($articleQuery)->fetch_all(MYSQLI_ASSOC);
$filters['fournisseur'] = $conn->query($fournisseurQuery)->fetch_all(MYSQLI_ASSOC);

header('Content-Type: application/json');
echo json_encode($filters);

$conn->close();
?>
