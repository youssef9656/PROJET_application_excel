<?php
include '../../Config/check_session.php';
checkUserRole('admin');

include '../../Config/connect_db.php'; ?>
<?php
$pageName= 'Statistiques des entree';

include '../../includes/header.php';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Graph with Filters</title>
    <script src="../../includes/node_modules/chart.js/dist/chart.umd.js"></script>
<!--    <link rel="stylesheet" href="../../includes/css/bootstrap.min.css">-->
</head>
<body>

<style>
    /* Couleurs de la palette */
    :root {
        --primary-color: #007bff; /* Bleu vif */
        --secondary-color: #28a745; /* Vert frais */
        --accent-color: #dc3545; /* Rouge accentué */
        --background-color: #f8f9fa; /* Fond gris clair */
        --text-color: #343a40; /* Couleur de texte foncé */
        --border-color: rgba(206, 212, 218, 0.72); /* Bordure grise claire */
        --shadow-color: rgba(0, 0, 0, 0.1); /* Ombre légère */
    }

    /* Arrière-plan de la page */
    body {
        background: linear-gradient(to bottom, #f8f9fa, #e9ecef);
        /*font-family: 'Arial', sans-serif;*/
    }

    /* Titre principal */
    h6 {
        margin-bottom: 30px;
        text-align: center;
        color: var(--primary-color);
        font-weight: 700;
        font-size: 1.5rem;
    }

    /* Section des filtres */
    .filter-section {
        margin-bottom: 30px;
        padding: 25px;
        border-radius: 10px;
        background: #ffffff; /* Fond blanc pour le contraste */
        box-shadow: 0 2px 10px var(--shadow-color);
    }

    /* Labels */
    label {
        font-weight: bold;
        color: var(--text-color);
    }

    /* Styles des sélecteurs et champs */
    .form-select, .form-control {
        border-radius: 5px; /* Coins arrondis */
        padding: 10px 15px;
        background-color: #ffffff; /* Fond blanc */
        border: 1px solid var(--border-color);
        transition: all 0.3s ease;
    }

    /* Effet au focus sur les champs */
    .form-select:focus, .form-control:focus {
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25); /* Bleu clair */
        border-color: var(--primary-color);
    }

    /* Bouton principal */
    .btn-primary {
        background-color: var(--primary-color);
        border: none;
        border-radius: 5px; /* Coins arrondis */
        padding: 10px 20px;
        font-size: 16px;
        transition: all 0.3s ease;
        color: white; /* Texte blanc pour les boutons */
    }

    /* Effet au survol du bouton */
    .btn-primary:hover {
        background-color: #0056b3; /* Bleu plus foncé au survol */
        transform: scale(1.05);
    }

    /* Conteneur des graphiques */
    .chart-container {
        padding: 20px;
        border-radius: 10px;
        background: #ffffff; /* Fond blanc */
        box-shadow: 0 2px 10px var(--shadow-color);
        margin: 0 auto;
        width: 100%; /* S'assurer que le conteneur s'étend sur toute la largeur */
    }

    /* Ajustement de la taille du canvas */
    /*canvas {*/
    /*    width: 100% !important;*/
    /*    height: auto !important;*/
    /*    border-radius: 10px; !* Coins arrondis pour le canvas *!*/
    /*}*/

    /* Conteneur global */
    .container {
        max-width: 1300px;
        padding: 20px; /* Ajout de padding pour un meilleur espacement */
        background-color: var(--background-color); /* Fond de la page */
        border-radius: 10px; /* Coins arrondis */
        margin: 0 auto; /* Centrer la page */
        box-shadow: 0 2px 10px var(--shadow-color);
    }

    /* Colonnes pour les graphiques */
    .col-md-6 {
        padding: 15px; /* Espacement accru pour une meilleure esthétique */
    }



    /* Pied de page */
</style>

<div class="container mt-2">
    <h6>Statistiques des entree </h6>

    <!-- قسم الفلاتر -->
    <div class="row filter-section">
        <div class="col-md-2">
            <label for="lotSelect">Lot:</label>
            <select id="lotSelect" class="form-select" onchange="updateSousLot();fetchData()">
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
            <select id="articleSelect" class="form-select" onchange="fetchData()">
                <option value="">All</option>
            </select>
        </div>

        <div class="col-md-2">
            <label for="fournisseurSelect">Fournisseur:</label>
            <select id="fournisseurSelect" class="form-select" onchange="fetchData()">
                <option value="">All</option>
            </select>
        </div>

        <div class="col-md-2">
            <label for="startDate">Start Date:</label>
            <input type="date" id="startDate" class="form-control">
        </div>

        <div class="col-md-2">
            <label for="endDate">End Date:</label>
            <input type="date" id="endDate" class="form-control" onchange="fetchData()">
        </div>
    </div>

