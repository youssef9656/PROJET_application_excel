<?php
include '../../Config/connect_db.php';
$data = json_decode(file_get_contents('php://input'), true);

function insertData($conn, $table, $columns, $values) {
    $columnsString = implode(", ", $columns);
    $placeholders = implode(", ", array_fill(0, count($values), '?'));
    $stmt = $conn->prepare("INSERT IGNORE INTO $table ($columnsString) VALUES ($placeholders)");

    if ($stmt === false) {
        die('Prepare failed: ' . $conn->error);
    }

    $stmt->bind_param(str_repeat('s', count($values)), ...$values);

    if (!$stmt->execute()) {
        die('Execute failed: ' . $stmt->error);
    }
    $stmt->close();
}

// Nettoyer les données
function cleanData($data) {
    return trim($data);
}

// Convertir les nombres avec virgules en format standard
function formatNumber($number) {
    return str_replace(",", "", $number);
}

// Traiter les données
foreach ($data as $item) {
    // Nettoyage des données

    //	Fournisseur	Articles	Description	Unité	P.U.Ttc	Stock Initial	Stock Min


    $lot = cleanData($item['lot']);
    $sous_lot = cleanData($item['s/lot']);
    $fournisseur = cleanData($item['fournisseur']);
    $article = cleanData($item['articles']);
    $description = cleanData($item['description']);
    $unite = cleanData($item['unité']);
    $stock_initial = formatNumber(cleanData($item['stockinitial']));
    $stock_min = formatNumber(cleanData($item['stockmin']));
    $price = $item['P.U.TTC'] === "――" ? NULL : cleanData($item['p.u.ttc']);

    // Table `lots`
    $lot_id_result = $conn->query("SELECT lot_id FROM lots WHERE lot_name = '" . $conn->real_escape_string($lot) . "'");
    if ($lot_id_result->num_rows === 0) {
        insertData($conn, 'lots', ['lot_name'], [$lot]);
        $lot_id = $conn->insert_id;
    } else {
        $lot_id = $lot_id_result->fetch_assoc()['lot_id'];
    }

    // Table `sous_lots`
    $sous_lot_id_result = $conn->query("SELECT sous_lot_id FROM sous_lots WHERE sous_lot_name = '" . $conn->real_escape_string($sous_lot) . "' AND lot_id = '$lot_id'");
    if ($sous_lot_id_result->num_rows === 0) {
        insertData($conn, 'sous_lots', ['lot_id', 'sous_lot_name'], [$lot_id, $sous_lot]);
        $sous_lot_id = $conn->insert_id;
    } else {
        $sous_lot_id = $sous_lot_id_result->fetch_assoc()['sous_lot_id'];
    }

//    // Séparer le nom et prénom du fournisseur
//    $full_name = explode(" ", $fournisseur);
//    $first_name = cleanData($full_name[0]);
//    $last_name = isset($full_name[1]) ? cleanData($full_name[1]) : 'youssef';
    $first_name =$fournisseur;
    $last_name=$fournisseur;
    // Table `fournisseurs`
    $fournisseur_id_result = $conn->query("SELECT id_fournisseur FROM fournisseurs WHERE nom_fournisseur = '" . $conn->real_escape_string($last_name) . "' AND prenom_fournisseur = '" . $conn->real_escape_string($first_name) . "'");
    if ($fournisseur_id_result->num_rows === 0) {
        insertData($conn, 'fournisseurs', ['nom_fournisseur', 'prenom_fournisseur'], [$last_name, $first_name]);
        $fournisseur_id = $conn->insert_id;
    } else {
        $fournisseur_id = $fournisseur_id_result->fetch_assoc()['id_fournisseur'];
    }

    // Table `lot_fournisseur`
    $lot_fournisseur_result = $conn->query("SELECT * FROM lot_fournisseurs WHERE lot_id = '$lot_id' AND id_fournisseur = '$fournisseur_id'");
    if ($lot_fournisseur_result->num_rows === 0) {
        insertData($conn, 'lot_fournisseurs', ['lot_id', 'id_fournisseur'], [$lot_id, $fournisseur_id]);
    }

    // Table `article`
    $article_id_result = $conn->query("SELECT id_article FROM article WHERE nom = '" . $conn->real_escape_string($article) . "'");
    if ($article_id_result->num_rows === 0) {
        insertData($conn, 'article', ['nom', 'description', 'stock_initial', 'stock_min', 'prix', 'unite'], [$article, $description, $stock_initial, $stock_min, $price, $unite]);
        $article_id = $conn->insert_id;
    } else {
        $article_id = $article_id_result->fetch_assoc()['id_article'];
    }

    // Table `sous_lot_articles`
    $sous_lot_article_result = $conn->query("SELECT * FROM sous_lot_articles WHERE sous_lot_id = '$sous_lot_id' AND article_id = '$article_id'");
    if ($sous_lot_article_result->num_rows === 0) {
        insertData($conn, 'sous_lot_articles', ['sous_lot_id', 'article_id'], [$sous_lot_id, $article_id]);
    }
}

// Fermer la connexion
$conn->close();
?>
