<?php
include '../../Config/check_session.php';
checkUserRole('user');
include '../../Config/connect_db.php';
$pageName= '';

$pageName = 'sortie commandes ';
include '../../includes/header.php';

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
<!--    <script src="../../includes/libriryPdf/unpkg/jspdf.umd.min.js"></script>-->
    <script src="../../includes/xlsx.full.min.js"></script>
    <script src="../../includes/js/jquery.min.js"></script> <!-- Assurez-vous d'utiliser la version complète -->
    <script src="../../includes/js/bootstrap.bundle.min.js"></script>
    <script src="../../includes/js/bootstrap123.min.js"></script>

    <head>
<!--        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">-->
        <style>
            body {
                font-family: Arial, sans-serif;
                background-color: #f4f4f4;
                padding: 20px;
            }

            .filter-wrapper {
                background-color: #ffffff;
                padding: 20px;
                border-radius: 8px;
                box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
                display: flex;
                flex-flow: row wrap;
                justify-content: space-between;
                /*max-width: 600px; !* Limite la largeur du conteneur *!*/
                margin: auto; /* Centre le conteneur */
            }

            .input-group1 {
                margin-bottom: 15px;
                width: 30%;
                display: flex;
                flex-flow: column wrap;
                justify-content: space-between;
            }


            label {
                display: block;
                margin-bottom: 5px;
                font-weight: bold;
                color: #333;
            }

            .input-field {
                /*width: 20%;*/
                padding: 10px;
                border: 1px solid #ccc;
                border-radius: 4px;
                transition: border-color 0.3s;
                font-size: 16px; /* Augmente la taille de la police */
            }

            .input-field:focus {
                border-color: #007bff; /* Couleur de la bordure au focus */
                outline: none; /* Supprime le contour par défaut */
            }


            .hover-effect {
                position: absolute;
                left: 50%;
                top: 50%;
                width: 300%;
                height: 300%;
                background-color: rgba(255, 255, 255, 0.2);
                transform: translate(-50%, -50%) rotate(45deg);
                transition: transform 0.5s ease;
                opacity: 0;
            }

            .submit-button:hover .hover-effect {
                opacity: 1;
            }







            .table-container {
                max-height: 400px; /* Hauteur maximale du conteneur */
                overflow-y: auto; /* Défilement vertical */
                border: 1px solid #dee2e6; /* Bordure douce */
                border-radius: .5rem; /* Coins arrondis */
                background-color: #ffffff; /* Couleur blanche pour le fond */
                box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1); /* Ombre douce */
                padding: 20px; /* Espacement intérieur */
                padding-top: 0;
                transition: transform 0.3s ease-in-out; /* Animation douce */
            }
            /*.table-container:hover {*/
            /*    transform: scale(1.02); !* Légère augmentation de taille au survol *!*/
            /*}*/
            .table {
                font-size: 0.9rem; /* Taille de police réduite pour le contenu de la table */
            }
            .table thead th {
                position: sticky;
                top: 0; /* Reste en haut lors du défilement */
                background-color: #007bff; /* Couleur d'arrière-plan */
                color: white; /* Couleur du texte */
                z-index: 10;
                padding: 15px;
                border-bottom: 2px solid #0056b3; /* Bordure inférieure plus prononcée */
            }
            .table tbody tr {
                transition: background-color 0.3s ease; /* Transition douce pour le changement de couleur */
            }
            .table tbody tr:hover {
                background-color: #d3e2ff; /* Couleur de survol */
                transform: translateY(-2px); /* Légère élévation au survol */
            }

            .header {
                background-color: transparent; /* Couleur d'arrière-plan de l'en-tête */
                backdrop-filter: blur(50px);
                color: white; /* Couleur du texte de l'en-tête */
                padding: 20px; /* Espacement intérieur */
                border-radius: .5rem; /* Coins arrondis */
                margin-bottom: 20px; /* Espacement en bas de l'en-tête */
                text-align: center; /* Centrer le texte */
                box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2); /* Ombre douce pour l'en-tête */
                animation: fadeIn 0.5s ease-in; /* Animation d'apparition */
            }
            @keyframes fadeIn {
                from {
                    opacity: 0; /* Début de l'animation */
                }
                to {
                    opacity: 1; /* Fin de l'animation */
                }
            }



            /* From Uiverse.io by Wendell47 */
            .button {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                padding: 15px 30px;
                border: 0;
                position: relative;
                overflow: hidden;
                border-radius: 10rem;
                transition: all 0.02s;
                font-weight: bold;
                cursor: pointer;
                color: rgb(128, 0, 98);
                z-index: 344;
                box-shadow: 0 0px 7px -5px rgba(0, 0, 0, 0.5);
                /*color: #5b005e;*/
            }

            .button:hover {
                background: rgb(193, 228, 248);
                color: rgb(33, 0, 85);
            }

            .button:active {
                transform: scale(0.97);
            }

            .hoverEffect {
                position: absolute;
                bottom: 0;
                top: 0;
                left: 0;
                right: 0;
                display: flex;
                align-items: center;
                justify-content: center;
                z-index: 1;
            }

            .hoverEffect div {
                background: rgb(0, 80, 19);
                background: linear-gradient(
                        90deg,
                        rgb(0, 129, 33) 0%,
                        rgb(0, 211, 140) 49%,
                        rgba(0, 212, 255, 1) 100%
                );
                border-radius: 40rem;
                width: 10rem;
                height: 10rem;
                transition: 0.4s;
                filter: blur(20px);
                animation: effect infinite 3s linear;
                opacity: 0.5;
            }

            .button:hover .hoverEffect div {
                width: 8rem;
                height: 8rem;
            }

            @keyframes effect {
                0% {
                    transform: rotate(0deg);
                }

                100% {
                    transform: rotate(360deg);
                }
            }


            .button1 {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                padding: 15px 30px;
                border: 0;
                position: relative;
                overflow: hidden;
                border-radius: 10rem;
                transition: all 0.02s;
                font-weight: bold;
                cursor: pointer;
                color: rgb(128, 0, 98);
                z-index: 344;
                box-shadow: 0 0px 7px -5px rgba(0, 0, 0, 0.5);
                /*color: #5b005e;*/
            }

            .button1:hover {
                background: rgb(143, 0, 177);
                color: rgb(255, 255, 255);
            }

            .button1:active {
                transform: scale(0.97);
            }

            .hoverEffect1 {
                position: absolute;
                bottom: 0;
                top: 0;
                left: 0;
                right: 0;
                display: flex;
                align-items: center;
                justify-content: center;
                z-index: 1;
            }

            .hoverEffect1 div {
                background: rgb(255, 116, 116);
                background: linear-gradient(
                        90deg,
                        rgb(218, 0, 225) 0%,
                        rgb(127, 0, 211) 49%,
                        rgb(255, 255, 255) 100%
                );
                border-radius: 40rem;
                width: 10rem;
                height: 10rem;
                transition: 0.4s;
                filter: blur(20px);
                animation: effect infinite 3s linear;
                opacity: 0.5;
            }

            .button1:hover .hoverEffect1 div {
                width: 8rem;
                height: 8rem;
            }


            /*body{*/
            /*    background-image: linear-gradient(20deg , #63e3ba, #e2ffc7, #ffffff, #71ff93);*/
            /*}*/
            body{
                background-image: url("../../image3.jpg");
                background-size: cover;
                background-repeat: no-repeat;
            }


            .button23 {
                line-height: 1;
                background-color: transparent;
                cursor: pointer;
                display: flex;
                align-items: center;
                gap: 0.35em;
                padding: 0.75em 1em;
                padding-right: 1.25em;
                color: #fff;
                border: 1px solid transparent;
                font-weight: 700;
                border-radius: 2.5em;
                font-size: 1rem;
                box-shadow: 0 0.7em 1.5em -0.5em hsla(249, 62%, 51%, 0.745);
                transition: transform 0.3s;

                background: linear-gradient(
                        90deg,
                        rgba(77, 54, 208, 1) 0%,
                        rgba(132, 116, 254, 1) 100%
                );
            }

            .button__icon {
                width: 1.5em;
                height: 1.5em;
            }

            .button23:hover {
                border-color: #f4f5f2;
            }

            .button23:active {
                transform: scale(0.98);
                box-shadow: 0 0.5em 1.5em -0.5em hsla(249, 62%, 51%, 0.745);
            }

            .label {
                color: white ;
            }
        </style>
    </head>
