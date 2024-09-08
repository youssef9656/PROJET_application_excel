<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Article Table</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
        body {
            padding: 20px;
        }
        .table-container {
            max-height: 400px; /* Adjust as needed */
            overflow-y: auto;
            border: 1px solid #dee2e6;
            border-radius: .25rem;
        }
        .table thead th {
            position: sticky;
            top: 0;
            background-color: #343a40; /* Dark background for sticky header */
            color: white;
            z-index: 10;
        }
        .btn {
            margin-top: 10px;
        }
    </style>
</head>
<body>
<div class="container">
    <h1 class="mb-4">Articles Table</h1>

    <!-- Form for filtering -->
    <div class="form-row mb-3">
        <div class="col">
            <label for="start_date">Date de début:</label>
            <input type="date" id="start_date" class="form-control">
        </div>
        <div class="col">
            <label for="end_date">Date de fin:</label>
            <input type="date" id="end_date" class="form-control">
        </div>
        <div class="col">
            <label for="status_filter">Filtrer par statut:</label>
            <select id="status_filter" class="form-control">
                <option value="">Tous</option>
                <option value="besoin">Besoin</option>
                <option value="bon">Bon</option>
            </select>
        </div>
    </div>
    <button onclick="fetchData()" class="btn btn-primary">Rechercher</button>

    <!-- Table to display the articles data -->
    <div class="table-container mt-4">
        <table id="articles_table" class="table table-striped table-bordered">
            <thead class="thead-dark">
            <tr>
                <th>ID</th>
                <th>Article</th>
                <th>Stock Initial</th>
                <th>Total Entrées</th>
                <th>Total Sorties</th>
                <th>Stock Final</th>
                <th>Prix Moyen</th>
                <th>Valeur Stock</th>
                <th>Stock Min</th>
                <th>Besoin</th>
            </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>

<!-- Bootstrap JS and dependencies -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
    function fetchData() {
        const startDate = document.getElementById('start_date').value || '1970-01-01'; // Default start date
        const endDate = document.getElementById('end_date').value || new Date().toISOString().split('T')[0]; // Default end date
        const statusFilter = document.getElementById('status_filter').value;

        fetch(`fetch_data.php?start_date=${startDate}&end_date=${endDate}&status_filter=${statusFilter}`)
            .then(response => response.json())
            .then(data => {
                const tableBody = document.getElementById('articles_table').getElementsByTagName('tbody')[0];
                tableBody.innerHTML = ''; // Clear the current table content

                data.forEach(row => {
                    const tr = document.createElement('tr');
                    Object.values(row).forEach(value => {
                        const td = document.createElement('td');
                        td.textContent = value;
                        tr.appendChild(td);
                    });
                    tableBody.appendChild(tr);
                });
            })
            .catch(error => console.error('Error fetching data:', error));
    }

    // Fetch data on page load without any filters (show all data)
    document.addEventListener('DOMContentLoaded', fetchData);
</script>
</body>
</html>
