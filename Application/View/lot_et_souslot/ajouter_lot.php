<?php
include '../../config/connect_db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $lot_name = $_POST['new_lot_name'];

    if (!empty($lot_name)) {
        $stmt = $conn->prepare("INSERT INTO lots (lot_name) VALUES (?)");
        $stmt->bind_param("s", $lot_name);

        if ($stmt->execute()) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => 'Erreur lors de l\'insertion du lot.']);
        }

        $stmt->close();
    } else {
        echo json_encode(['success' => false, 'error' => 'Le nom du lot est requis.']);
    }
}
?>
