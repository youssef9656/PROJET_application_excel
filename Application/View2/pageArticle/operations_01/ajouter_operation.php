<?php
// Affichage des erreurs pour le débogage
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Connexion à la base de données
include '../../config/connect_db.php';

// Fonction pour obtenir le nom du lot
function getLotName($lotId, $conn) {
    $queryLot = "SELECT lot_name FROM lots WHERE lot_id = ?";
    $stmt = $conn->prepare($queryLot);
    $stmt->bind_param("i", $lotId);
    $stmt->execute();
    $result = $stmt->get_result();
    $lotName = $result->fetch_assoc()['lot_name'];
    $stmt->close();
    return $lotName;
}

// Fonction pour obtenir le nom du sous-lot
function getSousLotName($sousLotId, $conn) {
    $querySousLot = "SELECT sous_lot_name FROM sous_lots WHERE sous_lot_id = ?";
    $stmt = $conn->prepare($querySousLot);
    $stmt->bind_param("i", $sousLotId);
    $stmt->execute();
    $result = $stmt->get_result();
    $sousLotName = $result->fetch_assoc()['sous_lot_name'];
    $stmt->close();
    return $sousLotName;
}

// Fonction pour obtenir le nom et l'unité de l'article
function getArticleData($articleId, $conn) {
    $queryArticle = "SELECT nom, unite FROM article WHERE id_article = ?";
    $stmt = $conn->prepare($queryArticle);
    $stmt->bind_param("i", $articleId);
    $stmt->execute();
    $result = $stmt->get_result();
    $articleData = $result->fetch_assoc();
    $stmt->close();
    return $articleData;
}

// Fonction pour obtenir le prix de la dernière opération
function getDernierPrix($articleName, $conn) {
    $queryPrix = "SELECT prix_operation FROM operation WHERE nom_article = ? ORDER BY date_operation DESC LIMIT 1";
    $stmt = $conn->prepare($queryPrix);
    $stmt->bind_param("s", $articleName);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $prix_sortie = floatval($result->fetch_assoc()['prix_operation']);
    } else {
        $prix_sortie = 0.00;
    }
    $stmt->close();
    return $prix_sortie;
}

// Fonction pour obtenir le nom du fournisseur
function getFournisseurName($fournisseurId, $conn) {
    $fournisseurName = '';
    if ($fournisseurId) {
        $queryFournisseur = "SELECT nom_fournisseur, prenom_fournisseur FROM fournisseurs WHERE id_fournisseur = ? and action_A_D = 1";
        $stmt = $conn->prepare($queryFournisseur);
        $stmt->bind_param("i", $fournisseurId);
        $stmt->execute();
        $result = $stmt->get_result();
        $fournisseurData = $result->fetch_assoc();
        $fournisseurName = $fournisseurData['nom_fournisseur'] . ' ' . $fournisseurData['prenom_fournisseur'];
        $stmt->close();
    }
    return $fournisseurName;
}

// Fonction pour insérer une opération
function insererOperation($lotName, $sousLotName, $articleName, $entree, $sortie, $fournisseurName, $serviceName, $prix, $unite, $pjOperation, $ref, $depense_entre, $depense_sortie, $conn) {
    $queryInsert = "INSERT INTO operation (lot_name, sous_lot_name, nom_article, date_operation, entree_operation, sortie_operation, nom_pre_fournisseur, service_operation, prix_operation, unite_operation, pj_operation, ref, depense_entre, depense_sortie)
                    VALUES (?, ?, ?, NOW(), ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmtInsert = $conn->prepare($queryInsert);
    $stmtInsert->bind_param("sssdsssssssss", $lotName, $sousLotName, $articleName, $entree, $sortie, $fournisseurName, $serviceName, $prix, $unite, $pjOperation, $ref, $depense_entre, $depense_sortie);

    if ($stmtInsert->execute()) {
        echo "Opération ajoutée avec succès.";
    } else {
        echo "Erreur lors de l'insertion de l'opération : " . $stmtInsert->error;
    }
    $stmtInsert->close();
}

// Fonction pour vérifier le stock
function verifierStock($articleName, $sortie, $conn) {
    $sqlStockFinal = "SELECT Stock_Final FROM etat_de_stocks WHERE Article = ?";
    $stmtStock = $conn->prepare($sqlStockFinal);
    $stmtStock->bind_param("s", $articleName);
    $stmtStock->execute();
    $stmtStock->bind_result($stockFinal);

    if ($stmtStock->fetch()) {
        $stmtStock->close();
        if ($sortie <= $stockFinal) {
            $stockFinaleValue = $stockFinal;
            return $stockFinaleValue & true;
        } else {
            echo "Erreur : La sortie de l'opération doit être inférieure ou égale au stock final ($stockFinal).";

            return false;
        }
    } else {
        echo "Aucun stock trouvé pour l'article $articleName.";
        return false;
    }
}

// Fonction pour vérifier l'état de besoin d'un article
function article_besoin($article, $besoin, $conn)
{
    $queryBesoin = "SELECT Requirement_Status FROM etat_de_stocks WHERE Article = ?";
    $stmt = $conn->prepare($queryBesoin);
    $stmt->bind_param("s", $article);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $status = $result->fetch_assoc()['Requirement_Status'];
    } else {
        return false;
    }
    $stmt->close();

    if ($status === $besoin) {
        return true;
    } else {
        return false;
    }
}

