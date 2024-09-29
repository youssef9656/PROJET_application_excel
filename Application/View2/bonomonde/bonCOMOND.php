<?php
include '../../Config/check_session.php';
checkUserRole('admin');
include '../../Config/connect_db.php';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Etat des stocks</title>
    <script src="../../includes/jquery.sheetjs.js"></script>
    <script src="../../includes/libriryPdf/unpkg/jspdf.umd.min.js"></script>
    <script src="../../includes/xlsx.full.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.23/jspdf.plugin.autotable.min.js"></script>

    <?php
    $pageName = 'Bon Commande';
    include '../../includes/header.php';
    ?>

    <head>
        <style>


            body{
                background-image: url("../../image3.jpg");
                background-size: cover;
                background-repeat: no-repeat;
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
            .table-container {
                max-height: 400px; /* Hauteur maximale du conteneur */
                overflow-y: auto; /* Défilement vertical */
                border: 1px solid #dee2e6; /* Bordure douce */
                border-radius: .5rem; /* Coins arrondis */
                background-color: #ffffff; /* Couleur blanche pour le fond */
                box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1); /* Ombre douce */
                padding: 20px; /* Espacement intérieur */
                padding-top: 0PX;
                /*transition: transform 0.3s ease-in-out; !* Animation douce *!*/
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
            /*.table-container:hover {*/
            /*    transform: scale(1.02); !* Légère augmentation de taille au survol *!*/
            /*}*/
            .table {

                font-size: 3.9rem; /* Taille de police réduite pour le contenu de la table */
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


                /* From Uiverse.io by vinodjangid07 */
            /* From Uiverse.io by Creatlydev */
            .button {
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
                border-radius: 2em;
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

            .button:hover {
                border-color: #f4f5f2;
            }

            .button:active {
                transform: scale(0.98);
                box-shadow: 0 0.5em 1.5em -0.5em hsla(249, 62%, 51%, 0.745);
            }

            /*bbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbb*/
            /* From Uiverse.io by AbanoubMagdy1 */
            .wave-group {
                position: relative;
            }

            .wave-group .input {
                font-size: 16px;
                padding: 10px 10px 10px 5px;
                display: block;
                width: 200px;
                border: none;
                border-bottom: 1px solid #515151;
                background: transparent;
            }

            .wave-group .input:focus {
                outline: none;
            }

            .wave-group .label {
                color: #999;
                font-size: 18px;
                font-weight: normal;
                position: absolute;
                pointer-events: none;
                left: 5px;
                top: 10px;
                display: flex;
            }

            .wave-group .label-char {
                transition: 0.2s ease all;
                transition-delay: calc(var(--index) * .05s);
            }

            .wave-group .input:focus ~ label .label-char,
            .wave-group .input:valid ~ label .label-char {
                transform: translateY(-20px);
                font-size: 14px;
                color: #5264AE;
            }

            .wave-group .bar {
                position: relative;
                display: block;
                width: 200px;
            }

            .wave-group .bar:before,.wave-group .bar:after {
                content: '';
                height: 2px;
                width: 0;
                bottom: 1px;
                position: absolute;
                background: #5264AE;
                transition: 0.2s ease all;
                -moz-transition: 0.2s ease all;
                -webkit-transition: 0.2s ease all;
            }

            .wave-group .bar:before {
                left: 50%;
            }

            .wave-group .bar:after {
                right: 50%;
            }

            .wave-group .input:focus ~ .bar:before,
            .wave-group .input:focus ~ .bar:after {
                width: 50%;
            }



        </style>
<body>

<div class="container ">
    <div class="header">
        <div class="d-flex justify-content-between">
            <h2 id="reportTitle"><?php echo $pageName; ?></h2>
            <div class="col-5  d-flex ">
                <label class="mt-3 for="start_date">Datede Livraison:</label>
                <div class=" ms-3 d-flex justify-content-between ">
                    <input type="date" id="date_livraison" class="form-control mt-2" onchange="fetchData()()">
                    <button class="Btn ms-3 button" id="downloadPdf" >
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
    <div class="form-row mb-3 filter-wrapper" style="flex-wrap: wrap; gap: 20px;">
        <div class="col-2">
            <label for="start_date">Date de début:</label>
            <input type="date" id="start_date" class="form-control" onchange="fetchData()()">
        </div>
        <div class="col-2">
            <label for="end_date">Date de fin:</label>
            <input type="date" id="end_date" class="form-control" onchange="fetchData()()">
        </div>
        <div class="col-2">
            <label for="status_filter">Filtrer par statut:</label>
            <select id="status_filter" class="form-control" onchange="fetchData()()">
                <option value="">Tous</option>
                <option value="besoin">Besoin</option>
                <option value="bon">Bon</option>
            </select>
        </div>
        <div class="col-2">
            <label for="lot">Lot:</label>
            <select id="lot" class="form-control" onchange="fetchData()()">
                <option value="">Sélectionner un lot</option>
                <!-- options dynamiques -->
            </select>
        </div>

        <div class="col-2">
            <label for="fournisseur">Fournisseur:</label>
            <select id="fournisseur" class="form-control" onchange="fetchData()()">
                <option value="">Sélectionner un fournisseur</option>
                <!-- options dynamiques -->
            </select>

        </div>
        <div class="col-2">
            <label for="sous_lot">Sous Lot:</label>
            <select id="sous_lot" class="form-control" onchange="fetchData()()">
                <option value="">Sélectionner un sous lot</option>
                <!-- options dynamiques -->
            </select>
        </div>
        <div class="col-2">
            <label for="service">Service:</label>
            <select id="service" class="form-control" onchange="fetchData()()">
                <option value="">Sélectionner un service</option>
                <!-- options dynamiques -->
            </select>
        </div>
        <div class="col-2">
            <label for="article">Article:</label>
            <select id="article" class="form-control" onchange="fetchData()()">
                <option value="">Sélectionner un article</option>
                <!-- options dynamiques -->
            </select>
        </div>

        <div class="col-2 ">
        <button onclick=" reloadPge()" class="btn btn-info" id="BtnRechercher">Affiche tout </button>
        </div>
       </div>


    <div class="table-container">
        <table id="articles_table" class="table table-bordered table-hover sheetjs">
            <thead class="thead-dark">
            <tr>
                <th>Order</th>
                <th>Article</th>
                <th>Quantité</th>
                <th>Unité</th>
                <th>Observations</th>
                <th> Stock_Final</th>

                <th >Requirement Status</th>


                <th>Action</th>
            </tr>
            </thead>
            <tbody >
            <!-- Ajoutez ici vos données -->
            </tbody>
        </table>
    </div>

</div>
<div id="lesdonneFournisseur" style="width: 100px ;color: rgba(255,255,255,0) "></div>
<script src="pdf.js"></script>

<script>


    function reloadPge(){
        location.reload()
    }


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
        const fournisseur = document.getElementById('fournisseur').value;
        const sousLot = document.getElementById('sous_lot').value;
        const service = document.getElementById('service').value;

        const params = new URLSearchParams({
            start_date: startDate,
            end_date: endDate,
            status_filter: statusFilter,
            lot: lot,
            article: article,
            fournisseur: fournisseur,
            sous_lot: sousLot,
            service: service
        });

        fetch(`fetch_data.php?${params.toString()}`)
            .then(response => response.json())
            .then(data => {
                const tableBody = document.querySelector('#articles_table tbody');
                tableBody.innerHTML = ''; // Effacer le contenu précédent de la table

                const fields = ['Article', 'Quantité', 'unite','','Stock_Final','Requirement_Status']; // Champs à afficher

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
                            input.classList.add('form-control');// Ajouter une classe pour le style
                            // td.appendChild(input);// Ajouter l'input à la cellule
                            td.innerHTML=`
<div class="wave-group">
  <input required="" type="number" class="input">
  <span class="bar"></span>
  <label class="label">
    <span class="label-char" style="--index: 0">Qu</span>
    <span class="label-char" style="--index: 1">an</span>
    <span class="label-char" style="--index: 2">ti</span>
    <span class="label-char" style="--index: 3">té</span>
  </label>
</div>`
                        } else {
                            td.textContent = row[field] || ''; // Remplir la cellule avec la valeur correspondante
                        }
                        if (field === 'Requirement_Status') {
                            td.innerText == "bon" ?      td.style.cssText = 'text-align: center; background-color: rgba(55, 222, 146, 0.87);': td.style.cssText = 'text-align: center; background-color: rgba(255,0,26,0.85);'

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
                    };
                    actionTd.appendChild(deleteButton); // Ajouter le bouton à la cellule d'action
                    tr.appendChild(actionTd); // Ajouter la cellule d'action à la ligne

                    tableBody.appendChild(tr); // Ajouter la ligne au corps de la table

                });

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

    });


    function fetchDropdownData() {
        fetch('fetch_dropdown_data.php') // Récupère les données depuis PHP
            .then(response => response.json())
            .then(data => {
                populateSelectOptions('lot', data.lots);
                populateSelectOptions('article', data.articles);
                populateSelectOptions('fournisseur', data.fournisseurs);
                populateSelectOptions('sous_lot', data.sous_lots);
                populateSelectOptions('service', data.services);
            })
            .catch(error => console.error('Error fetching dropdown data:', error));
    }

    function populateSelectOptions(selectId, options) {
        const selectElement = document.getElementById(selectId);
        selectElement.innerHTML = '';  // Efface les options précédentes

        // Ajoute l'option "Tous"
        const allOption = document.createElement('option');
        allOption.value = ''; // Valeur vide pour représenter "Tous"
        allOption.textContent = 'Tous'; // Texte affiché
        selectElement.appendChild(allOption);

        // Ajoute les autres options
        options.forEach(option => {
            const opt = document.createElement('option');
            opt.value = option;
            opt.textContent = option;
            selectElement.appendChild(opt);
        });
    }


</script>
</body>
</html>
