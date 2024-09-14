<?php
include '../../config/connect_db.php';  // Ajustez le chemin si nécessaire

// Vérifier si les données du formulaire ont été soumises
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les données du formulaire
    $lot_id = mysqli_real_escape_string($conn, $_POST['lot_id']);
    $fournisseur_id = mysqli_real_escape_string($conn, $_POST['fournisseur_id']);

    // Vérifier que les champs ne sont pas vides
    if (!empty($lot_id) && !empty($fournisseur_id)) {
        // Vérifier si le fournisseur est déjà associé au lot
        $checkQuery = "SELECT COUNT(*) AS count FROM lot_fournisseurs WHERE lot_id = ? AND id_fournisseur = ?";
        $stmt = $conn->prepare($checkQuery);
        $stmt->bind_param("ii", $lot_id, $fournisseur_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        if ($row['count'] > 0) {
            // Fournisseur déjà associé au lot
            echo json_encode(['success' => false, 'error' => 'Le fournisseur est déjà associé à ce lot.']);
        } else {
            // Insérer le nouveau fournisseur pour le lot
            $insertQuery = "INSERT INTO lot_fournisseurs (lot_id, id_fournisseur) VALUES (?, ?)";
            $stmt = $conn->prepare($insertQuery);
            $stmt->bind_param("ii", $lot_id, $fournisseur_id);

            if ($stmt->execute()) {
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false, 'error' => 'Erreur lors de l\'insertion du fournisseur.']);
            }

            $stmt->close();
        }
    } else {
        echo json_encode(['success' => false, 'error' => 'Le lot et le fournisseur sont requis.']);
    }
}
?>
