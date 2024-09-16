<?php
include '../../Config/connect_db.php';

// Vérifiez si le paramètre 'vue_articles_fournisseurs' est présent dans la requête GET
if (isset($_GET['vue_articles_fournisseurs'])) {
    // Requête SQL pour récupérer les données de la vue
    $sql = "SELECT * FROM vue_articles_fournisseurs";
    $result = $conn->query($sql);

    $data = array();

    if ($result->num_rows > 0) {
        // Récupérer les données et les ajouter au tableau $data
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    }

    // Définir le type de contenu en JSON
    header('Content-Type: application/json');

    // Convertir le tableau en JSON et l'afficher
    echo json_encode($data, JSON_PRETTY_PRINT);
} else {
    // Si le paramètre n'est pas présent, afficher un message d'erreur ou une réponse vide
    header('Content-Type: application/json');
    echo json_encode(array("error" => "Paramètre 'vue_articles_fournisseurs' non trouvé"), JSON_PRETTY_PRINT);
}

// Fermez la connexion
$conn->close();
?>
