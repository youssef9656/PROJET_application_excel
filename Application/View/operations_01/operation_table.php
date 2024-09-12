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

<!--    <style>-->
<!--        .table-operation thead{-->
<!--            position: sticky;-->
<!--            overflow: auto;-->
<!--        }-->
<!--        .table-operation th{-->
<!--            position: sticky;-->
<!--            top: 0;-->
<!--        }-->
<!---->
<!---->
<!--        #filters{-->
<!--            width: 100%;-->
<!--            margin: 20px;-->
<!---->
<!--        }-->
<!--    </style>-->

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }

        #tableoperationdiv {
            margin: 20px;
        }

        #filters {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            margin-bottom: 20px;
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
        }

        .table-operation th,
        .table-operation td {
            padding: 12px;
            text-align: left;
            border: 1px solid #dee2e6;
        }

        .table-operation thead {
            position: sticky;
            top: 0;
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
            <label for="startDate">Date de début:</label>
            <input type="date" id="startDate" name="startDate">

            <label for="endDate">Date de fin:</label>
            <input type="date" id="endDate" name="endDate">

            <button id="filterBtn">Filtrer</button>
            <button id="afficher_tous">Afficher tous</button>
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
            </tr>
            </thead>
            <tbody>
            <?php
            // Afficher les données en HTML
            while ($row = mysqli_fetch_assoc($result)) {
                echo '<tr>';
                echo '<td>' . htmlspecialchars($row['nom_article']) . '</td>';
                echo '<td>' . htmlspecialchars($row['date_operation']) . '</td>';
                echo '<td' . ($row['entree_operation'] == 0 ? ' style="background-color: orange;"' : '') . '>' . htmlspecialchars($row['entree_operation']) . '</td>';
                echo '<td' . ($row['sortie_operation'] == 0 ? ' style="background-color: yellow;"' : '') . '>' . htmlspecialchars($row['sortie_operation']) . '</td>';
                echo '<td>' . htmlspecialchars($row['pj_operation']) . '</td>';
                echo '<td>' . htmlspecialchars($row['ref']) . '</td>';
                echo '<td' . ($row['nom_pre_fournisseur'] == null ? ' style="background-color: orange;"' : '') . '>' . htmlspecialchars($row['nom_pre_fournisseur']) . '</td>';
                echo '<td' . ($row['service_operation'] == null ? ' style="background-color: yellow;"' : '') . '>' . htmlspecialchars($row['service_operation']) . '</td>';
                echo '<td' . ($row['unite_operation'] == 0 ? ' style="background-color: yellow;"' : '') . '>' . htmlspecialchars($row['unite_operation']) . '</td>';
                echo '<td>' . htmlspecialchars($row['depense_entre']) . '</td>';
                echo '<td>' . htmlspecialchars($row['prix_operation']) . '</td>';
                echo '<td>' . htmlspecialchars($row['depense_sortie']) . '</td>';
                echo '</tr>';
            }
            ?>
            </tbody>
        </table>
    </div>

</div>




