<?php
include '../../config/connect_db.php';

// Exécution de la requête pour obtenir les données des opérations, triées par date d'opération décroissante
$query = "
    SELECT id, lot_name, sous_lot_name, nom_article, date_operation, entree_operation, sortie_operation, pj_operation, nom_pre_fournisseur, service_operation, unite_operation, prix_operation , ref , depense_entre , depense_sortie
    FROM operation
    ORDER BY date_operation DESC
";
$result = mysqli_query($conn, $query);

// Vérifier si la requête a réussi
if (!$result) {
    die('Erreur de requête : ' . mysqli_error($conn));
}
?>


<div id="tableoperationdiv">



    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }

        #tableoperationdiv {
            position: sticky;
            top: 0px;
            margin: 20px;
        }

        #filters {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            margin-bottom: 20px;
            position: sticky;
            top: 0;
            background-color: white;
            z-index: 20;
            padding-bottom: 20px;
        }

        #filters label {
            margin-right: 10px;
            font-weight: bold;
        }

        #filters input[type="date"] {
            margin-right: 10px;
        }

        #filters button {
            margin-left: 10px;
            background-color: #007bff;
            border: none;
            color: white;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
        }

        #filters button:hover {
            background-color: #0056b3;
        }

        .table-operation {
            width: 100%;
            border-collapse: collapse;
            background-color: #ffffff;
            height: 80vh;

        }

        .table-operation th,
        .table-operation td {
            padding: 12px;
            text-align: left;
            border: 1px solid #dee2e6;
        }

        .table-operation thead {
            position: sticky;
            top: 60px;
            background-color: #007bff;
            color: #ffffff;
        }

        .table-operation tbody tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .table-operation tbody tr:hover {
            background-color: #e2e6ea;
        }

        .table-operation td {
            word-break: break-word;
        }

        .table-operation th {
            font-weight: bold;
        }

        .table-operation td input {
            border: none;
            background: transparent;
            width: 100%;
        }
    </style>

    <div id="tableoperationdiv">
        <div id="filters">
            <label for="startDate" id="p">Date de début:</label>
            <input type="date" id="startDate" name="startDate">

            <label for="endDate">Date de fin:</label>
            <input type="date" id="endDate" name="endDate">

            <button id="filterBtn">Filtrer</button>
            <button id="afficher_tous">Afficher tous</button>

            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#ajouterOperationModal">
                Ajouter Opération
            </button>
        </div>

        <table id="operationTable" class="table table-operation">
            <thead>
            <tr>
                <th>Article</th>
                <th>Date</th>
                <th>Entrée</th>
                <th>Sortie</th>
                <th>pj Operation</th>
                <th>Référence</th>
                <th>Fournisseur</th>
                <th>Service</th>
                <th>Unité</th>
                <th>Dépense Entrée</th>
                <th>Prix</th>
                <th>Déspense Sortie</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            <?php
            // Afficher les données en HTML
            while ($row = mysqli_fetch_assoc($result)) {
                echo '<tr>';
                echo '<td>' . htmlspecialchars($row['nom_article']) . '</td>';
                echo '<td>' . htmlspecialchars($row['date_operation']) . '</td>';
                echo '<td' . ($row['entree_operation'] == 0 ? ' style="background-color: #00ff44;"' : '') . '>' . htmlspecialchars($row['entree_operation']) . '</td>';
                echo '<td' . ($row['sortie_operation'] == 0 ? ' style="background-color: #ffbf4b;"' : '') . '>' . htmlspecialchars($row['sortie_operation']) . '</td>';
                echo '<td>' . htmlspecialchars($row['pj_operation']) . '</td>';
                echo '<td>' . htmlspecialchars($row['ref']) . '</td>';
                echo '<td' . ($row['nom_pre_fournisseur'] == null ? ' style="background-color: #00ff44;"' : '') . '>' . htmlspecialchars($row['nom_pre_fournisseur']) . '</td>';
                echo '<td' . ($row['service_operation'] == null ? ' style="background-color: #ffbf4b;"' : '') . '>' . htmlspecialchars($row['service_operation']) . '</td>';
                echo '<td' . ($row['unite_operation'] == 0 ? ' style="background-color: #ffbf4b;"' : '') . '>' . htmlspecialchars($row['unite_operation']) . '</td>';
                echo '<td>' . htmlspecialchars($row['depense_entre']) . '</td>';
                echo '<td>' . htmlspecialchars($row['prix_operation']) . '</td>';
                echo '<td>' . htmlspecialchars($row['depense_sortie']) . '</td>';
                echo '<td style="padding: 5px" class="text-center">';
                echo '<a href="#" style="color:green;" class="modify-btn" 
    data-id="' . htmlspecialchars($row['id']) . '"
    data-lot="' . htmlspecialchars($row['lot_name']) . '"
    data-sous-lot="' . htmlspecialchars($row['sous_lot_name']) . '"
    data-ref="' . htmlspecialchars($row['ref']) . '">
    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
        <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
        <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
    </svg>
</a> | ';

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

</div>




