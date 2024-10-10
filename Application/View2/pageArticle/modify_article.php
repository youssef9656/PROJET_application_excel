<?php

include '../../Config/connect_db.php'; // Inclure le fichier de connexion à la base de données

// Vérifier si les données POST sont disponibles
if (isset($_POST['id_article'])) {
    // Récupérer les données du formulaire
    $id_article = $_POST['id_article'];
    $nom = $_POST['nom'];
    $description = $_POST['description'];
    $stock_min = $_POST['stock_min'];
    $stock_initial = $_POST['stock_initial'];
    $prix = $_POST['prix'];
    $unite = $_POST['unite'];

    if (true) {
        // Si l'exécution est réussie, mettre à jour la table operation
        $updateOperation = $conn->prepare("
    UPDATE `operation` 
    SET `nom_article` = ? 
    WHERE `nom_article` =(SELECT `nom` FROM `article` WHERE `id_article` = ?)");


        if ($updateOperation) {
            // Lier les paramètres pour la mise à jour de la table operation
            $updateOperation->bind_param("si", $nom, $id_article);

            // Exécuter la mise à jour
            if ($updateOperation->execute()) {
                // Si la mise à jour est réussie
                echo json_encode(["success" => true, "message" => "Article modifié avec succès"]);
            } else {
                // En cas d'échec d'exécution de la mise à jour de l'opération
                echo json_encode(["success" => false, "message" => "Erreur lors de la mise à jour de l'opération"]);
            }
            // Fermer la déclaration préparée
            $updateOperation->close();
        } else {
            // En cas d'échec de la préparation de la mise à jour de l'opération
            echo json_encode(["success" => false, "message" => "Échec de la préparation de la mise à jour de l'opération"]);
        }
    } else {
        // En cas d'échec d'exécution de la mise à jour de l'article
        echo json_encode(["success" => false, "message" => "Erreur lors de la modification de l'article"]);
    }

    // Préparer la requête SQL pour mettre à jour l'article
    $sql = "UPDATE article SET 
                nom = ?, 
                description = ?, 
                stock_min = ?, 
                stock_initial = ?, 
                prix = ?, 
                unite = ? 
            WHERE id_article = ?";

    // Préparer la requête avec mysqli
    if ($stmt = $conn->prepare($sql)) {
        // Associer les paramètres à la requête
        $stmt->bind_param("ssiiisi", $nom, $description, $stock_min, $stock_initial, $prix, $unite, $id_article);
        $stmt->execute();
        // Fermer la déclaration préparée pour l'article
        $stmt->close();
    } else {
        // En cas d'échec de la préparation de la requête
        echo json_encode(["success" => false, "message" => "Échec de la préparation de la requête"]);
    }
} else {
    // Si l'ID de l'article n'a pas été envoyé
    echo json_encode(["success" => false, "message" => "ID de l'article non fourni"]);
}

// Fermer la connexion à la base de données
$conn->close();

?>
