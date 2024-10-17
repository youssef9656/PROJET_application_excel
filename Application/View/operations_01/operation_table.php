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
            max-height: 80vh;

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
            z-index: 12;
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


            <label for="article_filter">Article:</label>
            <input type="text" id="article_filter" list="article_list" onchange="filterArticle()">
            <datalist id="article_list">
                <!--                les articles seront ajouter ici -->
            </datalist>


            <button id="filterBtn">Filtrer</button>
            <button id="afficher_tous">Afficher tous</button>

            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#ajouterOperationModal">
                Ajouter Opération
            </button>

<!--            Article filter-->





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
            <tbody id="tbodyTableOperation">
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

                echo '<a href="#" data-bs-toggle="modal" data-bs-target="#reclamationModal" data-operation-id="' . htmlspecialchars($row['id']) . '"><button class="btn-12" style="width: 130px"><span>Reclamation</span></button></a>';
                echo '</td>';
                echo '</tr>';
            }
            ?>
            </tbody>
        </table>
    </div>

</div>


