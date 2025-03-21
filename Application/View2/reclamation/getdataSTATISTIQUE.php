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
        SUM(o.entree_operation) AS entree,  -- Utiliser SUM pour obtenir la somme des entrées
        p.prix_operation AS prix_operation, 
        o.nom_article,
        o.service_operation,
        COUNT(DISTINCT o.nom_pre_fournisseur) AS nombre_fournisseurs,  -- Compter les fournisseurs distincts
        o.nom_pre_fournisseur
    FROM operation o
    LEFT JOIN (
        SELECT 
            nom_article, 
            MAX(date_operation) AS last_date 
        FROM operation 
        WHERE pj_operation='Bon entrée' 
        GROUP BY nom_article
    ) last_operations ON o.nom_article = last_operations.nom_article 
                        AND o.date_operation = last_operations.last_date
    LEFT JOIN operation p ON o.nom_article = p.nom_article 
                          AND p.date_operation = last_operations.last_date
       LEFT JOIN fournisseurs f ON o.nom_pre_fournisseur = CONCAT(f.nom_fournisseur, ' ', f.prenom_fournisseur)
    WHERE o.pj_operation = 'Bon entrée'
      AND f.action_A_D = 1

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
// Uncomment this if you need the service filter
// if (!empty($service)) {
//     $sql .= " AND o.service_name = '" . $conn->real_escape_string($service) . "'";
// }
if (!empty($date_from) && !empty($date_to)) {
    $sql .= " AND o.date_operation BETWEEN '" . $conn->real_escape_string($date_from) . "' AND '" . $conn->real_escape_string($date_to) . "'";
}

$sql .= " GROUP BY o.date_operation, o.nom_article, o.service_operation, o.nom_pre_fournisseur, p.prix_operation 
          ORDER BY o.date_operation";

$result = $conn->query($sql);

if (!$result) {
    die("Query failed: " . $conn->error);
}

$charts = $result->fetch_all(MYSQLI_ASSOC);
echo json_encode(['charts' => $charts]);
?>
