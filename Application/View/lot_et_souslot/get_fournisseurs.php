<?php
include '../../config/connect_db.php';

$query = "SELECT nom_fournisseur FROM fournisseurs WHERE action_A_D = 1";
$result = mysqli_query($conn, $query);

$fournisseurs = array();
while ($row = mysqli_fetch_assoc($result)) {
    $fournisseurs[] = $row;
}

header('Content-Type: application/json');
echo json_encode($fournisseurs);
?>
