<?php
include '../../config/connect_db.php';

// Vérifier si l'id du fournisseur est passé en paramètre
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $fournisseur_id = mysqli_real_escape_string($conn, $_GET['id']);

    // Vérifier que le fournisseur existe dans la table
    $checkQuery = "SELECT COUNT(*) AS count FROM lot_fournisseurs WHERE id_fournisseur = ?";
    $stmt = $conn->prepare($checkQuery);
    $stmt->bind_param("i", $fournisseur_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if ($row['count'] > 0) {
        // Si le fournisseur existe, on le supprime
        $deleteQuery = "DELETE FROM lot_fournisseurs WHERE id_fournisseur = ?";
        $stmt = $conn->prepare($deleteQuery);
        $stmt->bind_param("i", $fournisseur_id);

        if ($stmt->execute()) {
            echo "Le fournisseur a été supprimé avec succès.";
            // Rediriger vers la page précédente ou principale
            header("Location: lot_souslot.php?message=fournisseur_deleted");
        } else {
            echo "Erreur lors de la suppression du fournisseur.";
        }
    } else {
        echo "Ce fournisseur n'existe pas.";
    }

    $stmt->close();
} else {
    echo "ID de fournisseur manquant.";
}

$conn->close();
?>
