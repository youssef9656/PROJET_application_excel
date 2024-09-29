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
    <link rel="stylesheet" href="../../includes/css/bootstrap.min.css">
    <script src="../../includes/libriryPdf/unpkg/jspdf.umd.min.js"></script>
    <script src="../../includes/xlsx.full.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.23/jspdf.plugin.autotable.min.js"></script>


    <head>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <style>
            body {
                background-color: #1bd0ff; /* Couleur de fond douce */
                font-family: 'Arial', sans-serif;
                margin: 0;
                padding: 20px;
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
            /* From Uiverse.io by vinodjangid07 */
            .Btn {
                width: 50px;
                height: 50px;
                border: 2px solid rgb(6, 39, 108);
                border-radius: 15px;
                background-color: rgb(59, 99, 224);
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                cursor: pointer;
                position: relative;
                transition-duration: 0.3s;
                box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.11);
            }

            .svgIcon {
                fill: rgb(70, 70, 70);
            }

            .icon2 {
                width: 18px;
                height: 5px;
                border-bottom: 2px solid rgb(70, 70, 70);
                border-left: 2px solid rgb(70, 70, 70);
                border-right: 2px solid rgb(70, 70, 70);
            }

            .Btn:hover {
                background-color: rgb(51, 51, 51);
                transition-duration: 0.3s;
            }

            .Btn:hover .icon2 {
                border-bottom: 2px solid rgb(146, 255, 246);
                border-left: 2px solid rgb(88, 215, 220);
                border-right: 2px solid rgb(101, 232, 158);
            }

            .Btn:hover .svgIcon {
                fill: rgb(255, 255, 255);
                animation: slide-in-top 1s linear infinite;
            }

            @keyframes slide-in-top {
                0% {
                    transform: translateY(-10px);
                    opacity: 0;
                }

                100% {
                    transform: translateY(0px);
                    opacity: 1;
                }
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
    </head>
<body>
<?php
$pageName = 'Bon Commande';
include '../../includes/header.php';
?>

<div class="container mt-2">
    <div class="header">
        <h2 id="reportTitle"><?php echo $pageName; ?></h2>
    </div>
    <div class="form-row mb-3" style="flex-wrap: wrap; gap: 20px;">
        <div class="col-2">
            <label for="start_date">Date de début:</label>
            <input type="date" id="start_date" class="form-control">
        </div>
        <div class="col-2">
            <label for="end_date">Date de fin:</label>
            <input type="date" id="end_date" class="form-control">
        </div>
        <div class="col-2">
            <label for="status_filter">Filtrer par statut:</label>
            <select id="status_filter" class="form-control">
                <option value="">Tous</option>
                <option value="besoin">Besoin</option>
                <option value="bon">Bon</option>
            </select>
        </div>
        <div class="col-2">
            <label for="lot">Lot:</label>
            <select id="lot" class="form-control">
                <option value="">Sélectionner un lot</option>
                <!-- options dynamiques -->
            </select>
        </div>
        <div class="col-2">
            <label for="article">Article:</label>
            <select id="article" class="form-control">
                <option value="">Sélectionner un article</option>
                <!-- options dynamiques -->
            </select>
        </div>
        <div class="col-2">
            <label for="fournisseur">Fournisseur:</label>
            <select id="fournisseur" class="form-control">
                <option value="">Sélectionner un fournisseur</option>
                <!-- options dynamiques -->
            </select>

        </div>
        <div class="col-2">
            <label for="sous_lot">Sous Lot:</label>
            <select id="sous_lot" class="form-control">
                <option value="">Sélectionner un sous lot</option>
                <!-- options dynamiques -->
            </select>
        </div>
        <div class="col-2">
            <label for="service">Service:</label>
            <select id="service" class="form-control">
                <option value="">Sélectionner un service</option>
                <!-- options dynamiques -->
            </select>
        </div>
        <div class="col-2 ">
        <button onclick="fetchData()" class="btn btn-info">Rechercher</button>
        </div>
        <div class="col-2">
            <label for="start_date">Datede Livraison:</label>
            <input type="date" id="date_livraison" class="form-control">
        </div>
       </div>
       <div class="col-2">
           <div class="col-2">
               <button class="Btn" id="downloadPdf">
                   <svg
                           xmlns="http://www.w3.org/2000/svg"
                           height="1em"
                           viewBox="0 0 384 512"
                           class="svgIcon"
                   >
                       <path
                               d="M169.4 470.6c12.5 12.5 32.8 12.5 45.3 0l160-160c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L224 370.8 224 64c0-17.7-14.3-32-32-32s-32 14.3-32 32l0 306.7L54.6 265.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3l160 160z"
                       ></path>
                   </svg>
                   <span class="icon2"></span>
               </button>

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

                <th>Requirement Status</th>


                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            <!-- Ajoutez ici vos données -->
            </tbody>
        </table>
    </div>

</div>
<div id="lesdonneFournisseur" style="width: 100px ;color: rgba(255,255,255,0) "></div>
<script src="pdf.js"></script>

<script>
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
