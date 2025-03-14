<?php
include '../../Config/check_session.php';
checkUserRole('user');

?>




<?php include '../../Config/connect_db.php'; $pageName= 'Catalogue du temps'; ?>
<?php
$querySelect = "SELECT * FROM fournisseurs";
$paramsSelect = [];
$data = selectData($querySelect, $paramsSelect);

$queryProduit = "SELECT DISTINCT nom_fournisseur FROM fournisseurs";
$nom_fournisseur1 = selectData($queryProduit, []);

$queryElement = "SELECT DISTINCT prenom_fournisseur FROM fournisseurs";
$prenom_fournisseur1 = selectData($queryElement, []);

//$queryFamille = "SELECT DISTINCT FamilleOperation FROM fournisseurs";
//$Familles = selectData($queryFamille, []);
?>



<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="../../includes/jquery.sheetjs.js"></script>

    <title>Document</title>
<!--    <link rel="stylesheet" href="../../includes/css/bootstrap.min.css">-->
    <style>

        /* Styles des boutons personnalisés */
        .acctiveCLOUR{
            background-color: rgba(83, 238, 165, 0.88) !important;
        }
        .custom-button {
            color: white;
            border: none;
            padding: 5px 5px;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
        }
        .active {
            background-color: #28a745; /* Vert */
            width: 50px;
            font-size: 10px;
        }
        .inactive {
            background-color: #dc3545; /* Rouge */
            width: 60px;
            font-size: 10px;
        }

        /* Conteneur de la table des fournisseurs */
        #tbl_fournisseur {
            width: 100%;
            max-height: 70VH;
            overflow-y: auto;
            margin: 2px;
        }

        /* Formulaire */
        .form-container {
            display: none; /* Masquer le formulaire par défaut */
            position: fixed;
            top: 20px;
            left: 20px;
            width: 100%;
            max-width: 96%;
            max-height: 100%;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            z-index: 1000;
            overflow-y: auto;
        }
        .form-container h2 {
            margin-top: 0;
        }
        .form-container .close-btn {
            display: block;
            text-align: right;
            margin-bottom: 10px;
            cursor: pointer;
            font-size: 20px;
        }
        .form-group {
            margin-bottom: 15px;
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }

        /* Champs de saisie */
        .form-group label {
            flex: 1 1 150px;
            display: flex;
            align-items: center;
            font-weight: bold;
            white-space: nowrap;
        }
        .form-group input {
            flex: 2 1 200px;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 14px;
        }

        /* Bouton pour afficher le formulaire */
        .show-form-btn {
            margin-bottom: 20px;
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 4px;
            font-size: 16px;
        }
        .show-form-btn:hover {
            background-color: #0056b3;
        }

        /* Styles du tableau */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f4f4f4;
        }
        #tblfr th {
            background-color: #f2f2f2;
            position: sticky;
            top: 0;
            z-index: 1;
        }

    </style>
</head>
<body>
<?php
$pageName= 'Fournisseurs';
include '../../includes/header.php';
?>

<div style="display:flex;flex-flow: row wrap ; ">
    <h4 class="mt-2 ms-5">Les Fournisseurs  <button class="show-form-btn" onclick="toggleForm()">+</button> </h4>
    <div class="col ms-5 mt-2">
        <div class="filter-inputs mb-3">
            <div class="form row" >
                <div class="col-3">
                    <input type="text" list='nom' class="form-control keepDatalist" placeholder="Nom"
                           id="nom_fournisseur1" onchange="filterTable()">
                    <datalist id='nom'>
                        <option value=""></option>
                            <?php foreach($nom_fournisseur1 as $p):?>
                        <option value='<?= $p['nom_fournisseur'] ?>'><?= $p['nom_fournisseur'] ?></option>
                        <?php endforeach;?>
                    </datalist>
                </div>
                <div class="col-3">
                    <input type="text" list='prenom' class="form-control keepDatalist" placeholder="Prenom"
                           id="prenom_fournisseur1" onchange="filterTable()">
                    <datalist id='prenom'>
                        <option value=""></option>
                        <?php foreach($prenom_fournisseur1 as $e):?>
                            <option value='<?= $e['prenom_fournisseur'] ?>'><?= $e['prenom_fournisseur'] ?></option>
                        <?php endforeach;?>
                    </datalist>
                </div>
            </div>
        </div>

        <div id='tbl'>

        </div>
    </div>
