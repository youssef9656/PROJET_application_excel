<?php

include '../../Config/check_session.php';
checkUserRole('admin');


$pageName = 'lot / sous lot'; include '../../config/connect_db.php'; include '../../includes/header.php'; ?>
<?php
if (isset($_GET['message'])) {
    switch ($_GET['message']) {
        case 'success':
            echo '<div class="alert alert-dismissible alert-success">
                    Le sous-lot a été ajouté avec succès.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
            break;
        case 'duplicate_sous_lot':
            echo '<div class="alert alert-dismissible alert-danger">
                        Erreur: Le sous-lot existe déjà dans un lot.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                  </div>';
            break;
        case 'error':
            echo '<div class="alert alert-dismissible alert-danger">
                        Erreur lors de l\'ajout du sous-lot.
                       <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                   </div>';
            break;
        case 'empty_fields':
            echo '<div class="alert alert-dismissible alert-danger">
                        Erreur: Tous les champs sont requis.
                       <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                   </div>';
            break;

        case 'fournisseur_deleted':
            echo '<div class="alert alert-dismissible alert-success">
                        Fournisseur supprimé avec succès !
                       <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                   </div>';
            break;
    }
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
<!--nnn-->
    <link rel="stylesheet" href="../../includes/css/bootstrap.min.css">
    <script src="../../includes/js/jquery.min.js"></script> <!-- Assurez-vous d'utiliser la version complète -->
    <script src="../../includes/js/bootstrap.bundle.min.js"></script>
    <script src="../../includes/js/bootstrap123.min.js"></script>
    <title>Document</title>
</head>
<body>

<style>
    .les-tables{
        width: 100%;
        display: flex;
        align-items: start;
        justify-content: space-around;
    }
    .div-table1 , .div-table2{
        width: 40%;
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
        margin-top: 40px;
        /*overflow: scroll;*/
    }
    .table1 ,.table2 , .table3{
        margin-top: 50px;
        width: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .ajouter_table1 , .ajouter_table2{
        width: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: row;
    }
    .filter-seleects{
        display: flex;
        flex-direction: row;
        width: 100%;
        justify-content: space-between;
        flex-flow: wrap

    }
    .filter-seleects div{
        display: flex ;
        flex-direction: column;
        /*justify-content: space-between;*/
        margin-top: 20px;
    }
    .table-fournisseur{
        margin-top: 40px;
    }
    .table-fournisseur-tete{
        margin: 30px;
        display: flex;
    }
    .table-fournisseur-tete{
        font-size: 30px;
        color: transparent;
        background-image: linear-gradient(-20deg , #00a357, #21ffe8);
        background-clip: text;
    }
</style>


<!-- Modal d'ajout de lot -->
<div class="modal fade" id="ajouterLotModal" tabindex="-1" aria-labelledby="ajouterLotModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content ajout_catalog">
            <div class="modal-header">
                <h5 class="modal-title" id="ajouterLotModalLabel">Ajouter un nouveau lot</h5>

            </div>
            <div class="modal-body">
                <form id="ajouterLotForm">
                    <div class="form-group">
                        <label for="new_lot_name">Nom du Lot</label>
                        <input type="text" class="form-control" id="new_lot_name" name="new_lot_name" required>
                    </div>
                    <button type="submit" class="btn btn-primary mt-4">Ajouter</button>
                    <button type="button" class="btn btn-info mt-4" onclick="$('#ajouterLotModal').modal('hide');">Annuler</button>
                </form>
                <div id="ajouterLotResult" class="mt-3"></div>
            </div>
        </div>
    </div>
</div>

<!--Modal pour modifier le lot-->
<div class="modal fade" id="modifyLotModal" tabindex="-1" aria-labelledby="modifyLotModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content ajout_catalog">
                <div class="modal-header">
                    <h5 class="modal-title" id="modifyLotModalLabel">Modifier un lot</h5>

                </div>
                <div class="modal-body">
                    <form id="modifyLotForm">
                        <input type="hidden" id="lot_id" name="lot_id">
                        <div class="form-group">
                            <label for="lot_name">Nom du Lot</label>
                            <input type="text" class="form-control" id="lot_name" name="lot_name" required>
                        </div>
                        <button type="submit" class="btn btn-primary mt-4">Sauvegarder</button>
                        <button type="button" class="btn btn-info mt-4" onclick="$('#modifyLotModal').modal('hide');">Annuler</button>

                    </form>
                    <div id="modifyLotResult" class="mt-3"></div>
                </div>
            </div>
        </div>
</div>

<!-- Modal ajouter sous lot -->
<div class="modal fade" id="ajouterSousLotModal" tabindex="-1" aria-labelledby="ajouterSousLotModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ajouterSousLotModalLabel">Ajouter un Sous-Lot</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="ajouter_sous_lot.php" method="POST">
                    <div class="mb-3">
                        <label for="lot_id" class="form-label">Nom du Lot</label>
                        <select class="form-select" id="lot_id" name="lot_id" required>
                            <option value="" selected disabled>Choisir un lot</option>
                            <?php
                            // Récupérer les lots depuis la base de données
                            $lotQuery = "SELECT lot_id, lot_name FROM lots";
                            $lotResult = mysqli_query($conn, $lotQuery);
                            while ($lotRow = mysqli_fetch_assoc($lotResult)) {
                                echo '<option value="' . htmlspecialchars($lotRow['lot_id']) . '">' . htmlspecialchars($lotRow['lot_name']) . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="sous_lot_name" class="form-label">Nom du Sous-Lot</label>
                        <input type="text" class="form-control" id="sous_lot_name" name="sous_lot_name" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Ajouter</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal pour modifier un sous-lot -->
<div class="modal fade" id="modifierSousLotModal" tabindex="-1" role="dialog" aria-labelledby="modifierSousLotModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modifierSousLotModalLabel">Modifier Sous-Lot</h5>
            </div>
            <form id="modifierSousLotForm" method="POST" action="modifier_sous_lot.php">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="modifierSousLotName">Nom du Sous-Lot</label>
                        <input type="text" class="form-control" id="modifierSousLotName" name="sous_lot_name" required>
                    </div>
                    <div class="form-group">
                        <label for="modifierLotSelect">Lot</label>
                        <select class="form-control" id="modifierLotSelect" name="lot_id" required>
                            <!-- Les options seront ajoutées dynamiquement par JavaScript -->
                        </select>
                    </div>
                    <input type="hidden" id="modifierSousLotId" name="sous_lot_id">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-info" onclick="$('#modifierSousLotModal').modal('hide');">Annuler</button>
                    <button type="submit" class="btn btn-primary">Enregistrer les modifications</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal pour ajouter fournisseur -->
<div class="modal fade" id="ajouterFournisseurModal" tabindex="-1" aria-labelledby="ajouterFournisseurModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ajouterFournisseurModalLabel">Ajouter un Fournisseur au Lot</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="ajouterFournisseurForm">
                    <div class="mb-3">
                        <label for="lot_id" class="form-label">Nom du Lot</label>
                        <select class="form-select" id="lot_id" name="lot_id" required>
                            <option value="" selected disabled>Choisir un lot</option>
                            <?php
                            // Récupérer les lots depuis la base de données
                            $lotQuery = "SELECT lot_id, lot_name FROM lots";
                            $lotResult = mysqli_query($conn, $lotQuery);
                            while ($lotRow = mysqli_fetch_assoc($lotResult)) {
                                echo '<option value="' . htmlspecialchars($lotRow['lot_id']) . '">' . htmlspecialchars($lotRow['lot_name']) . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="fournisseur_id" class="form-label">Nom du Fournisseur</label>
                        <select class="form-select" id="fournisseur_id" name="fournisseur_id" required>
                            <option value="" selected disabled>Choisir un fournisseur</option>
                            <?php
                            // Récupérer les fournisseurs depuis la base de données
                            $fournisseurQuery = "SELECT id_fournisseur, nom_fournisseur FROM fournisseurs";
                            $fournisseurResult = mysqli_query($conn, $fournisseurQuery);
                            while ($fournisseurRow = mysqli_fetch_assoc($fournisseurResult)) {
                                echo '<option value="' . htmlspecialchars($fournisseurRow['id_fournisseur']) . '">' . htmlspecialchars($fournisseurRow['nom_fournisseur']) . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div id="ajouterFournisseurResult"></div>
                    <button type="submit" class="btn btn-primary">Ajouter</button>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- Modal pour ajouter service -->

<div class="modal fade" id="addServiceModal" tabindex="-1" role="dialog" aria-labelledby="addServiceModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addServiceModalLabel">Ajouter un Service</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="addServiceForm">
                    <div class="form-group">
                        <label for="service">Service:</label>
                        <input type="text" class="form-control" id="service" name="service" required>
                    </div>
                    <div class="form-group">
                        <label for="zone">Zone:</label>
                        <input type="text" class="form-control" id="zone" name="zone" required>
                    </div>
                    <div class="form-group">
                        <label for="ref">Référence:</label>
                        <input type="text" class="form-control" id="ref" name="ref" required>
                    </div>
                    <div class="form-group">
                        <label for="equip">Équipe:</label>
                        <input type="text" class="form-control" id="equip" name="equip" required>
                    </div>
                    <button type="submit" class="btn btn-success">Ajouter</button>
                </form>
            </div>
        </div>
    </div>
</div>



<div class="les-tables">
    <div class="div-table1">
        <div class="ajouter_table1">
            <h4>ajouter un lot</h4>
            <button type="button" style="background: green; color:white; border: 1px solid white ; border-radius: 4px; font-size: 20px ; margin-left: 10px;padding-bottom: 4px"  id="openAddLotModal">
                +
            </button>


        </div>



        <div class="table1">
            <!-- le tableau de donnêes de lot           -->
        </div>
        <div class="table-fournisseur-tete">
            <div>Gérer vos fournisseurs ici</div> <!-- Bouton pour ouvrir la modal d'ajout de fournisseur -->
            <button type="button" style="background: green; color:white; border: 1px solid white ; border-radius: 4px; font-size: 20px ; margin-left: 10px;padding-bottom: 4px" class="btn-primary" data-bs-toggle="modal" data-bs-target="#ajouterFournisseurModal">
                +
            </button>
        </div>
        <!-- Inputs pour filtrer les données -->
        <div class="mb-3">
            <label for="filterLotfournisseur" class="form-label">Filtrer par Lot</label>
            <input type="text" id="filterLotfourniseur" class="form-control" placeholder="Tapez pour filtrer" list="lotOptions">
            <datalist id="lotOptions">
                <?php
                // Récupérer les lots depuis la base de données pour le datalist
                $lotQuery = "SELECT DISTINCT l.lot_name FROM lot_fournisseurs lf JOIN lots l ON lf.lot_id = l.lot_id";
                $lotResult = mysqli_query($conn, $lotQuery);
                while ($lotRow = mysqli_fetch_assoc($lotResult)) {
                    echo '<option value="' . htmlspecialchars($lotRow['lot_name']) . '">';
                }

                ?>
            </datalist>
        </div>

        <div class="mb-3">
            <label for="filterFournisseur" class="form-label">Filtrer par Fournisseur</label>
            <input type="text" id="filterFournisseur" class="form-control" placeholder="Tapez pour filtrer" list="fournisseurOptions">
            <datalist id="fournisseurOptions">
                <?php
                // Récupérer les fournisseurs depuis la base de données pour le datalist
                $fournisseurQuery = "SELECT DISTINCT f.nom_fournisseur FROM lot_fournisseurs lf JOIN fournisseurs f ON lf.id_fournisseur = f.id_fournisseur";
                $fournisseurResult = mysqli_query($conn, $fournisseurQuery);
                while ($fournisseurRow = mysqli_fetch_assoc($fournisseurResult)) {
                    echo '<option value="' . htmlspecialchars($fournisseurRow['nom_fournisseur']) . '">';
                }
                ?>
            </datalist>
        </div>


        <div class="table-fournisseur">
            <!-- Le tableau de données de fournisseurs            -->
        </div>
    </div>

    <div class="div-table2">
        <div class="ajouter_table2">
            <h4>ajouter un sous lot</h4>
            <button type="button" style="background: green; color:white; border: 1px solid white ; border-radius: 4px; font-size: 20px ; margin-left: 10px;padding-bottom: 4px" onclick="$('#ajouterSousLotModal').modal('show');"  id="ajouterSousLotModal">
                +
            </button>
        </div>
        <div class="filter-seleects">
            <div>
                <label for="filterSousLotId">Filtrer par Sous-Lot ID :</label>
                <input list="sousLotIds" id="filterSousLotId" name="filterSousLotId">
                <datalist id="sousLotIds">
                    <!-- Options générées dynamiquement -->
                    <?php
                    $query = "SELECT DISTINCT sous_lot_id FROM sous_lots";
                    $result = mysqli_query($conn, $query);
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo '<option value="' . htmlspecialchars($row['sous_lot_id']) . '">';
                    }
                    ?>
                </datalist>
            </div>
            <div>
                <label for="filterLot">Filtrer par Lot :</label>
                <input list="lotNames" id="filterLot" name="filterLot">
                <datalist id="lotNames">
                    <!-- Options générées dynamiquement -->
                    <?php
                    $query = "SELECT DISTINCT lot_name FROM lots";
                    $result = mysqli_query($conn, $query);
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo '<option value="' . htmlspecialchars($row['lot_name']) . '">';
                    }
                    ?>
                </datalist>
            </div>
            <div>


                <label for="filterSousLotName">Filtrer par Sous-Lot :</label>
                <input list="sousLotNames" id="filterSousLotName" name="filterSousLotName">
                <datalist id="sousLotNames">
                    <!-- Options générées dynamiquement -->
                    <?php
                    $query = "SELECT DISTINCT sous_lot_name FROM sous_lots";
                    $result = mysqli_query($conn, $query);
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo '<option value="' . htmlspecialchars($row['sous_lot_name']) . '">';
                    }
                    ?>
                </datalist>
            </div>

            <div>
                <button id="afficher_souslot" class="btn btn-primary">Afficher tous</button>
            </div>



        </div>

        <div class="table2">

            <!-- Le tableau de données de sous lots -->
        </div>



        <button style="margin-top: 50px" type="button" class="btn btn-primary" data-toggle="modal" data-target="#addServiceModal">
            Ajouter un Service
        </button>

        <div class="table3">


        </div>
    </div>

</div>
<script>

    $(document).ready(function() {

        $.ajax({
            url: 'service_table.php',
            method: 'GET',
            success: function (response) {
                $('.table3').html(response);
            },
            error: function (xhr, status, error) {
                console.error('Une erreur s\'est produite:', status, error);
            }
        });

    })

    $(document).ready(function() {
        // Afficher une alerte si le paramètre d'erreur est présent dans l'URL
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.get('error') === 'reference') {
            alert('Le lot ne peut pas être supprimé car il est référencé dans d\'autres tables.');
        }

        // Charger le contenu de la table via AJAX
        $.ajax({
            url: 'lot_table.php',
            method: 'GET',
            success: function(response) {
                $('.table1').html(response);
            },
            error: function(xhr, status, error) {
                console.error('Une erreur s\'est produite:', status, error);
            }
        });

        // Gérer le clic sur les boutons de modification
        $(document).on('click', '.modifier-lot', function(e) {
            e.preventDefault();

            // Récupérer les données du lot depuis les attributs data- du bouton
            var lot_id = $(this).data('id');
            var lot_name = $(this).data('name');

            // Pré-remplir les champs de la modal
            $('#lot_id').val(lot_id);
            $('#lot_name').val(lot_name);


            // Ouvrir la modal
            $('#modifyLotModal').modal('show');
        });

        // Gérer la soumission du formulaire de modification
        $('#modifyLotForm').on('submit', function(e) {
            e.preventDefault();

            $.ajax({
                url: 'modifier_lot.php',
                method: 'POST',
                data: $(this).serialize(),
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        $('#modifyLotModal').modal('hide');
                        alert('Le lot a été mis à jour avec succès.');
                        // Vous pouvez recharger les données ou mettre à jour la table ici
                        $.ajax({
                            url: 'lot_table.php',
                            method: 'GET',
                            success: function(response) {
                                $('.table1').html(response);
                            }
                        });
                    } else {
                        $('#modifyLotResult').html('<div class="alert alert-danger">Erreur: ' + response.error + '</div>');
                    }
                },
                error: function(xhr, status, error) {
                    $('#modifyLotResult').html('<div class="alert alert-danger">Erreur de connexion au serveur.</div>');
                }
            });
        });
    });


    // ajouter un lot

    $(document).ready(function() {
        // Gérer le clic sur le bouton d'ajout de lot
        $('#openAddLotModal').on('click', function(e) {
            e.preventDefault();

            // Réinitialiser le formulaire et les messages d'erreur/succès
            $('#ajouterLotForm')[0].reset();
            $('#ajouterLotResult').html('');

            // Ouvrir le modal
            $('#ajouterLotModal').modal('show');
        });

        // Gérer la soumission du formulaire d'ajout de lot
        $('#ajouterLotForm').on('submit', function(e) {
            e.preventDefault();

            $.ajax({
                url: 'ajouter_lot.php',
                method: 'POST',
                data: $(this).serialize(),
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        $('#ajouterLotModal').modal('hide');
                        alert('Le lot a été ajouté avec succès.');
                        location.reload()
                        // Rechargez ou mettez à jour la table des lots ici si nécessaire
                        $.ajax({
                            url: 'lot_table.php',
                            method: 'GET',
                            success: function(response) {
                                $('.table1').html(response);
                            }
                        });
                        // Réinitialiser le formulaire et les messages d'erreur/succès
                        $('#ajouterLotForm')[0].reset();
                        $('#ajouterLotResult').html('');
                    } else {
                        $('#ajouterLotResult').html('<div class="alert alert-danger">Erreur: ' + response.error + '</div>');
                    }
                },
                error: function(xhr, status, error) {
                    $('#ajouterLotResult').html('<div class="alert alert-danger">Erreur de connexion au serveur.</div>');
                }
            });
        });
    });