<!--    <div class="row">-->
<!--        <div class="col-12 text-center">-->
<!--            <button class="btn btn-primary" onclick="fetchData()">Apply Filters</button>-->
<!--        </div>-->
<!--    </div>-->

    <!-- المبيانان جنبًا إلى جنب -->
    <div class="row">
        <div class="col-md-6">
            <canvas id="chart1" width="500" height="300"></canvas>
        </div>
        <div class="col-md-6">
            <canvas id="chart2" width="500" height="300"></canvas>
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
                const entreeOperationData = data.map(d => d.entree_operation);
                const prixOperationData = data.map(d => d.prix_operation);

                // تحديث الرسم البياني الأول
                if (chart1) chart1.destroy();
                const ctx1 = document.getElementById('chart1').getContext('2d');
                 chart1 = new Chart(ctx1, {
                    type: 'line',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Entree Operation',
                            data: entreeOperationData,
                            borderColor: '#4e73df', // Couleur bleu foncé pour la ligne
                            backgroundColor: 'rgba(78, 115, 223, 0.2)', // Couleur avec plus de transparence
                            borderWidth: 2, // Épaisseur de la ligne
                            pointRadius: 4, // Taille des points
                            pointBackgroundColor: '#ffffff', // Couleur des points (blanc)
                            pointBorderColor: '#4e73df', // Bordure des points (bleu foncé)
                            pointHoverRadius: 6, // Taille des points au survol
                            pointHoverBackgroundColor: '#4e73df', // Couleur des points au survol
                            tension: 0.4 // Légère courbure de la ligne
                        }]
                    },
                    options: {
                        responsive: true,
                        scales: {
                            x: {
                                title: {
                                    text: 'Date',
                                    display: true,
                                    color: '#6e707e', // Gris foncé pour le titre de l'axe
                                    font: {
                                        size: 14,
                                        family: 'Arial, sans-serif', // Police moderne
                                        weight: 'bold' // Titre en gras
                                    }
                                },
                                grid: {
                                    color: 'rgba(200, 200, 200, 0.3)', // Lignes de grille en gris clair
                                },
                                ticks: {
                                    color: '#6e707e' // Couleur des ticks (étiquettes de l'axe X)
                                }
                            },
                            y: {
                                title: {
                                    text: 'Entree Operation',
                                    display: true,
                                    color: '#6e707e', // Même style pour l'axe Y
                                    font: {
                                        size: 14,
                                        family: 'Arial, sans-serif',
                                        weight: 'bold'
                                    }
                                },
                                grid: {
                                    color: 'rgba(200, 200, 200, 0.3)', // Grille en gris clair
                                },
                                ticks: {
                                    color: '#6e707e' // Couleur des ticks de l'axe Y
                                }
                            }
                        },
                        plugins: {
                            legend: {
                                display: true,
                                labels: {
                                    color: '#6e707e', // Couleur de la légende
                                    font: {
                                        size: 12,
                                        family: 'Arial, sans-serif'
                                    }
                                }
                            },
                            tooltip: {
                                backgroundColor: '#f8f9fc', // Fond de l'info-bulle en gris très clair
                                titleColor: '#4e73df', // Titre de l'info-bulle en bleu
                                bodyColor: '#858796', // Texte en gris foncé
                                borderColor: '#4e73df', // Bordure de l'info-bulle en bleu
                                borderWidth: 1
                            }
                        }
                    }
                });

                // تحديث الرسم البياني الثاني
                if (chart2) chart2.destroy();
                const ctx2 = document.getElementById('chart2').getContext('2d');
                 chart2 = new Chart(ctx2, {
                    type: 'line',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Prix Operation',
                            data: prixOperationData,
                            borderColor: '#e74a3b', // Rouge vif pour la ligne
                            backgroundColor: 'rgba(231, 74, 59, 0.2)', // Fond rouge avec transparence
                            borderWidth: 2, // Épaisseur de la ligne
                            pointRadius: 4, // Taille des points
                            pointBackgroundColor: '#ffffff', // Couleur blanche des points
                            pointBorderColor: '#e74a3b', // Bordure rouge des points
                            pointHoverRadius: 6, // Points agrandis au survol
                            pointHoverBackgroundColor: '#e74a3b', // Couleur des points au survol
                            tension: 0.4 // Légère courbure pour plus de fluidité
                        }]
                    },
                    options: {
                        responsive: true,
                        scales: {
                            x: {
                                title: {
                                    text: 'Date',
                                    display: true,
                                    color: '#6e707e', // Couleur gris foncé pour le titre de l'axe
                                    font: {
                                        size: 14,
                                        family: 'Arial, sans-serif',
                                        weight: 'bold' // Titre en gras
                                    }
                                },
                                grid: {
                                    color: 'rgba(200, 200, 200, 0.3)' // Lignes de grille discrètes en gris clair
                                },
                                ticks: {
                                    color: '#6e707e' // Couleur des étiquettes de l'axe X
                                }
                            },
                            y: {
                                title: {
                                    text: 'Prix Operation',
                                    display: true,
                                    color: '#6e707e', // Même style pour l'axe Y
                                    font: {
                                        size: 14,
                                        family: 'Arial, sans-serif',
                                        weight: 'bold'
                                    }
                                },
                                grid: {
                                    color: 'rgba(200, 200, 200, 0.3)' // Grille en gris clair
                                },
                                ticks: {
                                    color: '#6e707e' // Couleur des étiquettes de l'axe Y
                                }
                            }
                        },
                        plugins: {
                            legend: {
                                display: true,
                                labels: {
                                    color: '#6e707e', // Couleur de la légende
                                    font: {
                                        size: 12,
                                        family: 'Arial, sans-serif'
                                    }
                                }
                            },
                            tooltip: {
                                backgroundColor: '#f8f9fc', // Fond clair pour les info-bulles
                                titleColor: '#e74a3b', // Titre des info-bulles en rouge
                                bodyColor: '#858796', // Texte en gris foncé
                                borderColor: '#e74a3b', // Bordure de l'info-bulle en rouge
                                borderWidth: 1
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
                updateArticle(); // تحديث قائمة المقالات عند تغيير الـ sous-lot
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
