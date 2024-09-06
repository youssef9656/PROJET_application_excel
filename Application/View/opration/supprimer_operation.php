<?php
// Inclure le fichier de connexion à la base de données
include '../../config/connect_db.php';

// Vérifier si l'ID de l'opération a été passé dans l'URL
if (isset($_GET['id'])) {
    $operation_id = intval($_GET['id']);

    // Préparer la requête SQL pour supprimer l'opération
    $query = "DELETE FROM operation WHERE id = ?";

    // Initialiser une déclaration préparée
    if ($stmt = mysqli_prepare($conn, $query)) {
        // Associer les paramètres à la requête préparée
        mysqli_stmt_bind_param($stmt, "i", $operation_id);

        // Exécuter la requête
        if (mysqli_stmt_execute($stmt)) {
            // Redirection vers la page de tableau des opérations après suppression
            header('Location: option_Ent_Sor.php?message=operation_supprimee');
            exit;
        } else {
            echo "Erreur lors de la suppression de l'opération : " . mysqli_error($conn);
        }

        // Fermer la déclaration
        mysqli_stmt_close($stmt);
    } else {
        echo "Erreur de préparation de la requête : " . mysqli_error($conn);
    }
} else {
    echo "ID d'opération non spécifié.";
}

// Fermer la connexion à la base de données
mysqli_close($conn);
?>
