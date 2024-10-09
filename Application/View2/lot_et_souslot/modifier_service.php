<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include '../../config/connect_db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_GET['id'];
    $service = $_POST['service'];
    $zone = $_POST['zone'];
    $ref = $_POST['ref'];
    $equip = $_POST['equip'];

    $stmt = mysqli_prepare($conn, "UPDATE service_zone SET service = ?, zone = ?, ref = ?, equip = ? WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "ssssi", $service, $zone, $ref, $equip, $id);

    if (mysqli_stmt_execute($stmt)) {
        echo "Service mis à jour avec succès !".$id;
    } else {
        echo "Erreur lors de la mise à jour : " . mysqli_error($conn);
    }
}

?>

