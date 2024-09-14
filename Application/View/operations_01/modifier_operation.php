<?php
// Affichage des erreurs pour le débogage
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include '../../config/connect_db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Récupération des données du formulaire
    $operationId = isset($_POST['operation_id']) ? intval($_POST['operation_id']) : 0;
    $lotId = isset($_POST['lot']) ? intval($_POST['lot']) : 0;
    $sousLotId = isset($_POST['sousLot']) ? intval($_POST['sousLot']) : 0;
    $articleId = isset($_POST['article']) ? intval($_POST['article']) : 0;
    $fournisseurId = isset($_POST['fournisseur']) ? intval($_POST['fournisseur']) : 0;
    $serviceId = isset($_POST['service']) ? intval($_POST['service']) : 0;
    $ref = isset($_POST['ref']) ? $_POST['ref'] : '';
    $entree = isset($_POST['entree']) ? floatval($_POST['entree']) : 0.00;
    $sortie = isset($_POST['sortie']) ? floatval($_POST['sortie']) : 0.00;
    $prix = isset($_POST['prix']) ? floatval($_POST['prix']) : 0.00;
    $dateOperation = isset($_POST['date_operation']) ? $_POST['date_operation'] : '';

    // Convertir la date et l'heure en format DATETIME
    $formattedDateOperation = date('Y-m-d H:i:s', strtotime($dateOperation));

    if ($formattedDateOperation === false) {
        echo "La date d'opération est invalide.";
        exit();
    }

    // Supprimer l'ancienne opération
    if ($operationId > 0) {
        $deleteQuery = "DELETE FROM operation WHERE id = ?";
        if ($deleteStmt = $conn->prepare($deleteQuery)) {
            $deleteStmt->bind_param("i", $operationId);
            $deleteStmt->execute();
            $deleteStmt->close();
        } else {
            echo "Erreur lors de la suppression de l'opération : " . $conn->error;
            exit();
        }
    }

    // Obtenir le nom du lot
    $queryLot = "SELECT lot_name FROM lots WHERE lot_id = ?";
    $stmt = $conn->prepare($queryLot);
    $stmt->bind_param("i", $lotId);
    $stmt->execute();
    $result = $stmt->get_result();
    $lotName = $result->fetch_assoc()['lot_name'];
    $stmt->close();

    // Obtenir le nom du sous-lot
    $querySousLot = "SELECT sous_lot_name FROM sous_lots WHERE sous_lot_id = ?";
    $stmt = $conn->prepare($querySousLot);
    $stmt->bind_param("i", $sousLotId);
    $stmt->execute();
    $result = $stmt->get_result();
    $sousLotName = $result->fetch_assoc()['sous_lot_name'];
    $stmt->close();

    // Obtenir le nom et l'unité de l'article
    $queryArticle = "SELECT nom, unite FROM article WHERE id_article = ?";
    $stmt = $conn->prepare($queryArticle);
    $stmt->bind_param("i", $articleId);
    $stmt->execute();
    $result = $stmt->get_result();
    $articleData = $result->fetch_assoc();
    $articleName = $articleData['nom'];
    $unite = $articleData['unite'];
    $stmt->close();

    // Obtenir le prix de la dernière opération
    $queryPrix = "SELECT prix_operation FROM operation WHERE nom_article = ? ORDER BY date_operation DESC LIMIT 1";
    $stmt = $conn->prepare($queryPrix);
    $stmt->bind_param("s", $articleName);
    $stmt->execute();
    $result = $stmt->get_result();
    $prix_sortie = floatval($result->fetch_assoc()['prix_operation']);
    $stmt->close();

    // Calcul du prix et des dépenses
    $prix = ($entree == 0.00) ? $prix_sortie : $prix;
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
        $stmt->close();
    }

    // Obtenir le nom du service
    $serviceName = '';
    if ($serviceId) {
        $queryService = "SELECT service FROM service_zone WHERE id = ?";
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
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($queryInsert);
    $stmt->bind_param("ssssssssssssss", $lotName, $sousLotName, $articleName, $formattedDateOperation, $entree, $sortie, $fournisseurName, $serviceName, $prix, $unite, $pjOperation, $ref, $depense_entre, $depense_sortie);

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
}
?>
