<?php
include '../../Config/check_session.php';
checkUserRole('admin');

include '../../Config/connect_db.php'; ?>
<?php
$pageName= ' Statistiques Dépenses Sorties';

include '../../includes/header.php';

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Graphiques</title>
    <script src="../../includes/node_modules/chart.js/dist/chart.umd.js"></script>
<!--    <link rel="stylesheet" href="../../includes/css/bootstrap.min.css">-->
</head>


<style>
    body {
        background-color: #f0f4f8;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    h1, h6 {
        text-align: center;
        color: #34495e;
        margin-top: 20px;
    }

    .formC {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
        width: 90%;
        margin: 30px auto;
        padding: 30px;
        background-color: #fff;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        border-radius: 10px;
    }

    .formC > div {
        flex: 1;
        min-width: 250px;
    }

    select, input[type="date"] {
        height: 45px;
        padding: 10px;
        border-radius: 8px;
        border: 1px solid #ced4da;
        font-size: 16px;
        transition: border-color 0.2s ease;
    }

    select:focus, input[type="date"]:focus {
        border-color: #3498db;
        outline: none;
    }

    .buttonfiltre {
        background-color: #2ecc71;
        color: white;
        padding: 12px 25px;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        font-size: 16px;
        transition: background-color 0.3s ease;
        margin-top: 25px;
    }

    .buttonfiltre:hover {
        background-color: #27ae60;
    }

    #chartdiv {
        width: 100%;
        height: 600px;
    }

    .chart-container {
        display: flex;
        justify-content: space-between;
        margin-top: 40px;
        padding: 0 5%;
    }

    .chart-container > #div1 {
        width:60%;
        background-color: #fff;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }
    .chart-container > #div2 {
        width: 40%;
        background-color: #fff;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }
</style>
<body>
<h6 class="text-center">Afficher les Graphiques et Statistiques</h6>
<div class="formC row g-3">
    <div class="col-sm-4">
        <label for="lot">Lot:</label>
        <select id="lot" class="form-select" onchange="updateSousLot();fetchData()">
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
        <select id="sous_lot" class="form-select" onchange="updateservice();fetchData()">
            <option value="">Sélectionner un sous lot</option>
        </select>
    </div>

    <div class="col-sm-4">
        <label for="service">Service:</label>
        <select id="service" onchange="fetchData()">
            <option value="">Sélectionner un service</option>
        </select>
    </div>

    <div class="col-sm-4">
        <label for="date_from">Date de début:</label>
        <input type="date" id="date_from" class="form-control" onchange="fetchData()">
    </div>

    <div class="col-sm-4">
        <label for="date_to">Date de fin:</label>
        <input type="date" id="date_to" class="form-control" onchange="fetchData()">
    </div>

<!--    <div class="col-sm-4">-->
<!--        <button class="btn  buttonfiltre btn-primary mt-3" onclick="fetchData()">Afficher Graphiques</button>-->
<!--    </div>-->
</div>





<div class="chart-container">
    <div id="div1">
        <canvas id="entreeChart"></canvas>
    </div>
    <div  id="div2">
        <canvas id="sortieChart"></canvas>
    </div>
</div>

<script src="../../includes/js/bootstrap.bundle.min.js"></script>