<body>


<div class="container mt-2">
    <div class="header">
        <div class="d-flex justify-content-between">
            <h2 id="reportTitle"><?php echo $pageName; ?></h2>
            <div class="col-5  d-flex ">
                <label class="mt-3 label" for="start_date">Date de livraison :</label>
                <div class=" ms-3 d-flex justify-content-between ">
                    <input type="date" id="dateLivraison" class="form-control mt-2" onchange="fetchData()()">
                    <button class=" ms-3 button23" id="downloadPdf" >
                        <svg
                                stroke-linejoin="round"
                                stroke-linecap="round"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="1.5"
                                viewBox="0 0 24 24"
                                height="40"
                                width="40"
                                class="button__icon"
                                xmlns="http://www.w3.org/2000/svg"
                        >
                            <path fill="none" d="M0 0h24v24H0z" stroke="none"></path>
                            <path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2"></path>
                            <path d="M7 11l5 5l5 -5"></path>
                            <path d="M12 4l0 12"></path>
                        </svg>
                        <span class="button__text">Download</span>
                    </button>

                </div>
            </div>
        </div>
    </div>


    <div class="filter-wrapper" style="margin-bottom: 50px">
        <div class="input-group1">
            <label for="start_date">Date de début:</label>
            <input type="date" id="start_date" class="input-field">
        </div>
        <div class="input-group1">
            <label for="end_date">Date de fin:</label>
            <input type="date" id="end_date" class="input-field">
        </div>
        <div class="input-group1">
            <label for="status_filter">Filtrer par statut:</label>
            <input type="text" id="status_filter" class="input-field" list="statusOptions" placeholder="Sélectionner un statut">
            <datalist id="statusOptions">
                <option value="">Tous</option>
                <option value="besoin">Besoin</option>
                <option value="bon">Bon</option>
            </datalist>
        </div>
        <div class="input-group1">
            <label for="lot">Lot:</label>
            <input type="text" id="lot" class="input-field" list="lotsDatalist" placeholder="Sélectionner un lot">
            <datalist id="lotsDatalist"></datalist>
        </div>
        <div class="input-group1">
            <label for="article">Article:</label>
            <input type="text" id="article" class="input-field" list="articlesDatalist" placeholder="Sélectionner un article">
            <datalist id="articlesDatalist"></datalist>
        </div>
        <div class="input-group1">
            <label for="service">Service:</label>
            <input type="text" id="service" class="input-field" list="fournisseursDatalist" placeholder="Sélectionner un fournisseur">
            <datalist id="fournisseursDatalist"></datalist>
        </div>
        <div class="input-group1">
            <label for="sous_lot">Sous Lot:</label>
            <input type="text" id="sous_lot" class="input-field" list="sousLotsDatalist" placeholder="Sélectionner un sous lot">
            <datalist id="sousLotsDatalist"></datalist>
        </div>
