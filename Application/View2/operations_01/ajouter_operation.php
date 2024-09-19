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
$serviceId = $_POST['service'];
$ref = $_POST['ref'];

if(isset($_POST['fournisseur'])){
    $fournisseurId = $_POST['fournisseur'];
}else{
    $fournisseurId = null ;
}



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
                VALUES (?, ?, ?, NOW(), ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($queryInsert);
$stmt->bind_param("sssdsssssssss", $lotName, $sousLotName, $articleName, $entree, $sortie, $fournisseurName, $serviceName, $prix, $unite, $pjOperation, $ref, $depense_entre, $depense_sortie);

// Exécution de la requête
if ($stmt->execute()) {

        $start_date = '1000-01-01'; // Date de début
        $end_date = '9024-12-31'; // Date de fin

        $sql_select = "
    SELECT 
        a.id_article AS ID,
        a.nom AS Article,
        a.stock_initial AS Stock_Initial,
        COALESCE(SUM(o.entree_operation), 0) AS Total_Entry_Operations,
        COALESCE(SUM(o.sortie_operation), 0) AS Total_Exit_Operations,
        a.stock_initial + COALESCE(SUM(o.entree_operation), 0) - COALESCE(SUM(o.sortie_operation), 0) AS Stock_Final,
        (
            SELECT AVG(p.prix_operation)
            FROM operation p
            WHERE p.nom_article = a.nom
            AND p.date_operation BETWEEN '$start_date' AND '$end_date'
            ORDER BY p.date_operation DESC
            LIMIT 30
        ) AS Prix,
        (
            a.stock_initial + COALESCE(SUM(o.entree_operation), 0) - COALESCE(SUM(o.sortie_operation), 0)
        ) * (
            SELECT AVG(p.prix_operation)
            FROM operation p
            WHERE p.nom_article = a.nom
            AND p.date_operation BETWEEN '$start_date' AND '$end_date'
            ORDER BY p.date_operation DESC
            LIMIT 30
        ) AS Stock_Value,
        a.stock_min AS Stock_Min,
        CASE 
            WHEN a.stock_initial + COALESCE(SUM(o.entree_operation), 0) - COALESCE(SUM(o.sortie_operation), 0) < a.stock_min 
            THEN 'besoin' 
            ELSE 'bon' 
        END AS Requirement_Status
    FROM 
        article a
    LEFT JOIN 
        operation o ON o.nom_article = a.nom
    WHERE 
        o.date_operation BETWEEN '$start_date' AND '$end_date'
    GROUP BY 
        a.id_article, a.nom, a.stock_initial, a.stock_min
    LIMIT 0, 25
";

        $result = $conn->query($sql_select);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $id = $row['ID'];
                $article = $row['Article'];
                $stock_initial = $row['Stock_Initial'];
                $total_entry_operations = $row['Total_Entry_Operations'];
                $total_exit_operations = $row['Total_Exit_Operations'];
                $stock_final = $row['Stock_Final'];
                $prix = $row['Prix'];
                $stock_value = $row['Stock_Value'];
                $stock_min = $row['Stock_Min'];
                $requirement_status = $row['Requirement_Status'];

                // Calculer les dépenses
                $total_depenses_entree = $total_entry_operations * $prix;
                $total_depenses_sortie = $total_exit_operations * $prix;

                // Vérifier si les données existent dans la table
                $sql_check = "SELECT ID FROM etat_de_stocks WHERE ID = ?";
                $stmt = $conn->prepare($sql_check);
                $stmt->bind_param("i", $id);
                $stmt->execute();
                $stmt->store_result();

                if ($stmt->num_rows > 0) {
                    // Mettre à jour les données si elles existent
                    $sql_update = "TRUNCATE TABLE etat_de_stocks";
                    if ($conn->query($sql_update) === TRUE) {
                        $sql_insert = "
                INSERT INTO etat_de_stocks (ID, Article, Stock_Initial, Total_Entry_Operations, Total_Exit_Operations, 
                    Stock_Final, Prix, Stock_Value, Total_Depenses_Entree, Total_Depenses_Sortie, Stock_Min, Requirement_Status)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
            ";
                        $stmt = $conn->prepare($sql_insert);
                        $stmt->bind_param("isssiiidddis", $id, $article, $stock_initial, $total_entry_operations, $total_exit_operations, $stock_final, $prix, $stock_value, $total_depenses_entree, $total_depenses_sortie, $stock_min, $requirement_status);
                    }

                } else {
                    // Insérer les données si elles n'existent pas
                    $sql_insert = "
                INSERT INTO etat_de_stocks (ID, Article, Stock_Initial, Total_Entry_Operations, Total_Exit_Operations, 
                    Stock_Final, Prix, Stock_Value, Total_Depenses_Entree, Total_Depenses_Sortie, Stock_Min, Requirement_Status)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
            ";
                    $stmt = $conn->prepare($sql_insert);
                    $stmt->bind_param("isssiiidddis", $id, $article, $stock_initial, $total_entry_operations, $total_exit_operations, $stock_final, $prix, $stock_value, $total_depenses_entree, $total_depenses_sortie, $stock_min, $requirement_status);
                }

                $stmt->execute();
            }
        } else {
            echo "Aucune donnée à traiter.";
        }


    header("Location: option_Ent_Sor.php");
    exit();
} else {
    echo "Erreur lors de l'ajout de l'opération : " . $stmt->error;
}

$stmt->close();





$conn->close();
?>
