<?php
include '../../Config/connect_db.php';
$data = json_decode(file_get_contents('php://input'), true);

function insertData($conn, $table, $columns, $values) {
$columnsString = implode(", ", $columns);
$placeholders = implode(", ", array_fill(0, count($values), '?'));
$stmt = $conn->prepare("INSERT IGNORE INTO $table ($columnsString) VALUES ($placeholders)");
$stmt->bind_param(str_repeat('s', count($values)), ...$values);
$stmt->execute();
}

// إزالة المسافات غير الضرورية
function cleanData($data) {
return trim($data);
}

// معالجة البيانات
foreach ($data as $item) {
// إزالة المسافات غير الضرورية من البيانات
$lot = cleanData($item['LOT']);
$sous_lot = cleanData($item['S/LOT']);
$fournisseur = $item['FOURNISSEUR NOM  PRENOM'];
$article = cleanData($item['ARTICLES']);
$description = cleanData($item['Description']);
$unite = cleanData($item['Unité']);
$stock_initial = cleanData($item['STOCK INITIAL']);
$stock_min = cleanData($item['STOCK MIN ']);
$price = $item['P.U.TTC'] === "――" ? NULL : cleanData($item['P.U.TTC']);

// التعامل مع جدول `lots`
$lot_id_result = $conn->query("SELECT lot_id FROM lots WHERE lot_name = '$lot'");
if ($lot_id_result->num_rows === 0) {
insertData($conn, 'lots', ['lot_name'], [$lot]);
$lot_id = $conn->insert_id;
} else {
$lot_id = $lot_id_result->fetch_assoc()['lot_id'];
}

// التعامل مع جدول `sous_lots`
$sous_lot_id_result = $conn->query("SELECT sous_lot_id FROM sous_lots WHERE sous_lot_name = '$sous_lot' AND lot_id = '$lot_id'");
if ($sous_lot_id_result->num_rows === 0) {
insertData($conn, 'sous_lots', ['lot_id', 'sous_lot_name'], [$lot_id, $sous_lot]);
$sous_lot_id = $conn->insert_id;
} else {
$sous_lot_id = $sous_lot_id_result->fetch_assoc()['sous_lot_id'];
}

// تقسيم اسم المورد إلى الاسم الأول واسم العائلة
$full_name = explode(" ", $fournisseur);
$first_name = cleanData($full_name[0]);
$last_name = isset($full_name[1]) ? cleanData($full_name[1]) : '';

// التعامل مع جدول `fournisseurs`
$fournisseur_id_result = $conn->query("SELECT id_fournisseur FROM fournisseurs WHERE nom_fournisseur = '$last_name' AND prenom_fournisseur = '$first_name'");
if ($fournisseur_id_result->num_rows === 0) {
insertData($conn, 'fournisseurs', ['nom_fournisseur', 'prenom_fournisseur'], [$last_name, $first_name]);
$fournisseur_id = $conn->insert_id;
} else {
$fournisseur_id = $fournisseur_id_result->fetch_assoc()['id_fournisseur'];
}

// إدخال بيانات جدول `lot_fournisseur`
$lot_fournisseur_result = $conn->query("SELECT * FROM lot_fournisseur WHERE lot_id = '$lot_id' AND fournisseur_id = '$fournisseur_id'");
if ($lot_fournisseur_result->num_rows === 0) {
insertData($conn, 'lot_fournisseur', ['lot_id', 'fournisseur_id'], [$lot_id, $fournisseur_id]);
}

// التعامل مع جدول `article`
$article_id_result = $conn->query("SELECT id_article FROM article WHERE nom = '$article'");
if ($article_id_result->num_rows === 0) {
insertData($conn, 'article', ['nom', 'description', 'stock_initial', 'stock_min', 'prix', 'unite'], [$article, $article, $stock_initial, $stock_min, $price, $unite]);
$article_id = $conn->insert_id;
} else {
$article_id = $article_id_result->fetch_assoc()['id_article'];
}

// إدخال بيانات جدول `sous_lot_articles`
$sous_lot_article_result = $conn->query("SELECT * FROM sous_lot_articles WHERE sous_lot_id = '$sous_lot_id' AND article_id = '$article_id'");
if ($sous_lot_article_result->num_rows === 0) {
insertData($conn, 'sous_lot_articles', ['sous_lot_id', 'article_id'], [$sous_lot_id, $article_id]);
}
}

// إغلاق الاتصال
$conn->close();
?>