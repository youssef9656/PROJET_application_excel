<?php
include '../../Config/check_session.php';
checkUserRole('admin');
include '../../Config/connect_db.php';
$pageName = 'Acceuil ';
include '../../includes/header.php';


$query = "SELECT id, reclamation FROM operation WHERE reclamation IS NOT NULL";
$result = $conn->query($query);

if (isset($_GET['message'])) {
    if (isset($_GET['nomArticle'])) {
        $nomArticle = htmlspecialchars($_GET['nomArticle']);
    } else {
        $nomArticle = 'l\'article inconnu';
    }
    if (isset($_GET['nomArticle'])){
        $nomArticle = htmlspecialchars($_GET['nomArticle']);
    }else{
        $nomArticle = 'l\'article inconnu' ;
    }

    if (isset($_GET['stockFinaleValue'])){
        $stockFinaleValue = htmlspecialchars($_GET['stockFinaleValue']) ;
    }else{
        $stockFinaleValue = 'l\'article inconnu' ;
    }

    switch ($_GET['message']) {
        case 'ssajouter':
            echo '
<div class="modalBesoin" id="myModal">
    <div id="container11">
        <div id="error-box">
            <button class="close">
                <svg xmlns="http://www.w3.org/2000/svg" width="60" height="60" fill="currentColor" class="bi bi-x-circle" viewBox="0 0 16 16">
                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                    <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708"/>
                </svg>
            </button>
            <div class="face2">
                <div class="eye"></div>
                <div class="eye right"></div>
                <div class="mouth sad"></div>
            </div>
            <div class="shadow move"></div>
            <div class="message"><h1 class="alert">Alert !</h1><p class="modaleBody">    Il y a un besoin dans l\'article : ' . $nomArticle . '    </div>
        </div>
    </div>

</div>


';
            break;
        case 'stock_insuffisant':
            echo '
<div class="modalBesoin" id="myModal">
    <div id="container11">
        <div id="error-box">
            <button class="close">
                <svg xmlns="http://www.w3.org/2000/svg" width="60" height="60" fill="currentColor" class="bi bi-x-circle" viewBox="0 0 16 16">
                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                    <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708"/>
                </svg>
            </button>
            <div class="face2">
                <div class="eye"></div>
                <div class="eye right"></div>
                <div class="mouth sad"></div>
            </div>
            <div class="shadow move"></div>
            <div class="message"><h1 class="alert">Alert !</h1><p class="modaleBody">  Vous avez dépassé le stock final pour l\'article :  ' . $nomArticle . '   <br> Le stock actuel est :' . $stockFinaleValue . '  </div>
        </div>
    </div>

</div>


';
            break;


        case 'ss':
            echo '
<div class="modalBesoin" id="myModal">
    <div id="container11">
        <div id="error-box">
            <button class="close">
                <svg xmlns="http://www.w3.org/2000/svg" width="60" height="60" fill="currentColor" class="bi bi-x-circle" viewBox="0 0 16 16">
                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                    <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708"/>
                </svg>
            </button>
            <div class="face2">
                <div class="eye"></div>
                <div class="eye right"></div>
                <div class="mouth sad"></div>
            </div>
            <div class="shadow move"></div>
            <div class="message"><h1 class="alert">Alert !</h1><p class="modaleBody">    Il y a un besoin dans l\'article : ' . $nomArticle . '    <br> Le stock actuel est :' . $stockFinaleValue . '   </div>
        </div>
    </div>

</div>

';
            break;

        case 'eppuisement':
            echo '
<div class="modalBesoin" id="myModal">
    <div id="container11">
        <div id="error-box">
            <button class="close">
                <svg xmlns="http://www.w3.org/2000/svg" width="60" height="60" fill="currentColor" class="bi bi-x-circle" viewBox="0 0 16 16">
                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                    <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708"/>
                </svg>
            </button>
            <div class="face2">
                <div class="eye"></div>
                <div class="eye right"></div>
                <div class="mouth sad"></div>
            </div>
            <div class="shadow move"></div>
            <div class="message"><h1 class="alert">Alert !</h1><p class="modaleBody">  Vous avez dépassé le stock final pour l\'article :  ' . $nomArticle. ' <br> Le stock actuel est :' . $stockFinaleValue . '    </div>
        </div>
    </div>

</div>

';
            break;

        case 'reclamationError' :
            echo '
<div class="modalBesoin" id="myModal">
    <div id="container11">
        <div id="error-box">
            <button class="close">
                <svg xmlns="http://www.w3.org/2000/svg" width="60" height="60" fill="currentColor" class="bi bi-x-circle" viewBox="0 0 16 16">
                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                    <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708"/>
                </svg>
            </button>
            <div class="face2">
                <div class="eye"></div>
                <div class="eye right"></div>
                <div class="mouth sad"></div>
            </div>
            <div class="shadow move"></div>
            <div class="message"><h1 class="alert">Alert !</h1><p class="modaleBody">   Erreur lors de l\'enregistrement de la réclamation. Veuillez réessayer.  </div>
        </div>
    </div>

</div>


';
            break ;
        case 'reclamationSuccess':
            echo '
<div class="modalBesoin" id="myModal">
    <div id="container11">
        <div class="success-box">
            <button class="close">
                <svg xmlns="http://www.w3.org/2000/svg" width="60" height="60" fill="currentColor" class="bi bi-x-circle" viewBox="0 0 16 16">
                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                    <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708"/>
                </svg>
            </button>
            <div class="face2">
                <div class="eye"></div>
                <div class="eye right"></div>
                <div class="mouth happy"></div>
            </div>
            <div class="shadow move"></div>
            <div class="message"><h1 class="alert">Alert !</h1><p class="modaleBody">   Votre reclamation a été ajouter avec succès .   </div>
        </div>
    </div>

</div>

';
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Etat des stocks</title>
    <script src="../../includes/jquery.sheetjs.js"></script>
    <!--    <link rel="stylesheet" href="../../includes/css/bootstrap.min.css">-->
    <link rel="stylesheet" href="../../includes/css/bootstrap.css">
    <script src="../../includes/libriryPdf/unpkg/jspdf.umd.min.js"></script>
    <script src="../../includes/libriryPdf/jspdf.plugin.autotable.min.js"></script>
    <!--    <script src="../../includes/html2canvas.min.js"></script>-->
    <!--    <script src="../../includes/libriryPdf/cdnjs/jspdf.min.js"></script>-->
    <!--    <script src="../../includes/xlsx.full.min.js"></script>-->
    <script src="../../includes/js/jquery.min.js"></script> <!-- Assurez-vous d'utiliser la version complète -->
    <script src="../../includes/js/bootstrap.bundle.min.js"></script>
    <script src="../../includes/js/bootstrap123.min.js"></script>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="lato_styles/lato_style.css">
    <script src="../../includes/node_modules/chart.js/dist/chart.umd.js"></script>



</head>
<body>

<div class="accueil">
    Accueil
</div>

<div class="content2">


    <?php
    if ($result->num_rows > 0) {
        // Boucle à travers chaque réclamation
        while ($row = $result->fetch_assoc()) {
            $id_operation = $row['id'];  // ID de l'opération
            $reclamation = $row['reclamation'];   // Texte de la réclamation
            ?>
            <div class="note-div">
                <div class="note-ligne"></div>
                <div class="note-text"><?php echo htmlspecialchars($reclamation); ?></div>
                <div class="note-buttons">
                    <button class="btn-12 note-modifier modifier-operation" data-id="<?php echo $id_operation; ?>"><span>Modifier</span></button>
                    <button class="btn-12 note-modifier supprimer_reclamation" data-id="<?php echo $id_operation; ?>"><span>Supprimer</span></button>
                </div>
            </div>
            <?php
        }
    } else {
        echo "<div class='aucune'>Aucune réclamation trouvée.</div>";
    }
    ?>

<!--    <div class="note-div">-->
<!--        <div class="note-ligne"></div>-->
<!--        <div class="note-text"></div>-->
<!--        <button class="btn-12 note-modifier"><span>Modifier</span></button>-->
<!---->
<!--    </div>-->



</div>


<!--div pour statistique-->

<div class="content1 row ">
        <div   STYLE="width: 50% ; height: 350px;margin: 10px"  >
            <canvas id="sortieChart"></canvas>
        </div>
    <div  class="col-md-3" STYLE="width: 40% ; height: 350px;margin: 10px" >
        <canvas id="sortieChart2"></canvas>
    </div>

</div>

<!-- Modal Bootstrap pour modifier une opération -->
<div class="modal fade" id="modifierOperationModal" tabindex="-1" role="dialog" aria-labelledby="modifierOperationLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title w-75" id="modifierOperationLabel">Modifier l'opération</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" style="font-size: 40px">&times;</span>
                </button>
            </div>
            <div class="note-div">
<!--                <div class="note-ligne"></div>-->
                <div class="note-text" id="text-reclamation-modal"></div>
            </div>

            <form id="modifierOperationForm" method="POST" action="modifier_operation.php">

                <div class="modal-body">
                    <input type="hidden" id="operationId" name="operation_id">

                    <div class="form-group">
                        <label for="lot">Lot :</label>
                        <select id="lot" name="lot" class="form-control" required>
                            <!-- Options dynamiques ajoutées via AJAX -->
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="sousLot">Sous-lot :</label>
                        <select id="sousLot" name="sousLot" class="form-control" required disabled>
                            <!-- Options dynamiques ajoutées via AJAX -->
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="article">Article :</label>
                        <select id="article" name="article" class="form-control" required disabled>
                            <!-- Options dynamiques ajoutées via AJAX -->
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="ref">Référence :</label>
                        <input type="text" id="ref" name="ref" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="entree">Entrée :</label>
                        <input type="number" id="entree" name="entree" step="0.01" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="sortie">Sortie :</label>
                        <input type="number" id="sortie" name="sortie" step="0.01" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="fournisseur">Fournisseur :</label>
                        <select id="fournisseur" name="fournisseur" class="form-control" required disabled>
                            <!-- Options dynamiques ajoutées via AJAX -->
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="service">Service :</label>
                        <select id="service" name="service" class="form-control" required disabled>
                            <!-- Options dynamiques ajoutées via AJAX -->
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="prix">Prix :</label>
                        <input type="number" id="prix" name="prix" step="0.01" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="date_operation">Date d'opération :</label>
                        <input type="datetime-local" id="date_operation" name="date_operation" class="form-control" required>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                    <button type="submit" class="btn btn-primary">Modifier</button>
                </div>
            </form>
        </div>
    </div>
</div>


<script src="script.js"></script>
</body>
</html>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>

<script>

    let sortieChartInstance = null; // Declare outside to access globally
    let sortieChartInstance1 = null; // Declare outside to access globally

    function fetchData() {
        const lot = "";
        const sousLot = "";
        const fournisseur = "";
        const dateFrom = "";
        const dateTo = "";

        fetch(`getdataSTATISTIQUE.php?lot=${encodeURIComponent(lot)}&sous_lot=${encodeURIComponent(sousLot)}&fournisseur=${encodeURIComponent(fournisseur)}&date_from=${encodeURIComponent(dateFrom)}&date_to=${encodeURIComponent(dateTo)}`)
            .then(response => response.json())
            .then(data => {
                displayCharts(data.charts); // Fonction pour afficher les graphiques
            })
            .catch(error => {
                console.error("There was a problem with the fetch operation:", error);
            });
    }

    function displayCharts(data) {
        function aggregateData(data) {
            const result = {};

            data.forEach(item => {
                const { nom_pre_fournisseur, entree, prix_operation, date_operation } = item;

                if (!result[nom_pre_fournisseur]) {
                    result[nom_pre_fournisseur] = {
                        totalEntree: 0,
                        lastPrixOperation: null,
                        lastDateOperation: null,
                    };
                }

                result[nom_pre_fournisseur].totalEntree += parseFloat(entree);
                if (prix_operation) {
                    result[nom_pre_fournisseur].lastPrixOperation = parseFloat(prix_operation);
                }
                if (!result[nom_pre_fournisseur].lastDateOperation || new Date(date_operation) > new Date(result[nom_pre_fournisseur].lastDateOperation)) {
                    result[nom_pre_fournisseur].lastDateOperation = date_operation;
                }
            });

            const formattedResult = [];
            for (const fournisseur in result) {
                const { totalEntree, lastPrixOperation, lastDateOperation } = result[fournisseur];
                const total = totalEntree * (lastPrixOperation || 0);
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

        if (sortieChartInstance) {
            sortieChartInstance.destroy();
        }

        const ctx2 = document.getElementById('sortieChart').getContext('2d');

        const config = {
            type: 'bar',
            data: {
                labels: nom_pre_fournisseur,
                datasets: [{
                    data: total,
                    backgroundColor: [
                        '#FF6B6B',
                        '#4ECDC4',
                        '#FFD93D',
                        '#C7CEEA',
                        '#6B73FF'
                    ],
                    borderColor: 'rgba(255, 255, 255, 0.5)',
                    borderWidth: 2,
                }]
            },
            options: {
                indexAxis: 'x',
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: '#e0e0e0',
                        },
                        ticks: {
                            color: '#0000FF',
                            font: {
                                size: 1,
                                weight: '600',
                                family: 'Poppins'
                            }
                        }
                    },
                    x: {
                        ticks: {
                            color: '#FF0000',
                            font: {
                                size: 1,
                                weight: '600',
                                family: 'Poppins'
                            }
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    },
                    datalabels: {
                        anchor: 'end',
                        align: 'end',
                        color: '#000',
                        font: {
                            size: 14,
                            weight: 'bold',
                            family: 'Poppins'
                        },
                        formatter: function(value, context) {
                            return value;
                        }
                    }
                },
                animation: {
                    duration: 1500,
                    easing: 'easeInOutBounce',
                }
            },
            plugins: [ChartDataLabels]
        };

        sortieChartInstance = new Chart(ctx2, config);
    }

    function fetchData2() {
        const lot = "";
        const sousLot = ""
        const service = "";
        const dateFrom = "";
        const dateTo = "";

        fetch(`getdata2STATISYTIQUE.php?lot=${encodeURIComponent(lot)}&sous_lot=${encodeURIComponent(sousLot)}&service=${encodeURIComponent(service)}&date_from=${encodeURIComponent(dateFrom)}&date_to=${encodeURIComponent(dateTo)}`)
            .then(response => response.json())
            .then(data => {
                displayCharts2(data.charts);
            })
            .catch(error => {
                console.error("There was a problem with the fetch operation:", error);
            });
    }

    function displayCharts2(data) {
        function aggregateData2(data) {
            const result = {};

            data.forEach(item => {
                const { service_operation, entree, prix_operation, date_operation } = item;

                if (!result[service_operation]) {
                    result[service_operation] = {
                        totalEntree: 0,
                        lastPrixOperation: null,
                        lastDateOperation: null,
                    };
                }

                result[service_operation].totalEntree += parseFloat(entree);
                if (prix_operation) {
                    result[service_operation].lastPrixOperation = parseFloat(prix_operation);
                }
                if (!result[service_operation].lastDateOperation || new Date(date_operation) > new Date(result[service_operation].lastDateOperation)) {
                    result[service_operation].lastDateOperation = date_operation;
                }
            });

            const formattedResult = [];
            for (const fournisseur in result) {
                const { totalEntree, lastPrixOperation, lastDateOperation } = result[fournisseur];
                const total = totalEntree * (lastPrixOperation || 0);
                formattedResult.push({
                    service_operation: fournisseur,
                    totalEntree,
                    total,
                    lastDateOperation
                });
            }
            return formattedResult;
        }

        const aggregatedData = aggregateData2(data);
        console.log(aggregatedData);

        const service_operation = aggregatedData.map(item => item.service_operation);
        const total = aggregatedData.map(item => item.total);

        if (sortieChartInstance1) {
            sortieChartInstance1.destroy();
        }
        const ctx2 = document.getElementById('sortieChart2').getContext('2d');
        sortieChartInstance1 = new Chart(ctx2, {
            type: 'pie', // Type 'pie'
            data: {
                labels: service_operation,
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
            },
            options: {
                plugins: {
                    datalabels: {
                        formatter: (value, ctx) => {
                            let sum = ctx.chart.data.datasets[0].data.reduce((a, b) => a + b, 0);
                            let percentage = (value * 100 / sum).toFixed(2) + "%"; // Calcul du pourcentage
                            return percentage; // Retourne le pourcentage
                        },
                        color: '#fff', // Couleur des pourcentages
                        font: {
                            size: 14,  // Taille de la police
                            weight: 'bold'
                        },
                        align: 'center', // Aligne le texte au centre du segment
                        anchor: 'center' // Le texte reste dans le segment
                    }
                }
            }
        });


    }

    // Combine both fetch calls in one window.onload function
    window.onload = function() {
        fetchData();
        fetchData2();
    };

</script>