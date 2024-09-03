<?php
// Inclure le fichier de configuration pour la connexion à la base de données
include "../../Config/connect_db.php";

// Vérifier si les données du fournisseur sont présentes dans la requête POST
if (isset($_POST['id_fournisseur'])) {
    // Récupérer les données du POST
    $id_fournisseur = intval($_POST['id_fournisseur']);
    $nom_fournisseur = $_POST['nom_fournisseur'];
    $prenom_fournisseur = $_POST['prenom_fournisseur'];
    $cp_fournisseur = $_POST['cp_fournisseur'];
    $ville_fournisseur = $_POST['ville_fournisseur'];
    $pay_fournisseur = $_POST['pay_fournisseur'];
    $telephone_fixe_fournisseur = $_POST['telephone_fixe_fournisseur'];
    $telephone_portable_fournisseur = $_POST['telephone_portable_fournisseur'];
    $commande_fournisseur = $_POST['commande_fournisseur'];
    $condition_livraison = $_POST['condition_livraison'];
    $coord_livreur = $_POST['coord_livreur'];
    $calendrier_livraison = $_POST['calendrier_livraison'];
    $details_livraison = $_POST['details_livraison'];
    $condition_paiement = $_POST['condition_paiement'];
    $facturation = $_POST['facturation'];
    $certificatione = $_POST['certificatione'];
    $produit_service_fourni = $_POST['produit_service_fourni'];
    $siuvi_fournisseur = $_POST['siuvi_fournisseur'];
    $mail_fournisseur = $_POST['mail_fournisseur'];
    $groupe_fournisseur = $_POST['groupe_fournisseur'];
    $adress_fournisseur = $_POST['adress_fournisseur'];

    // Préparer la requête pour mettre à jour le fournisseur
    $stmt = $conn->prepare("
        UPDATE fournisseurs SET
            nom_fournisseur = ?, 
            prenom_fournisseur = ?, 
            cp_fournisseur = ?, 
            ville_fournisseur = ?, 
            pay_fournisseur = ?, 
            telephone_fixe_fournisseur = ?, 
            telephone_portable_fournisseur = ?, 
            commande_fournisseur = ?, 
            condition_livraison = ?, 
            coord_livreur = ?, 
            calendrier_livraison = ?, 
            details_livraison = ?, 
            condition_paiement = ?, 
            facturation = ?, 
            certificatione = ?, 
            produit_service_fourni = ?, 
            siuvi_fournisseur = ?, 
            mail_fournisseur = ?, 
            groupe_fournisseur = ?, 
            adress_fournisseur = ?
        WHERE id_fournisseur = ?
    ");

    if ($stmt === false) {
        die("Erreur de préparation de la déclaration : " . $conn->error);
    }

    // Lier les paramètres
    $stmt->bind_param(
        "ssssssssssssssssssssi",
        $nom_fournisseur, $prenom_fournisseur, $cp_fournisseur, $ville_fournisseur, $pay_fournisseur,
        $telephone_fixe_fournisseur, $telephone_portable_fournisseur, $commande_fournisseur, $condition_livraison,
        $coord_livreur, $calendrier_livraison, $details_livraison, $condition_paiement, $facturation,
        $certificatione, $produit_service_fourni, $siuvi_fournisseur, $mail_fournisseur, $groupe_fournisseur,
        $adress_fournisseur, $id_fournisseur
    );

    // Exécuter la déclaration
    if ($stmt->execute()) {
        echo "Fournisseur mis à jour avec succès.";
    } else {
        echo "Erreur : " . $stmt->error;
    }

    // Fermer la déclaration
    $stmt->close();
} else {
    echo "ID du fournisseur non spécifié.";
}

// Fermer la connexion
$conn->close();
?>
