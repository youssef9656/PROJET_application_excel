<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Excel</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
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
    </style>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.4/xlsx.full.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
</head>
<body>
<div class="container">
    <h1>Importer un fichier Excel</h1>
    <div class="form-group">
        <input type="file" id="fileInput" class="form-control-file" />
    </div>
    <button class="btn btn-primary" onclick="uploadData()">Importer les données</button>

    <div id="alertContainer" class="alert alert-danger mt-3" role="alert"></div>

    <div id="tableContainer" class="table-container mt-4">
        <!-- Table will be dynamically inserted here -->
    </div>
    <button id="sendData" class="btn btn-success btn-custom" style="display: none;" onclick="sendData()">Envoyer les données</button>
</div>

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
        var table = '<table class="table table-bordered table-striped table-fixed"><thead><tr>';

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
            var json = XLSX.utils.sheet_to_json(worksheet);

            console.log('JSON original :', json);

            // Convert all text to lower case and capitalize the first letter for display
            var formattedJson = json.map(row => {
                let newRow = {};
                Object.keys(row).forEach(key => {
                    newRow[key] = capitalizeWords(removeExtraSpaces(String(row[key])));
                });
                return newRow;
            });

            // Display table
            displayTable(formattedJson);

            // Store formatted JSON data for later use
            window.jsonData = transformDataForSending(json);

            // Log JSON data to be sent
            console.log('Données à envoyer au serveur :', window.jsonData);
        };
        reader.readAsArrayBuffer(file);
    }

    function sendData() {
        if (!window.jsonData) {
            alert('Aucune donnée à envoyer.');
            return;
        }

        console.log('Envoi des données :', window.jsonData);

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
</script>
</body>
</html>




<!--<!DOCTYPE html>-->
<!--<html>-->
<!--<head>-->
<!--    <title>Upload Excel</title>-->
<!--    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.4/xlsx.full.min.js"></script>-->
<!--</head>-->
<!--<body>-->
<!--<input type="file" id="fileInput" />-->
<!--<button onclick="uploadData()">Upload Data</button>-->
<!---->
<!--<script>-->
<!--    function uploadData() {-->
<!--        var fileInput = document.getElementById('fileInput');-->
<!--        var file = fileInput.files[0];-->
<!--        if (!file) {-->
<!--            alert('Please select a file.');-->
<!--            return;-->
<!--        }-->
<!---->
<!--        var reader = new FileReader();-->
<!--        reader.onload = function(event) {-->
<!--            var data = new Uint8Array(event.target.result);-->
<!--            var workbook = XLSX.read(data, {type: 'array'});-->
<!--            var sheetName = workbook.SheetNames[0];-->
<!--            var worksheet = workbook.Sheets[sheetName];-->
<!--            var json = XLSX.utils.sheet_to_json(worksheet);-->
<!---->
<!--            console.log(json)-->
<!--            document.write( JSON.stringify(json))-->
<!--            // Envoyer les données au serveur-->
<!--            fetch('upload.php', {-->
<!--                method: 'POST',-->
<!--                headers: {-->
<!--                    'Content-Type': 'application/json',-->
<!--                },-->
<!--                body: JSON.stringify(json),-->
<!--            })-->
<!--                .then(response => response.text())-->
<!--                .then(result => {-->
<!--                    alert('Data uploaded successfully.');-->
<!--                })-->
<!--                .catch(error => {-->
<!--                    console.error('Error:', error);-->
<!--                });-->
<!--        };-->
<!--        reader.readAsArrayBuffer(file);-->
<!--    }-->
<!--</script>-->
<!--</body>-->
<!--</html>-->












