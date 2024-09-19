
<?php
include '../../Config/connect_db.php';

include '../../Config/check_session.php';
checkUserRole('admin');

$pageName = 'Importer les données';

include '../../includes/header.php';


?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Excel</title>
<!--    <script src="../../includes/jquery.sheetjs.js"></script>-->
    <script src="xlsx.full.min.js"></script>

<!--    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.4/xlsx.full.min.js"></script>-->
<!--    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>-->
</head>
<div style="color: white ;">

</div>

<body>



<style>

    .container {
        max-width: 90%;
        margin: auto;
        padding: 20px;
        background: white;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }
    .table-container {
        margin-top: 20px;
        max-height: 400px;
        overflow-y: auto;
    }
    .table-fixed thead th {
        position: -webkit-sticky; /* For Safari */
        position: sticky;
        top: 0;
        background-color: #007bff;
        color: white;
        z-index: 1;
    }
    table {
        width: 100%;
    }
    th, td {
        text-align: center;
        padding: 10px;
    }
    td {
        background-color: #e9ecef;
    }
    .btn-custom {
        margin-top: 20px;
    }
    .alert {
        display: none;
    }
    /* From Uiverse.io by omar49511 */
    .container-btn-file {
        display: flex;
        position: relative;
        justify-content: center;
        align-items: center;
        background-color: #307750;
        color: #fff;
        border-style: none;
        padding: 1em 2em;
        border-radius: 0.5em;
        overflow: hidden;
        z-index: 1;
        box-shadow: 4px 8px 10px -3px rgba(0, 0, 0, 0.356);
        transition: all 250ms;
    }
    .container-btn-file input[type="file"] {
        position: absolute;
        width: 100%;
        height: 100%;
        opacity: 0;
        cursor: pointer;
    }
    .container-btn-file > svg {
        margin-right: 1em;
    }
    .container-btn-file::before {
        content: "";
        position: absolute;
        height: 100%;
        width: 0;
        border-radius: 0.5em;
        background-color: #469b61;
        z-index: -1;
        transition: all 350ms;
    }
    .container-btn-file:hover::before {
        width: 100%;
    }


    /* Style pour le conteneur du tableau */
    #tablecontainerEroor {
        margin: 20px 0;
        overflow: hidden;
        width: 100%;
    }

    /* Style pour le tableau */
    #tablecontainerEroor table {
        width: 100%;
        border-collapse: collapse;
        font-family: Arial, sans-serif;
        border: 2px solid #f44336; /* Bordure rouge */
        background-color: #ffebee; /* Fond légèrement rouge pâle */
        table-layout: fixed;
    }

    /* Fixer la largeur des colonnes */
    #tablecontainerEroor th, #tablecontainerEroor td {
        padding: 8px;
        text-align: left;
        border-bottom: 1px solid #f44336;
    }

    /* Style pour fixer les en-têtes */
    #tablecontainerEroor thead {
        background-color: #f44336; /* Rouge vif pour les en-têtes */
        color: white;
        position: sticky;
        top: 0;
        z-index: 10;
    }

    /* Style pour le corps du tableau avec défilement */
    #tablecontainerEroor tbody {
        display: block;
        max-height: 300px; /* Hauteur maximale pour le défilement */
        overflow-y: scroll;
    }

    #tablecontainerEroor tbody tr {
        display: table;
        width: 100%;
        table-layout: fixed;
    }

    /* Alternance des couleurs pour les lignes du tbody */
    #tablecontainerEroor tbody tr:nth-child(even) {
        background-color: #ffcdd2; /* Alternance des lignes */
    }

    /* Style pour les cellules du tbody */
    #tablecontainerEroor tbody td {
        background-color: #ffebee; /* Couleur de fond */
        color: #333; /* Couleur du texte */
    }

    /* Survol des lignes du tbody */
    #tablecontainerEroor tbody tr:hover {
        background-color: #ef9a9a; /* Survol avec une couleur plus claire */
    }

    /* Bordure sur le côté droit du tableau pour éviter des chevauchements */
    #tablecontainerEroor table th, #tablecontainerEroor table td {
        border-right: 1px solid #f44336;
    }

    /* Supprimer la barre de défilement horizontale si nécessaire */
    #tablecontainerEroor tbody::-webkit-scrollbar {
        width: 8px;
    }

    #tablecontainerEroor tbody::-webkit-scrollbar-thumb {
        background-color: #f44336;
        border-radius: 10px;
    }


