<?php
include "../../Config/connect_db.php";

// Vérifie si l'ID du fournisseur a été passé via GET
if (isset($_GET['id_fournisseur'])) {
    $id_fournisseur = intval($_GET['id_fournisseur']); // Récupère l'ID et assure qu'il est entier

    // Récupère la valeur actuelle de `action_A_D`
    $sql = "SELECT action_A_D FROM fournisseurs WHERE id_fournisseur = $id_fournisseur";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $currentValue = $row['action_A_D'];

        // Change la valeur : si 1 devient 0, sinon devient 1
        $newValue = ($currentValue == 1) ? 0 : 1;

        // Met à jour la valeur dans la base de données
        $updateSql = "UPDATE fournisseurs SET action_A_D = $newValue WHERE id_fournisseur = $id_fournisseur";

        if ($conn->query($updateSql) === TRUE) {
            echo "Valeur de action_A_D mise à jour avec succès pour le fournisseur $id_fournisseur.";
        } else {
            echo "Erreur lors de la mise à jour : " . $conn->error;
        }
    } else {
        echo "Fournisseur non trouvé avec l'ID $id_fournisseur.";
    }
} else {
    echo "ID du fournisseur non fourni.";
}

// Ferme la connexion à la base de données
$conn->close();
?>
