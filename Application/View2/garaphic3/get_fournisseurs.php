<?php
//include '../../config/connect_db.php';
//
//$sous_lot = $_GET['sous_lot'] ?? '';
//
//// Vérifier si un sous-lot est sélectionné
//if (!empty($sous_lot)) {
//    $sql = "SELECT DISTINCT nom_pre_fournisseur FROM operation WHERE sous_lot_name = '" . $conn->real_escape_string($sous_lot) . "'";
//} else {
//    // Si aucun sous-lot n'est sélectionné, récupérer tous les fournisseurs
//    $sql = "SELECT DISTINCT nom_pre_fournisseur FROM operation  ";
//}
//
//$result = $conn->query($sql);
//
//$fournisseurs = [];
//while ($row = $result->fetch_assoc()) {
//    $fournisseurs[] = $row;
//}
//
//echo json_encode($fournisseurs);
//?>

<?php
include '../../config/connect_db.php';

$sous_lot = $_GET['sous_lot'] ?? '';

// Vérifier si un sous-lot est sélectionné
if (!empty($sous_lot)) {
    // Sélectionner nom_pre_fournisseur de operation et joindre avec fournisseurs
    $sql = "
        SELECT DISTINCT o.nom_pre_fournisseur 
        FROM operation o
        JOIN fournisseurs f ON o.nom_pre_fournisseur = CONCAT(f.nom_fournisseur, ' ', f.prenom_fournisseur)
        WHERE f.action_A_D = 1 AND o.sous_lot_name = '" . $conn->real_escape_string($sous_lot) . "'
    ";
} else {
    // Récupérer tous les nom_pre_fournisseur avec action_A_D = 1
    $sql = "
        SELECT DISTINCT o.nom_pre_fournisseur 
        FROM operation o
        JOIN fournisseurs f ON o.nom_pre_fournisseur = CONCAT(f.nom_fournisseur, ' ', f.prenom_fournisseur)
        WHERE f.action_A_D = 1
    ";
}

$result = $conn->query($sql);

$fournisseurs = [];
while ($row = $result->fetch_assoc()) {
    $fournisseurs[] = $row;
}

echo json_encode($fournisseurs);
?>
