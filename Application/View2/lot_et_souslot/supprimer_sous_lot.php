<?php
include '../../config/connect_db.php';

// Vérifier si l'ID du sous-lot est fourni
if (isset($_GET['id'])) {
    $sous_lot_id = $_GET['id'];

    // Démarrer une transaction pour s'assurer que les suppressions se font ensemble
    mysqli_begin_transaction($conn);

    try {
        // Supprimer les produits associés à ce sous-lot dans la table products
        $delete_products_query = "DELETE FROM products WHERE sous_lot_id = ?";
        $stmt_products = mysqli_prepare($conn, $delete_products_query);
        mysqli_stmt_bind_param($stmt_products, "i", $sous_lot_id);
        mysqli_stmt_execute($stmt_products);
        mysqli_stmt_close($stmt_products);

        // Supprimer le sous-lot lui-même dans la table sous_lots
        $delete_sous_lot_query = "DELETE FROM sous_lots WHERE sous_lot_id = ?";
        $stmt_sous_lot = mysqli_prepare($conn, $delete_sous_lot_query);
        mysqli_stmt_bind_param($stmt_sous_lot, "i", $sous_lot_id);
        mysqli_stmt_execute($stmt_sous_lot);
        mysqli_stmt_close($stmt_sous_lot);

        // Si tout s'est bien passé, valider la transaction
        mysqli_commit($conn);

        // Rediriger vers la page principale après la suppression
        header("Location: lot_souslot.php?message=success");
        exit;
    } catch (Exception $e) {
        // En cas d'erreur, annuler la transaction
        mysqli_rollback($conn);

        die('Erreur lors de la suppression : ' . $e->getMessage());
    }
} else {
    echo "ID du sous-lot non fourni.";
}
?>
