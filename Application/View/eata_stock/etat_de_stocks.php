<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Affichage des Articles et Opérations</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin-top: 20px;
        }
        table {
            margin-top: 20px;
        }
    </style>
</head>
<body>
<div class="container">
    <h1 class="text-center">Affichage des Articles et Opérations</h1>
    <form id="filterForm" class="form-inline justify-content-center">
        <div class="form-group mb-2">
            <label for="startDate" class="mr-2">Date de début:</label>
            <input type="date" id="startDate" name="startDate" class="form-control">
        </div>
        <div class="form-group mx-sm-3 mb-2">
            <label for="endDate" class="mr-2">Date de fin:</label>
            <input type="date" id="endDate" name="endDate" class="form-control">
        </div>
        <button type="button" class="btn btn-primary mb-2" onclick="filterData()">Filtrer</button>
    </form>

    <table class="table table-striped table-bordered" id="dataTable">
        <thead>
        <tr>
            <th>ID</th>
            <th>Article</th>
            <th>Stock Initial</th>
            <th>Entree Operation</th>
            <th>Sortie Operation</th>
            <th>Stock Final</th>
<!--            <th>Prix</th>-->
            <th>Valeur Stock</th>
            <th>Stock Min</th>
            <th>Besoin</th>
        </tr>
        </thead>
        <tbody>
        <!-- Les données seront insérées ici via JavaScript -->
        </tbody>
    </table>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
    function loadData() {
        fetch('fetch_data.php')
            .then(response => response.json())
            .then(data => {
                const tableBody = document.getElementById('dataTable').getElementsByTagName('tbody')[0];
                tableBody.innerHTML = '';

                data.forEach(row => {
                    const tr = document.createElement('tr');
                    tr.innerHTML = `
                            <td>${row.id}</td>
                            <td>${row.article}</td>
                            <td>${row.stock_initial}</td>
                            <td>${row.entree_operation}</td>
                            <td>${row.sortie_operation}</td>
                            <td>${row.stock_final}</td>
<!--                            <td>JJ</td>-->
                            <td>${row.valeur_stock}</td>
                            <td>${row.stock_min}</td>
                            <td>${row.besoin}</td>
                        `;
                    tableBody.appendChild(tr);
                });
            });
    }

    function filterData() {
        const startDate = document.getElementById('startDate').value;
        const endDate = document.getElementById('endDate').value;

        fetch(`fetch_data.php?startDate=${startDate}&endDate=${endDate}`)
            .then(response => response.json())
            .then(data => {
                const tableBody = document.getElementById('dataTable').getElementsByTagName('tbody')[0];
                tableBody.innerHTML = '';

                data.forEach(row => {
                    const tr = document.createElement('tr');
                    tr.innerHTML = `
                            <td>${row.id}</td>
                            <td>${row.article}</td>
                            <td>${row.stock_initial}</td>
                            <td>${row.entree_operation}</td>
                            <td>${row.sortie_operation}</td>
                            <td>${row.stock_final}</td>
                            <td>KK</td>
                            <td>${row.valeur_stock}</td>
                            <td>${row.stock_min}</td>
                            <td>${row.besoin}</td>
                        `;
                    tableBody.appendChild(tr);
                });
            });
    }

    window.onload = loadData;
</script>
</body>
</html>
