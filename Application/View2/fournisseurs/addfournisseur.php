<?php
include "../../Config/connect_db.php";

// التحقق مما إذا كان المورد موجودًا بالفعل بناءً على البريد الإلكتروني أو الاسم واللقب
$check_stmt = $conn->prepare("
    SELECT COUNT(*) 
    FROM fournisseurs 
    WHERE mail_fournisseur = ? 
    OR (nom_fournisseur = ? AND prenom_fournisseur = ?)
");
if ($check_stmt === false) {
    die("Erreur de préparation de la déclaration de vérification : " . $conn->error);
}

$check_stmt->bind_param("sss", $_POST['mail_fournisseur'], $_POST['nom_fournisseur'], $_POST['prenom_fournisseur']);
$check_stmt->execute();
$check_stmt->bind_result($count);
$check_stmt->fetch();
$check_stmt->close();

if ($count > 0) {
    echo "Le fournisseur existe déjà avec le même email ou le même nom et prénom !";
} else {
    // إعداد وتنفيذ الإدخال إذا لم يكن المورد موجودًا
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

    // ربط المعلمات
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

    // تنفيذ الإدخال
    if ($stmt->execute()) {
        echo "Nouveau fournisseur ajouté avec succès !";
    } else {
        echo "Erreur : " . $stmt->error;
    }

    // إغلاق التصريح والاتصال
    $stmt->close();
}

$conn->close();
?>
