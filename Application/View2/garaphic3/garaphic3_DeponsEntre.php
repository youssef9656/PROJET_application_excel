

<?php include '../../config/connect_db.php'; ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Graphiques et Statistiques en Ligne</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>


<!-- Resources -->
<script src="https://cdn.amcharts.com/lib/5/index.js"></script>
<script src="https://cdn.amcharts.com/lib/5/xy.js"></script>
<script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>
<STYLE>
    #chartdiv {
        width: 100%;
        height: 500px;
    }
    /* Global Styles */
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
        <select id="sous_lot" class="form-select" onchange="updateFournisseur()">
            <option value="">Sélectionner un sous lot</option>
        </select>
    </div>

    <div class="col-sm-4">
        <label for="fournisseur">Fournisseur:</label>
        <select id="fournisseur" class="form-select">
            <option value="">Sélectionner un fournisseur</option>
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
<div id="chartdiv"></div>

<!-- Bootstrap JS (optionnel) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
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

    function updateFournisseur() {
        const sousLot = document.getElementById("sous_lot").value;
        fetch(`get_fournisseurs.php?sous_lot=${sousLot}`)
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

        fetch(`getdata.php?lot=${lot}&sous_lot=${sousLot}&fournisseur=${fournisseur}&date_from=${dateFrom}&date_to=${dateTo}`)
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
        const nomEntree = [...new Set(data.map(d => d.nom_article).filter(service => service))];
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
            type: 'polarArea',
             data : {
                 labels:nomEntree ,
                datasets: [{
                    data: totalEntree,
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


    am5.ready(function() {
        var root = am5.Root.new("chartdiv");
        const myTheme = am5.Theme.new(root);
        myTheme.rule("AxisLabel", ["minor"]).setAll({ dy: 1 });
        myTheme.rule("Grid", ["minor"]).setAll({ strokeOpacity: 0.08 });

        root.setThemes([am5themes_Animated.new(root), myTheme]);

        var chart = root.container.children.push(am5xy.XYChart.new(root, {
            panX: false,
            panY: false,
            wheelX: "panX",
            wheelY: "zoomX",
            paddingLeft: 0
        }));

        var cursor = chart.set("cursor", am5xy.XYCursor.new(root, { behavior: "zoomX" }));
        cursor.lineY.set("visible", false);

        async function fetchData() {
            const lot = document.getElementById("lot").value;
            const sousLot = document.getElementById("sous_lot").value;
            const fournisseur = document.getElementById("fournisseur").value;
            const dateFrom = document.getElementById("date_from").value;
            const dateTo = document.getElementById("date_to").value;

            try {
                const response = await fetch(`getdata.php?lot=${lot}&sous_lot=${sousLot}&fournisseur=${fournisseur}&date_from=${dateFrom}&date_to=${dateTo}`);
                if (!response.ok) {
                    throw new Error(`HTTP error! Status: ${response.status}`);
                }

                const data = await response.json();
                console.log(data);

                if (Array.isArray(data.charts)) {
                    const chartData = data.charts.map(item => {
                        try {
                            const parsedDate = new Date(Date.parse(item.date_operation));
                            console.log("Parsed date:", parsedDate);
                            return {
                                date: parsedDate,
                                totalEntree: parseFloat(item.total_depense_entree)
                            };
                        } catch (error) {
                            console.error("Error parsing date:", item.date_operation, error);
                            return null;
                        }
                    }).filter(item => item !== null);

                    console.log(chartData);
                    series.data.setAll(chartData);
                } else {
                    console.error("Data is not an array:", data.charts);
                }

            } catch (error) {
                console.error("There was a problem with the fetch operation:", error);
            }
        }

        var xAxis = chart.xAxes.push(am5xy.DateAxis.new(root, {
            maxDeviation: 0,
            baseInterval: { timeUnit: "day", count: 1 },
            renderer: am5xy.AxisRendererX.new(root, {
                minorGridEnabled: true,
                minGridDistance: 200,
                minorLabelsEnabled: true
            }),
            tooltip: am5.Tooltip.new(root, {})
        }));

        xAxis.set("minorDateFormats", { day: "dd", month: "MM" });
        xAxis.set("dateFormats", { day: "dd MMM", month: "MMM yyyy" }); // تأكد من إضافة تنسيق التواريخ

        var yAxis = chart.yAxes.push(am5xy.ValueAxis.new(root, {
            renderer: am5xy.AxisRendererY.new(root, {})
        }));

        var series = chart.series.push(am5xy.LineSeries.new(root, {
            name: "Total Entrée",
            xAxis: xAxis,
            yAxis: yAxis,
            valueYField: "totalEntree",
            valueXField: "date",
            tooltip: am5.Tooltip.new(root, { labelText: "{valueY}" })
        }));

        series.bullets.push(function () {
            var bulletCircle = am5.Circle.new(root, { radius: 5, fill: series.get("fill") });
            return am5.Bullet.new(root, { sprite: bulletCircle });
        });

        chart.set("scrollbarX", am5.Scrollbar.new(root, { orientation: "horizontal" }));
        fetchData();
        series.appear(1000);
        chart.appear(1000, 100);

    }); // نهاية am5.ready()


    window.onload = function() {
        fetchData();
    };
</script>
</body>
</html>
