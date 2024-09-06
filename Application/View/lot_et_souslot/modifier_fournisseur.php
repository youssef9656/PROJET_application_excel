<?php
include '../../config/connect_db.php';

// Vérifier si les données ont été envoyées via POST
if (isset($_POST['id']) && isset($_POST['fournisseur_id']) && isset($_POST['lot_id'])) {
    // Récupérer les données envoyées
    $id = mysqli_real_escape_string($conn, $_POST['id']);
    $fournisseurId = mysqli_real_escape_string($conn, $_POST['fournisseur_id']);
    $lotId = mysqli_real_escape_string($conn, $_POST['lot_id']);

    // Préparer la requête SQL pour mettre à jour les données
    $query = "
        UPDATE lot_fournisseurs 
        SET lot_id = '$lotId', id_fournisseur = '$fournisseurId' 
        WHERE id = '$id'
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
