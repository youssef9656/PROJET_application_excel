<?php
include '../../config/connect_db.php';

// Récupérer les données du formulaire
$id_article = $_POST['id_article'];
$nom = $_POST['nom_article'];
$description = $_POST['description'];
$stock_min = $_POST['stock_min'];
$stock_initial = $_POST['stock_initial'];
$prix = $_POST['prix'];
$unite = $_POST['unite'];

// Mise à jour de l'article
$query = "UPDATE article SET nom = ?, description = ?, stock_min = ?, stock_initial = ?, prix = ?, unite = ? WHERE id_article = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('ssiddsi', $nom, $description, $stock_min, $stock_initial, $prix, $unite, $id_article);

if ($stmt->execute()) {
    echo "Article modifié avec succès.";
} else {
    echo "Erreur lors de la modification de l'article : " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
