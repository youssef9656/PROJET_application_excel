<?php
include '../../Config/check_session.php';
checkUserRole('admin');

include '../../Config/connect_db.php';
$pageName = 'Article';

$querySelect = "SELECT * FROM article";
$paramsSelect = [];
$data = selectData($querySelect, $paramsSelect);

$querynom_article = "SELECT DISTINCT nom FROM article";
$nom_article = selectData($querynom_article, []);

$querystock_min = "SELECT DISTINCT stock_min FROM article";
$stock_min = selectData($querystock_min, []);

$querystock_initial= "SELECT DISTINCT stock_initial FROM article";
$stock_initial = selectData($querystock_initial, []);

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php echo $pageName; ?></title>
<!--    <link rel="stylesheet" href="../../includes/css/bootstrap.min.css">-->
</head>
<style>
    /* Amélioration de l'apparence du bouton "ajouter" */
    #ajouterBtn {
        background-color: #007bff;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 50%;
        font-size: 20px;
        cursor: pointer;
        transition: background-color 0.3s ease, transform 0.3s ease;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
    #ajouterBtn:hover {
        background-color: #0056b3;
        transform: scale(1.1);
    }

    /* Apparence améliorée du formulaire flottant */
    .floating-form {
        position: absolute;
        top: 50px;
        left: 50%;
        transform: translateX(-50%);
        background-color: white;
        border: 1px solid #ccc;
        padding: 20px;
        z-index: 9999;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        width: 60%;
        display: none;
        height: 80vh;
        border-radius: 8px;
    }

    /* Champs de saisie du formulaire */
    .floating-form input,
    .floating-form select,
    .floating-form textarea {
        width: 100%;
        padding: 10px;
        margin: 10px 0;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        transition: box-shadow 0.2s ease, border-color 0.2s ease;
    }
    .floating-form input:focus,
    .floating-form select:focus,
    .floating-form textarea:focus {
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
        border-color: #66afe9;
    }

    /* Boutons du formulaire */
    .floating-form button {
        padding: 10px 15px;
        background-color: #007bff;
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        box-shadow: 0 3px 6px rgba(0, 0, 0, 0.2);
        transition: box-shadow 0.2s ease, background-color 0.2s ease;
    }
    .floating-form button:hover {
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.3);
        background-color: #0056b3;
    }

    /* Bouton "soumettre" dans le formulaire */
    #submitArticle {
        background-color: #1441fc;
        color: white;
        border: none;
        padding: 10px 20px;
        cursor: pointer;
        border-radius: 5px;
        transition: background-color 0.3s ease;
    }
    #submitArticle:hover {
        background-color: #0d34d2;
    }

    /* Bouton "modifier" dans le formulaire */
    #modifier_Ar {
        background-color: #28a745;
        color: white;
        border: none;
        padding: 10px 20px;
        cursor: pointer;
        border-radius: 5px;
        transition: background-color 0.3s ease;
    }
    #modifier_Ar:hover {
        background-color: #218838;
    }

    /* Bouton "cacher" dans le formulaire */
    #hideBtn {
        background-color: #35dcdc;
        color: white;
        border: none;
        padding: 10px 20px;
        cursor: pointer;
        border-radius: 5px;
        transition: background-color 0.3s ease;
    }
    #hideBtn:hover {
        background-color: #2370c8;
    }

    /* Conteneur de la table avec défilement */
    .table-container {
        max-height: 400px;
        overflow-y: auto;
    }
    .table {
        width: 100%;
        border-collapse: collapse;
    }
    .table thead th {
        position: sticky;
        top: 0;
        background: #f9f9f9;
        z-index: 1;
        border-bottom: 2px solid #ddd;
    }
    .table tbody td {
        padding: 10px;
        border-bottom: 1px solid #ddd;
    }

    /* Éléments de la recherche */
    .form-control {
        border: 1px solid #ced4da;
        border-radius: .25rem;
        padding: .375rem .75rem;
    }
    /* Style général de la page */
    body {
        font-family: 'Poppins', sans-serif;
        background-color: #f8f9fa;
        color: #333;
        margin: 0;
        padding: 0;
    }

    /* Style du conteneur de recherche */
    .search-container {
        margin-top: 20px;
        padding: 15px;
        background-color: #ffffff;
        border-radius: 10px;
        box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
        animation: fadeIn 1s ease;
    }

    /* Input de recherche */
    .search-input {
        padding: 10px;
        border: 2px solid #e3e3e3;
        border-radius: 5px;
        box-shadow: 0 3px 8px rgba(0, 0, 0, 0.05);
        transition: border-color 0.3s, box-shadow 0.3s;
    }
    .search-input:focus {
        border-color: #007bff;
        box-shadow: 0 5px 15px rgba(0, 123, 255, 0.3);
    }

    /* Liste déroulante (datalist) */
    .datalist {
        max-height: 150px;
        overflow-y: auto;
    }

    /* Boutons et sélecteur */
    .search-select {
        padding: 10px;
        border-radius: 5px;
        border: 2px solid #e3e3e3;
        transition: border-color 0.3s ease;
    }
    .search-select:focus {
        border-color: #007bff;
    }

    /* Animation pour une meilleure transition visuelle */
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Transition et style de bouton */
    #ajouterBtn {
        padding: 10px 20px;
        background-color: #007bff;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s ease, transform 0.3s ease;
    }
    #ajouterBtn:hover {
        background-color: #0056b3;
        transform: scale(1.05);
    }

    /* Media queries pour les petits écrans */
    @media (max-width: 768px) {
        .search-container {
            flex-direction: column;
        }
        .search-input, .search-select {
            width: 100%;
            margin-bottom: 15px;
        }
    }

