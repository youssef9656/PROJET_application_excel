<?php
include '../../Config/check_session.php';
checkUserRole('user');


include '../../Config/connect_db.php';
$pageName = 'Article';

$querySelect = "SELECT * FROM fournisseurs";
$paramsSelect = [];
$data = selectData($querySelect, $paramsSelect);

$queryProduit = "SELECT DISTINCT nom_fournisseur FROM fournisseurs";
$nom_fournisseur = selectData($queryProduit, []);

$queryElement = "SELECT DISTINCT prenom_fournisseur FROM fournisseurs";
$prenom_fournisseur = selectData($queryElement, []);

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php echo $pageName; ?></title>
    <link rel="stylesheet" href="../../includes/css/bootstrap.min.css">
    <style>
        /* تحسين شكل الزر + */
        #ajouterBtn {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 50%;
            font-size: 20px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        }

        #ajouterBtn:hover {
            background-color: #0056b3;
        }

        /* تعيين الموقع المطلق للنموذج */
        .floating-form {
            position: absolute;
            top: 50px;
            left: 50%;
            transform: translateX(-50%);
            background-color: white;
            border: 1px solid #ccc;
            padding: 20px;
            z-index: 9999;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            width: 400px;
            display: none;
            height: 500px;
            overflow-y: scroll;


        }

        /* تحسين شكل الزر داخل النموذج */
        #submitArticle {
            background-color: #1441fc;
            color: white;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }
        #modifier_Ar{
            background-color: #28a745;
            color: white;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }
        }

        #submitArticle:hover {
            background-color: #218838;
        }

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

        .table-container {
            max-height: 400px; /* Ajuste la hauteur en fonction de tes besoins */
            overflow-y: auto; /* Ajoute une barre de défilement verticale si le contenu dépasse la hauteur */
            /*border: 1px solid #050505; !* Optionnel : ajouter une bordure autour du conteneur *!*/
        }

        .table {
            width: 100%;
            border-collapse: collapse;
        }

        .table thead th {
            position: -webkit-sticky; /* Pour les anciens navigateurs WebKit */
            position: sticky;
            top: 0; /* Fixe l'en-tête en haut du conteneur */
            background: #f9f9f9; /* Ajoute une couleur d'arrière-plan pour l'en-tête */
            z-index: 1; /* Assure que l'en-tête est au-dessus du contenu du tableau */
            border-bottom: 2px solid #ddd; /* Optionnel : ajouter une bordure sous l'en-tête */
        }

        .table tbody td {
            padding: 10px; /* Ajuste le padding pour les cellules du tableau */
            border-bottom: 1px solid #ddd; /* Ajoute une bordure sous chaque cellule */
        }

    </style>
</head>
<body>
<?php include '../../includes/header.php'; ?>

<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center">
        <h4>Les Articles</h4>
        <button id="ajouterBtn">+</button>
    </div>

    <div id="formContainer" class="floating-form">
        <form id="articleForm">
            <label for="nom">Nom:</label>
            <input type="text" id="nom" name="nom" class="form-control" required><br><br>

            <label for="description">Description:</label>
            <textarea id="description" name="description" class="form-control" required></textarea><br><br>

            <label for="stock_min">Stock Min:</label>
            <input type="number" id="stock_min" name="stock_min" class="form-control" required><br><br>

            <label for="stock_initial">Stock Initial:</label>
            <input type="number" id="stock_initial" name="stock_initial" class="form-control" required><br><br>

            <label for="prix">Prix:</label>
            <input type="number" id="prix" name="prix" class="form-control" step="0.01"><br><br>

            <label for="unite">Unité:</label>
            <input type="text" id="unite" name="unite" class="form-control" required><br><br>

            <button type="submit" id="submitArticle">Ajouter Article</button>
            <button type="button" id="modifier_Ar" style="display: none;" class="btn btn-success ">Modifier</button>
            <button type="button" id="hideBtn" class="btn">Annuler </button>
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
</script>
</body>
</html>
