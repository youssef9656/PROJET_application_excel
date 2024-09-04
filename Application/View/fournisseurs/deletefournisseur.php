<?php
// Inclure le fichier de configuration pour la connexion à la base de données
include "../../Config/connect_db.php";

// Vérifier si l'ID du fournisseur est présent dans la requête POST
if (isset($_POST['id_fournisseur'])) {
    $id_fournisseur = intval($_POST['id_fournisseur']); // Convertir en entier pour éviter les injections SQL

    // Préparer la requête SQL pour supprimer le fournisseur
    $stmt = $conn->prepare("DELETE FROM fournisseurs WHERE id_fournisseur = ?");

    if ($stmt === false) {
        die("Erreur de préparation de la déclaration : " . $conn->error);
    }

    // Lier les paramètres
    $stmt->bind_param("i", $id_fournisseur); // 'i' pour integer

    // Exécuter la requête
    if ($stmt->execute()) {
        echo "Fournisseur supprimé avec succès.";
    } else {
        echo "Erreur : " . $stmt->error;
    }

    // Fermer la déclaration
    $stmt->close();
} else {
    echo "Aucun ID de fournisseur fourni.";
}

// Fermer la connexion
$conn->close();
?>
