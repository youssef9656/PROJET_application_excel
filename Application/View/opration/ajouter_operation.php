<?php
// Affichage des erreurs pour le débogage
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);

// Connexion à la base de données
include '../../config/connect_db.php';

// Récupération des données du formulaire
$lotId = $_POST['lot'];
$sousLotId = $_POST['sousLot'];
$articleId = $_POST['article'];
$entree = $_POST['entree'] ?? null;
$sortie = $_POST['sortie'] ?? null;
$fournisseurId = $_POST['fournisseur'] ?? null;
$serviceId = $_POST['service'] ?? null;
$prix = $_POST['prix'] ?? null;

// Obtenir le nom du lot
$queryLot = "SELECT lot_name FROM lots WHERE lot_id = ?";
$stmt = $conn->prepare($queryLot);
$stmt->bind_param("i", $lotId);
$stmt->execute();
$result = $stmt->get_result();
$lotName = $result->fetch_assoc()['lot_name'] ?? '';

// Obtenir le nom du sous-lot
$querySousLot = "SELECT sous_lot_name FROM sous_lots WHERE sous_lot_id = ?";
$stmt = $conn->prepare($querySousLot);
$stmt->bind_param("i", $sousLotId);
$stmt->execute();
$result = $stmt->get_result();
$sousLotName = $result->fetch_assoc()['sous_lot_name'] ?? '';

// Obtenir le nom et l'unité de l'article
$queryArticle = "SELECT nom, unite FROM article WHERE id_article = ?";
$stmt = $conn->prepare($queryArticle);
$stmt->bind_param("i", $articleId);
$stmt->execute();
$result = $stmt->get_result();
$articleData = $result->fetch_assoc();
$articleName = $articleData['nom'] ?? '';
$unite = $articleData['unite'] ?? '';

// Obtenir le nom du fournisseur
$fournisseurName = '';
if ($fournisseurId) {
    $queryFournisseur = "SELECT nom_fournisseur, prenom_fournisseur FROM fournisseurs WHERE id_fournisseur = ?";
    $stmt = $conn->prepare($queryFournisseur);
    $stmt->bind_param("i", $fournisseurId);
    $stmt->execute();
    $result = $stmt->get_result();
    $fournisseurData = $result->fetch_assoc();
    $fournisseurName = ($fournisseurData['nom_fournisseur'] ?? '') . ' ' . ($fournisseurData['prenom_fournisseur'] ?? '');
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
    $pjOperation = null; // ou une valeur par défaut si nécessaire
}

// Préparer la requête pour insérer les données dans la table operation
$queryInsert = "INSERT INTO operation (lot_name, sous_lot_name, nom_article, date_operation, entree_operation, sortie_operation, nom_pre_fournisseur, service_operation, prix_operation, unite_operation, pj_operation)
                VALUES (?, ?, ?, NOW(), ?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($queryInsert);

// La chaîne de types correspond aux variables passées
// 'sssddssssss' : 3 chaînes (lot_name, sous_lot_name, nom_article), 2 décimaux (entree_operation, sortie_operation), 2 chaînes (nom_pre_fournisseur, service_operation), 1 décimal (prix_operation), 1 chaîne (unite_operation), 1 chaîne (pj_operation)
$stmt->bind_param("sssdssssss", $lotName, $sousLotName, $articleName, $entree, $sortie, $fournisseurName, $serviceName, $prix, $unite, $pjOperation);

// Exécution de la requête
if ($stmt->execute()) {
    echo "Opération ajoutée avec succès.";
    header("Location: option_Ent_Sor.php");
} else {
    echo "Erreur lors de l'ajout de l'opération : " . $stmt->error;
}

// Fermer la connexion
$stmt->close();
$conn->close();
?>


