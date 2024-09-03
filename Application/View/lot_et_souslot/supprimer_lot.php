<?php
include '../../config/connect_db.php';

// Vérifier si l'ID du lot est passé dans l'URL
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die('ID du lot invalide.');
}

$lot_id = intval($_GET['id']);

// Supprimer le lot
$query = "DELETE FROM lots WHERE lot_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $lot_id);

if ($stmt->execute()) {
    header('Location: lot_table.php');
    exit();
} else {
    die('Erreur lors de la suppression du lot.');
}
?>
