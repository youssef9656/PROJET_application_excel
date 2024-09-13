<?php
include '../../Config/connect_db.php';
// Lecture des données JSON envoyées en POST
$data = json_decode(file_get_contents('php://input'), true);

// Fonction pour insérer des données en évitant les doublons
function insertData($conn, $table, $columns, $values) {
    $columnsString = implode(", ", $columns);
    $placeholders = implode(", ", array_fill(0, count($values), '?'));
    $stmt = $conn->prepare("INSERT IGNORE INTO $table ($columnsString) VALUES ($placeholders)");
    $stmt->bind_param(str_repeat('s', count($values)), ...$values);
    $stmt->execute();
}

// Traitement des données
foreach ($data as $item) {
    // Insertion dans la table `lots`
    $lot = $item['LOT'];
    insertData($conn, 'lots', ['lot_name'], [$lot]);

    // Insertion dans la table `sous_lots`
    $sous_lot = $item['S/LOT'];
    $lot_id_result = $conn->query("SELECT lot_id FROM lots WHERE lot_name = '$lot'");
    if ($lot_id_result->num_rows > 0) {
        $lot_id = $lot_id_result->fetch_assoc()['lot_id'];
        insertData($conn, 'sous_lots', ['lot_id', 'sous_lot_name'], [$lot_id, $sous_lot]);
    }

    // Insertion dans la table `fournisseurs`
    $full_name = explode(" ", $item['FOURNISSEUR NOM PRENOM']);
    $first_name = $full_name[0];
    $last_name = isset($full_name[1]) ? $full_name[1] : '';
    insertData($conn, 'fournisseurs', ['nom_fournisseur', 'prenom_fournisseur'], [$last_name, $first_name]);

    // Insertion dans la table `article`
    $article = $item['ARTICLES'];
    $unite = $item['Unité'];
    $stock_initial = $item['STOCK INITIAL'];
    $stock_min = $item['STOCK MIN '];
    $price = $item['P.U.TTC'] === "――" ? NULL : $item['P.U.TTC'];
    insertData($conn, 'article', ['nom', 'description', 'stock_initial', 'stock_min', 'prix', 'unite'], [$article, $article, $stock_initial, $stock_min, $price, $unite]);

    // Insertion dans la table `sous_lot_articles`
    $article_id_result = $conn->query("SELECT id_article FROM article WHERE nom = '$article'");
    if ($article_id_result->num_rows > 0) {
        $article_id = $article_id_result->fetch_assoc()['id_article'];
        $sous_lot_result = $conn->query("SELECT sous_lot_id FROM sous_lots WHERE sous_lot_name = '$sous_lot' AND lot_id = '$lot_id'");
        if ($sous_lot_result->num_rows > 0) {
            $sous_lot_id = $sous_lot_result->fetch_assoc()['sous_lot_id'];
            insertData($conn, 'sous_lot_articles', ['sous_lot_id', 'article_id'], [$sous_lot_id, $article_id]);
        }
    }
}

// Fermeture de la connexion
$conn->close();
?>
