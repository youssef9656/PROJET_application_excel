<?php
include '../../Config/check_session.php';
checkUserRole('admin');

include '../../Config/connect_db.php'; ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Graphiques</title>
    <script src="../../includes/node_modules/chart.js/dist/chart.umd.js"></script>
    <link rel="stylesheet" href="../../includes/css/bootstrap.min.css">
</head>
<?php
$pageName= ' Statistiques Dépenses Sorties';

include '../../includes/header.php';

?>

<STYLE>

    h1 {
        text-align: center;
        color: #2c3e50;
        margin-bottom: 30px;
    }

    /* Styles pour Select et Input */
    select, input[type="date"] {
        height: 38px; /* Ajuste la hauteur pour les rendre plus petits */
        padding: 5px; /* Réduit le padding */
        border-radius: 5px;
        border: 1px solid #ccc;
        font-size: 14px; /* Ajuste la taille de la police */
        background-color: #fff;
    }

    button {
        background-color: #3498db;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 16px;
        transition: background-color 0.3s ease;
        display: block;
        margin: 20px auto;
    }

    button:hover {
        background-color: #2980b9;
    }

    .formC {
        display: flex;
        flex-wrap: wrap; /* Permet aux éléments de s'enrouler sur plusieurs lignes */
        gap: 15px; /* Espace entre les éléments */
        width: 100%; /* Largeur maximale du formulaire */
        margin: 0 auto; /* Centre le formulaire sur la page */
    }

    .formC > div {
        flex: 1; /* Permet à chaque colonne de prendre l'espace disponible */
        min-width: 200px; /* Largeur minimale pour les colonnes */
    }

    .formC label {
        font-weight: bold; /* Met en gras les étiquettes */
    }
    #chartdiv {
        width: 100%;
        height: 500px;
    }
</STYLE>

<body>
<h6 class="text-center">Afficher les Graphiques et Statistiques</h6>
<div class="formC row g-3">
    <div class="col-sm-4">
        <label for="lot">Lot:</label>
        <select id="lot" class="form-select" onchange="updateSousLot()">
            <option value="">Sélectionner un lot</option>
            <?php
            $result = $conn->query("SELECT DISTINCT lot_name FROM operation");
            while ($row = $result->fetch_assoc()) {
                echo "<option value='{$row['lot_name']}'>{$row['lot_name']}</option>";
            }
            ?>
        </select>
    </div>

    <div class="col-sm-4">
        <label for="sous_lot">Sous Lot:</label>
        <select id="sous_lot" class="form-select" onchange="updateservice()">
            <option value="">Sélectionner un sous lot</option>
        </select>
    </div>

    <div class="col-sm-4">
        <label for="service">Service:</label>
        <select id="service">
            <option value="">Sélectionner un service</option>
        </select>
    </div>

    <div class="col-sm-4">
        <label for="date_from">Date de début:</label>
        <input type="date" id="date_from" class="form-control">
    </div>

    <div class="col-sm-4">
        <label for="date_to">Date de fin:</label>
        <input type="date" id="date_to" class="form-control">
    </div>

    <div class="col-sm-4">
        <button class="btn btn-primary mt-3" onclick="fetchData()">Afficher Graphiques</button>
    </div>
</div>




<div class="col-12 row p-5 mt-4 container" >
    <div class="col-6">
        <canvas id="entreeChart"></canvas>
    </div>
    <div class="col-4">
        <canvas id="sortieChart"></canvas>
    </div>
</div>

<script src="../../includes/js/bootstrap.bundle.min.js"></script>

<script>
    function updateSousLot() {
        const lot = document.getElementById("lot").value;
        fetch(`get_sous_lots.php?lot=${encodeURIComponent(lot)}`)
            .then(response => response.json())
            .then(data => {
                const sousLotSelect = document.getElementById("sous_lot");
                sousLotSelect.innerHTML = '<option value="">Sélectionner un sous lot</option>';
                data.forEach(sousLot => {
                    sousLotSelect.innerHTML += `<option value="${sousLot.sous_lot_name}">${sousLot.sous_lot_name}</option>`;
                });
            });
    }

    function updateservice() {
        const sousLot = document.getElementById("sous_lot").value;
        fetch(`get_service.php?sous_lot=${encodeURIComponent(sousLot)}`)
            .then(response => response.json())
            .then(data => {
                const service_operation = document.getElementById("service");
                service_operation.innerHTML = '<option value="">Sélectionner un service</option>';
                data.forEach(service => {
                    service_operation.innerHTML += `<option value="${service.service_operation}">${service.service_operation}</option>`;
                });
            });
    }

    function fetchData() {
        const lot = document.getElementById("lot").value;
        const sousLot = document.getElementById("sous_lot").value;
        // const fournisseur = document.getElementById("fournisseur").value;
        const service = document.getElementById("service").value;
        const dateFrom = document.getElementById("date_from").value;
        const dateTo = document.getElementById("date_to").value;

        fetch(`getdata2.php?lot=${encodeURIComponent(lot)}&sous_lot=${encodeURIComponent(sousLot)}&service_operation=${encodeURIComponent(service)}&date_from=${encodeURIComponent(dateFrom)}&date_to=${encodeURIComponent(dateTo)}`)
            .then(response => response.json())
            .then(data => {
                displayCharts(data.charts);
            })
            .catch(error => {
                console.error("There was a problem with the fetch operation:", error);
            });
    }


    let entreeChartInstance = null;
    let sortieChartInstance = null;

    function displayCharts(data) {
        const dates = data.map(item => item.date_operation);
        const totalSortie = data.map(item => item.total_sortie_operations);
        const nomSortie = [...new Set(data.map(d => d.nom_article).filter(service => service))];
        if (entreeChartInstance) {
            entreeChartInstance.destroy();
        }
        const ctx1 = document.getElementById('entreeChart').getContext('2d');
        entreeChartInstance = new Chart(ctx1, {
            type: 'line',
            data: {
                labels: dates,
                datasets: [{
                    label: 'Total Depenses Sorties',
                    data: totalSortie,
                    borderColor: 'blue',
                    fill: false
                }]
            }
        });

        if (sortieChartInstance) {
            sortieChartInstance.destroy();
        }
        const ctx2 = document.getElementById('sortieChart').getContext('2d');
        sortieChartInstance = new Chart(ctx2, {
            type: 'polarArea',
            data : {
                labels:nomSortie ,
                datasets: [{
                    data: totalSortie,
                    backgroundColor: [
                        'rgb(255, 99, 132)',
                        'rgb(75, 192, 192)',
                        'rgb(255, 205, 86)',
                        'rgb(201, 203, 207)',
                        'rgb(54, 162, 235)'
                    ]
                }]
            }
        });
    }



    // Chargement des données initiales sans filtre
    window.onload = function() {
        fetchData();
    };
</script>
</body>
</html>
