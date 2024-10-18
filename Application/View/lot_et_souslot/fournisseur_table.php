<?php
include '../../config/connect_db.php';

// Exécution de la requête pour obtenir les données des fournisseurs et le nom du lot associé
$query = "
    SELECT f.id_fournisseur, f.nom_fournisseur, l.lot_name
    FROM lot_fournisseurs lf 
    JOIN fournisseurs f ON lf.id_fournisseur = f.id_fournisseur
    JOIN lots l ON lf.lot_id = l.lot_id
    WHERE f.action_A_D = 1
    ORDER BY l.lot_name
";
$result = mysqli_query($conn, $query);

// Vérifier si la requête a réussi
if (!$result) {
    die('Erreur de requête : ' . mysqli_error($conn));
}
?>

<table id="fournisseursTable" class="table-bordered table table-striped table-hover">
    <thead>
    <tr>
        <th style="min-width: 150px">ID Fournisseur</th>
        <th style="min-width: 150px; padding: 5px">Nom du Lot</th>
        <th style="min-width: 150px; padding: 5px">Nom du Fournisseur</th>
        <th style="min-width: 100px; padding: 5px">Action</th>
    </tr>
    </thead>
    <tbody>
    <?php
    // Afficher les données en HTML
    while ($row = mysqli_fetch_assoc($result)) {
        echo '<tr>';
        echo '<td>' . htmlspecialchars($row['id_fournisseur']) . '</td>';
        echo '<td style="padding: 5px">' . htmlspecialchars($row['lot_name']) . '</td>';
        echo '<td style="padding: 5px">' . htmlspecialchars($row['nom_fournisseur']) . '</td>';
        echo '<td style="padding: 5px" class="text-center">';

        echo '<a style="color:red" href="supprimer_fournisseur.php?id=' . urlencode($row['id_fournisseur']) . '" onclick="return confirm(\'Êtes-vous sûr de vouloir supprimer ce fournisseur ?\')">';
        echo '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash3-fill" viewBox="0 0 16 16"><path d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5m-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5M4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06m6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528M8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5"/></svg>';
        echo '</a>';
        echo '</td>';
        echo '</tr>';
    }
    ?>
    </tbody>
</table>

