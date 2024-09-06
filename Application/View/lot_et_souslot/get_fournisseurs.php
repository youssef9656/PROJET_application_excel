<?php
include '../../config/connect_db.php';

// Exécuter la requête pour obtenir les données des fournisseurs
$query = "SELECT id_fournisseur AS id, nom_fournisseur AS name FROM fournisseurs";
$result = mysqli_query($conn, $query);

// Vérifier si la requête a réussi
if (!$result) {
    die('Erreur de requête : ' . mysqli_error($conn));
}

// Récupérer les données et les encoder en JSON
$fournisseurs = array();
while ($row = mysqli_fetch_assoc($result)) {
    $fournisseurs[] = array('id' => $row['id'], 'name' => $row['name']);
}

echo json_encode($fournisseurs);

mysqli_close($conn);
?>
