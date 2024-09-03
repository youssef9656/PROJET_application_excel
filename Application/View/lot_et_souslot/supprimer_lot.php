<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include '../../config/connect_db.php';

// Vérifier si l'ID du lot est passé dans l'URL
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die('ID du lot invalide.');
}

$lot_id = intval($_GET['id']);

// Fonction pour vérifier les références
function checkReferences($conn, $lot_id) {
    $queries = [
        "SELECT COUNT(*) FROM lot_fournisseurs WHERE lot_id = ?"
        // Ajoutez d'autres requêtes pour vérifier d'autres tables si nécessaire
    ];

    foreach ($queries as $query) {
        $stmt = $conn->prepare($query);
        $stmt->bind_param('i', $lot_id);
        $stmt->execute();
        $stmt->bind_result($count);
        $stmt->fetch();
        if ($count > 0) {
            return true; // Références trouvées
        }
    }
    return false; // Aucune référence trouvée
}

// Vérifier les références
if (checkReferences($conn, $lot_id)) {
    header('Location: lot_souslot.php?error=reference'); // Rediriger avec un paramètre d'erreur
    exit();
}

// Démarrer une transaction
$conn->begin_transaction();

try {
    // Supprimer les enregistrements associés dans lot_fournisseurs
    $query1 = "DELETE FROM lot_fournisseurs WHERE lot_id = ?";
    $stmt1 = $conn->prepare($query1);
    $stmt1->bind_param('i', $lot_id);
    $stmt1->execute();

    // Supprimer le lot
    $query2 = "DELETE FROM lots WHERE lot_id = ?";
    $stmt2 = $conn->prepare($query2);
    $stmt2->bind_param('i', $lot_id);
    $stmt2->execute();

    // Confirmer la transaction
    $conn->commit();

    header('Location: lot_souslot.php');
    exit();
} catch (Exception $e) {
    // Annuler la transaction en cas d'erreur
    $conn->rollback();
    die('Erreur lors de la suppression du lot : ' . $e->getMessage());
}
?>
