<?php
include '../../config/connect_db.php';

$sous_lot = $_GET['sous_lot'] ?? '';

if ($sous_lot) {
    $sql = "SELECT DISTINCT service_operation FROM operation WHERE sous_lot_name = '" . $conn->real_escape_string($sous_lot) . "'";
} else {
    $sql = "SELECT DISTINCT service_operation FROM operation"; // Récupérer tous les services
}

$result = $conn->query($sql);

if ($result) {
    $service = [];
    while ($row = $result->fetch_assoc()) {
        $service[] = $row;
    }
    echo json_encode($service);
} else {
    // En cas d'erreur dans la requête SQL
    echo json_encode(["error" => "Erreur dans la requête: " . $conn->error]);
}
?>
