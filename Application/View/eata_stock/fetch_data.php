<?php
include '../../config/connect_db.php';

$startDate = isset($_GET['startDate']) ? $_GET['startDate'] : '1900-01-01';
$endDate = isset($_GET['endDate']) ? $_GET['endDate'] : '9999-12-31';

$sql = "SELECT 
            a.id_article AS id,
            a.nom AS article,
            a.stock_initial,
            COALESCE(SUM(o.entree_operation), 0) AS entree_operation,
            COALESCE(SUM(o.sortie_operation), 0) AS sortie_operation,
            a.stock_initial + COALESCE(SUM(o.entree_operation), 0) - COALESCE(SUM(o.sortie_operation), 0) AS stock_final,
            (a.stock_initial + COALESCE(SUM(o.entree_operation), 0) - COALESCE(SUM(o.sortie_operation), 0)) * a.prix AS valeur_stock,
            a.stock_min,
            CASE 
                WHEN (a.stock_initial + COALESCE(SUM(o.entree_operation), 0) - COALESCE(SUM(o.sortie_operation), 0)) < a.stock_min 
                THEN 'besoin' 
                ELSE 'bon' 
            END AS besoin
        FROM article a
        LEFT JOIN operation o ON a.nom = o.nom_article
        WHERE o.date_operation BETWEEN '$startDate' AND '$endDate'
        GROUP BY a.id_article";

$result = $conn->query($sql);

$data = array();
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}

header('Content-Type: application/json');
echo json_encode($data);

$conn->close();
?>