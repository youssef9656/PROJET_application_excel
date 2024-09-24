<?php
include '../../Config/check_session.php';
checkUserRole('admin');

include '../../Config/connect_db.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Graph with Filters</title>
    <script src="../../includes/node_modules/chart.js/dist/chart.umd.js"></script>
    <link rel="stylesheet" href="../../includes/css/bootstrap.min.css">
</head>
<body>
<?php
$pageName= 'Statistiques des sorties';

include '../../includes/header.php';

?>
<style>

    h1 {
        margin-bottom: 30px;
        text-align: center;
        color: #343a40;
        font-weight: 700;
        font-size: 2.5rem;
    }
    .filter-section {
        margin-bottom: 30px;
        padding: 15px;
        border-radius: 10px;
        background-color: #ffffff;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
    label {
        font-weight: bold;
        color: #495057;
    }
    .form-select, .form-control {
        border-radius: 25px;
        padding: 10px 15px;
        transition: all 0.3s ease;
    }
    .form-select:focus, .form-control:focus {
        box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
        border-color: #0d6efd;
    }
    .btn-primary {
        background-color: #0d6efd;
        border: none;
        border-radius: 25px;
        padding: 10px 20px;
        font-size: 16px;
        transition: all 0.3s ease;
    }
    .btn-primary:hover {
        background-color: #0b5ed7;
        transform: scale(1.05);
    }
    canvas {
        margin-top: 20px;
        background-color: #ffffff;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
    .container {
        max-width: 1200px;
    }
    .col-md-6 {
        padding: 10px;
    }
    .text-center {
        margin-top: 20px;
    }
    footer {
        text-align: center;
        padding: 20px;
        margin-top: 50px;
        background-color: #0d6efd;
        color: white;
        font-size: 14px;
    }
</style>

<div class="container mt-2">
    <h1>Statistiques des sorties </h1>

    <!-- قسم الفلاتر -->
    <div class="row filter-section">
        <div class="col-md-2">
            <label for="lotSelect">Lot:</label>
            <select id="lotSelect" class="form-select" onchange="updateSousLot()">
                <option value="">All</option>
            </select>
        </div>

        <div class="col-md-2">
            <label for="sousLotSelect">Sous-lot:</label>
            <select id="sousLotSelect" class="form-select" onchange="updateArticle()">
                <option value="">All</option>
            </select>
        </div>

        <div class="col-md-2">
            <label for="articleSelect">Article:</label>
            <select id="articleSelect" class="form-select">
                <option value="">All</option>
            </select>
        </div>

        <div class="col-md-2">
            <label for="fournisseurSelect">Fournisseur:</label>
            <select id="fournisseurSelect" class="form-select">
                <option value="">All</option>
            </select>
        </div>

        <div class="col-md-2">
            <label for="startDate">Start Date:</label>
            <input type="date" id="startDate" class="form-control">
        </div>

        <div class="col-md-2">
            <label for="endDate">End Date:</label>
            <input type="date" id="endDate" class="form-control">
        </div>
    </div>

    <div class="row">
        <div class="col-12 text-center">
            <button class="btn btn-primary" onclick="fetchData()">Apply Filters</button>
        </div>
    </div>

    <div class="row mb-12">
        <div class="col-md-8">
            <canvas id="chart1" width="400" height="200" ></canvas>
        </div>

        <div class="col-md-4">
            <canvas id="chart2" width="400" height="200"></canvas>
        </div>

    </div>

</div>
<script src="../../includes/js/bootstrap.bundle.min.js"></script>


<script>
    let chart1, chart2;

    function fetchData() {
        const lot = document.getElementById('lotSelect').value;
        const sousLot = document.getElementById('sousLotSelect').value;
        const article = document.getElementById('articleSelect').value;
        const fournisseur = document.getElementById('fournisseurSelect').value;
        const startDate = document.getElementById('startDate').value;
        const endDate = document.getElementById('endDate').value;

        fetch(`getData.php?lot=${encodeURIComponent(lot)}&sous_lot=${encodeURIComponent(sousLot)}&article=${encodeURIComponent(article)}&fournisseur=${encodeURIComponent(fournisseur)}&start_date=${encodeURIComponent(startDate)}&end_date=${encodeURIComponent(endDate)}`)
            .then(response => response.json())
            .then(data => {

                const labels = data.map(d => d.date_operation);
                const  sortie_operation  = data.map(d => d.sortie_operation);
                const  service_operation= data.map(d => d.service_operation);
                const uniqueServices = [...new Set(data.map(d => d.service_operation).filter(service => service))];

                // حساب عدد المقالات لكل service_operation
                const articleCounts = uniqueServices.map(service => {
                    return data.filter(d => d.service_operation === service).length;
                });

                // تحديث الرسم البياني الأول
// Vérifiez si le graphique existe déjà et détruisez-le pour éviter les erreurs
// Vérifiez si le graphique existe déjà et détruisez-le pour éviter les erreurs
                if (chart1) {
                    chart1.destroy();
                }

// Récupérez le contexte du canvas pour le graphique
                const ctx1 = document.getElementById('chart1').getContext('2d');

// Créez un dégradé linéaire pour le fond du graphique
                const gradient = ctx1.createLinearGradient(0, 0, 0, 400);
                gradient.addColorStop(0, 'rgba(0, 0, 255, 0.6)'); // Couleur du début du dégradé
                gradient.addColorStop(1, 'rgba(0, 0, 255, 0.1)'); // Couleur de fin du dégradé

// Créez un nouveau graphique
                chart1 = new Chart(ctx1, {
                    type: 'line', // Type de graphique
                    data: {
                        labels: labels, // Labels pour l'axe X
                        datasets: [{
                            label: 'Sortie Operation', // Légende du dataset
                            data: sortie_operation, // Données pour l'axe Y
                            borderColor: 'blue', // Couleur de la ligne
                            backgroundColor: gradient, // Utilisation du dégradé linéaire comme fond
                            borderWidth: 2, // Largeur de la ligne
                            pointBackgroundColor: 'blue', // Couleur des points sur la ligne
                            pointBorderColor: '#fff', // Couleur de la bordure des points
                            pointBorderWidth: 2, // Largeur de la bordure des points
                            pointRadius: 5, // Rayon des points
                            pointHoverRadius: 7, // Rayon des points au survol
                            tension: 0.4 // Adoucit la courbe de la ligne
                        }]
                    },
                    options: {
                        responsive: true, // Le graphique s'ajuste automatiquement à la taille de l'écran
                        plugins: {
                            legend: {
                                display: true, // Afficher la légende
                                position: 'top' // Position de la légende
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(tooltipItem) {
                                        return `Sortie Operation: ${tooltipItem.raw}`;
                                    },
                                    title: function(tooltipItem) {
                                        return `Date: ${tooltipItem[0].label}`;
                                    }
                                },
                                backgroundColor: 'rgba(0, 0, 0, 0.8)', // Couleur de fond de l'infobulle
                                titleFont: { size: 14 }, // Taille de la police du titre
                                bodyFont: { size: 12 }, // Taille de la police du corps
                                displayColors: false // Ne pas afficher les couleurs des éléments dans l'infobulle
                            }
                        },
                        scales: {
                            x: {
                                title: {
                                    text: 'Date', // Titre de l'axe X
                                    display: true
                                }
                            },
                            y: {
                                title: {
                                    text: 'Sortie Operation', // Titre de l'axe Y
                                    display: true
                                },
                                beginAtZero: true // Commence l'axe Y à zéro
                            }
                        }
                    }
                });



                if (chart2) chart2.destroy();
                const ctx2 = document.getElementById('chart2').getContext('2d');
                chart2 = new Chart(ctx2, {
                    type: 'pie',
                    data: {
                        labels: uniqueServices,  // أسماء الخدمات بدون تكرار
                        datasets: [{
                            label: 'Distribution des articles par service',
                            data: articleCounts,
                            backgroundColor: [
                                'rgb(255, 99, 132)',
                                'rgb(75, 192, 192)',
                                'rgb(255, 205, 86)',
                                'rgb(201, 203, 207)',
                                'rgb(54, 162, 235)',
                                'rgba(153, 102, 255, 1)',
                                'rgba(255, 159, 64, 1)'


                            ],
                            borderColor: [
                                'rgba(255, 99, 132, 1)',
                                'rgba(54, 162, 235, 1)',
                                'rgba(255, 206, 86, 1)',
                                'rgba(75, 192, 192, 1)',
                                'rgba(153, 102, 255, 1)',
                                'rgba(255, 159, 64, 1)'
                            ],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'top',
                            },
                            title: {
                                display: true,
                                text: 'Répartition des articles par service'
                            }
                        }
                    }
                });
            })
            .catch(error => console.error('Error fetching data:', error));
    }

    function updateSousLot() {
        const lot = document.getElementById('lotSelect').value;
        fetch(`getSousLot.php?lot=${encodeURIComponent(lot)}`)
            .then(response => response.json())
            .then(data => {
                const sousLotSelect = document.getElementById('sousLotSelect');
                sousLotSelect.innerHTML = '<option value="">All</option>';
                data.forEach(sousLot => {
                    const option = document.createElement('option');
                    option.value = sousLot.sous_lot_name;
                    option.textContent = sousLot.sous_lot_name;
                    sousLotSelect.appendChild(option);
                });
                updateArticle();
            });
    }

    function updateArticle() {
        const sousLot = document.getElementById('sousLotSelect').value;
        fetch(`getArticle.php?sous_lot=${encodeURIComponent(sousLot)}`)
            .then(response => response.json())
            .then(data => {
                const articleSelect = document.getElementById('articleSelect');
                articleSelect.innerHTML = '<option value="">All</option>';
                data.forEach(article => {
                    const option = document.createElement('option');
                    option.value = article.nom_article;
                    option.textContent = article.nom_article;
                    articleSelect.appendChild(option);
                });
            });
    }

    window.onload = function() {
        fetchData();

        fetch('getFilters.php')
            .then(response => response.json())
            .then(filters => {
                const lotSelect = document.getElementById('lotSelect');
                const fournisseurSelect = document.getElementById('fournisseurSelect');

                filters.lot.forEach(lot => {
                    const option = document.createElement('option');
                    option.value = lot.lot_name;
                    option.textContent = lot.lot_name;
                    lotSelect.appendChild(option);
                });

                filters.fournisseur.forEach(fournisseur => {
                    const option = document.createElement('option');
                    option.value = fournisseur.nom_pre_fournisseur;
                    option.textContent = fournisseur.nom_pre_fournisseur;
                    fournisseurSelect.appendChild(option);
                });
            });
    };
    function updateSousLot() {
        const lot = document.getElementById('lotSelect').value;
        fetch(`getSousLot.php?lot=${encodeURIComponent(lot)}`)
            .then(response => response.json())
            .then(data => {
                const sousLotSelect = document.getElementById('sousLotSelect');
                sousLotSelect.innerHTML = '<option value="">All</option>';
                data.forEach(sousLot => {
                    const option = document.createElement('option');
                    option.value = sousLot.sous_lot_name;
                    option.textContent = sousLot.sous_lot_name;
                    sousLotSelect.appendChild(option);
                });
                updateArticle(); // تحديث قائمة المقالات عند تغيير الـ sous-lot
            })
            .catch(error => console.error('Error fetching sous-lots:', error));
    }


    function updateArticle() {
        const sousLot = document.getElementById('sousLotSelect').value;
        fetch(`getArticle.php?sous_lot=${encodeURIComponent(sousLot)}`)
            .then(response => response.json())
            .then(data => {
                const articleSelect = document.getElementById('articleSelect');
                articleSelect.innerHTML = '<option value="">All</option>';
                data.forEach(article => {
                    const option = document.createElement('option');
                    option.value = article.nom_article;
                    option.textContent = article.nom_article;
                    articleSelect.appendChild(option);
                });
            })
            .catch(error => console.error('Error fetching articles:', error));
    }

    window.onload = function() {
        fetchData();
        fetch('getFilters.php')
            .then(response => response.json())
            .then(filters => {
                const lotSelect = document.getElementById('lotSelect');
                const fournisseurSelect = document.getElementById('fournisseurSelect');

                filters.lot.forEach(lot => {
                    const option = document.createElement('option');
                    option.value = lot.lot_name;
                    option.textContent = lot.lot_name;
                    lotSelect.appendChild(option);
                });

                filters.fournisseur.forEach(fournisseur => {
                    const option = document.createElement('option');
                    option.value = fournisseur.nom_pre_fournisseur;
                    option.textContent = fournisseur.nom_pre_fournisseur;
                    fournisseurSelect.appendChild(option);
                });
            })
            .catch(error => console.error('Error fetching filters:', error));
    };

</script>

</body>
</html>
