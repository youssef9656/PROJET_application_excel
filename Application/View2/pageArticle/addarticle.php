<?php
include '../../Config/connect_db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les données du formulaire
    $nom = $_POST['nom'];
    $description = $_POST['description'];
    $stock_min = $_POST['stock_min'];
    $stock_initial = $_POST['stock_initial'];
    $prix = $_POST['prix'];
    $unite = $_POST['unite'];

    // Vérifier si l'article existe déjà
    $sql = "SELECT COUNT(*) FROM article WHERE nom = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("s", $nom);
        $stmt->execute();
        $stmt->bind_result($count);
        $stmt->fetch();
        $stmt->close();

        if ($count > 0) {
            // L'article existe déjà
            echo "L'article existe déjà.";
        } else {
            // Insérer le nouvel article
            $sql = "INSERT INTO article (nom, description, stock_min, stock_initial, prix, unite) VALUES (?, ?, ?, ?, ?, ?)";
            if ($stmt = $conn->prepare($sql)) {
                $stmt->bind_param("sssdds", $nom, $description, $stock_min, $stock_initial, $prix, $unite);
                if ($stmt->execute()) {
                    echo "Article ajouté avec succès.";
                } else {
                    echo "Erreur lors de l'ajout de l'article.";
                }
                $stmt->close();
            } else {
                echo "Échec de la préparation de la requête.";
            }
        }
    } else {
        echo "Échec de la préparation de la requête.";
    }

    $conn->close();
}
?>
