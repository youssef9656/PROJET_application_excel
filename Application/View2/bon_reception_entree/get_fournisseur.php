<?php
include '../../config/connect_db.php';

// Vérifie si les paramètres GET sont présents
if (isset($_GET['nom_fournisseur']) && isset($_GET['prenom_fournisseur'])) {
    $nom = $_GET['nom_fournisseur'];
    $prenom = $_GET['prenom_fournisseur'];

    // Préparer la requête SQL pour récupérer les informations du fournisseur
    $sql = "SELECT * FROM fournisseurs WHERE nom_fournisseur = ? AND prenom_fournisseur = ? AND action_A_D = 1 ";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ss', $nom, $prenom);
    $stmt->execute();
    $result = $stmt->get_result();

    // Initialiser un tableau pour stocker les données du fournisseur
    $response = array();

    if ($result->num_rows > 0) {
        $fournisseur = $result->fetch_assoc();
        // Récupérer uniquement les données nécessaires
        $response['success'] = true; // Indique que la requête a réussi
        $response['data'] = array(
            'nom' => $fournisseur['nom_fournisseur'],
            'prenom' => $fournisseur['prenom_fournisseur'],
            'telephone_fixe' => $fournisseur['telephone_fixe_fournisseur'],
            'telephone_portable' => $fournisseur['telephone_portable_fournisseur'],
            'adresse' => $fournisseur['adress_fournisseur'],
            'ville' => $fournisseur['ville_fournisseur'],
            'pays' => $fournisseur['pay_fournisseur']
        );
    } else {
        $response['success'] = false; // Indique que la requête a échoué
        $response['message'] = "Aucun fournisseur trouvé avec ce nom et ce prénom.";
    }

    $stmt->close();
} else {
    $response['success'] = false; // Indique que la requête a échoué
    $response['message'] = "Les paramètres nom et prénom sont manquants.";
}

// Envoie l'en-tête JSON
header('Content-Type: application/json');
// Encode le tableau en JSON et l'affiche
echo json_encode($response);

$conn->close();
?>