// sous lot codes



    $(document).ready(function() {

        // const urlParams = new URLSearchParams(window.location.search);
        // if (urlParams.get('error') === 'reference') {
        //     alert('Le lot ne peut pas être supprimé car il est référencé dans d\'autres tables.');
        // }


        $.ajax({
            url: 'souslot_table.php',
            method: 'GET',
            success: function (response) {
                $('.table2').html(response);
            },
            error: function (xhr, status, error) {
                console.error('Une erreur s\'est produite:', status, error);
            }
        });

    })


//     modifier sous lot

    document.addEventListener('DOMContentLoaded', function() {
        // Sélectionner tous les boutons de modification
        setTimeout(()=>{
            document.querySelector('#afficher_souslot').addEventListener('click', ()=>{
                location.reload()
            })
            var modifyButtons = document.querySelectorAll('#id1');

            modifyButtons.forEach(function(button) {
                button.addEventListener('click', function() {
                    // Récupérer les données du bouton
                    var sousLotId = this.getAttribute('data-id');
                    var sousLotName = this.getAttribute('data-name');
                    var lotId = this.getAttribute('data-lot-id');

                    // Remplir le formulaire du modal avec les données
                    document.getElementById('modifierSousLotId').value = sousLotId;
                    document.getElementById('modifierSousLotName').value = sousLotName;

                    // Charger les options des lots dans le select
                    loadLotOptions(lotId);

                    // Afficher le modal
                    $('#modifierSousLotModal').modal('show');
                });
            });
        } , 1000)

        // afficher tous les sous lots button


        function loadLotOptions(selectedLotId) {
            var lotSelect = document.getElementById('modifierLotSelect');
            lotSelect.innerHTML = ''; // Réinitialiser le select

            // Faire une requête AJAX pour obtenir les lots
            var xhr = new XMLHttpRequest();
            xhr.open('GET', 'get_lots.php', true);
            xhr.onload = function() {
                if (xhr.status >= 200 && xhr.status < 300) {
                    var lots = JSON.parse(xhr.responseText);

                    lots.forEach(function(lot) {
                        var option = document.createElement('option');
                        option.value = lot.id;
                        option.textContent = lot.name;
                        if (lot.id == selectedLotId) {
                            option.selected = true;
                        }
                        lotSelect.appendChild(option);
                    });
                } else {
                    console.error('La requête a échoué.');
                }
            };
            xhr.send();
        }

        // Gérer la soumission du formulaire de modification
        document.getElementById('modifierSousLotForm').addEventListener('submit', function(event) {
            event.preventDefault();

            var sousLotId = document.getElementById('modifierSousLotId').value;
            var sousLotName = document.getElementById('modifierSousLotName').value;
            var lotId = document.getElementById('modifierLotSelect').value;

            // Préparer les données pour la requête AJAX
            var formData = new FormData();
            formData.append('sous_lot_id', sousLotId);
            formData.append('sous_lot_name', sousLotName);
            formData.append('lot_id', lotId);

            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'modifier_sous_lot.php', true);
            xhr.onload = function() {
                if (xhr.status >= 200 && xhr.status < 300) {
                    var response = JSON.parse(xhr.responseText);

                    if (response.status === 'success') {
                        alert('Sous-lot modifié avec succès !');
                        // Optionnel: Recharger la page ou mettre à jour le tableau
                        location.reload(); // Recharger la page pour voir les changements
                    } else {
                        alert('Erreur : ' + response.message);
                    }
                } else {
                    alert('La requête a échoué.');
                }
            };
            xhr.send(formData);
        });
    });


