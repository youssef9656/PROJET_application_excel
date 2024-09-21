<?php
include '../../config/connect_db.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Vérifiez si les données ont été envoyées via POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Récupération des données du formulaire
    $service = $_POST['service'];
    $zone = $_POST['zone'];
    $ref = $_POST['ref'];
    $equip = $_POST['equip'];

    // Préparer la requête SQL
    $stmt = $conn->prepare("INSERT INTO service_zone (service, zone, ref, equip) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $service, $zone, $ref, $equip);

    // Exécuter la requête
    if ($stmt->execute()) {
        // Réponse de succès
        echo json_encode(['status' => 'success', 'message' => 'Service ajouté avec succès']);
    } else {
        // Réponse d'erreur
        echo json_encode(['status' => 'error', 'message' => 'Erreur lors de l\'ajout du service: ' . $stmt->error]);
    }

    // Fermer la requête préparée
    $stmt->close();
}

// Fermer la connexion à la base de données
$conn->close();
?>
