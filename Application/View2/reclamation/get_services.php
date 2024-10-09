<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include '../../config/connect_db.php';

$query = "SELECT id, service FROM service_zone";

if ($result = $conn->query($query)) {
    $services = [];
    while ($row = $result->fetch_assoc()) {
        $services[] = $row;
    }
    echo json_encode($services);
} else {
    echo json_encode([]);
}

$conn->close();
?>
