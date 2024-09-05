<?php
include '../../config/connect_db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $lot_name = $_POST['new_lot_name'];

    if (!empty($lot_name)) {
        // Vérifier si le nom du lot existe déjà
        $stmt = $conn->prepare("SELECT COUNT(*) FROM lots WHERE lot_name = ?");
        $stmt->bind_param("s", $lot_name);
        $stmt->execute();
        $stmt->bind_result($count);
        $stmt->fetch();
        $stmt->close();

        if ($count > 0) {
            echo json_encode(['success' => false, 'error' => 'Le nom du lot existe déjà.']);
        } else {
            // Insérer le nouveau lot
            $stmt = $conn->prepare("INSERT INTO lots (lot_name) VALUES (?)");
            $stmt->bind_param("s", $lot_name);

            if ($stmt->execute()) {
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false, 'error' => 'Erreur lors de l\'insertion du lot.']);
            }

            $stmt->close();
        }
    } else {
        echo json_encode(['success' => false, 'error' => 'Le nom du lot est requis.']);
    }
}
?>
