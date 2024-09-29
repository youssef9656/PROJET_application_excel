<?php
include '../../Config/check_session.php';
checkUserRole('admin');


include '../../Config/connect_db.php';
$pageName = 'Article';

$lot = "SELECT lot_id, lot_name FROM lots";
$lot_name = selectData($lot, []);

if(isset($_GET["lot_name"])){
   $lot_name= $_GET["lot_name"];
    $queryProduit = "SELECT DISTINCT sous_lot_name, sous_lot_id 
FROM sous_lots 
WHERE lot_id = (SELECT lot_id FROM `lots` WHERE lot_name ='$lot_name');";
    $sous_lot_name = selectData($queryProduit, []);

}else{

    $queryProduit = "SELECT DISTINCT sous_lot_name ,sous_lot_id	 FROM sous_lots ";
    $sous_lot_name = selectData($queryProduit, []);

}

//$sqle1="SELECT * FROM article
//WHERE id_article IN (
//    SELECT article_id
//    FROM `sous_lot_articles`
//    WHERE sous_lot_id = (
//        SELECT sous_lot_id
//        FROM `sous_lots`
//        WHERE sous_lot_name = 'Sous-lot A1'
//    )
//);
//";



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
        #table1_ar {
            width: 560px; /* Largeur fixe du conteneur de la table */
            height: 80vh; /* Hauteur fixe du conteneur de la table */
            overflow: auto; /* Activer les barres de défilement si nécessaire */
            font-size: 10px; /* Taille de la police */
        }
        #table2_souslot {
            width: 100%; /* Largeur fixe du conteneur de la table */
            height: 80vh; /* Hauteur fixe du conteneur de la table */
            overflow: auto; /* Activer les barres de défilement si nécessaire */
            font-size: 10px; /* Taille de la police */
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #ddd; /* Bordure des cellules */
            padding: 5px; /* Espacement intérieur des cellules */
        }

        th {
            background-color: #f2f2f2; /* Couleur de fond des en-têtes */
        }
    </style>
</head>
<body>
<?php include '../../includes/header.php'; ?>

<div style="display: flex;flex-flow: row">
<div>
    <h4 class="text-center m-2">Liste des Articles Son sous lot</h4>

    <div id="table1_ar"  style="width: 600px;overflow: auto;font-size: 10px">

    </div>

</div>


        <div class="w-75 m-3 mt-2">
            <div class="filter-inputs mb-3">
                <div class="form row text-center" style="display: flex;flex-flow: row;justify-content: center " >
                    <div class="w-25" >
                        <input  type="text" list='lot' class="form-control keepDatalist w-100" placeholder="nam sous lot"
                               id="lot_name" onchange="fillot_name()">
                        <datalist id='lot'>
                            <option value=""></option>
                            <?php foreach($lot_name as $p):?>
                                <option value='<?= $p['lot_name'] ?>'><?= $p['lot_name'] ?></option>
                            <?php endforeach;?>
                        </datalist>
                    </div>
                    <div id="div_sous_lot_name">
                    <div class="w-25" >
                        <input  type="text" list='nom' class="form-control keepDatalist w-100" placeholder="nam sous lot"
                                id="sous_lot_name" onchange="filterTable()">
                        <datalist id='nom' >
                            <option value=""></option>
                            <?php foreach($sous_lot_name as $p):?>
                                <option value='<?= $p['sous_lot_name'] ?>'><?= $p['sous_lot_name'] ?></option>
                            <?php endforeach;?>
                        </datalist>
                    </div>
                    </div>
                </div>

                <div id="table2_souslot">


                </div>
        </div>
    </div>




</div>
</body>
<script src="../../includes/jquery.sheetjs.js"></script>
<script src="../../includes/js/bootstrap.bundle.min.js"></script>
<script>

    document.addEventListener('DOMContentLoaded', function() {
        const  sous_lot_name = document.getElementById('sous_lot_name');
        const  lot_name = document.getElementById('lot_name');

        window.fillot_name =()=>{
            var url = 'article_sous_lot.php?lot_name=' + encodeURIComponent(lot_name.value);
            $('#div_sous_lot_name').load(url + ' #div_sous_lot_name',function (){


            });

        }
        window.filterTable = function() {
            const  sous_lot_name = document.getElementById('sous_lot_name');

            var url = 'aficheArticleDeSousLou.php?sous_lot_name=' + encodeURI(sous_lot_name.value);
            $('#table2_souslot').load(url + ' #tblarARlot',function (){


            });

        }

    });

// document.getElementById("table1_ar")


    $('#table1_ar').load('afficherarticlewher.php #tblar');

    function ajouteArsouLOU(){
        setTimeout(() => {
            console.log(document.getElementById("tble1"));

            document.querySelectorAll(".trTb1").forEach((row) => {
                row.ondblclick = () => {
                    // Récupérer l'ID de l'article depuis l'attribut de la ligne
                    var article_id = row.getAttribute('id-data');
                    var sous_lot_name = document.getElementById('sous_lot_name').value;

                    console.log(sous_lot_name);
                    console.log(article_id);

                    // Vérifier que les valeurs sont bien définies
                    if (sous_lot_name && article_id) {
                        // Envoi des données via une requête GET en AJAX
                        var xhr = new XMLHttpRequest();
                        xhr.open('GET', `addAeSoilot.php?sous_lot_name=${encodeURIComponent(sous_lot_name)}&article_id=${article_id}`, true);

                        xhr.onload = function () {
                            if (xhr.status === 200) {
                                // Affiche la réponse du serveur dans la console
                                // console.log(xhr.responseText);
                                $('#table1_ar').load('afficherarticlewher.php #tblar');
                                const  sous_lot_name = document.getElementById('sous_lot_name');
                                var url = 'aficheArticleDeSousLou.php?sous_lot_name=' + encodeURI(sous_lot_name.value);
                                $('#table2_souslot').load(url + ' #tblarARlot',function (){


                                });

                                ajouteArsouLOU()

                            } else {
                                console.error('Erreur lors de la requête');
                            }
                        };

                        xhr.onerror = function () {
                            console.error('Erreur de réseau');
                        };

                        xhr.send();
                    } else {
                        console.warn('Nom du sous-lot ou ID de l\'article manquant');
                    }
                };
            });
        }, 200);

    }
    ajouteArsouLOU()

    function delteArticle(articleId) {
        if (confirm("Êtes-vous sûr de vouloir supprimer cet article ?")) {
            // Créer une requête AJAX
            var xhr = new XMLHttpRequest();
            xhr.open('GET', `delArticlSoulot.php?article_id=${articleId}`, true);

            xhr.onload = function() {
                if (xhr.status === 200) {
                    // Réponse du serveur
                    console.log(xhr.responseText);
                    const response = JSON.parse(xhr.responseText);

                    if (response.message === 'Enregistrement supprimé avec succès') {
                        $('#table1_ar').load('afficherarticlewher.php #tblar');
                        const  sous_lot_name = document.getElementById('sous_lot_name');
                        var url = 'aficheArticleDeSousLou.php?sous_lot_name=' + encodeURI(sous_lot_name.value);
                        $('#table2_souslot').load(url + ' #tblarARlot',function (){


                        });
                        ajouteArsouLOU()

                    } else {
                        alert('Erreur: ' + response.message);
                    }
                } else {
                    alert('Erreur lors de la suppression');
                }
            };

            xhr.onerror = function() {
                alert('Erreur réseau');
            };

            xhr.send();
        }
    }




</script>
</html>