<script>
    // Fonction pour récupérer les sous-lots en fonction du lot sélectionné ou tous par défaut
    function updateSousLot() {
        const lot = document.getElementById("lot").value;
        let url = "get_sous_lots.php";

        // Si un lot est sélectionné, ajouter le paramètre à l'URL
        if (lot) {
            url += `?lot=${encodeURIComponent(lot)}`;
        }

        fetch(url)
            .then(response => response.json())
            .then(data => {
                const sousLotSelect = document.getElementById("sous_lot");
                sousLotSelect.innerHTML = '<option value="">Sélectionner un sous-lot</option>';
                data.forEach(sousLot => {
                    sousLotSelect.innerHTML += `<option value="${sousLot.sous_lot_name}">${sousLot.sous_lot_name}</option>`;
                });

                // Met à jour les services après avoir chargé les sous-lots
                updateservice();
            })
            .catch(error => {
                console.error("Erreur lors de la récupération des sous-lots:", error);
            });
    }

    // Fonction pour récupérer les services en fonction du sous-lot sélectionné
    function updateservice() {
        const sousLot = document.getElementById("sous_lot").value;
        let url = "get_service.php";

        // Si un sous-lot est sélectionné, ajouter le paramètre à l'URL
        if (sousLot) {
            url += `?sous_lot=${encodeURIComponent(sousLot)}`;
        }

        fetch(url)
            .then(response => response.json())
            .then(data => {
                const service_operation = document.getElementById("service");
                service_operation.innerHTML = '<option value="">Sélectionner un service</option>';
                data.forEach(service => {
                    service_operation.innerHTML += `<option value="${service.service_operation}">${service.service_operation}</option>`;
                });
            });
    }

    // Fonction pour récupérer les données basées sur les sélections
    function fetchData() {
        const lot = document.getElementById("lot").value;
        const sousLot = document.getElementById("sous_lot").value;
        const service = document.getElementById("service").value;
        const dateFrom = document.getElementById("date_from").value;
        const dateTo = document.getElementById("date_to").value;

        fetch(`getdata2.php?lot=${encodeURIComponent(lot)}&sous_lot=${encodeURIComponent(sousLot)}&service=${encodeURIComponent(service)}&date_from=${encodeURIComponent(dateFrom)}&date_to=${encodeURIComponent(dateTo)}`)
            .then(response => response.json())
            .then(data => {
                displayCharts(data.charts);
            })
            .catch(error => {
                console.error("There was a problem with the fetch operation:", error);
            });
    }

    // Charger les sous-lots par défaut au chargement de la page
    document.addEventListener("DOMContentLoaded", function() {
        updateSousLot(); // Afficher tous les sous-lots par défaut au chargement
    });



    let entreeChartInstance = null;
    let sortieChartInstance = null;

    function displayCharts(data) {
        // Récupérer les dates et les totaux des entrées
        // const dates = data.map(item => item.date_operation);
        // const totalEntree = data.map(item => item.total_depense_entree);




        const result = data.reduce((acc, current) => {
            const existingArticle = acc.find(item => item.nom_article === current.nom_article);

            // Convertir l'entrée en nombre
            const entreeValue = parseFloat(current.entree);

            if (existingArticle) {
                // Additionner les 'entree' pour l'article existant
                existingArticle.entree += entreeValue;

                // Mettre à jour le dernier prix_operation et la date_operation si disponible
                if (current.prix_operation) {
                    existingArticle.prix_operation = current.prix_operation;
                }
                existingArticle.date_operation = current.date_operation; // Mettre à jour la date
            } else {
                // Ajouter un nouvel article à l'accumulateur
                acc.push({...current, entree: entreeValue}); // Ajouter l'entrée comme nombre
            }

            return acc;
        }, []);

// Ajouter la somme des entree et prix_operation à chaque objet
        const finalResult = result.map(item => {
            const prix = item.prix_operation ? parseFloat(item.prix_operation) : 0; // Assurer que prix_operation soit un nombre
            const total = item.entree * prix; // Calculer le total
            return {
                nom_article: item.nom_article,
                total_sourter: item.entree, // Somme des entree
                prix_operation: prix, // Dernier prix_operation
                total: total, // Total calculé
                date_operation: item.date_operation // Dernière date_operation
            };
        });

// Afficher le résultat final
        const dates = finalResult.map(item => item.date_operation);
        const total_sourt = finalResult.map(item => item.total);
        const nom_article = finalResult.map(item => item.nom_article);







        function aggregateData(data) {
            const result = {};

            data.forEach(item => {
                const { service_operation, entree, prix_operation, date_operation } = item;

                // Initialisation de l'objet pour chaque fournisseur
                if (!result[service_operation]) {
                    result[service_operation] = {
                        totalEntree: 0,
                        lastPrixOperation: null,
                        lastDateOperation: null,
                    };
                }

                // Somme des entrees pour le fournisseur
                result[service_operation].totalEntree += parseFloat(entree);

                // Mettre à jour le dernier prix d'opération s'il existe
                if (prix_operation) {
                    result[service_operation].lastPrixOperation = parseFloat(prix_operation);
                }

                // Mettre à jour la dernière date d'opération
                if (!result[service_operation].lastDateOperation || new Date(date_operation) > new Date(result[service_operation].lastDateOperation)) {
                    result[service_operation].lastDateOperation = date_operation;
                }
            });

            // Formater le résultat final
            const formattedResult = [];

            for (const fournisseur in result) {
                const { totalEntree, lastPrixOperation, lastDateOperation } = result[fournisseur];
                const total = totalEntree * (lastPrixOperation || 0); // Calcul du total

                formattedResult.push({
                    service_operation: fournisseur,
                    totalEntree,
                    total,
                    lastDateOperation
                });
            }

            return formattedResult;
        }

        const aggregatedData = aggregateData(data);
        console.log(aggregatedData);

        const service_operation = aggregatedData.map(item => item.service_operation);
        const total = aggregatedData.map(item => item.total);

        console.log(service_operation)
        // Récupérer les noms des fournisseurs, sans doublons
        // const nomEntree = [...new Set(data.map(d => d.nom_pre_fournisseur).filter(service => service))];

        // Détruire le graphique existant si présent avant de créer un nouveau
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
                    data: total_sourt,
                    borderColor: 'blue',
                    fill: false
                }]
            }
        });

        // Détruire le graphique existant si présent avant de créer un nouveau
        if (sortieChartInstance) {
            sortieChartInstance.destroy();
        }
        const ctx2 = document.getElementById('sortieChart').getContext('2d');
        sortieChartInstance = new Chart(ctx2, {
            type: 'polarArea',
            data: {
                labels: service_operation,  // Utiliser les noms des fournisseurs comme étiquettes
                datasets: [{
                    data: total,
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


    // function displayCharts(data) {
    //     console.log(data)
    //     const dates = data.map(item => item.date_operation);
    //     const totalSortie = data.map(item => item.total_sortie_operations);
    //     const nomSortie = [...new Set(data.map(d => d.nom_article).filter(service => service))];
    //     if (entreeChartInstance) {
    //         entreeChartInstance.destroy();
    //     }
    //     const ctx1 = document.getElementById('entreeChart').getContext('2d');
    //     entreeChartInstance = new Chart(ctx1, {
    //         type: 'line',
    //         data: {
    //             labels: dates,
    //             datasets: [{
    //                 label: 'Total Depenses Sorties',
    //                 data: totalSortie,
    //                 borderColor: 'blue',
    //                 fill: false
    //             }]
    //         }
    //     });
    //
    //     if (sortieChartInstance) {
    //         sortieChartInstance.destroy();
    //     }
    //     const ctx2 = document.getElementById('sortieChart').getContext('2d');
    //     sortieChartInstance = new Chart(ctx2, {
    //         type: 'polarArea',
    //         data : {
    //             labels:nomSortie ,
    //             datasets: [{
    //                 data: totalSortie,
    //                 backgroundColor: [
    //                     'rgb(255, 99, 132)',
    //                     'rgb(75, 192, 192)',
    //                     'rgb(255, 205, 86)',
    //                     'rgb(201, 203, 207)',
    //                     'rgb(54, 162, 235)'
    //                 ]
    //             }]
    //         }
    //     });
    // }



    // Chargement des données initiales sans filtre
    window.onload = function() {
        fetchData();
    };
</script>
</body>
</html>
