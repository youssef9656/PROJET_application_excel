<?php
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);

include '../../config/connect_db.php';

$result = mysqli_query($conn, "SELECT lot_id, lot_name FROM lots");
$lots = array();

while ($row = mysqli_fetch_assoc($result)) {
    $lots[] = $row;
}

// Assurez-vous que $lots n'est pas vide avant d'encoder
if (empty($lots)) {
    echo json_encode([]);
} else {
    echo json_encode($lots);
}

mysqli_close($conn);
?>
