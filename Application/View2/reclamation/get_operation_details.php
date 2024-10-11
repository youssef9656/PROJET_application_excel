<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include '../../config/connect_db.php';

// Récupérer l'ID de l'opération à partir des paramètres GET
if (isset($_GET['operation_id'])) {
    $operationId = intval($_GET['operation_id']);
} else {
    $operationId = 0;
}

if ($operationId > 0) {
    // Préparer la requête pour récupérer les détails de l'opération
    $query = "
        SELECT 
            o.id,
            o.lot_name,
            o.sous_lot_name,
            o.nom_article,
            o.nom_pre_fournisseur,
            o.service_operation,
            o.date_operation,
            o.entree_operation,
            o.sortie_operation,
            o.prix_operation,
            o.ref,
            o.pj_operation,
            o.depense_entre,
            o.depense_sortie,
            o.reclamation
        FROM operation o
        WHERE o.id = ?";

    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param("i", $operationId);
        $stmt->execute();
        $result = $stmt->get_result();

        // Récupérer les données
        if ($row = $result->fetch_assoc()) {
            echo json_encode($row);
        } else {
            echo json_encode(['error' => 'Opération non trouvée']);
        }

        $stmt->close();
    } else {
        echo json_encode(['error' => 'Erreur de préparation de la requête']);
    }
} else {
    echo json_encode(['error' => 'ID d\'opération invalide']);
}

$conn->close();
?>
