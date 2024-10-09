<?php
include '../../config/connect_db.php';

// Fonction pour récupérer les résultats sous forme de tableau
function fetchAllResults($result) {
    $data = [];
    while ($row = $result->fetch_row()) {
        $data[] = $row[0]; // On récupère la première colonne de chaque ligne
    }
    return $data;
}

// Récupérer toutes les options de la base de données
$lots = fetchAllResults($conn->query("SELECT DISTINCT lot_name FROM operation"));
$articles = fetchAllResults($conn->query("SELECT DISTINCT nom_article FROM operation"));
$fournisseurs = fetchAllResults($conn->query("
    SELECT DISTINCT o.nom_pre_fournisseur 
    FROM operation o
    JOIN fournisseurs f ON o.nom_pre_fournisseur = CONCAT(f.nom_fournisseur, ' ', f.prenom_fournisseur)
    WHERE f.action_A_D = 1
"));$sous_lots = fetchAllResults($conn->query("SELECT DISTINCT sous_lot_name FROM operation"));
//$services = fetchAllResults($conn->query("SELECT DISTINCT service_operation FROM operation"));

// Envoyer les données en format JSON
header('Content-Type: application/json');
echo json_encode([
    'lots' => $lots,
    'articles' => $articles,
    'fournisseurs' => $fournisseurs,
    'sous_lots' => $sous_lots
//    'services' => $services
]);
