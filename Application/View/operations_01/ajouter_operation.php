<?php
// Affichage des erreurs pour le débogage
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Connexion à la base de données
include '../../config/connect_db.php';

// Récupération des données du formulaire
$lotId = $_POST['lot'];
$sousLotId = $_POST['sousLot'];
$articleId = $_POST['article'];
$fournisseurId = $_POST['fournisseur'];
$serviceId = $_POST['service'];
$ref = $_POST['ref'];



if (isset($_POST['entree'])){
    $entree =  floatval($_POST['entree']);
}else{
    $entree = 0.00 ;
}

if (isset($_POST['sortie'])){
    $sortie = floatval($_POST['sortie']);
}else{
    $sortie = 0.00;
}




// Obtenir le nom du lot
$queryLot = "SELECT lot_name FROM lots WHERE lot_id = ?";
$stmt = $conn->prepare($queryLot);
$stmt->bind_param("i", $lotId);
$stmt->execute();
$result = $stmt->get_result();
$lotName = $result->fetch_assoc()['lot_name'];

// Obtenir le nom du sous-lot
$querySousLot = "SELECT sous_lot_name FROM sous_lots WHERE sous_lot_id = ?";
$stmt = $conn->prepare($querySousLot);
$stmt->bind_param("i", $sousLotId);
$stmt->execute();
$result = $stmt->get_result();
$sousLotName = $result->fetch_assoc()['sous_lot_name'];

// Obtenir le nom et l'unité de l'article
$queryArticle = "SELECT nom, unite FROM article WHERE id_article = ?";
$stmt = $conn->prepare($queryArticle);
$stmt->bind_param("i", $articleId);
$stmt->execute();
$result = $stmt->get_result();
$articleData = $result->fetch_assoc();
$articleName = $articleData['nom'];
$unite = $articleData['unite'];

// Obtenir le prix de la dernière opération
$queryPrix = "SELECT prix_operation FROM operation WHERE nom_article = ? ORDER BY date_operation DESC LIMIT 1";
$stmt = $conn->prepare($queryPrix);
$stmt->bind_param("s", $articleName);
$stmt->execute();
$result = $stmt->get_result();
$prix_sortie = floatval($result->fetch_assoc()['prix_operation']);

// Calcul du prix et des dépenses
if ($entree == 0.00) {
    $prix = $prix_sortie;
} else {
    $prix = floatval($_POST['prix']);
}
$depense_sortie = $prix * $sortie;
$depense_entre = $entree * $prix;

// Obtenir le nom du fournisseur
$fournisseurName = '';
if ($fournisseurId) {
    $queryFournisseur = "SELECT nom_fournisseur, prenom_fournisseur FROM fournisseurs WHERE id_fournisseur = ?";
    $stmt = $conn->prepare($queryFournisseur);
    $stmt->bind_param("i", $fournisseurId);
    $stmt->execute();
    $result = $stmt->get_result();
    $fournisseurData = $result->fetch_assoc();
    $fournisseurName = $fournisseurData['nom_fournisseur'] . ' ' . $fournisseurData['prenom_fournisseur'];
}

// Obtenir le nom du service
$serviceName = '';
if ($serviceId) {
    $queryService = "SELECT nom_service FROM service_zone WHERE id = ?";
    $stmtService = $conn->prepare($queryService);
    $stmtService->bind_param('i', $serviceId);
    $stmtService->execute();
    $stmtService->bind_result($serviceName);
    $stmtService->fetch();
    $stmtService->close();
}

// Déterminer la valeur de pj_operation
if (!empty($entree)) {
    $pjOperation = "Bon entrée";
} elseif (!empty($sortie)) {
    $pjOperation = "Bon sortie";
} else {
    $pjOperation = null;
}

// Préparer la requête pour insérer les données dans la table operation
$queryInsert = "INSERT INTO operation (lot_name, sous_lot_name, nom_article, date_operation, entree_operation, sortie_operation, nom_pre_fournisseur, service_operation, prix_operation, unite_operation, pj_operation, ref, depense_entre, depense_sortie)
                VALUES (?, ?, ?, NOW(), ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($queryInsert);
$stmt->bind_param("sssdsssssssss", $lotName, $sousLotName, $articleName, $entree, $sortie, $fournisseurName, $serviceName, $prix, $unite, $pjOperation, $ref, $depense_entre, $depense_sortie);

// Exécution de la requête
if ($stmt->execute()) {
    header("Location: option_Ent_Sor.php");
    exit();
} else {
    echo "Erreur lors de l'ajout de l'opération : " . $stmt->error;
}

// Fermer la connexion
$stmt->close();
$conn->close();
?>