// Fonction pour mettre à jour la table etat_de_stocks
function mettreAJourEtatStocks($conn) {
    $start_date = '1000-01-01';
    $end_date = '9024-12-31';

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
";

    $result = $conn->query($sql_select);

    if ($result->num_rows > 0) {
        // Vider la table avant l'insertion
        $conn->query("TRUNCATE TABLE etat_de_stocks");

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

            $total_depenses_entree = $total_entry_operations * $prix;
            $total_depenses_sortie = $total_exit_operations * $prix;

            $sql_insert = "
                INSERT INTO etat_de_stocks (ID, Article, Stock_Initial, Total_Entry_Operations, Total_Exit_Operations, 
                    Stock_Final, Prix, Stock_Value, Total_Depenses_Entree, Total_Depenses_Sortie, Stock_Min, Requirement_Status)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
            ";
            $stmt = $conn->prepare($sql_insert);
            $stmt->bind_param("isssiiidddis", $id, $article, $stock_initial, $total_entry_operations, $total_exit_operations, $stock_final, $prix, $stock_value, $total_depenses_entree, $total_depenses_sortie, $stock_min, $requirement_status);
            $stmt->execute();
            $stmt->close();
        }
    } else {
        echo "Aucune donnée à traiter.";
    }
}

// Récupération des données du formulaire
$lotId = $_POST['lot'];
$sousLotId = $_POST['sousLot'];
$articleId = $_POST['article'];
$ref = $_POST['ref'];
$serviceName = isset($_POST['service']) ? $_POST['service'] : '';
$fournisseurId = isset($_POST['fournisseur']) ? $_POST['fournisseur'] : null;
$entree = isset($_POST['entree']) ? floatval($_POST['entree']) : 0.00;
$sortie = isset($_POST['sortie']) ? floatval($_POST['sortie']) : 0.00;

// Appel des fonctions pour obtenir les données
$lotName = getLotName($lotId, $conn);
$sousLotName = getSousLotName($sousLotId, $conn);
$articleData = getArticleData($articleId, $conn);
$articleName = $articleData['nom'];
$unite = $articleData['unite'];
$prix_sortie = getDernierPrix($articleName, $conn);
$fournisseurName = getFournisseurName($fournisseurId, $conn);

// Calcul du prix et des dépenses
$prix = ($entree == 0.00) ? $prix_sortie : floatval($_POST['prix']);
$depense_sortie = $prix * $sortie;
$depense_entre = $entree * $prix;

// Déterminer la valeur de pj_operation
$pjOperation = null;
if (!empty($entree)) {
    $pjOperation = "Bon entrée";
} elseif (!empty($sortie)) {
    $pjOperation = "Bon sortie";
}

// Vérifier le stock et insérer l'opération
$isInserted = false;

if (verifierStock($articleName, $sortie, $conn)) {
    insererOperation($lotName, $sousLotName, $articleName, $entree, $sortie, $fournisseurName, $serviceName, $prix, $unite, $pjOperation, $ref, $depense_entre, $depense_sortie, $conn);
    $isInserted = true;
    return $isInserted;
}

// Mettre à jour la table etat_de_stocks
mettreAJourEtatStocks($conn);





$sqlStockFinal1 = "SELECT Stock_Final FROM etat_de_stocks WHERE Article = ?";
$stmtStock1 = $conn->prepare($sqlStockFinal1);
$stmtStock1->bind_param("s", $articleName);
$stmtStock1->execute();
$stmtStock1->bind_result($stockFinal1);
if ($stmtStock1->fetch()) {
    $stockFinaleValue = $stockFinal1 ;
}

$stmtStock1->close();

// Redirection et affichage du message
if (article_besoin($articleName, "besoin", $conn)) {
    if ($isInserted){
        echo json_encode(['success' => true]);
        header("Location: option_Ent_Sor.php?message=ssajouter&nomArticle=$articleName");
    }else{
        header("Location: option_Ent_Sor.php?message=eppuisement&nomArticle=$articleName&stockFinaleValue=$stockFinaleValue");
    }

} else {
    header("Location: option_Ent_Sor.php");
}

exit();

$conn->close();
?>