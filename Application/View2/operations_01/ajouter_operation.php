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


function getService($serviceId, $conn)
{
    $serviceName = ''; // Variable pour stocker le nom du service
    if ($serviceId) { // Vérifiez si un ID de service est fourni
        $queryService = "SELECT service FROM service_zone WHERE id = ?"; // Requête SQL
        $stmt = $conn->prepare($queryService); // Préparer la requête
        $stmt->bind_param("i", $serviceId); // Lier l'ID du service en tant qu'entier
        $stmt->execute(); // Exécuter la requête
        $result = $stmt->get_result(); // Obtenir le résultat
        if ($result->num_rows > 0) { // Vérifiez si des données ont été trouvées
            $serviceData = $result->fetch_assoc(); // Récupérer les données
            $serviceName = $serviceData['service']; // Stocker le nom du service
        }
        $stmt->close(); // Fermer la déclaration
    }
    return $serviceName; // Retourner le nom du service
}

// Fonction pour insérer une opération
function insererOperation($lotName, $sousLotName, $articleName, $entree, $sortie, $fournisseurName, $serviceName1, $prix, $unite, $pjOperation, $ref, $depense_entre, $depense_sortie, $conn) {
    $queryInsert = "INSERT INTO operation (lot_name, sous_lot_name, nom_article, date_operation, entree_operation, sortie_operation, nom_pre_fournisseur, service_operation, prix_operation, unite_operation, pj_operation, ref, depense_entre, depense_sortie , reclamation)
                    VALUES (?, ?, ?, NOW(), ?, ?, ?, ?, ?, ?, ?, ?, ?, ? , NULL)";
    $stmtInsert = $conn->prepare($queryInsert);
    $stmtInsert->bind_param("sssdsssssssss", $lotName, $sousLotName, $articleName, $entree, $sortie, $fournisseurName, $serviceName1, $prix, $unite, $pjOperation, $ref, $depense_entre, $depense_sortie);

    if ($stmtInsert->execute()) {
        return true;
    } else {
        // Enregistrer l'erreur dans un journal ou la renvoyer pour la gérer plus tard
        error_log("Erreur lors de l'insertion de l'opération : " . $stmtInsert->error);
        return false;
    }
    $stmtInsert->close();
}

// Fonction pour vérifier le stock

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
        a.stock_min AS Stock_Min 
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
        while ($row = $result->fetch_assoc()) {
            $prix = $row['Prix'];
            $stock_final = $row['Stock_Final'];
            $stock_value = $stock_final * $prix;
            $total_depenses_entree = $row['Total_Entry_Operations'] * $prix;
            $total_depenses_sortie = $row['Total_Exit_Operations'] * $prix;
            $requirement_status = ($stock_final < $row['Stock_Min']) ? 'besoin' : 'bon';$sql_update = "
                INSERT INTO etat_de_stocks (ID, Article, Stock_Initial, Total_Entry_Operations, Total_Exit_Operations, 
                    Stock_Final, Prix, Stock_Value, Total_Depenses_Entree, Total_Depenses_Sortie, Stock_Min, Requirement_Status)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
                ON DUPLICATE KEY UPDATE 
                    Total_Entry_Operations = VALUES(Total_Entry_Operations),
                    Total_Exit_Operations = VALUES(Total_Exit_Operations),
                    Stock_Final = VALUES(Stock_Final),
                    Prix = VALUES(Prix),
                    Stock_Value = VALUES(Stock_Value),
                    Total_Depenses_Entree = VALUES(Total_Depenses_Entree),
                    Total_Depenses_Sortie = VALUES(Total_Depenses_Sortie),
                    Requirement_Status = VALUES(Requirement_Status)
            ";
            $stmt = $conn->prepare($sql_update);
            $stmt->bind_param("isssiiidddis", $row['ID'], $row['Article'], $row['Stock_Initial'], $row['Total_Entry_Operations'], $row['Total_Exit_Operations'], $stock_final, $prix, $stock_value, $total_depenses_entree, $total_depenses_sortie, $row['Stock_Min'], $requirement_status);
            $stmt->execute();
            $stmt->close();
        }
    } else {
        // Enregistrer l'absence de données dans un journal
        error_log("Aucune donnée à traiter dans mettreAJourEtatStocks()");
    }
}

// Récupération des données du formulaire
$lotId = $_POST['lot'];
$sousLotId = $_POST['sousLot'];
$articleId = $_POST['article'];
$ref = $_POST['ref'];
if (isset($_POST['service'])) {
    $serviceName = $_POST['service'];
} else {
    $serviceName = null;
}

if (isset($_POST['fournisseur'])) {
    $fournisseurId = $_POST['fournisseur'];
} else {
    $fournisseurId = null;
}

if (isset($_POST['entree'])) {
    $entree = floatval($_POST['entree']);
} else {
    $entree = 0.00;
}

if (isset($_POST['sortie'])) {
    $sortie = floatval($_POST['sortie']);
} else {
    $sortie = 0.00;
}

// Appel des fonctions pour obtenir les données
$lotName = getLotName($lotId, $conn);
$sousLotName = getSousLotName($sousLotId, $conn);
$articleData = getArticleData($articleId, $conn);
$articleName = $articleData['nom'];
$unite = $articleData['unite'];
$prix_sortie = getDernierPrix($articleName, $conn);
$fournisseurName = getFournisseurName($fournisseurId, $conn);
$serviceName1 = getService($serviceName , $conn);

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
$operationAjoutee = false;

