<?php
include '../../config/connect_db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fournisseurId = $_POST['fournisseurId'];
    $fournisseurNom = $_POST['fournisseurNom'];
    $lotId = $_POST['lotSelect'];

    // Préparer la requête SQL pour mettre à jour le fournisseur
    $query = "
        UPDATE lot_fournisseurs
        JOIN fournisseurs ON lot_fournisseurs.id_fournisseur = fournisseurs.id_fournisseur
        SET fournisseurs.nom_fournisseur = ?, lot_fournisseurs.lot_id = ?
        WHERE fournisseurs.id_fournisseur = ?
    ";

    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'sii', $fournisseurNom, $lotId, $fournisseurId);

    if (mysqli_stmt_execute($stmt)) {
        echo 'Succès';
    } else {
        echo 'Erreur : ' . mysqli_error($conn);
    }

    mysqli_stmt_close($stmt);
}
?>