// filtrer les sous lots


        document.addEventListener('DOMContentLoaded', function() {
        var filterInputs = document.querySelectorAll('#filterSousLotId, #filterLot, #filterSousLotName');

        filterInputs.forEach(function(input) {
        input.addEventListener('input', function() {
        filterTable();
    });
    });

        function filterTable() {
        var sousLotId = document.getElementById('filterSousLotId').value.toLowerCase();
        var lotName = document.getElementById('filterLot').value.toLowerCase();
        var sousLotName = document.getElementById('filterSousLotName').value.toLowerCase();

        var table = document.getElementById('sousLotsTable');
        var rows = table.querySelectorAll('tbody tr');
        rows.forEach(function(row) {
        var id = row.querySelector('td:nth-child(1)').textContent.toLowerCase();
        var lot = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
        var name = row.querySelector('td:nth-child(3)').textContent.toLowerCase();

        var isVisible = (!sousLotId || id.includes(sousLotId)) &&
        (!lotName || lot.includes(lotName)) &&
        (!sousLotName || name.includes(sousLotName));

        row.style.display = isVisible ? '' : 'none';
    });
    }
    });

    //     fournisseurs codes

    $(document).ready(function() {
        // Fonction pour charger les données dans le div
        function loadFournisseurTable() {
            $.ajax({
                url: 'fournisseur_table.php', // URL de votre fichier PHP
                method: 'GET',
                success: function(response) {
                    $('.table-fournisseur').html(response); // Injecter le tableau HTML dans le div
                },
                error: function(xhr, status, error) {
                    $('.table-fournisseur').html('<div class="alert alert-danger">Erreur de connexion au serveur.</div>');
                }
            });
        }

        // Charger la table lors du chargement de la page
        loadFournisseurTable();
    });


