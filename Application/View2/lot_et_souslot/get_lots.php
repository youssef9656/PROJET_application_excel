<?php
include '../../config/connect_db.php';

// Exécuter la requête pour obtenir les données des lots
$query = "SELECT lot_id, lot_name FROM lots";
$result = mysqli_query($conn, $query);

// Vérifier si la requête a réussi
if (!$result) {
    die('Erreur de requête : ' . mysqli_error($conn));
}

// Récupérer les données et les encoder en JSON
$lots = array();
while ($row = mysqli_fetch_assoc($result)) {
    $lots[] = array('id' => $row['lot_id'], 'name' => $row['lot_name']);
}

echo json_encode($lots);

mysqli_close($conn);
?>