</style>

<div class="container">
    <h1>Importer un fichier Excel</h1>

    <div id="instructionsContainer">
        <p><strong>Instructions :</strong></p>
        <p>Veuillez ne pas modifier l'ordre ou les noms des colonnes dans votre fichier Excel. Le format attendu est :</p>
        <ul STYLE="display: flex;flex-flow: row;justify-content: space-between">
            <li>LOT</li>
            <li>Sous Lot</li>
            <li>Fournisseur</li>
            <li>ARTICLES</li>
            <li>Description</li>
            <li>Unité</li>
            <li>P.U.TTC</li>
            <li>STOCK INITIAL</li>
            <li>STOCK MIN</li>
        </ul>
        <p>Les colonnes doivent rester dans cet ordre pour éviter les erreurs lors du traitement des données.</p>
    </div>

    <div class="form-group w-100 text-center">
        <div style="display:flex;justify-content: center;">
            <button class="container-btn-file w-">
                <svg
                        fill="#fff"
                        xmlns="http://www.w3.org/2000/svg"
                        width="20"
                        height="20"
                        viewBox="0 0 50 50"
                >
                    <path
                            d="M28.8125 .03125L.8125 5.34375C.339844
    5.433594 0 5.863281 0 6.34375L0 43.65625C0
    44.136719 .339844 44.566406 .8125 44.65625L28.8125
    49.96875C28.875 49.980469 28.9375 50 29 50C29.230469
    50 29.445313 49.929688 29.625 49.78125C29.855469 49.589844
    30 49.296875 30 49L30 1C30 .703125 29.855469 .410156 29.625
    .21875C29.394531 .0273438 29.105469 -.0234375 28.8125 .03125ZM32
    6L32 13L34 13L34 15L32 15L32 20L34 20L34 22L32 22L32 27L34 27L34
    29L32 29L32 35L34 35L34 37L32 37L32 44L47 44C48.101563 44 49
    43.101563 49 42L49 8C49 6.898438 48.101563 6 47 6ZM36 13L44
    13L44 15L36 15ZM6.6875 15.6875L11.8125 15.6875L14.5 21.28125C14.710938
    21.722656 14.898438 22.265625 15.0625 22.875L15.09375 22.875C15.199219
    22.511719 15.402344 21.941406 15.6875 21.21875L18.65625 15.6875L23.34375
    15.6875L17.75 24.9375L23.5 34.375L18.53125 34.375L15.28125
    28.28125C15.160156 28.054688 15.035156 27.636719 14.90625
    27.03125L14.875 27.03125C14.8125 27.316406 14.664063 27.761719
    14.4375 28.34375L11.1875 34.375L6.1875 34.375L12.15625 25.03125ZM36
    20L44 20L44 22L36 22ZM36 27L44 27L44 29L36 29ZM36 35L44 35L44 37L36 37Z"
                    ></path>
                </svg>
                Importer un fichier
                <!--            <input class="file" name="text" type="file" />-->
                <input type="file" name="text" id="fileInput" class="form-control-file file" />

            </button>
        </div>
        <button class="btn btn-primary m-3 " onclick="uploadData()">Importer les données</button>


    </div>


    <div id="alertContainer" class="alert alert-danger mt-3" role="alert"></div>

    <div id="tableContainer" class="table-container mt-4">
        <!-- Table will be dynamically inserted here -->
    </div>
    <button id="sendData" class="btn btn-success btn-custom" style="display: none;" onclick="sendData()">Envoyer les données</button>
