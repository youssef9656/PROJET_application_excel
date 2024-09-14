<?php
include '../../config/connect_db.php';

// Vérifier si les données ont été envoyées via POST
if (isset($_POST['sous_lot_id']) && isset($_POST['sous_lot_name']) && isset($_POST['lot_id'])) {
    // Récupérer les données envoyées
    $sousLotId = mysqli_real_escape_string($conn, $_POST['sous_lot_id']);
    $sousLotName = mysqli_real_escape_string($conn, $_POST['sous_lot_name']);
    $lotId = mysqli_real_escape_string($conn, $_POST['lot_id']);

    // Préparer la requête SQL pour mettre à jour les données
    $query = "
        UPDATE sous_lots 
        SET sous_lot_name = '$sousLotName', lot_id = '$lotId' 
        WHERE sous_lot_id = '$sousLotId'
    ";

    // Exécuter la requête
    if (mysqli_query($conn, $query)) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => mysqli_error($conn)]);
    }

    mysqli_close($conn);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Données manquantes.']);
}
?>
