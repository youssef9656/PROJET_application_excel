<?php
include '../../config/connect_db.php';

$query = "SELECT lot_id , lot_name FROM lots";
$result = mysqli_query($conn, $query);

$lots = array();
while ($row = mysqli_fetch_assoc($result)) {
    $lots[] = $row;
}

header('Content-Type: application/json');
echo json_encode($lots);
?>