</div>
<style>
    /* Style pour le conteneur du tableau */
    #tablecontainerEroor {
        margin: 20px 0;
        overflow: hidden;
        width: 100%;
    }

    /* Style pour le tableau */
    #tablecontainerEroor table {
        width: 100%;
        border-collapse: collapse;
        font-family: Arial, sans-serif;
        border: 2px solid #f44336; /* Bordure rouge */
        background-color: #ffebee; /* Fond légèrement rouge pâle */
        table-layout: fixed;
    }

    /* Fixer la largeur des colonnes */
    #tablecontainerEroor th, #tablecontainerEroor td {
        padding: 12px; /* Augmenter l'espace interne */
        text-align: left;
        border-bottom: 1px solid #f44336;
        font-size: 14px; /* Taille de police plus grande */
    }

    /* Style pour fixer les en-têtes */
    #tablecontainerEroor thead {
        background-color: #f44336; /* Rouge vif pour les en-têtes */
        color: white;
        position: sticky;
        top: 0;
        z-index: 10;
        display: table;
        width: 100%; /* Assurer que thead prend toute la largeur du tableau */
        table-layout: fixed;
        font-size: 16px; /* Police plus grande pour les en-têtes */
    }

    /* Défilement du tbody avec la même largeur que thead */
    #tablecontainerEroor tbody {
        display: block;
        max-height: 300px; /* Hauteur maximale pour le défilement */
        overflow-y: auto; /* Défilement vertical */
        width: 100%; /* Correspondre à la largeur du thead */
    }

    #tablecontainerEroor tbody tr {
        display: table;
        width: 100%; /* Largeur identique au tableau */
        table-layout: fixed; /* Forcer une largeur fixe des colonnes */
    }

    /* Alternance des couleurs pour les lignes du tbody */
    #tablecontainerEroor tbody tr:nth-child(even) {
        background-color: #ffcdd2; /* Alternance des lignes */
    }

    /* Style pour les cellules du tbody */
    #tablecontainerEroor tbody td {
        background-color: #ffebee; /* Couleur de fond */
        color: #333; /* Couleur du texte */
    }

    /* Style spécial pour la dernière colonne (Raison du doublon) */
    #tablecontainerEroor tbody td:last-child {
        background-color: rgba(21, 22, 169, 0.8); /* Couleur orange pour attirer l'attention */
        color: white; /* Texte blanc pour contraster */
        font-weight: bold; /* Texte en gras pour plus d'accent */
    }

    /* Survol des lignes du tbody */
    #tablecontainerEroor tbody tr:hover {
        background-color: #ef9a9a; /* Survol avec une couleur plus claire */
    }

    /* Bordure sur le côté droit du tableau */
    #tablecontainerEroor table th, #tablecontainerEroor table td {
        border-right: 1px solid #f44336;
    }

    /* Supprimer la barre de défilement horizontale si nécessaire */
    #tablecontainerEroor tbody::-webkit-scrollbar {
        width: 8px;
    }

    #tablecontainerEroor tbody::-webkit-scrollbar-thumb {
        background-color: #f44336;
        border-radius: 10px;
    }

</style>
<h2 clo>Liste des Doublons</h2>
<div id="tablecontainerEroor"></div>
<script src="../../includes/js/bootstrap.bundle.min.js"></script>

