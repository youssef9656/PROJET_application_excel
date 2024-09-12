<?php
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
