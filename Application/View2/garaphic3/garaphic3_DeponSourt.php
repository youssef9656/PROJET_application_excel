<?php include '../../config/connect_db.php'; ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Graphiques</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
<h1>Afficher les Graphiques</h1>

<label for="lot">Lot:</label>
<select id="lot" onchange="updateSousLot()">
    <option value="">Sélectionner un lot</option>
    <?php
    $result = $conn->query("SELECT DISTINCT lot_name FROM operation");
    while ($row = $result->fetch_assoc()) {
        echo "<option value='{$row['lot_name']}'>{$row['lot_name']}</option>";
    }
    ?>
</select>

<label for="sous_lot">Sous Lot:</label>
<select id="sous_lot" onchange="Service()">
    <option value="">Sélectionner un sous lot</option>
</select>



<label for="service">Service:</label>
<select id="service">
    <option value="">Sélectionner un service</option>
</select>

<label for="date_from">Date de début:</label>
<input type="date" id="date_from">

<label for="date_to">Date de fin:</label>
<input type="date" id="date_to">

<button onclick="fetchData()">Afficher Graphiques</button>

<canvas id="entreeChart"></canvas>
<canvas id="sortieChart"></canvas>

<script>
    function updateSousLot() {
        const lot = document.getElementById("lot").value;
        fetch(`get_sous_lots.php?lot=${lot}`)
            .then(response => response.json())
            .then(data => {
                const sousLotSelect = document.getElementById("sous_lot");
                sousLotSelect.innerHTML = '<option value="">Sélectionner un sous lot</option>';
                data.forEach(sousLot => {
                    sousLotSelect.innerHTML += `<option value="${sousLot.sous_lot_name}">${sousLot.sous_lot_name}</option>`;
                });
            });
    }

    // function updateFournisseur() {
    //     const sousLot = document.getElementById("sous_lot").value;
    //     fetch(`get_fournisseurs.php?sous_lot=${sousLot}`)
    //         .then(response => response.json())
    //         .then(data => {
    //             const fournisseurSelect = document.getElementById("fournisseur");
    //             fournisseurSelect.innerHTML = '<option value="">Sélectionner un fournisseur</option>';
    //             data.forEach(fournisseur => {
    //                 fournisseurSelect.innerHTML += `<option value="${fournisseur.nom_pre_fournisseur}">${fournisseur.nom_pre_fournisseur}</option>`;
    //             });
    //         });
    // }

    function fetchData() {
        const lot = document.getElementById("lot").value;
        const sousLot = document.getElementById("sous_lot").value;
        // const fournisseur = document.getElementById("fournisseur").value;
        const service = document.getElementById("service").value;
        const dateFrom = document.getElementById("date_from").value;
        const dateTo = document.getElementById("date_to").value;

        fetch(`getdata.php?lot=${lot}&sous_lot=${sousLot}&service=${service}&date_from=${dateFrom}&date_to=${dateTo}`)
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
        const totalEntree = data.map(item => item.total_depense_entree);
        const totalSortie = data.map(item => item.total_sortie_operations);

        if (entreeChartInstance) {
            entreeChartInstance.destroy();
        }
        const ctx1 = document.getElementById('entreeChart').getContext('2d');
        entreeChartInstance = new Chart(ctx1, {
            type: 'line',
            data: {
                labels: dates,
                datasets: [{
                    label: 'Total Entrées',
                    data: totalEntree,
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
            type: 'line',
            data: {
                labels: dates,
                datasets: [{
                    label: 'Total Sorties',
                    data: totalSortie,
                    borderColor: 'red',
                    fill: false
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
