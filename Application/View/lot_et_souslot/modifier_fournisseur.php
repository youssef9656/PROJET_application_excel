<?php
include '../../config/connect_db.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les données du formulaire
    $fournisseurId = $_POST['fournisseurId'];
    $nomFournisseur = $_POST['nomFournisseur'];
    $lotFournisseur = $_POST['lotFournisseur'];

    // Préparer la requête SQL pour obtenir les ids
    $queryLot = "SELECT lot_id FROM lots WHERE lot_name = ?";
    $queryFournisseur = "SELECT id_fournisseur FROM fournisseurs WHERE nom_fournisseur = ?";

    $lotId = null;
    $idFournisseur = null;

    // Obtenir le lot_id
    if ($stmt = $conn->prepare($queryLot)) {
        $stmt->bind_param('s', $lotFournisseur);
        $stmt->execute();
        $stmt->bind_result($lotId);
        $stmt->fetch();
        $stmt->close();
    }

    // Obtenir le id_fournisseur
    if ($stmt = $conn->prepare($queryFournisseur)) {
        $stmt->bind_param('s', $nomFournisseur);
        $stmt->execute();
        $stmt->bind_result($idFournisseur);
        $stmt->fetch();
        $stmt->close();
    }

    // Vérifier si nous avons trouvé les ids
    if ($lotId && $idFournisseur) {
        // Préparer la requête SQL pour vérifier si la combinaison existe déjà
        $checkQuery = "SELECT COUNT(*) FROM lot_fournisseurs WHERE lot_id = ? AND id_fournisseur = ?";
        if ($checkStmt = $conn->prepare($checkQuery)) {
            $checkStmt->bind_param('ii', $lotId, $idFournisseur);
            $checkStmt->execute();
            $checkStmt->bind_result($count);
            $checkStmt->fetch();
            $checkStmt->close();

            if ($count > 0) {
                // Si la combinaison existe déjà, mettez à jour la ligne
                $updateQuery = "UPDATE lot_fournisseurs SET lot_id = ?, id_fournisseur = ? WHERE lot_id = ? AND id_fournisseur = ?";

                if ($updateStmt = $conn->prepare($updateQuery)) {
                    $updateStmt->bind_param('iiii', $lotId, $idFournisseur, $lotId, $idFournisseur);
                    if ($updateStmt->execute()) {
                        echo 'Mise à jour réussie.';
                    } else {
                        echo 'Erreur lors de la mise à jour : ' . $updateStmt->error;
                    }
                    $updateStmt->close();
                } else {
                    echo 'Erreur de préparation de la requête de mise à jour : ' . $conn->error;
                }
            } else {
                // Si la combinaison n'existe pas, insérer une nouvelle ligne
                $insertQuery = "INSERT INTO lot_fournisseurs (lot_id, id_fournisseur) VALUES (?, ?)";

                if ($insertStmt = $conn->prepare($insertQuery)) {
                    $insertStmt->bind_param('ii', $lotId, $idFournisseur);
                    if ($insertStmt->execute()) {
                        echo 'Insertion réussie.';
                    } else {
                        echo 'Erreur lors de l\'insertion : ' . $insertStmt->error;
                    }
                    $insertStmt->close();
                } else {
                    echo 'Erreur de préparation de la requête d\'insertion : ' . $conn->error;
                }
            }
        } else {
            echo 'Erreur de préparation de la requête de vérification : ' . $conn->error;
        }
    } else {
        echo 'Lot ou fournisseur non trouvé.';
    }

    // Fermer la connexion
    $conn->close();
} else {
    echo 'Aucune donnée reçue.';
}
?>