//     ajouter fournisseur

    $(document).ready(function() {
        // Gérer la soumission du formulaire d'ajout de fournisseur
        $('#ajouterFournisseurForm').on('submit', function(e) {
            e.preventDefault();

            $.ajax({
                url: 'ajouter_fournisseur.php',
                method: 'POST',
                data: $(this).serialize(),
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        $('#ajouterFournisseurModal').modal('hide');
                        alert('Le fournisseur a été ajouté avec succès.');
                        location.reload()
                        // Rechargez ou mettez à jour la table des fournisseurs si nécessaire
                    } else {
                        $('#ajouterFournisseurResult').html('<div class="alert alert-danger">Erreur: ' + response.error + '</div>');
                    }
                },
                error: function(xhr, status, error) {
                    $('#ajouterFournisseurResult').html('<div class="alert alert-danger">Erreur de connexion au serveur.</div>');
                }
            });
        });
    });

    //  filtrer fournisseurs

    document.addEventListener('DOMContentLoaded', function() {
        function filterTable() {
            var lotFilter = document.getElementById('filterLotfourniseur').value.toLowerCase();
            var fournisseurFilter = document.getElementById('filterFournisseur').value.toLowerCase();

            var rows = document.querySelectorAll('#fournisseursTable tbody tr');

            rows.forEach(function(row) {
                var lotName = row.cells[1].textContent.toLowerCase(); // Colonne Lot
                var fournisseurName = row.cells[2].textContent.toLowerCase(); // Colonne Fournisseur

                var isLotMatch = lotName.includes(lotFilter);
                var isFournisseurMatch = fournisseurName.includes(fournisseurFilter);

                if (isLotMatch && isFournisseurMatch) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }

        document.getElementById('filterLotfourniseur').addEventListener('input', filterTable);
        document.getElementById('filterFournisseur').addEventListener('input', filterTable);
    });

//     modifier fournisseur

    // setTimeout(function (){
    //     $(document).ready(function() {
    //         // Lorsque le bouton de modification est cliqué
    //         $('.modifierFournisseurBtn').on('click', function() {
    //             var fournisseurId = $(this).data('id');
    //             var nomFournisseur = $(this).data('name');
    //             var lotFournisseur = $(this).data('lot');
    //
    //             // Remplir le modal avec les données actuelles
    //             $('#fournisseurId').val(fournisseurId);
    //             $('#nomFournisseur').val(nomFournisseur);
    //             $('#lotFournisseur').val(lotFournisseur);
    //
    //             // Afficher le modal
    //             $('#modifierFournisseurModal').modal('show');
    //         });
    //
    //         // Charger les options dans les datalists
    //         function loadOptions() {
    //             $.getJSON('get_fournisseurs.php', function(data) {
    //                 var fournisseurList = $('#fournisseurList');
    //                 fournisseurList.empty();
    //                 $.each(data, function(index, fournisseur) {
    //                     fournisseurList.append('<option value="' + fournisseur.nom_fournisseur + '">');
    //                 });
    //             });
    //
    //             $.getJSON('get_lot_f.php', function(data) {
    //                 var lotList = $('#lotList');
    //                 lotList.empty();
    //                 $.each(data, function(index, lot) {
    //                     lotList.append('<option value="' + lot.lot_name + '">');
    //                 });
    //             });
    //         }
    //
    //         // Charger les options au chargement de la page
    //         loadOptions();
    //     });
    //
    // } , 1100)

//  services codes :

//     ajouter service
    $(document).ready(function() {
        $('#addServiceForm').on('submit', function(event) {
            event.preventDefault(); // Empêche le rechargement de la page

            // Récupérer les valeurs des champs du formulaire
            const service = $('#service').val();
            const zone = $('#zone').val();
            const ref = $('#ref').val();
            const equip = $('#equip').val();

            // Effectuer une requête AJAX pour ajouter le service
            $.ajax({
                type: 'POST',
                url: 'ajouter_service.php', // Chemin vers le fichier PHP
                data: {
                    service: service,
                    zone: zone,
                    ref: ref,
                    equip: equip
                },
                dataType: 'json', // Attente d'une réponse JSON
                success: function(response) {
                    if (response.status === 'success') {
                        alert(response.message); // Message de succès
                        $('#addServiceModal').modal('hide'); // Fermer le modal
                        // Optionnel : rafraîchir la page ou mettre à jour le tableau
                        location.reload(); // Pour recharger la page
                    } else {
                        alert('Erreur : ' + response.message); // Message d'erreur
                    }
                },
                error: function(xhr, status, error) {
                    alert('Erreur lors de l\'ajout du service. Veuillez réessayer.'); // Message d'erreur générique
                }
            });
        });
    });

//     supprimer service
    $(document).ready(function() {
       setTimeout(()=>{
           $('.deleteServiceBtn').on('click', function(e) {
               e.preventDefault(); // Empêche la redirection par défaut

               const serviceId = $(this).data('id');

               if (confirm('Êtes-vous sûr de vouloir supprimer ce service ?')) {
                   $.ajax({
                       type: 'POST',
                       url: 'supprimer_service.php',
                       data: { id: serviceId },
                       dataType: 'json',
                       success: function(response) {
                           if (response.status === 'success') {
                               alert(response.message);
                               location.reload(); // Rafraîchir la page pour mettre à jour le tableau
                           } else {
                               alert('Erreur : ' + response.message);
                           }
                       },
                       error: function(xhr, status, error) {
                           alert('Erreur lors de la suppression. Veuillez réessayer.');
                       }
                   });
               }
           });

       },100)
    });






</script>

<!-- jQuery -->

<!-- Bootstrap JS -->
<!--<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>-->


</body>
</html>
