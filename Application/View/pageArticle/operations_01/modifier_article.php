<?php
include '../../config/connect_db.php';

// Récupérer les données du formulaire
$id_article = $_POST['id_article'];
$nom = $_POST['nom_article'];
$description = $_POST['description'];
$stock_min = $_POST['stock_min'];
$stock_initial = $_POST['stock_initial'];
$prix = $_POST['prix'];
$unite = $_POST['unite'];


// Mise à jour de l'article
$query = "UPDATE article SET nom = ?, description = ?, stock_min = ?, stock_initial = ?, prix = ?, unite = ? WHERE id_article = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('ssiddsi', $nom, $description, $stock_min, $stock_initial, $prix, $unite, $id_article);

$response = [];

if ($stmt->execute()) {
    // Réponse en cas de succès
    $response['status'] = 'success';
    $response['message'] = 'Article modifié avec succès.';
} else {
    // Réponse en cas d'échec
    $response['status'] = 'error';
    $response['message'] = 'Erreur lors de la modification de l\'article : ' . $stmt->error;
}

// Retourner la réponse sous forme de JSON
echo json_encode($response);

$stmt->close();
$conn->close();
?>
<?php
header('Content-Type: application/json');  // Indique que la réponse est en JSON

// Exemple de traitement
$result = [
    'status' => 'success',
    'message' => 'Article modifié avec succès'
];

// Si une erreur s'est produite, vous pourriez avoir quelque chose comme :
// $result = ['status' => 'error', 'message' => 'Erreur lors de la modification'];

echo json_encode($result);  // Envoie la réponse en format JSON
?>