<script>

    function capitalizeWords(text) {
        return text.toLowerCase().replace(/\b\w/g, function(char) {
            return char.toUpperCase();
        });
    }

    function removeExtraSpaces(text) {
        return text.replace(/\s+/g, ' ').trim();
    }

    function formatKey(key) {
        return capitalizeWords(removeExtraSpaces(key));
    }

    function displayTable(json) {
        var tableContainer = document.getElementById('tableContainer');
        var table = '<table class="table table-bordered table-striped table-fixed sheetjs"><thead><tr>';


        // Create table headers
        var headers = Object.keys(json[0]);
        headers.forEach(function(header) {
            table += '<th>' + formatKey(header) + '</th>';
        });
        table += '</tr></thead><tbody>';

        // Create table rows
        json.forEach(function(row) {
            table += '<tr>';
            headers.forEach(function(header) {
                table += '<td>' + formatKey(String(row[header])) + '</td>';
            });
            table += '</tr>';
        });

        table += '</tbody></table>';
        tableContainer.innerHTML = table;
        document.getElementById('sendData').style.display = 'inline-block';
    }

    function transformDataForSending(json) {
        return json.map(row => {
            let newRow = {};
            Object.keys(row).forEach(key => {
                let formattedKey = formatKey(key).replace(/\s+/g, '').toLowerCase();
                newRow[formattedKey] = removeExtraSpaces(String(row[key])).toLowerCase();
            });
            return newRow;
        });
    }
    get_data()

    function get_data(){
        const url = 'get_data.php?vue_articles_fournisseurs';

        fetch(url)

            .then(response => {
                // Vérifiez  si la réponse est OK
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json(); // Convertir la réponse en JSON
            })
            .then(data => {
                console.log('Données JSON reçues:', data);
            })
            .catch(error => {
                // Gérer les erreurs
                console.error('There was a problem with the fetch operation:', error);
                document.getElementById('result').textContent = 'Erreur: ' + error.message;
            });

    }

    function uploadData() {
        var fileInput = document.getElementById('fileInput');
        var file = fileInput.files[0];
        if (!file) {
            document.getElementById('alertContainer').innerText = 'Veuillez sélectionner un fichier.';
            document.getElementById('alertContainer').style.display = 'block';
            return;
        }
        document.getElementById('alertContainer').style.display = 'none';

        var reader = new FileReader();
        reader.onload = function(event) {
            var data = new Uint8Array(event.target.result);
            var workbook = XLSX.read(data, {type: 'array'});
            var sheetName = workbook.SheetNames[0];
            var worksheet = workbook.Sheets[sheetName];
            var json = XLSX.utils.sheet_to_json(worksheet, {header:1}); // Read as array of arrays

            if (json.length > 0) {
                // Define expected column order
                var expectedColumns = ['lot', 'sous lot', 'fournisseur', 'articles', 'description', 'unité', 'p.u.ttc', 'stock initial', 'stock min'];

                // Get actual columns from the first row and format them
                var actualColumns = json[0].map(col => removeExtraSpaces(col.toLowerCase()));

                // Check if columns match in order
                var columnsMatch = expectedColumns.length === actualColumns.length &&
                    expectedColumns.every((col, index) => col === actualColumns[index]);

                if (!columnsMatch) {
                    showError('Le fichier Excel contient des colonnes dans un ordre différent de celui attendu. Les colonnes doivent être dans l\'ordre suivant : LOT, Sous Lot, Fournisseur, ARTICLES, Description, Unité, P.U.TTC, STOCK INITIAL, STOCK MIN.');
                    return;
                }

                // Proceed with processing if columns match
                console.log('Colonnes vérifiées avec succès.');
                var formattedJson = json.slice(1).map(row => {
                    let newRow = {};
                    actualColumns.forEach((col, index) => {
                        newRow[col] = String(row[index]).trim();
                    });
                    return newRow;
                });

                displayTable(formattedJson);
                const { filteredData, errors } = filterData(formattedJson);

                // console.log('Filtered Data:', filteredData);
                // console.log('Errors:', errors);
                // console.log('felhhh ',formattedJson)





                createTable(errors);

                window.jsonData = transformDataForSending(filteredData);

            }
        };
        reader.readAsArrayBuffer(file);
    }

    function showError(message) {
        document.getElementById('alertContainer').innerText = message;
        document.getElementById('alertContainer').style.display = 'block';
    }

    function removeExtraSpaces(text) {
        return text.trim().replace(/\s+/g, ' ');
    }

    function showError(message) {
        document.getElementById('alertContainer').innerText = message;
        document.getElementById('alertContainer').style.display = 'block';
    }




    function sendData() {
        if (!window.jsonData) {
            alert('Aucune donnée à envoyer.');
            return;
        }

        // console.log('Envoi des données :', window.jsonData);

        fetch('upload.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(window.jsonData),
        })
            .then(response => response.text())
            .then(result => {
                alert('Données envoyées avec succès.');
            })
            .catch(error => {
                console.error('Erreur :', error);
            });
    }



    function createTable(data) {
        const tableContainer = document.getElementById('tablecontainerEroor');
        tableContainer.innerHTML = ''; // Effacer le contenu précédent

        if (data.length === 0) {
            tableContainer.textContent = 'Aucune donnée à afficher.';
            return;
        }

        const table = document.createElement('table');
        const thead = document.createElement('thead');
        const tbody = document.createElement('tbody');

        // Créer les en-têtes de tableau
        const headers = [
            "Lot", "Sous Lot", "Fournisseur", "Article", "Description", "Unité", "Prix TTC", "Stock Initial", "Stock Min", "Raison du doublon"
        ];
        const headerRow = document.createElement('tr');
        headers.forEach(header => {
            const th = document.createElement('th');
            th.textContent = header;
            headerRow.appendChild(th);
        });
        thead.appendChild(headerRow);

        // Créer les lignes de tableau
        data.duplicates.forEach(entry => {
            const item = entry.item;
            const row = document.createElement('tr');
            const cells = [
                item.lot,
                item['sous lot'],
                item.fournisseur,
                item.articles,
                item.description,
                item.unité,
                item['p.u.ttc'],
                item['stock initial'],
                item['stock min'],
                entry.reason
            ];
            cells.forEach(cell => {
                const td = document.createElement('td');
                td.textContent = cell; // Utiliser textContent pour éviter le HTML
                row.appendChild(td);
            });
            tbody.appendChild(row);
        });

        table.appendChild(thead);
        table.appendChild(tbody);
        tableContainer.appendChild(table);
    }

    function filterData(data) {
        const seen = {
            articles: new Set(),
            lotToSousLots: new Map(),  // Map pour suivre les sous lots à l'intérieur de chaque lot
            sousLotToLots: new Map()   // Map pour suivre les sous lots à travers différents lots
        };

        const errors = {
            duplicates: []
        };

        const filteredData = data.filter((item, index) => {
            // Transformer les articles, lot et sous lot en minuscules et enlever les espaces
            const articleKey = item.articles.trim().toLowerCase();
            const lotKey = item.lot.trim().toLowerCase();
            const sousLotKey = item['sous lot'].trim().toLowerCase();

            // Vérifier les doublons d'articles
            if (seen.articles.has(articleKey)) {
                errors.duplicates.push({
                    item,
                    reason: `Nom d'article en doublon dans la colonne ${index + 2}`
                });
                return false;
            }
            seen.articles.add(articleKey);

            // Vérifier si le sous lot existe dans un autre lot
            if (seen.sousLotToLots.has(sousLotKey)) {
                const existingLot = seen.sousLotToLots.get(sousLotKey);
                if (existingLot !== lotKey) {
                    errors.duplicates.push({
                        item,
                        reason: `Sous lot '${sousLotKey}' existe dans un autre lot : ${existingLot} (colonne ${index + 2})`
                    });
                    return false;
                }
            } else {
                seen.sousLotToLots.set(sousLotKey, lotKey);
            }

            // Permettre les sous lots en doublon à l'intérieur du même lot
            if (!seen.lotToSousLots.has(lotKey)) {
                seen.lotToSousLots.set(lotKey, new Set());
            }
            const sousLotsInLot = seen.lotToSousLots.get(lotKey);
            sousLotsInLot.add(sousLotKey);

            return true;
        });

        return {
            filteredData,
            errors
        };
    }












</script>
</body>
</html>

















