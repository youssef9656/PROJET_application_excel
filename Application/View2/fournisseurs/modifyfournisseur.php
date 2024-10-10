<?php
include "../../Config/connect_db.php";

// Vérifiez que 'id_fournisseur' existe dans $_POST
if (isset($_POST['id_fournisseur'])) {
    // Préparez la déclaration pour mettre à jour le fournisseur
    $stmt = $conn->prepare("UPDATE fournisseurs SET 
        nom_fournisseur = ?, prenom_fournisseur = ?, cp_fournisseur = ?, ville_fournisseur = ?, 
        pay_fournisseur = ?, telephone_fixe_fournisseur = ?, telephone_portable_fournisseur = ?, 
        commande_fournisseur = ?, condition_livraison = ?, coord_livreur = ?, calendrier_livraison = ?, 
        details_livraison = ?, condition_paiement = ?, facturation = ?, certificatione = ?, 
        produit_service_fourni = ?, siuvi_fournisseur = ?, mail_fournisseur = ?, groupe_fournisseur = ?, 
        adress_fournisseur = ? 
        WHERE id_fournisseur = ?");

    if ($stmt === false) {
        die("Erreur de préparation de la déclaration : " . $conn->error);
    }

    // Lier les paramètres
    $stmt->bind_param(
        "ssssssssssssssssssssi",
        $_POST['nom_fournisseur'], $_POST['prenom_fournisseur'], $_POST['cp_fournisseur'],
        $_POST['ville_fournisseur'], $_POST['pay_fournisseur'], $_POST['telephone_fixe_fournisseur'],
        $_POST['telephone_portable_fournisseur'], $_POST['commande_fournisseur'], $_POST['condition_livraison'],
        $_POST['coord_livreur'], $_POST['calendrier_livraison'], $_POST['details_livraison'],
        $_POST['condition_paiement'], $_POST['facturation'], $_POST['certificatione'],
        $_POST['produit_service_fourni'], $_POST['siuvi_fournisseur'], $_POST['mail_fournisseur'],
        $_POST['groupe_fournisseur'], $_POST['adress_fournisseur'],
        $_POST['id_fournisseur']  // ID du fournisseur à mettre à jour
    );

    if ($stmt->execute()) {
        echo "Informations du fournisseur mises à jour avec succès !";

        // Vérifiez s'il y a des opérations associées à ce fournisseur
        $checkOperationStmt = $conn->prepare("SELECT COUNT(*) FROM `operation` 
            WHERE `nom_pre_fournisseur` = (SELECT CONCAT(nom_fournisseur, ' ', prenom_fournisseur) 
            FROM fournisseurs WHERE id_fournisseur = ?)");

        $checkOperationStmt->bind_param("i", $_POST['id_fournisseur']);
        $checkOperationStmt->execute();
        $checkOperationStmt->bind_result($count);
        $checkOperationStmt->fetch();
        $checkOperationStmt->close();

        if ($count > 0) {
            // Mise à jour de la table operation
            $updateOperation = $conn->prepare("UPDATE `operation` 
            SET `nom_pre_fournisseur` = ? 
            WHERE `nom_pre_fournisseur` = (
                SELECT CONCAT(nom_fournisseur, ' ', prenom_fournisseur) 
                FROM fournisseurs 
                WHERE id_fournisseur = ?
            )");

            if ($updateOperation) {
                $nomComplet = $_POST['nom_fournisseur'] . ' ' . $_POST['prenom_fournisseur'];
                $idFournisseur = $_POST['id_fournisseur'];

                // Lier les paramètres pour la mise à jour de la table operation
                $updateOperation->bind_param("si", $nomComplet, $idFournisseur);

                if ($updateOperation->execute()) {
                    if ($updateOperation->affected_rows > 0) {
                        echo "Mise à jour de l'opération réussie !" ;
                    } else {
                        echo "Aucune opération mise à jour pour le fournisseur : " . $nomComplet;
                    }
                } else {
                    echo "Erreur lors de la mise à jour de l'opération : " . $updateOperation->error;
                }

                // Fermez la déclaration
                $updateOperation->close();
            } else {
                echo "Erreur lors de la préparation de la mise à jour de l'opération : " . $conn->error;
            }
        } else {
            echo "Aucun enregistrement trouvé dans operation pour ce fournisseur.";
        }
    } else {
        echo "Erreur lors de la mise à jour du fournisseur : " . $stmt->error;
    }

    // Fermez la déclaration et la connexion
    $stmt->close();
} else {
    echo "Erreur : Aucun ID de fournisseur spécifié.";
}

$conn->close();
?>





