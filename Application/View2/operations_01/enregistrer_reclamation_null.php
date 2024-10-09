<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include '../../config/connect_db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $operationId = $_POST['operationId'];

    // Préparation de la requête
    $stmt = mysqli_prepare($conn, "UPDATE operation SET reclamation = NULL WHERE id = ?");

    // Liaison des paramètres
    mysqli_stmt_bind_param($stmt, "i", $operationId);

    // Exécution de la requête
    if (mysqli_stmt_execute($stmt)) {
        echo json_encode(['success' => true, 'message' => 'La réclamation a été enregistrée avec la valeur NULL.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Erreur lors de l\'enregistrement de la réclamation. Veuillez réessayer.']);
    }

    // Fermeture de la requête préparée
    mysqli_stmt_close($stmt);
}

mysqli_close($conn);
?>