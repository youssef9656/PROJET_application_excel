<?php

include "../../Config/connect_db.php";

// Vérifiez que 'id_fournisseur' existe dans $_POST
if (isset($_POST['id_fournisseur'])) {
    $idFournisseur = $_POST['id_fournisseur'];
    $nomFournisseur = $_POST['nom_fournisseur'];
    $prenomFournisseur = $_POST['prenom_fournisseur'];
    $nomComplet = $nomFournisseur . ' ' . $prenomFournisseur;

    // Étape 1 : Vérifier si le nom et prénom existent déjà pour un autre fournisseur
    $checkUnique = $conn->prepare("SELECT COUNT(*) FROM fournisseurs 
        WHERE nom_fournisseur = ? AND prenom_fournisseur = ? AND id_fournisseur != ?");
    $checkUnique->bind_param("ssi", $nomFournisseur, $prenomFournisseur, $idFournisseur);
    $checkUnique->execute();
    $checkUnique->bind_result($count);
    $checkUnique->fetch();
    $checkUnique->close();

    if ($count > 0) {
        die("Erreur : Un fournisseur avec ce nom et prénom existe déjà.");
    }

    // Étape 2 : Récupérer l'ancien nom complet du fournisseur avant la mise à jour
    $selectFournisseur = $conn->prepare("SELECT CONCAT(nom_fournisseur, ' ', prenom_fournisseur) 
        FROM fournisseurs WHERE id_fournisseur = ?");
    $selectFournisseur->bind_param("i", $idFournisseur);
    $selectFournisseur->execute();
    $selectFournisseur->bind_result($ancienNomComplet);
    $selectFournisseur->fetch();
    $selectFournisseur->close();

    // Vérification du résultat de l'ancien nom complet
    if (empty($ancienNomComplet)) {
        die("Erreur : Aucun fournisseur trouvé avec cet ID.");
    }

    // Étape 3 : Mise à jour du fournisseur dans la table 'fournisseurs'
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

    // Lier les paramètres pour la mise à jour du fournisseur
    $stmt->bind_param(
        "ssssssssssssssssssssi",
        $nomFournisseur, $prenomFournisseur, $_POST['cp_fournisseur'], $_POST['ville_fournisseur'],
        $_POST['pay_fournisseur'], $_POST['telephone_fixe_fournisseur'], $_POST['telephone_portable_fournisseur'],
        $_POST['commande_fournisseur'], $_POST['condition_livraison'], $_POST['coord_livreur'],
        $_POST['calendrier_livraison'], $_POST['details_livraison'], $_POST['condition_paiement'],
        $_POST['facturation'], $_POST['certificatione'], $_POST['produit_service_fourni'],
        $_POST['siuvi_fournisseur'], $_POST['mail_fournisseur'], $_POST['groupe_fournisseur'],
        $_POST['adress_fournisseur'], $idFournisseur
    );

    // Exécuter la mise à jour du fournisseur
    if ($stmt->execute()) {

        // Étape 4 : Mise à jour de la table 'operation' après la modification du fournisseur
        $updateOperation = $conn->prepare("UPDATE `operation` 
            SET `nom_pre_fournisseur` = ? 
            WHERE `nom_pre_fournisseur` = ?");

        if ($updateOperation) {
            // Lier les paramètres pour la mise à jour de la table 'operation'
            $updateOperation->bind_param("ss", $nomComplet, $ancienNomComplet);

            if ($updateOperation->execute()) {
                if ($updateOperation->affected_rows > 0) {
//                    echo "Mise à jour de l'opération réussie pour " . $nomComplet;
                    echo "Informations du fournisseur mises à jour avec succès !";

                }
//                else {
////                    echo "Aucune opération mise à jour pour ce fournisseur.";
//                }
            }
//            else {
////                echo "Erreur lors de la mise à jour de l'opération : " . $updateOperation->error;
//            }

            $updateOperation->close();
        }
//        else {
////            echo "Erreur lors de la préparation de la mise à jour de l'opération : " . $conn->error;
//        }
    }
    else {
        echo "Erreur lors de la mise à jour du fournisseur : " . $stmt->error;
    }

    // Fermez la déclaration
    $stmt->close();
}
//else {
////    echo "Erreur : Aucun ID de fournisseur spécifié.";
//}

$conn->close();
