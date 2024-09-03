<?php
// Inclure le fichier de connexion à la base de données
include '../../config/connect_db.php';

// Vérifier si les données du formulaire ont été soumises
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les données du formulaire
    $lot_id = mysqli_real_escape_string($conn, $_POST['lot_id']);
    $sous_lot_name = mysqli_real_escape_string($conn, $_POST['sous_lot_name']);

    // Vérifier que les champs ne sont pas vides
    if (!empty($lot_id) && !empty($sous_lot_name)) {
        // Insérer le nouveau sous-lot dans la base de données
        $query = "INSERT INTO sous_lots (sous_lot_name, lot_id) VALUES ('$sous_lot_name', '$lot_id')";

        if (mysqli_query($conn, $query)) {
            // Rediriger vers la page principale avec un message de succès
            header('Location: lot_souslot.php?message=success');
            exit();
        } else {
            // Rediriger avec un message d'erreur
            header('Location: lot_souslot.php?message=error');
            exit();
        }
    } else {
        // Rediriger avec un message d'erreur si les champs sont vides
        header('Location: lot_souslot.php?message=empty_fields');
        exit();
    }
} else {
    // Rediriger si l'accès direct à la page est tenté
    header('Location: lot_souslot.php');
    exit();
}
?>
