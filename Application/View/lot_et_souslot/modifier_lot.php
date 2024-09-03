<?php
include '../../config/connect_db.php';

// Vérifier si les données du formulaire sont passées
if (!isset($_POST['lot_id'], $_POST['lot_name'])) {
    die('Données du formulaire manquantes.');
}

$lot_id = intval($_POST['lot_id']);
$lot_name = trim($_POST['lot_name']);

// Mettre à jour les données du lot
$query = "UPDATE lots SET lot_name = ? WHERE lot_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('si', $lot_name, $lot_id);

if ($stmt->execute()) {
    header('Location: lot_table.php');
    exit();
} else {
    die('Erreur lors de la mise à jour du lot.');
}
?>
