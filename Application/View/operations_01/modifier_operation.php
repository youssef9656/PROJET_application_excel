<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// Inclure le fichier de connexion à la base de données
include '../../config/connect_db.php';

// Vérifier si les données ont été envoyées via POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Récupérer les données du formulaire
    $operationId = $_POST['operationId'];
    $dateOperation = $_POST['date_operation'];
    $lotId = $_POST['lot_id'];
    $sousLotId = $_POST['sous_lot_id'];
    $articleId = $_POST['article_id'];
    $entreeOperation = $_POST['entree_operation'];
    $sortieOperation = $_POST['sortie_operation'];
    $fournisseurId = $_POST['fournisseur_id'];
    $prixOperation = $_POST['prix_operation'];
    $serviceId = $_POST['service_id'];

    // Récupérer les noms des champs pour les opérations
    $query = "SELECT lot_name, sous_lot_name, nom_article FROM operation WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $operationId);
    $stmt->execute();
    $stmt->bind_result($lotName, $sousLotName, $nomArticle);
    $stmt->fetch();
    $stmt->close();

    // Mettre à jour les informations de l'opération
    $updateQuery = "UPDATE operation SET 
        lot_name = ?, 
        sous_lot_name = ?, 
        nom_article = ?, 
        date_operation = ?, 
        entree_operation = ?, 
        sortie_operation = ?, 
        nom_pre_fournisseur = (SELECT nom_fournisseur FROM fournisseurs WHERE id_fournisseur = ?),
        service_operation = (SELECT nom_service FROM service_zone WHERE id = ?),
        prix_operation = ?, 
        unite_operation = (SELECT unite FROM article WHERE id_article = ?)
        WHERE id = ?";

    $stmt = $conn->prepare($updateQuery);
    $stmt->bind_param('sssdddiiii',
        $lotName,
        $sousLotName,
        $nomArticle,
        $dateOperation,
        $entreeOperation,
        $sortieOperation,
        $fournisseurId,
        $serviceId,
        $prixOperation,
        $articleId,
        $operationId
    );

    if ($stmt->execute()) {
        echo "Opération modifiée avec succès.";
    } else {
        echo "Erreur lors de la modification de l'opération : " . $conn->error;
    }

    $stmt->close();
    $conn->close();
}
?>
