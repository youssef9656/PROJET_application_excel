<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include '../../config/connect_db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $operationId = mysqli_real_escape_string($conn, $_POST['operationId']);
    $reclamationText = mysqli_real_escape_string($conn, $_POST['reclamationText']);

    // Mise à jour de la réclamation dans la table operation
    $sql = "UPDATE operation SET reclamation = '$reclamationText' WHERE id = '$operationId'";

    if (mysqli_query($conn, $sql)) {
//        header("Location: option_Ent_Sor.php?message=reclamationSuccess");
        echo json_encode(['success' => true, 'message' => 'reclamationSuccess']);

    } else {
        header("Location: option_Ent_Sor.php?message=reclamationError");
    }
}
?>

