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
<!--    <link rel="stylesheet" href="../../includes/css/bootstrap.min.css">-->
</head>
<?php
$pageName= 'Statistiques Dépenses Entrées';
include '../../includes/header.php';
?>

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

<h6>Afficher les Graphiques et Statistiques</h6>
<div class="formC">
    <div>
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

    <div>
        <label for="sous_lot">Sous Lot:</label>
        <select id="sous_lot" class="form-select" onchange="updateFournisseur()">
            <option value="">Sélectionner un sous lot</option>
        </select>
    </div>

    <div>
        <label for="fournisseur">Fournisseur:</label>
        <select id="fournisseur" class="form-select">
            <option value="">Sélectionner un fournisseur</option>
        </select>
    </div>

    <div>
        <label for="date_from">Date de début:</label>
        <input type="date" id="date_from" class="form-control">
    </div>

    <div>
        <label for="date_to">Date de fin:</label>
        <input type="date" id="date_to" class="form-control">
    </div>

    <div>
        <button class="btn  buttonfiltre btn-primary" onclick="fetchData()">Afficher Graphiques</button>
    </div>
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

    function updateFournisseur() {
        const sousLot = document.getElementById("sous_lot").value;
        fetch(`get_fournisseurs.php?sous_lot=${encodeURIComponent(sousLot)}`)
            .then(response => response.json())
            .then(data => {
                const fournisseurSelect = document.getElementById("fournisseur");
                fournisseurSelect.innerHTML = '<option value="">Sélectionner un fournisseur</option>';
                data.forEach(fournisseur => {
                    fournisseurSelect.innerHTML += `<option value="${fournisseur.nom_pre_fournisseur}">${fournisseur.nom_pre_fournisseur}</option>`;
                });
            });
    }

    function fetchData() {
        const lot = document.getElementById("lot").value;
        const sousLot = document.getElementById("sous_lot").value;
        const fournisseur = document.getElementById("fournisseur").value;
        // const service = document.getElementById("service").value;
        const dateFrom = document.getElementById("date_from").value;
        const dateTo = document.getElementById("date_to").value;

        fetch(`getdata.php?lot=${encodeURIComponent(lot)}&sous_lot=${encodeURIComponent(sousLot)}&fournisseur=${encodeURIComponent(fournisseur)}&date_from=${encodeURIComponent(dateFrom)}&date_to=${encodeURIComponent(dateTo)}`)
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
                total_entree: item.entree, // Somme des entree
                prix_operation: prix, // Dernier prix_operation
                total: total, // Total calculé
                date_operation: item.date_operation // Dernière date_operation
            };
        });

// Afficher le résultat final
        const dates = finalResult.map(item => item.date_operation);
        const totalEntree = finalResult.map(item => item.total);
        const nom_article = finalResult.map(item => item.nom_article);







        function aggregateData(data) {
            const result = {};

            data.forEach(item => {
                const { nom_pre_fournisseur, entree, prix_operation, date_operation } = item;

                // Initialisation de l'objet pour chaque fournisseur
                if (!result[nom_pre_fournisseur]) {
                    result[nom_pre_fournisseur] = {
                        totalEntree: 0,
                        lastPrixOperation: null,
                        lastDateOperation: null,
                    };
                }

                // Somme des entrees pour le fournisseur
                result[nom_pre_fournisseur].totalEntree += parseFloat(entree);

                // Mettre à jour le dernier prix d'opération s'il existe
                if (prix_operation) {
                    result[nom_pre_fournisseur].lastPrixOperation = parseFloat(prix_operation);
                }

                // Mettre à jour la dernière date d'opération
                if (!result[nom_pre_fournisseur].lastDateOperation || new Date(date_operation) > new Date(result[nom_pre_fournisseur].lastDateOperation)) {
                    result[nom_pre_fournisseur].lastDateOperation = date_operation;
                }
            });

            // Formater le résultat final
            const formattedResult = [];

            for (const fournisseur in result) {
                const { totalEntree, lastPrixOperation, lastDateOperation } = result[fournisseur];
                const total = totalEntree * (lastPrixOperation || 0); // Calcul du total

                formattedResult.push({
                    nom_pre_fournisseur: fournisseur,
                    totalEntree,
                    total,
                    lastDateOperation
                });
            }

            return formattedResult;
        }

        const aggregatedData = aggregateData(data);
        console.log(aggregatedData);

        const nom_pre_fournisseur = aggregatedData.map(item => item.nom_pre_fournisseur);
        const total = aggregatedData.map(item => item.total);

        console.log(nom_pre_fournisseur)
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
                    label: 'Total Dépenses Entrées',
                    data: totalEntree,
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
                labels: nom_pre_fournisseur,  // Utiliser les noms des fournisseurs comme étiquettes
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





    window.onload = function() {
        fetchData();
    };
</script>
</body>
</html>