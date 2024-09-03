<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="../../includes/jquery.sheetjs.js"></script>

    <title>Document</title>
    <link rel="stylesheet" href="../../includes/css/bootstrap.min.css">
    <style>
        #tbl_fournisseur {
            width: 98%;
            height: 80vh;
            overflow: auto;
            /*border: 1px solid #ccc;*/
        }

        .form-container {
            display: none; /* Masquer le formulaire par défaut */
            position: fixed; /* Positionner le formulaire au-dessus des autres éléments */
            top: 20px;
            left: 20px;
            width: 90%;
            max-width: 1000px; /* Largeur du formulaire */
            max-height: 80%; /* Hauteur maximale du formulaire */
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            z-index: 1000; /* Assurer que le formulaire est au-dessus des autres éléments */
            overflow-y: auto; /* Ajouter un défilement vertical si nécessaire */
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
            display: flex; /* Utilisation de flexbox pour aligner les champs côte à côte */
            flex-wrap: wrap; /* Permet aux champs de se déplacer sur plusieurs lignes si nécessaire */
            gap: 20px; /* Espacement entre les champs */
        }
        .form-group label {
            flex: 1 1 150px; /* Largeur minimale pour les labels */
            display: flex;
            align-items: center;
            font-weight: bold;
            white-space: nowrap; /* Empêcher le texte du label de se déformer */
        }
        .form-group input {
            flex: 2 1 200px; /* Largeur minimale pour les champs de saisie */
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 14px; /* Taille de police réduite pour les champs de saisie */
        }
        .form-group input[type="submit"] {
            background-color: #28a745;
            color: white;
            border: none;
            cursor: pointer;
            width: auto; /* Largeur automatique pour le bouton d'envoi */
            padding: 10px 20px;
            font-size: 16px;
        }
        .form-group input[type="submit"]:hover {
            background-color: #218838;
        }
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

<h4 class="mt-2 ms-5">Les Fournisseurs  <button class="show-form-btn" onclick="toggleForm()">+</button> </h4>
<div id="ajouter_fr" style="width: 100%">





    <div class="form-container" id="formContainer">
        <span class="close-btn" onclick="toggleForm()">×</span>
        <h2>Formulaire d'ajout de fournisseur</h2>
        <form id="fournisseurForm">
            <div class="form-group">
                <label for="nom_fournisseur">Nom du fournisseur :</label>
                <input type="text" id="nom_fournisseur" name="nom_fournisseur" required>
            </div>
            <div class="form-group">
                <label for="prenom_fournisseur">Prénom du fournisseur :</label>
                <input type="text" id="prenom_fournisseur" name="prenom_fournisseur" required>
            </div>
            <div class="form-group">
                <label for="cp_fournisseur">Code postal :</label>
                <input type="text" id="cp_fournisseur" name="cp_fournisseur" required>
            </div>
            <div class="form-group">
                <label for="ville_fournisseur">Ville :</label>
                <input type="text" id="ville_fournisseur" name="ville_fournisseur" required>
            </div>
            <div class="form-group">
                <label for="pay_fournisseur">Pays :</label>
                <input type="text" id="pay_fournisseur" name="pay_fournisseur" required>
            </div>
            <div class="form-group">
                <label for="telephone_fixe_fournisseur">Téléphone fixe :</label>
                <input type="text" id="telephone_fixe_fournisseur" name="telephone_fixe_fournisseur" required>
            </div>
            <div class="form-group">
                <label for="telephone_portable_fournisseur">Téléphone portable :</label>
                <input type="text" id="telephone_portable_fournisseur" name="telephone_portable_fournisseur" required>
            </div>
            <div class="form-group">
                <label for="commande_fournisseur">Commande fournisseur :</label>
                <input type="text" id="commande_fournisseur" name="commande_fournisseur" required>
            </div>
            <div class="form-group">
                <label for="condition_livraison">Conditions de livraison :</label>
                <input type="text" id="condition_livraison" name="condition_livraison" required>
            </div>
            <div class="form-group">
                <label for="coord_livreur">Coordonnées du livreur :</label>
                <input type="text" id="coord_livreur" name="coord_livreur" required>
            </div>
            <div class="form-group">
                <label for="calendrier_livraison">Calendrier de livraison :</label>
                <input type="text" id="calendrier_livraison" name="calendrier_livraison" required>
            </div>
            <div class="form-group">
                <label for="details_livraison">Détails de livraison :</label>
                <input type="text" id="details_livraison" name="details_livraison" required>
            </div>
            <div class="form-group">
                <label for="condition_paiement">Conditions de paiement :</label>
                <input type="text" id="condition_paiement" name="condition_paiement" required>
            </div>
            <div class="form-group">
                <label for="facturation">Facturation :</label>
                <input type="text" id="facturation" name="facturation" required>
            </div>
            <div class="form-group">
                <label for="certificatione">Certification :</label>
                <input type="text" id="certificatione" name="certificatione" required>
            </div>
            <div class="form-group">
                <label for="produit_service_fourni">Produit/Service fourni :</label>
                <input type="text" id="produit_service_fourni" name="produit_service_fourni" required>
            </div>
            <div class="form-group">
                <label for="siuvi_fournisseur">SIUVI fournisseur :</label>
                <input type="text" id="siuvi_fournisseur" name="siuvi_fournisseur" required>
            </div>
            <div class="form-group">
                <label for="mail_fournisseur">Email :</label>
                <input type="email" id="mail_fournisseur" name="mail_fournisseur" required>
            </div>
            <div class="form-group">
                <label for="groupe_fournisseur">Groupe du fournisseur :</label>
                <input type="text" id="groupe_fournisseur" name="groupe_fournisseur" required>
            </div>
            <div class="form-group">
                <label for="adress_fournisseur">Adresse du fournisseur :</label>
                <input type="text" id="adress_fournisseur" name="adress_fournisseur" required>
            </div>
            <div class="form-group">
                <input type="submit" value="Envoyer">
                <input type="submit" value="modifier" id="modifier_fr" style="display: none">
            </div>
        </form>
    </div>
