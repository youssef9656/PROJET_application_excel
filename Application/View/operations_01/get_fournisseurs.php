<?php
include '../../config/connect_db.php';

$lotId = isset($_GET['lot_id']) ? intval($_GET['lot_id']) : 0;

if ($lotId > 0) {
    $query = "
        SELECT f.id_fournisseur, f.nom_fournisseur
        FROM fournisseurs f
        JOIN lot_fournisseurs lf ON f.id_fournisseur = lf.id_fournisseur
        WHERE lf.lot_id = ?";

    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param("i", $lotId);
        $stmt->execute();
        $result = $stmt->get_result();

        $fournisseurs = [];
        while ($row = $result->fetch_assoc()) {
            $fournisseurs[] = $row;
        }

        echo json_encode($fournisseurs);

        $stmt->close();
    } else {
        echo json_encode([]);
    }
}

$conn->close();
?>