</style>


<body>
<?php include '../../includes/header.php'; ?>

<div class="col-12 row  text-center w-100 search-container">
    <div class="col">
        <input type="text" list='nom1' class="form-control keepDatalist search-input" placeholder="Chercher Article"
               id="nom_article1" onchange="filterTable()">
        <datalist id='nom1'>
            <option value=""></option>
            <?php foreach($nom_article as $p):?>
                <option value='<?= $p['nom'] ?>'><?= $p['nom'] ?></option>
            <?php endforeach;?>
        </datalist>
    </div>
    <div class="col">
        <input type="text" list='stock_minarticle' class="form-control keepDatalist search-input" placeholder="Chercher Stock Min"
               id="stock_min1" onchange="filterTable()">
        <datalist id='stock_minarticle'>
            <option value=""></option>
            <?php foreach($stock_min as $p):?>
                <option value='<?= $p['stock_min'] ?>'><?= $p['stock_min'] ?></option>
            <?php endforeach;?>
        </datalist>
    </div>
    <div class="col">
        <input type="text" list='stock_initialarticle' class="form-control keepDatalist search-input" placeholder="Chercher Stock Initial"
               id="stock_initial1" onchange="filterTable()">
        <datalist id='stock_initialarticle'>
            <option value=""></option>
            <?php foreach($stock_initial as $p):?>
                <option value='<?= $p['stock_initial'] ?>'><?= $p['stock_initial'] ?></option>
            <?php endforeach;?>
        </datalist>
    </div>
    <div class="col-2">
        <select class="form-control search-select" onchange="filterTable()" id="selectAll_son">
            <option value="All">All</option>
            <option value="SonLot">Son lot</option>
        </select>
    </div>
    <div class="col-2">
<button onclick="location.reload()" class="btn btn-secondary">Affiche tout</button>
    </div>
</div>
<div class="container mt-1">
    <div class="d-flex justify-content-between align-items-center col-12">
        <h4>Les Articles</h4>
        <button id="ajouterBtn" CLASS="m-3">+</button>
    </div>

    <div id="formContainer" class="floating-form">
        <form id="articleForm" class="row col-12">
            <div class="col-6">
                <label for="nom">Nom:</label>
                <input type="text" id="nom" name="nom" class="form-control" required>
            </div>

            <div class="col-6">

            <label for="stock_min">Stock Min:</label>
            <input type="number" id="stock_min" name="stock_min" class="form-control" required><br><br>
            </div>
            <div class="col-6">

            <label for="stock_initial">Stock Initial:</label>
            <input type="number" id="stock_initial" name="stock_initial" class="form-control" required><br><br>
            </div>
            <div class="col-6">

            <label for="prix">Prix:</label>
            <input type="number" id="prix" name="prix" class="form-control" step="0.01"><br><br>
            </div>

            <div class="col-6">
                <label for="description">Description:</label>
                <textarea id="description" name="description" class="form-control "  style="height: 140px" required></textarea><br><br>
            </div>

            <div class="col-6">
                <div>
                <label for="unite">Unité:</label>
                <input type="text" id="unite" name="unite" class="form-control" required>
          </div>

                </br>
                <div class="col text-center">
                    <button type="submit" id="submitArticle">Ajouter Article</button>
                    <button type="button" id="modifier_Ar" style="display: none;" class="btn btn-success ">Modifier</button>
                    <button type="button" id="hideBtn" class="btn">Annuler </button>
                </div>
            </div>




        </form>
    </div>

    <div id="tbl_article" class="table-container">


    </div>
</div>

