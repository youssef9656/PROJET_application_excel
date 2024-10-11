<?php
include '../../config/connect_db.php';

if (isset($_GET['lot_id'])) {
    $lotId = intval($_GET['lot_id']);
} else {
    $lotId = 0;
}

if ($lotId > 0) {
    $query = "
        SELECT f.id_fournisseur, f.nom_fournisseur , prenom_fournisseur
        FROM fournisseurs f
        JOIN lot_fournisseurs lf ON f.id_fournisseur = lf.id_fournisseur
        WHERE lf.lot_id = ? and f.action_A_D = 1";

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