</div>



<div id="tbl_fournisseur" class="container" >

</div>

</body>
<script src="../../includes/js/bootstrap.bundle.min.js"></script>
<script>
    function toggleForm() {
        const formContainer = document.getElementById('formContainer');
        formContainer.style.display = formContainer.style.display === 'none' ? 'block' : 'none';
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
                $('#tbl_fournisseur').load('afficherfournisseur.php',function (){


                });
            })
            .catch(error => {
                console.error('Erreur:', error);
            });
    });
    function toggleForm() {
        $('#formContainer').toggle(); // Afficher ou cacher le formulaire
    }

    function editFournisseur(button, id) {
        const formContainer = document.getElementById('formContainer');
        formContainer.style.display = formContainer.style.display === '' ? 'block' : '';
        document.getElementById("modifier_fr").style.display=""
        var row = $(button).closest('tr');

        // Extraire les valeurs des cellules de la ligne
        var nom = row.find('td:eq(1)').text();
        var prenom = row.find('td:eq(2)').text();
        var cp = row.find('td:eq(3)').text();
        var ville = row.find('td:eq(4)').text();
        var pay = row.find('td:eq(5)').text();
        var telFixe = row.find('td:eq(6)').text();
        var telPortable = row.find('td:eq(7)').text();
        var commande = row.find('td:eq(8)').text();
        var conditionLivraison = row.find('td:eq(9)').text();
        var coordLivreur = row.find('td:eq(10)').text();
        var calendrierLivraison = row.find('td:eq(11)').text();
        var detailsLivraison = row.find('td:eq(12)').text();
        var conditionPaiement = row.find('td:eq(13)').text();
        var facturation = row.find('td:eq(14)').text();
        var certificatione = row.find('td:eq(15)').text();
        var produitService = row.find('td:eq(16)').text();
        var siuvi = row.find('td:eq(17)').text();
        var mail = row.find('td:eq(18)').text();
        var groupe = row.find('td:eq(19)').text();
        var adresse = row.find('td:eq(20)').text();

        // Remplir le formulaire avec les valeurs extraites
        $('#formContainer #nom_fournisseur').val(nom);
        $('#formContainer #prenom_fournisseur').val(prenom);
        $('#formContainer #cp_fournisseur').val(cp);
        $('#formContainer #ville_fournisseur').val(ville);
        $('#formContainer #pay_fournisseur').val(pay);
        $('#formContainer #telephone_fixe_fournisseur').val(telFixe);
        $('#formContainer #telephone_portable_fournisseur').val(telPortable);
        $('#formContainer #commande_fournisseur').val(commande);
        $('#formContainer #condition_livraison').val(conditionLivraison);
        $('#formContainer #coord_livreur').val(coordLivreur);
        $('#formContainer #calendrier_livraison').val(calendrierLivraison);
        $('#formContainer #details_livraison').val(detailsLivraison);
        $('#formContainer #condition_paiement').val(conditionPaiement);
        $('#formContainer #facturation').val(facturation);
        $('#formContainer #certificatione').val(certificatione);
        $('#formContainer #produit_service_fourni').val(produitService);
        $('#formContainer #siuvi_fournisseur').val(siuvi);
        $('#formContainer #mail_fournisseur').val(mail);
        $('#formContainer #groupe_fournisseur').val(groupe);
        $('#formContainer #adress_fournisseur').val(adresse);

        // Ajouter un champ caché pour l'ID du fournisseur
        $('#formContainer').append('<input type="hidden" id="fournisseur_id" name="fournisseur_id" value="' + id + '">');

        // Afficher le formulaire
    }

    // Soumettre le formulaire via AJAX
    document.getElementById("modifier_fr").addEventListener("click",function (event){
            event.preventDefault(); // Empêche la soumission normale du formulaire

            var formData = $(this).serialize(); // Sérialiser les données du formulaire

            $.ajax({
                url: 'modifyfournisseur.php', // URL de la page PHP qui traitera les données
                type: 'POST',
                data: formData,
                success: function(response) {
                    // Gérer la réponse du serveur
                    alert('Fournisseur modifié avec succès');
                    toggleForm(); // Cacher le formulaire après l'envoi
                    // Optionnel: Actualiser la liste des fournisseurs ou le tableau
                },
                error: function(xhr, status, error) {
                    // Gérer les erreurs
                    alert('Une erreur est survenue : ' + error);
                }
            });

    })


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
                    alert(result);
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

</script>

</html>
