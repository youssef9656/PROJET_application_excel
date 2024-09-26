<?php
include '../../Config/check_session.php';
checkUserRole('admin');
include '../../Config/connect_db.php';
$pageName= 'Catalogue du temps';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Etat des stocks</title>
    <script src="../../includes/jquery.sheetjs.js"></script>
    <link rel="stylesheet" href="../../includes/css/bootstrap.min.css">
    <script src="../../includes/libriryPdf/unpkg/jspdf.umd.min.js"></script>
    <script src="../../includes/xlsx.full.min.js"></script>

    <style>
        .table-container {
            max-height: 500px;
            overflow-y: auto;
            border: 1px solid #dee2e6;
            border-radius: .25rem;
            width: 100%;
        }
        .table thead th {
            position: sticky;
            top: 0;
            background-color: #115faf;
            color: white;
            z-index: 10;
        }
        .btn {
            margin-top: 10px;
        }
    </style>
</head>
<body>
<?php
$pageName= 'Etat des stocks';
include '../../includes/header.php';
?>

<div class="m-2">
    <div class="form col-12 mb-3" style="display: flex; flex-wrap: wrap; gap: 20px">
        <div class="col-2">
            <label for="start_date">Date de début:</label>
            <input type="date" id="start_date" class="form-control">
        </div>
        <div class="col-2">
            <label for="end_date">Date de fin:</label>
            <input type="date" id="end_date" class="form-control">
        </div>
        <div class="col-2">
            <label for="status_filter">Filtrer par statut:</label>
            <select id="status_filter" class="form-control">
                <option value="">Tous</option>
                <option value="besoin">Besoin</option>
                <option value="bon">Bon</option>
            </select>
        </div>
        <div class="col-2">
            <label for="lot">Lot:</label>
            <select id="lot" class="form-control">
                <option value="">Sélectionner un lot</option>
                <!-- هنا يمكن إضافة الخيارات الديناميكية من قاعدة البيانات -->
            </select>
        </div>
        <div class="col-2">
            <label for="article">Article:</label>
            <select id="article" class="form-control">
                <option value="">Sélectionner un article</option>
                <!-- هنا يمكن إضافة الخيارات الديناميكية من قاعدة البيانات -->
            </select>
        </div>
        <div class="col-2">
            <label for="fournisseur">Fournisseur:</label>
            <select id="fournisseur" class="form-control">
                <option value="">Sélectionner un fournisseur</option>
                <!-- هنا يمكن إضافة الخيارات الديناميكية من قاعدة البيانات -->
            </select>
        </div>
        <div class="col-2">
            <label for="sous_lot">Sous Lot:</label>
            <select id="sous_lot" class="form-control">
                <option value="">Sélectionner un sous lot</option>
                <!-- هنا يمكن إضافة الخيارات الديناميكية من قاعدة البيانات -->
            </select>
        </div>
        <div class="col-2">
            <label for="service">Service:</label>
            <select id="service" class="form-control">
                <option value="">Sélectionner un service</option>
                <!-- هنا يمكن إضافة الخيارات الديناميكية من قاعدة البيانات -->
            </select>
        </div>
        <button onclick="fetchData()" class="btn btn-primary">Rechercher</button>
    </div>

    <div class="table-container mt-4">
        <table id="articles_table" class="table table-bordered table-hover table-group-divider sheetjs">
            <thead class="thead-dark">
            <tr>
                <th>ID</th>
                <th>Article</th>
                <th>Stock Initial</th>
                <th>Total Entrées</th>
                <th>Total Sorties</th>
                <th>Stock Final</th>
                <th>Prix Moyen</th>
                <th>Valeur Stock Final</th>
                <th>Total Dépenses Entrées</th>
                <th>Total Dépenses Sorties</th>
                <th>Stock Min</th>
                <th>Besoin</th>
            </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
</div>

<script>
    function fetchData() {
        let currentDate = new Date();
        currentDate.setFullYear(currentDate.getFullYear() + 2);

        const startDate = document.getElementById('start_date').value || '1970-01-01';
        const endDate = document.getElementById('end_date').value || currentDate.toISOString().split('T')[0];
        const statusFilter = document.getElementById('status_filter').value;
        const lot = document.getElementById('lot').value;
        const article = document.getElementById('article').value;
        const fournisseur = document.getElementById('fournisseur').value;
        const sousLot = document.getElementById('sous_lot').value;
        const service = document.getElementById('service').value;

        const params = new URLSearchParams({
            start_date: startDate,
            end_date: endDate,
            status_filter: statusFilter,
            lot: lot,
            article: article,
            fournisseur: fournisseur,
            sous_lot: sousLot,
            service: service
        });

        fetch(`fetch_data.php?${params.toString()}`)
            .then(response => response.json())
            .then(data => {
                const tableBody = document.querySelector('#articles_table tbody');
                tableBody.innerHTML = '';

                data.forEach(row => {
                    const tr = document.createElement('tr');
                    const fields = ['ID', 'Article', 'Stock_Initial', 'Total_Entry_Operations', 'Total_Exit_Operations', 'Stock_Final', 'Prix', 'Stock_Value', 'Total_Depenses_Entree', 'Total_Depenses_Sortie', 'Stock_Min', 'Requirement_Status'];
                    fields.forEach(field => {
                        const td = document.createElement('td');
                        td.textContent = row[field] || '';
                        tr.appendChild(td);
                    });
                    tableBody.appendChild(tr);
                });
            })
            .catch(error => console.error('Error fetching data:', error));
    }

    document.addEventListener('DOMContentLoaded', fetchData);

    document.addEventListener('DOMContentLoaded', () => {
        fetchDropdownData();
        fetchData();
    });



    function fetchDropdownData() {
        fetch('fetch_dropdown_data.php') // يقوم بجلب البيانات من PHP
            .then(response => response.json())
            .then(data => {
                populateSelectOptions('lot', data.lots);
                populateSelectOptions('article', data.articles);
                populateSelectOptions('fournisseur', data.fournisseurs);
                populateSelectOptions('sous_lot', data.sous_lots);
                populateSelectOptions('service', data.services);
            })
            .catch(error => console.error('Error fetching dropdown data:', error));
    }

    function populateSelectOptions(selectId, options) {
        const selectElement = document.getElementById(selectId);
        selectElement.innerHTML = '';  // مسح الخيارات السابقة
        options.forEach(option => {
            const opt = document.createElement('option');
            opt.value = option;
            opt.textContent = option;
            selectElement.appendChild(opt);
        });
    }


</script>
</body>
</html>
