<?php
include '../../Config/check_session.php';
checkUserRole('admin');
include '../../Config/connect_db.php';
$pageName= 'Catalogue du temps';
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

    <head>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <style>
            body {
                background-color: #eef2f3; /* Couleur de fond douce */
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
                transition: transform 0.3s ease-in-out; /* Animation douce */
            }
            .table-container:hover {
                transform: scale(1.02); /* Légère augmentation de taille au survol */
            }
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
            .btn {
                margin-top: 10px;
                padding: 10px 15px; /* Ajustement de la taille des boutons */
                border: none;
                border-radius: 5px;
                background-color: #28a745; /* Couleur du bouton */
                color: white;
                font-size: 0.9rem; /* Taille de police des boutons */
                transition: background-color 0.3s ease, transform 0.2s ease; /* Animation douce */
            }
            .btn:hover {
                background-color: #218838; /* Couleur du bouton au survol */
                transform: scale(1.05); /* Zoom léger */
            }
            .form label {
                font-weight: bold;
                color: #343a40; /* Couleur des étiquettes */
            }
            .form-control {
                margin-bottom: 10px;
                border: 1px solid #ced4da; /* Bordure des champs */
                border-radius: .25rem; /* Coins arrondis */
                transition: border-color 0.3s; /* Animation de la bordure */
            }
            .form-control:focus {
                border-color: #007bff; /* Couleur de la bordure lors de la mise au point */
                box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25); /* Ombre autour du champ */
            }
            .header {
                background-color: #007bff; /* Couleur d'arrière-plan de l'en-tête */
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
        </style>
    </head>
<body>
<?php
$pageName = 'État des Stocks';
include '../../includes/header.php';
?>

<div class="container mt-2">
    <div class="header">
        <h2><?php echo $pageName; ?></h2>
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
        <div class="col-2">
            <button onclick="fetchData()" class="btn">Rechercher</button>
        </div>
    </div>

    <div class="table-container">
        <table id="articles_table" class="table table-bordered table-hover">
            <thead class="thead-dark">
            <tr>
                <th>Order</th>
                <th>Article</th>
                <th>Quantité</th>
                <th>Unité</th>
                <th>Requirement Status</th>
                <th>Observations</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            <!-- Ajoutez ici vos données -->
            </tbody>
        </table>
    </div>
</div>


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

                const fields = ['Article', 'Quantité', 'unite','Requirement_Status','']; // Champs à afficher

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