<script src="../../includes/jquery.sheetjs.js"></script>
<script src="../../includes/js/bootstrap.bundle.min.js"></script>

<script>

    document.getElementById('ajouterBtn').addEventListener('click', function() {
        vide()
        var formContainer = document.getElementById('formContainer');
        formContainer.style.display = (formContainer.style.display === 'none' || formContainer.style.display === '') ? 'block' : 'none';
    });

    document.getElementById('hideBtn').addEventListener('click', function() {
        document.getElementById('formContainer').style.display = 'none';
    });

    document.getElementById('articleForm').addEventListener('submit', function(event) {
        event.preventDefault();

        const formData = new FormData(this);
        fetch('addarticle.php', {
            method: 'POST',
            body: formData
        })
            .then(response => response.text())
            .then(result => {
                console.log('Réponse du serveur:', result);
                if (result.includes("déjà")) {
                    // Afficher le message si l'article est déjà ajouté
                    alert(result);
                } else {
                    // Afficher un message de succès et recharger la table
                    $('#tbl_article').load('afficherarticle.php #tblar');
                    document.getElementById('formContainer').style.display = 'none';
                }
            })
            .catch(error => {
                console.error('Erreur:', error);
            });
    });



    function deleteArticle(id_article) {
        if (confirm('Êtes-vous sûr de vouloir supprimer cet article ?')) {
            $.ajax({
                url: 'delete_article.php',  // Chemin vers ton fichier PHP qui gère la suppression
                type: 'POST',
                data: { id_article: id_article },
                success: function(response) {
                    var result = JSON.parse(response);
                    if (result.success) {
                        $('#tbl_article').load('afficherarticle.php #tblar');

                    }
                },
                error: function(xhr, status, error) {
                    alert('Erreur lors de la suppression : ' + error);
                }
            });
        }
    }



    function editArticle(button, id) {
        const formContainer = document.getElementById('formContainer');
        formContainer.style.display = 'block'; // Affiche le formulaire

        var row = $(button).closest('tr'); // Trouve la ligne correspondante

        // Remplit le formulaire avec les valeurs extraites de la ligne sélectionnée
        $('#nom').val(row.find('td:eq(1)').text());
        $('#description').val(row.find('td:eq(2)').text());
        $('#stock_min').val(row.find('td:eq(3)').text());
        $('#stock_initial').val(row.find('td:eq(4)').text());
        $('#prix').val(row.find('td:eq(5)').text());
        $('#unite').val(row.find('td:eq(6)').text());

        // Afficher le bouton de modification et masquer celui d'ajout
        $('#submitArticle').hide();
        $('#modifier_Ar').show();

        // Gérer la soumission du formulaire pour la modification
        $('#modifier_Ar').off('click').on('click', function() {
            var formData = {
                id_article: id,
                nom: $('#nom').val(),
                description: $('#description').val(),
                stock_min: $('#stock_min').val(),
                stock_initial: $('#stock_initial').val(),
                prix: $('#prix').val(),
                unite: $('#unite').val()
            };

            $.ajax({
                type: "POST",
                url: "modify_article.php",
                data: formData,
                success: function(response) {
                    var result = JSON.parse(response);
                    if (result.success) {
                        $('#formContainer').hide();
                        $('#tbl_article').load('afficherarticle.php #tblar'); // Recharger le tableau avec les données mises à jour
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert("Erreur : " + textStatus + " - " + errorThrown);
                }
            });
        });

        // Gérer le bouton pour masquer le formulaire
        $('#hideBtn').off('click').on('click', function() {
            vide()
            $('#formContainer').hide();
            $('#submitArticle').show(); // Réafficher le bouton d'ajout
            $('#modifier_Ar').hide(); // Masquer le bouton de modification
        });
    }

function vide(){
    $('#nom').val("");
    $('#description').val("");
    $('#stock_min').val("");
    $('#stock_initial').val("");
    $('#prix').val("");
    $('#unite').val("");

}


    $('#tbl_article').load('afficherarticle.php #tblar');



    document.addEventListener('DOMContentLoaded', function() {
        const  nom_article = document.getElementById('nom_article1');
        const  stock_min = document.getElementById('stock_min1');
        const  stock_initial = document.getElementById('stock_initial1');
        const  selectAll_son = document.getElementById('selectAll_son');
        window.filterTable = function() {

            var url = 'afficherarticle.php?nom_article=' + encodeURI(nom_article.value) + '&stock_min=' + encodeURI(stock_min.value) + '&stock_initial=' + encodeURI(stock_initial.value) + '&selectAll_son=' + encodeURI(selectAll_son.value);
            $('#tbl_article').load(url + ' #tblar',function (){


            });

        }

    });


</script>
</body>
</html>
