<?php
include "../../Config/connect_db.php";

// Récupérer et nettoyer toutes les données POST
$nom_fournisseur = isset($_POST['nom_fournisseur']) ? strtolower(trim($_POST['nom_fournisseur'])) : '';
$prenom_fournisseur = isset($_POST['prenom_fournisseur']) ? strtolower(trim($_POST['prenom_fournisseur'])) : '';
$cp_fournisseur = isset($_POST['cp_fournisseur']) ? trim($_POST['cp_fournisseur']) : '';
$ville_fournisseur = isset($_POST['ville_fournisseur']) ? trim($_POST['ville_fournisseur']) : '';
$pay_fournisseur = isset($_POST['pay_fournisseur']) ? trim($_POST['pay_fournisseur']) : '';
$telephone_fixe_fournisseur = isset($_POST['telephone_fixe_fournisseur']) ? trim($_POST['telephone_fixe_fournisseur']) : '';
$telephone_portable_fournisseur = isset($_POST['telephone_portable_fournisseur']) ? trim($_POST['telephone_portable_fournisseur']) : '';
$commande_fournisseur = isset($_POST['commande_fournisseur']) ? trim($_POST['commande_fournisseur']) : '';
$condition_livraison = isset($_POST['condition_livraison']) ? trim($_POST['condition_livraison']) : '';
$coord_livreur = isset($_POST['coord_livreur']) ? trim($_POST['coord_livreur']) : '';
$calendrier_livraison = isset($_POST['calendrier_livraison']) ? trim($_POST['calendrier_livraison']) : '';
$details_livraison = isset($_POST['details_livraison']) ? trim($_POST['details_livraison']) : '';
$condition_paiement = isset($_POST['condition_paiement']) ? trim($_POST['condition_paiement']) : '';
$facturation = isset($_POST['facturation']) ? trim($_POST['facturation']) : '';
$certificatione = isset($_POST['certificatione']) ? trim($_POST['certificatione']) : '';
$produit_service_fourni = isset($_POST['produit_service_fourni']) ? trim($_POST['produit_service_fourni']) : '';
$siuvi_fournisseur = isset($_POST['siuvi_fournisseur']) ? trim($_POST['siuvi_fournisseur']) : '';
$mail_fournisseur = isset($_POST['mail_fournisseur']) ? trim($_POST['mail_fournisseur']) : '';
$groupe_fournisseur = isset($_POST['groupe_fournisseur']) ? trim($_POST['groupe_fournisseur']) : '';
$adress_fournisseur = isset($_POST['adress_fournisseur']) ? trim($_POST['adress_fournisseur']) : '';

// التحقق مما إذا كان المورد موجودًا بالفعل بناءً على الاسم واللقب
$check_stmt = $conn->prepare("
    SELECT COUNT(*) 
    FROM fournisseurs 
    WHERE nom_fournisseur = ? AND prenom_fournisseur = ?
");
if ($check_stmt === false) {
    die("Erreur de préparation de la déclaration de vérification : " . $conn->error);
}

$check_stmt->bind_param("ss", $nom_fournisseur, $prenom_fournisseur);
$check_stmt->execute();
$check_stmt->bind_result($count);
$check_stmt->fetch();
$check_stmt->close();

if ($count > 0) {
    echo "Le fournisseur existe déjà avec le même nom et prénom !";
} else {
    // Préparer et exécuter l'insertion si le fournisseur n'existe pas
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
        $nom_fournisseur, $prenom_fournisseur, $cp_fournisseur, $ville_fournisseur,
        $pay_fournisseur, $telephone_fixe_fournisseur, $telephone_portable_fournisseur,
        $commande_fournisseur, $condition_livraison, $coord_livreur,
        $calendrier_livraison, $details_livraison, $condition_paiement,
        $facturation, $certificatione, $produit_service_fourni,
        $siuvi_fournisseur, $mail_fournisseur, $groupe_fournisseur,
        $adress_fournisseur
    );

    // Exécuter l'insertion
    if ($stmt->execute()) {
        echo "Nouveau fournisseur ajouté avec succès !";
    } else {
        echo "Erreur : " . $stmt->error;
    }

    // Fermer la déclaration
    $stmt->close();
}

$conn->close();
?>