<!--        <div class="input-group1">-->
<!--            <button onclick="fetchData()" class="button">-->
<!--                Rechercher-->
<!--                <div class="hoverEffect">-->
<!--                    <div></div>-->
<!--                </div>-->
<!--            </button>-->
<!--        </div>-->
        <div class="input-group1">
            <button onclick="location.reload()" class="button1">
                Afficher tous
                <div class="hoverEffect1">
                    <div></div>
                </div>
            </button>
        </div>
    </div>
<!---->
<!--    <button id="downloadPdf" class="btn btn-primary">Télécharger en PDF</button>-->
<!---->
<!--    <input type="date" name="dateLivraison" id="dateLivraison">-->



    <div class="table-container">
        <table id="articles_table" class="table table-bordered table-hover">
            <thead class="thead-dark">
            <tr>
                <th>Order</th>
                <th>Article</th>
                <th>Quantité</th>
                <th>Prix</th>
                <th>Total dépense sorties</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody id="tableDepenses">
            <!-- Ajoutez ici vos données -->
            </tbody>
            <tfoot>
            <tr>
                <td colspan="4">Total:</td>
                <td id="totalDépense"></td>
            </tr>
            </tfoot>
        </table>
    </div>
</div>


<script>


    document.addEventListener('DOMContentLoaded' , ()=>{
        let inputs = document.querySelectorAll('input');

        inputs.forEach( input =>{
            input.addEventListener('change' , ()=>{
                fetchData()
                setTimeout(()=>{
                    calculerSommeTotalDepense()
                } , 100)

            })
        })


    })





    function updateOrderNumbers() {
        const tableRows = document.querySelectorAll('#articles_table tbody tr');
        tableRows.forEach((row, index) => {
            const orderTd = row.querySelector('td:first-child'); // Sélectionner la première cellule (numéro d'ordre)
            orderTd.textContent = index + 1; // Mettre à jour le numéro d'ordre
        });
    }

    // Code pour supprimer une ligne
    const deleteButton = document.createElement('button'); // Créer un bouton
    deleteButton.textContent = 'Supprimer'; // Texte du bouton
    deleteButton.classList.add('btn', 'btn-danger'); // Ajouter des classes pour le style
    deleteButton.onclick = () => {
        tr.remove(); // Supprimer la ligne lorsque le bouton est cliqué
        updateOrderNumbers(); // Mettre à jour les numéros d'ordre
    };

    function fetchData() {
        let currentDate = new Date();
        currentDate.setFullYear(currentDate.getFullYear() + 2);

        const startDate = document.getElementById('start_date').value || '1970-01-01';
        const endDate = document.getElementById('end_date').value || currentDate.toISOString().split('T')[0];
        const statusFilter = document.getElementById('status_filter').value;
        const lot = document.getElementById('lot').value;
        const article = document.getElementById('article').value;
        // const fournisseur = document.getElementById('fournisseur').value;
        const sousLot = document.getElementById('sous_lot').value;
        const service = document.getElementById('service').value;

        const params = new URLSearchParams({
            start_date: startDate,
            end_date: endDate,
            status_filter: statusFilter,
            lot: lot,
            article: article,
            // fournisseur: fournisseur,
            sous_lot: sousLot,
            service:service
        });

        fetch(`fetch_data.php?${params.toString()}`)
            .then(response => response.json())
            .then(data => {
                const tableBody = document.querySelector('#articles_table tbody');
                tableBody.innerHTML = ''; // Effacer le contenu précédent de la table

                const fields = ['Article', 'Total_Entry_Operations', 'Prix','Total_Depenses_Sortie']; // Champs à afficher

                // Parcourir chaque ligne de données
                data.forEach((row, index) => {
                    const tr = document.createElement('tr'); // Créer une nouvelle ligne

                    // Ajouter le numéro d'ordre
                    const orderTd = document.createElement('td');
                    orderTd.textContent = index + 1; // Numéro de ligne
                    tr.appendChild(orderTd); // Ajouter la cellule de numéro d'ordre

                    // Remplir les cellules avec les valeurs correspondantes
                    fields.forEach(field => {
                        const td = document.createElement('td'); // Créer une nouvelle cellule
                        if (field === 'Quantité') {
                            const input = document.createElement('input'); // Créer un input pour la quantité
                            input.type = 'number'; // Définir le type comme nombre
                            input.value = row[field] || ''; // Remplir avec la valeur correspondante
                            input.classList.add('form-control'); // Ajouter une classe pour le style
                            td.appendChild(input); // Ajouter l'input à la cellule
                        } else {
                            td.textContent = row[field] || ''; // Remplir la cellule avec la valeur correspondante
                        }
                        tr.appendChild(td); // Ajouter la cellule à la ligne
                    });

                    // Ajouter le bouton de suppression
                    const actionTd = document.createElement('td'); // Créer une nouvelle cellule pour l'action
                    const deleteButton = document.createElement('button'); // Créer un bouton
                    deleteButton.textContent = 'Supprimer'; // Texte du bouton
                    deleteButton.classList.add('btn', 'btn-danger'); // Ajouter des classes pour le style
                    deleteButton.onclick = () => {
                        tr.remove(); // Supprimer la ligne lorsque le bouton est cliqué
                        updateOrderNumbers(); // Mettre à jour les numéros d'ordre
                        calculerSommeTotalDepense()
                    };
                    actionTd.appendChild(deleteButton); // Ajouter le bouton à la cellule d'action
                    tr.appendChild(actionTd); // Ajouter la cellule d'action à la ligne

                    tableBody.appendChild(tr); // Ajouter la ligne au corps de la table
                });
                calculerSommeTotalDepense()
            })
            .catch(error => console.error('Error fetching data:', error)); // Gérer les erreurs

        function updateOrderNumbers() {
            const tableRows = document.querySelectorAll('#articles_table tbody tr');
            tableRows.forEach((row, index) => {
                const orderTd = row.querySelector('td:first-child'); // Sélectionner la première cellule (numéro d'ordre)
                orderTd.textContent = index + 1; // Mettre à jour le numéro d'ordre
            });
        }
    }
    document.addEventListener('DOMContentLoaded', fetchData);

    document.addEventListener('DOMContentLoaded', () => {
        fetchDropdownData();
        fetchData();
        calculerSommeTotalDepense()
    });


    function fetchDropdownData() {
        fetch('fetch_dropdown_data.php') // Récupère les données depuis PHP
            .then(response => response.json())
            .then(data => {
                populateDatalistOptions('lotsDatalist', data.lots);
                populateDatalistOptions('articlesDatalist', data.articles);
                // populateDatalistOptions('fournisseursDatalist', data.fournisseurs);
                populateDatalistOptions('sousLotsDatalist', data.sous_lots);
                populateDatalistOptions('servicesDatalist', data.services);
                calculerSommeTotalDepense()

            })
            .catch(error => console.error('Error fetching dropdown data:', error));
    }

    function populateDatalistOptions(datalistId, options) {
        calculerSommeTotalDepense()

        const datalistElement = document.getElementById(datalistId);
        datalistElement.innerHTML = '';  // Efface les options précédentes

        // Ajoute les autres options
        options.forEach(option => {
            const opt = document.createElement('option');
            opt.value = option;
            datalistElement.appendChild(opt);
            calculerSommeTotalDepense()

        });
    }

    // Appel initial pour charger les données
    fetchDropdownData();

    function calculerSommeTotalDepense() {
        let total = 0;
        const rows = document.querySelectorAll('#tableDepenses tr');

        rows.forEach(row => {
            // Récupère la valeur dans la colonne "Total Dépense"
            const depense = parseFloat(row.querySelector('td:nth-child(5)').textContent);
            // console.log(depense)
            total += depense;




        });

        // Affiche la somme totale dans le pied du tableau
        document.getElementById('totalDépense').textContent = total; // Formater en 2 décimales si nécessaire
    }

    // Appelle cette fonction après avoir chargé ou modifié le tableau
    document.addEventListener('DOMContentLoaded' , ()=>{
        setTimeout(()=>{
            calculerSommeTotalDepense();
        } , 200)

    })






</script>
<script src="script.js"></script>
</body>
</html>
