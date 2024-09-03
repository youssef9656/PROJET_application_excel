<?php
include "../../Config/connect_db.php";



// Inclure le fichier de configuration pour la connexion à la base de données

// Préparer et lier
$stmt = $conn->prepare("INSERT INTO fournisseurs (
    nom_fournisseur, prenom_fournisseur, cp_fournisseur, ville_fournisseur,
    pay_fournisseur, telephone_fixe_fournisseur, telephone_portable_fournisseur,
    commande_fournisseur, condition_livraison, coord_livreur, calendrier_livraison,
    details_livraison, condition_paiement, facturation, certificatione,
    produit_service_fourni, siuvi_fournisseur, mail_fournisseur, groupe_fournisseur,
    adress_fournisseur
) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

if ($stmt === false) {
    die("Erreur de préparation de la déclaration : " . $conn->error);
}

// Lier les paramètres
$stmt->bind_param(
    "ssssssssssssssssssss",
    $_POST['nom_fournisseur'], $_POST['prenom_fournisseur'], $_POST['cp_fournisseur'],
    $_POST['ville_fournisseur'], $_POST['pay_fournisseur'], $_POST['telephone_fixe_fournisseur'],
    $_POST['telephone_portable_fournisseur'], $_POST['commande_fournisseur'], $_POST['condition_livraison'],
    $_POST['coord_livreur'], $_POST['calendrier_livraison'], $_POST['details_livraison'],
    $_POST['condition_paiement'], $_POST['facturation'], $_POST['certificatione'],
    $_POST['produit_service_fourni'], $_POST['siuvi_fournisseur'], $_POST['mail_fournisseur'],
    $_POST['groupe_fournisseur'], $_POST['adress_fournisseur']
);

// Exécuter la déclaration
if ($stmt->execute()) {
    echo "Nouveau fournisseur ajouté avec succès !";
} else {
    echo "Erreur : " . $stmt->error;
}

// Fermer la déclaration et la connexion
$stmt->close();
$conn->close();



?>