</div>


<div id="ajouter_fr" style="width: 100%">
    <div class="form-container" id="formContainer">
        <div class="row col-12">
            <h2 class="text-center col-11 ">Formulaire d'ajout de fournisseur</h2>
            <span class="close-btn fs-1 col-1" onclick="toggleForm()">×</span>
        </div>
        <form id="fournisseurForm" class="col-12 row">
            <div class="form-group col-2">
                <label for="nom_fournisseur">Nom du fournisseur :</label>
                <input type="text" id="nom_fournisseur" name="nom_fournisseur" required>
            </div>
            <div class="form-group col-2">
                <label for="prenom_fournisseur">Prénom du fournisseur :</label>
                <input type="text" id="prenom_fournisseur" name="prenom_fournisseur" required>
            </div>
            <div class="form-group col-2">
                <label for="mail_fournisseur">Email :</label>
                <input type="email" id="mail_fournisseur" name="mail_fournisseur" >
            </div>
            <div class="form-group col-2">
                <label for="cp_fournisseur">Code postal :</label>
                <input type="text" id="cp_fournisseur" name="cp_fournisseur" >
            </div>
            <div class="form-group col-2">
                <label for="ville_fournisseur">Ville :</label>
                <input type="text" id="ville_fournisseur" name="ville_fournisseur" >
            </div>
            <div class="form-group col-2">
                <label for="pay_fournisseur">Pays :</label>
                <input type="text" id="pay_fournisseur" name="pay_fournisseur" >
            </div>
            <div class="form-group col-2">
                <label for="telephone_fixe_fournisseur">Téléphone fixe :</label>
                <input type="text" id="telephone_fixe_fournisseur" name="telephone_fixe_fournisseur" >
            </div>
            <div class="form-group col-2">
                <label for="telephone_portable_fournisseur">Téléphone portable :</label>
                <input type="text" id="telephone_portable_fournisseur" name="telephone_portable_fournisseur" >
            </div>
            <div class="form-group col-2">
                <label for="commande_fournisseur">Commande fournisseur :</label>
                <input type="text" id="commande_fournisseur" name="commande_fournisseur" >
            </div>
            <div class="form-group col-2">
                <label for="condition_livraison">Conditions de livraison :</label>
                <input type="text" id="condition_livraison" name="condition_livraison" >
            </div>
            <div class="form-group col-2">
                <label for="coord_livreur">Coordonnées du livreur :</label>
                <input type="text" id="coord_livreur" name="coord_livreur" >
            </div>
            <div class="form-group col-2">
                <label for="calendrier_livraison">Calendrier de livraison :</label>
                <input type="text" id="calendrier_livraison" name="calendrier_livraison" >
            </div>
            <div class="form-group col-2">
                <label for="details_livraison">Détails de livraison :</label>
                <input type="text" id="details_livraison" name="details_livraison" >
            </div>
            <div class="form-group col-2">
                <label for="condition_paiement">Conditions de paiement :</label>
                <input type="text" id="condition_paiement" name="condition_paiement" >
            </div>
            <div class="form-group col-2">
                <label for="facturation">Facturation :</label>
                <input type="text" id="facturation" name="facturation" >
            </div>
            <div class="form-group col-2">
                <label for="certificatione">Certification :</label>
                <input type="text" id="certificatione" name="certificatione" >
            </div>
            <div class="form-group col-2">
                <label for="produit_service_fourni">Produit/Service fourni :</label>
                <input type="text" id="produit_service_fourni" name="produit_service_fourni" >
            </div>
            <div class="form-group col-2">
                <label for="siuvi_fournisseur">SIUVI fournisseur :</label>
                <input type="text" id="siuvi_fournisseur" name="siuvi_fournisseur" >
            </div>

            <div class="form-group col-2">
                <label for="groupe_fournisseur">Groupe du fournisseur :</label>
                <input type="text" id="groupe_fournisseur" name="groupe_fournisseur" >
            </div>
            <div class="form-group col-2">
                <label for="adress_fournisseur">Adresse du fournisseur :</label>
                <input type="text" id="adress_fournisseur" name="adress_fournisseur" >
            </div>
            <div class="form-group">
                <input   type="submit" value="Enregistrer" id="Enregistrer" class="btn btn-primary w-100">
                <button class="btn btn-success w-100" id="modifier_fr" style="display: " type="button" >Modifier</button>
            </div>
        </form>
    </div>
