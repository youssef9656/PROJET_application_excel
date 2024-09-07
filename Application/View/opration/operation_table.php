<?php
include '../../config/connect_db.php';

// Exécution de la requête pour obtenir les données des opérations
$query = "
    SELECT id, lot_name, sous_lot_name, nom_article, date_operation, entree_operation, sortie_operation, pj_operation ,nom_pre_fournisseur , service_operation ,unite_operation,prix_operation
    FROM operation
";
$result = mysqli_query($conn, $query);

// Vérifier si la requête a réussi
if (!$result) {
    die('Erreur de requête : ' . mysqli_error($conn));
}
?>


<div id="tableoperationdiv">

    <style>
        #filters{
            width: 100%;
            margin: 20px;

        }
    </style>


    <div id="filters">
        <label for="startDate">Date de début:</label>
        <input type="date" id="startDate" name="startDate">

        <label for="endDate">Date de fin:</label>
        <input type="date" id="endDate" name="endDate">

        <button id="filterBtn">Filtrer</button>
        <button id="afficher_tous">Afficher tous</button>
    </div>




    <table id="operationTable" class="table table-striped table-hover table-bordered">
        <thead>
        <tr>
            <th style="min-width: 100px; padding: 5px">ID</th>
            <th style="min-width: 150px; padding: 5px">Article</th>
            <th style="min-width: 150px; padding: 5px">Date</th>
            <th style="min-width: 100px; padding: 5px">Entrée</th>
            <th style="min-width: 100px; padding: 5px">Sortie</th>
            <th style="min-width: 100px; padding: 5px">pj Operation</th>
            <th style="min-width: 100px; padding: 5px">Fournisseur</th>
            <th style="min-width: 100px; padding: 5px">service</th>
            <th style="min-width: 100px; padding: 5px">unité</th>
            <th style="min-width: 100px; padding: 5px">Prix</th>
            <th style="min-width: 100px; padding: 5px">Action</th> <!-- Colonne d'actions -->
        </tr>
        </thead>
        <tbody>
        <?php
        // Afficher les données en HTML
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<tr>';
            echo '<td style="padding: 5px">' . htmlspecialchars($row['id']) . '</td>';
            echo '<td style="padding: 5px">' . htmlspecialchars($row['nom_article']) . '</td>';
            echo '<td style="padding: 5px">' . htmlspecialchars($row['date_operation']) . '</td>';
            echo '<td style="padding: 5px'  . ($row['entree_operation'] == 0 ? '; background-color: orange' : '') . '">' . htmlspecialchars($row['entree_operation']) . '</td>';
            echo '<td style="padding: 5px' . ($row['sortie_operation'] == 0 ? '; background-color: yellow' : '') . '">' . htmlspecialchars($row['sortie_operation']) . '</td>';
            echo '<td style="padding: 5px">' . htmlspecialchars($row['pj_operation']) . '</td>';
            echo '<td style="padding: 5px' . ($row['nom_pre_fournisseur'] == null ? '; background-color: orange' : '') . '">' . htmlspecialchars($row['nom_pre_fournisseur']) . '</td>';
            echo '<td style="padding: 5px' . ($row['service_operation'] == null ? '; background-color: yellow' : '') . '">' . htmlspecialchars($row['service_operation']) . '</td>';
            echo '<td style="padding: 5px' . ($row['unite_operation'] == 0 ? '; background-color: yellow' : '') . '">' . htmlspecialchars($row['unite_operation']) . '</td>';
            echo '<td style="padding: 5px">' . htmlspecialchars($row['prix_operation']) . '</td>';
            echo '<td style="padding: 5px" class="text-center">';
            echo '<a href="#" style="color:green;" class="modify-btn" data-id="' . htmlspecialchars($row['id']) . '" data-lot="' . htmlspecialchars($row['lot_name']) . '" data-sous-lot="' . htmlspecialchars($row['sous_lot_name']) . '" data-article="' . htmlspecialchars($row['nom_article']) . '">';
            echo '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16"><path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/><path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/></svg>';
            echo '</a> | ';
            echo '<a style="color:red" href="supprimer_operation.php?id=' . urlencode($row['id']) . '" onclick="return confirm(\'Êtes-vous sûr de vouloir supprimer cette opération ?\')">';
            echo '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash3-fill" viewBox="0 0 16 16"><path d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5m-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5M4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06m6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528M8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5"/></svg>';
            echo '</a>';
            echo '</td>';
            echo '</tr>';
        }
        ?>
        </tbody>
    </table>


</div>




