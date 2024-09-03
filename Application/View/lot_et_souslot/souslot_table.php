<?php
include '../../config/connect_db.php';

// Exécution de la requête pour obtenir les données des sous-lots et le nom du lot associé
$query = "
    SELECT sous_lots.sous_lot_id, sous_lots.sous_lot_name, sous_lots.lot_id, lots.lot_name
    FROM sous_lots
    JOIN lots ON sous_lots.lot_id = lots.lot_id
";
$result = mysqli_query($conn, $query);
// Vérifier si la requête a réussi
if (!$result) {
    die('Erreur de requête : ' . mysqli_error($conn));
}
?>
<table id="sousLotsTable" class="table-bordered">
    <thead>
    <tr>
        <th style="min-width: 100px">Order</th>
        <th style="min-width: 100px">Lot</th>
        <th style="min-width: 100px">Sous-Lot</th><!-- Nouvelle colonne pour le nom du lot -->
        <th style="min-width: 100px">Action</th> <!-- Colonne d'actions -->
    </tr>
    </thead>
    <tbody>
    <?php
    // Afficher les données en HTML
    while ($row = mysqli_fetch_assoc($result)) {
        echo '<tr>';
        echo '<td>' . htmlspecialchars($row['sous_lot_id']) . '</td>';
        echo '<td>' . htmlspecialchars($row['lot_name']) . '</td>'; // Affichage du nom du lot
        echo '<td>' . htmlspecialchars($row['sous_lot_name']) . '</td>';
        echo '<td>';
        echo '<a href="#" style="color:green;" class="modify-btn" id="id1" data-id="' . htmlspecialchars($row['sous_lot_id']) . '" data-name="' . htmlspecialchars($row['sous_lot_name']) . '" data-lot-id="' . htmlspecialchars($row['lot_id']) . '">';
        echo '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16"><path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/><path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/></svg>';
        echo '</a> | ';
        echo '<a style="color:red" href="supprimer_sous_lot.php?id=' . urlencode($row['sous_lot_id']) . '" onclick="return confirm(\'Êtes-vous sûr de vouloir supprimer ce sous-lot ?\')">';
        echo '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash3-fill" viewBox="0 0 16 16"><path d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5m-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5M4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06m6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528M8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5"/></svg>';
        echo '</a>';
        echo '</td>';
        echo '</tr>';
    }
    ?>
    </tbody>
</table>
