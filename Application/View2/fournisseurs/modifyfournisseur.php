<?php
include "../../Config/connect_db.php";

// التأكد من أن 'id' موجود في $_POST لتحديد المورد المراد تحديثه
if (isset($_POST['id_fournisseur'])) {
    // إعداد الجملة مع المعلمات
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

    // ربط المعلمات
    $stmt->bind_param(
        "ssssssssssssssssssssi",
        $_POST['nom_fournisseur'], $_POST['prenom_fournisseur'], $_POST['cp_fournisseur'],
        $_POST['ville_fournisseur'], $_POST['pay_fournisseur'], $_POST['telephone_fixe_fournisseur'],
        $_POST['telephone_portable_fournisseur'], $_POST['commande_fournisseur'], $_POST['condition_livraison'],
        $_POST['coord_livreur'], $_POST['calendrier_livraison'], $_POST['details_livraison'],
        $_POST['condition_paiement'], $_POST['facturation'], $_POST['certificatione'],
        $_POST['produit_service_fourni'], $_POST['siuvi_fournisseur'], $_POST['mail_fournisseur'],
        $_POST['groupe_fournisseur'], $_POST['adress_fournisseur'],
        $_POST['id_fournisseur']  // هذا هو معرف المورد الذي سيتم تحديثه
    );

    // تنفيذ الجملة
    if ($stmt->execute()) {
        echo "Informations du fournisseur mises à jour avec succès !";
    } else {
        echo "Erreur : " . $stmt->error;
    }

    // غلق الجملة والاتصال
    $stmt->close();
} else {
    echo "Erreur : Aucun ID de fournisseur spécifié.";
}

$conn->close();
?>
