<?php
include '../../config/connect_db.php';

$lot = $_GET['lot'] ?? '';
$sous_lot = $_GET['sous_lot'] ?? '';
$fournisseur = $_GET['fournisseur'] ?? '';
$service = $_GET['service'] ?? '';
$date_from = $_GET['date_from'] ?? '';
$date_to = $_GET['date_to'] ?? '';

$sql = "
    SELECT 
        o.date_operation, 
        SUM(o.entree_operation * p.prix_operation) AS total_depense_entree, 
        SUM(o.sortie_operation) AS total_sortie_operations 
    FROM operation o
    LEFT JOIN (
        SELECT 
            nom_article, 
            MAX(date_operation) AS last_date, 
            prix_operation 
        FROM operation 
        GROUP BY nom_article
    ) p 
    ON o.nom_article = p.nom_article AND o.date_operation = p.last_date
    WHERE  1=1  
";

if (!empty($lot)) {
    $sql .= " AND o.lot_name = '" . $conn->real_escape_string($lot) . "'";
}
if (!empty($sous_lot)) {
    $sql .= " AND o.sous_lot_name = '" . $conn->real_escape_string($sous_lot) . "'";
}
if (!empty($fournisseur)) {
    $sql .= " AND o.nom_pre_fournisseur = '" . $conn->real_escape_string($fournisseur) . "'";
}
if (!empty($service)) {
    $sql .= " AND o.service_name = '" . $conn->real_escape_string($service) . "'";
}
if (!empty($date_from) && !empty($date_to)) {
    $sql .= " AND o.date_operation BETWEEN '" . $conn->real_escape_string($date_from) . "' AND '" . $conn->real_escape_string($date_to) . "'";
}

$sql .= " GROUP BY o.date_operation ORDER BY o.date_operation";

$result = $conn->query($sql);

if (!$result) {
    die("Query failed: " . $conn->error);
}

$charts = $result->fetch_all(MYSQLI_ASSOC);
echo json_encode(['charts' => $charts]);
?>