function verifierStock($articleName, $sortie, $conn) {
    $sqlStockFinal = "SELECT Stock_Final FROM etat_de_stocks WHERE Article = ?";
    $stmtStock = $conn->prepare($sqlStockFinal);
    $stmtStock->bind_param("s", $articleName);
    $stmtStock->execute();
    $stmtStock->bind_result($stockFinal);

    if ($stmtStock->fetch()) {
        $stmtStock->close();
        if ($sortie <= $stockFinal) {
            return true; // Stock suffisant pour la sortie
        } else {
            return false; // Stock insuffisant pour la sortie
        }
    } else {
        $stmtStock->close();
        return false; // Article non trouvé dans le stock
    }
}



function verifierArticleStockFinal($articleId, $conn) {
    // Requête SQL pour vérifier si l'article existe déjà dans le stock final
    $query = "SELECT 1 FROM etat_de_stocks WHERE Article = ? LIMIT 1";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $articleId); // Lie l'ID de l'article à la requête
    $stmt->execute();
    $result = $stmt->get_result();

    // Retourne true si l'article est trouvé, false sinon
    return $result->num_rows > 0;
}

$articleTrouve = false;

if (verifierArticleStockFinal($articleName , $conn)){
    if (verifierStock($articleName, $sortie, $conn)){
        $operationAjoutee = insererOperation($lotName, $sousLotName, $articleName, $entree, $sortie, $fournisseurName, $serviceName1, $prix, $unite, $pjOperation, $ref, $depense_entre, $depense_sortie, $conn);
        $articleTrouve = true;
    }
}
else{
    if ($entree > 0){
        $operationAjoutee = insererOperation($lotName, $sousLotName, $articleName, $entree, $sortie, $fournisseurName, $serviceName1, $prix, $unite, $pjOperation, $ref, $depense_entre, $depense_sortie, $conn);
    }
    $articleTrouve = false;
}

if (verifierArticleStockFinal($articleName , $conn)){
    $articleTrouve = true;
}


$isBesoin = false;


function checkBesoin($article, $sortie, $conn)
{
    $queryBesoin = "SELECT Stock_Final, Stock_Min, Requirement_Status FROM etat_de_stocks WHERE Article = ?";
    $stmt = $conn->prepare($queryBesoin);
    $stmt->bind_param("s", $article);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc(); // Récupérer la seule ligne
        $stockMin = $row['Stock_Min'];
        $stockFinal = $row['Stock_Final'];
        $status = $row['Requirement_Status'];
    } else {
        return false;
    }

    $etat = $stockFinal;
    $stmt->close();

    if ($etat <= $stockMin || $status === 'besoin') {
        return true;
    } else {
        return false;
    }
}





$stocktrue = false;
if (verifierStock($articleName, $sortie, $conn)){
    $stocktrue = true;
}
// Mettre à jour la table etat_de_stocks
mettreAJourEtatStocks($conn);

// Obtenir la valeur de stock final
$sqlStockFinal1 = "SELECT Stock_Final FROM etat_de_stocks WHERE Article = ?";
$stmtStock1 = $conn->prepare($sqlStockFinal1);
$stmtStock1->bind_param("s", $articleName);
$stmtStock1->execute();
$stmtStock1->bind_result($stockFinal1);
if ($stmtStock1->fetch()) {
    $stockFinaleValue = $stockFinal1;
}
$stmtStock1->close();

// Redirection et affichage du message
if (checkBesoin($articleName , $sortie , $conn)){
    $isBesoin = true;
}
$redirectUrl = "option_Ent_Sor.php";

if ($articleTrouve){
    if (verifierStock($articleName, $sortie, $conn)) {
        if (checkBesoin($articleName , $sortie , $conn)) {
            if ($operationAjoutee){
                $message = "ssajouter&nomArticle=$articleName&stockFinaleValue=$stockFinaleValue";
            }
            else{
                if ($sortie > 0) {
                    $message = "eppuisement&nomArticle=$articleName&stockFinaleValue=$stockFinaleValue";
                }
                else{
                    $message = "itwotkfffffff2212";
                }
            }
//            $redirectUrl .= "?message=$message&nomArticle=$articleName&stockFinaleValue=$stockFinaleValue";
        } else {
            $message = "itwotk221346275897783459768452";
//            $redirectUrl .= "?message=$message&nomArticle=$articleName&stockFinaleValue=$stockFinaleValue";
        }
//        $redirectUrl .= "?message=$message";
    } else {
        $message = "eppuisement&nomArticle=$articleName&stockFinaleValue=$stockFinaleValue";
//        $redirectUrl .= "?message=$message";
    }
}else{
    if ($operationAjoutee){
        if ($isBesoin){
            $message = "ssajouter&nomArticle=$articleName&stockFinaleValue=$stockFinaleValue";
        }
        else{
            $message = "itwork";
        }
    }else{
        if($operationAjoutee == false){
            $message = "stock_non_trouve";
        }else{
            $message = "error";
        }
//        $redirectUrl .= "?message=$message";
    }
}







$redirectUrl .= "?message=$message";
// Redirection finale

if ($isBesoin){
    $isBesoin = 1;
}else{
    $isBesoin = 0;
}

header("Location: $redirectUrl&ss=$isBesoin");

exit();

$conn->close();
?>