</div>




<div id="tbl_fournisseur" class="" >

</div>

</body>
<script src="../../includes/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const  nom_fournisseur = document.getElementById('nom_fournisseur');
        const  prenom_fournisseur = document.getElementById('prenom_fournisseur');
        window.filterTable = function() {


            var url = 'afficherfournisseur.php?nom_fournisseur=' + encodeURI(nom_fournisseur.value) + '&prenom_fournisseur=' + encodeURI(prenom_fournisseur.value);
            $('#tbl_fournisseur').load(url + ' #tblfr',function (){


            });

        }

    });





    function toggleForm() {
        vide()
        const formContainer = document.getElementById('formContainer');
        formContainer.style.display = formContainer.style.display === 'none' ? 'block' : 'none';
        document.getElementById('Enregistrer').style.display=""
        document.getElementById('modifier_fr').style.display="none"





    }
    toggleForm()
    document.getElementById('fournisseurForm').addEventListener('submit', function(event) {
        event.preventDefault(); // Empêcher le rechargement de la page

        const formData = new FormData(this);

        fetch('addfournisseur.php', {
            method: 'POST',
            body: formData
        })
            .then(response => response.text())
            .then(result => {
                console.log('Réponse du serveur:', result);
                // Vous pouvez ajouter ici une logique pour gérer la réponse du serveur
                toggleForm();
                $('#tbl_fournisseur').load('afficherfournisseur.php #tblfr',function (){


                });
            })
            .catch(error => {
                console.error('Erreur:', error);
            });
    });
    // function toggleForm() {
    //     $('#formContainer').toggle(); // Afficher ou cacher le formulaire
    // }

    function editFournisseur(button, id) {
        toggleForm()
        document.getElementById('Enregistrer').style.display="none"
        document.getElementById('modifier_fr').style.display=""



        const formContainer = document.getElementById('formContainer');
        formContainer.style.display = 'block';

        var row = $(button).closest('tr');

        $('#id_fournisseur').val(id);
        $('#nom_fournisseur').val(row.find('td:eq(1)').text());
        $('#prenom_fournisseur').val(row.find('td:eq(2)').text());
        $('#cp_fournisseur').val(row.find('td:eq(3)').text());
        $('#ville_fournisseur').val(row.find('td:eq(4)').text());
        $('#pay_fournisseur').val(row.find('td:eq(5)').text());
        $('#telephone_fixe_fournisseur').val(row.find('td:eq(6)').text());
        $('#telephone_portable_fournisseur').val(row.find('td:eq(7)').text());
        $('#commande_fournisseur').val(row.find('td:eq(8)').text());
        $('#condition_livraison').val(row.find('td:eq(9)').text());
        $('#coord_livreur').val(row.find('td:eq(10)').text());
        $('#calendrier_livraison').val(row.find('td:eq(11)').text());
        $('#details_livraison').val(row.find('td:eq(12)').text());
        $('#condition_paiement').val(row.find('td:eq(13)').text());
        $('#facturation').val(row.find('td:eq(14)').text());
        $('#certificatione').val(row.find('td:eq(15)').text());
        $('#produit_service_fourni').val(row.find('td:eq(16)').text());
        $('#siuvi_fournisseur').val(row.find('td:eq(17)').text());
        $('#mail_fournisseur').val(row.find('td:eq(18)').text());
        $('#groupe_fournisseur').val(row.find('td:eq(19)').text());
        $('#adress_fournisseur').val(row.find('td:eq(20)').text());

        $('#modifier_fr').on('click', function() {
            var formData = {
                id_fournisseur: id,
                nom_fournisseur: $('#formContainer #nom_fournisseur').val(),
                prenom_fournisseur: $('#formContainer #prenom_fournisseur').val(),
                cp_fournisseur: $('#formContainer #cp_fournisseur').val(),
                ville_fournisseur: $('#formContainer #ville_fournisseur').val(),
                pay_fournisseur: $('#formContainer #pay_fournisseur').val(),
                telephone_fixe_fournisseur: $('#formContainer #telephone_fixe_fournisseur').val(),
                telephone_portable_fournisseur: $('#formContainer #telephone_portable_fournisseur').val(),
                commande_fournisseur: $('#formContainer #commande_fournisseur').val(),
                condition_livraison: $('#formContainer #condition_livraison').val(),
                coord_livreur: $('#formContainer #coord_livreur').val(),
                calendrier_livraison: $('#formContainer #calendrier_livraison').val(),
                details_livraison: $('#formContainer #details_livraison').val(),
                condition_paiement: $('#formContainer #condition_paiement').val(),
                facturation: $('#formContainer #facturation').val(),
                certificatione: $('#formContainer #certificatione').val(),
                produit_service_fourni: $('#formContainer #produit_service_fourni').val(),
                siuvi_fournisseur: $('#formContainer #siuvi_fournisseur').val(),
                mail_fournisseur: $('#formContainer #mail_fournisseur').val(),
                groupe_fournisseur: $('#formContainer #groupe_fournisseur').val(),
                adress_fournisseur: $('#formContainer #adress_fournisseur').val()
            };
            $.ajax({
                type: "POST",
                url: "modifyfournisseur.php",  //
                data: formData,
                success: function(response) {
                    alert(response);
                    $('#formContainer').hide();
                    $('#tbl_fournisseur').load('afficherfournisseur.php #tblfr',function (){


                    });
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert("Error: " + textStatus + " - " + errorThrown);  // عرض رسالة خطأ إذا فشل الطلب
                }
            });
        });

    }




    function deleteFournisseur(id) {
        // Code pour supprimer le fournisseur
        if (confirm('Êtes-vous sûr de vouloir supprimer ce fournisseur ?')) {
            fetch('deletefournisseur.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'id_fournisseur=' + id
            })
                .then(response => response.text())
                .then(result => {
                    // alert(result);
                    location.reload(); // Recharger la page pour voir les changements
                })
                .catch(error => {
                    console.error('Erreur:', error);
                });
        }
    }

            // Charger le contenu du tableau via AJAX
    $('#tbl_fournisseur').load('afficherfournisseur.php #tblfr',function (){


    });


    function vide() {
        $('#nom_fournisseur').val("");
        $('#prenom_fournisseur').val("");
        $('#cp_fournisseur').val("");
        $('#ville_fournisseur').val("");
        $('#pay_fournisseur').val("");
        $('#telephone_fixe_fournisseur').val("");
        $('#telephone_portable_fournisseur').val("");
        $('#commande_fournisseur').val("");
        $('#condition_livraison').val("");
        $('#coord_livreur').val("");
        $('#calendrier_livraison').val("");
        $('#details_livraison').val("");
        $('#condition_paiement').val("");
        $('#facturation').val("");
        $('#certificatione').val("");
        $('#produit_service_fourni').val("");
        $('#siuvi_fournisseur').val("");
        $('#mail_fournisseur').val("");
        $('#groupe_fournisseur').val("");
        $('#adress_fournisseur').val("");
    }




    // Fonction pour changer la valeur de action_A_D
    function toggleActionAD(button, fournisseurId) {
        const isActive = button.classList.contains('active');
        var rowTD = $(button).closest('tr').children(); // Sélectionne tous les enfants de la ligne


        // console.log(row)
        $.ajax({
            url: 'toggle_value.php',
            type: 'GET',
            data: { id_fournisseur: fournisseurId, action: isActive ? 0 : 1 }, // Passer la nouvelle valeur
            success: function(response) {
                // Changer le texte et la classe du bouton
                if (isActive) {
                    button.textContent = 'Désactivé';
                    button.classList.remove('active');
                    button.classList.add('inactive');
                    // Utilisez la méthode each() de jQuery pour itérer sur les éléments
                    rowTD.each(function(index, td) {
                         td.classList.remove("acctiveCLOUR")
                    });



                } else {
                    button.textContent = 'Active';
                    button.classList.remove('inactive');
                    button.classList.add('active');
                    // Utilisez la méthode each() de jQuery pour itérer sur les éléments
                    rowTD.each(function(index, td) {
                        td.classList.add("acctiveCLOUR")
                    });


                }
            },
            error: function(xhr, status, error) {
                alert('Une erreur est survenue : ' + error);
            }
        });
    }

</script>

</html>
