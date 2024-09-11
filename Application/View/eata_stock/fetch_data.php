<?php
header('Content-Type: application/json');
include '../../config/connect_db.php';

// Get filter dates and status
$start_date = isset($_GET['start_date']) ? $_GET['start_date'] : '1970-01-01'; // Default to a very old date if not set
$end_date = isset($_GET['end_date']) ? $_GET['end_date'] : date('Y-m-d'); // Default to today if not set
$status_filter = isset($_GET['status_filter']) ? $_GET['status_filter'] : ''; // Get the status filter (besoin or bon)

// Prepare SQL query
$sql = "SELECT 
    a.id_article AS ID,
    a.nom AS Article,
    a.stock_initial AS Stock_Initial,
    ROUND(COALESCE(SUM(o.entree_operation), 0), 2) AS Total_Entry_Operations,
    ROUND(COALESCE(SUM(o.sortie_operation), 0), 2) AS Total_Exit_Operations,
    ROUND(a.stock_initial + COALESCE(SUM(o.entree_operation), 0) - COALESCE(SUM(o.sortie_operation), 0), 2) AS Stock_Final,
    ROUND(
        (
            SELECT p.prix_operation
            FROM operation p
            WHERE p.nom_article = a.nom
            AND p.date_operation BETWEEN '$start_date' AND '$end_date'
            ORDER BY p.date_operation DESC
            LIMIT 1
        ), 2
    ) AS Prix,
    ROUND(
        (
            a.stock_initial + COALESCE(SUM(o.entree_operation), 0) - COALESCE(SUM(o.sortie_operation), 0)
        ) * (
            SELECT p.prix_operation
            FROM operation p
            WHERE p.nom_article = a.nom
            AND p.date_operation BETWEEN '$start_date' AND '$end_date'
            ORDER BY p.date_operation DESC
            LIMIT 1
        ), 2
    ) AS Stock_Value,
    ROUND(
        COALESCE(SUM(o.entree_operation), 0) * (
            SELECT p.prix_operation
            FROM operation p
            WHERE p.nom_article = a.nom
            AND p.date_operation BETWEEN '$start_date' AND '$end_date'
            ORDER BY p.date_operation DESC
            LIMIT 1
        ), 2
    ) AS Total_Depenses_Entree,
    ROUND(
        COALESCE(SUM(o.sortie_operation), 0) * (
            SELECT p.prix_operation
            FROM operation p
            WHERE p.nom_article = a.nom
            AND p.date_operation BETWEEN '$start_date' AND '$end_date'
            ORDER BY p.date_operation DESC
            LIMIT 1
        ), 2
    ) AS Total_Depenses_Sortie,
    a.stock_min AS Stock_Min,
    CASE 
        WHEN a.stock_initial + COALESCE(SUM(o.entree_operation), 0) - COALESCE(SUM(o.sortie_operation), 0) < a.stock_min 
        THEN 'besoin' 
        ELSE 'bon' 
    END AS Requirement_Status
FROM 
    article a
LEFT JOIN 
    operation o ON o.nom_article = a.nom
WHERE 
    o.date_operation BETWEEN '$start_date' AND '$end_date'
GROUP BY 
    a.id_article, a.nom, a.stock_initial, a.stock_min
HAVING 
    ('$status_filter' = '' OR Requirement_Status = '$status_filter')
LIMIT 0, 25;
";

$result = $conn->query($sql);

$data = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}

echo json_encode($data);

$conn->close();
?>
