<?php $pageName = 'lot / sous lot'; include '../../config/connect_db.php'; include '../../includes/header.php'; ?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="stylesheet" href="../../includes/css/bootstrap.min.css">
    <script src="../../includes/js/jquery.min.js"></script> <!-- Assurez-vous d'utiliser la version complète -->
    <script src="../../includes/js/bootstrap.bundle.min.js"></script>
    <title>Document</title>
</head>
<body>

<style>
    .table1 {
        width: 40%;
        display: flex;
        justify-content: center;
        align-items: center;
    }
</style>

<div class="ajouter_table1">
    <h4>ajouter un nouveau lot</h4>
    <button type="button" class="btn btn-success" id="openAddLotModal">
        Ajouter un nouveau lot
    </button>


</div>
<!-- Modal d'ajout de lot -->
<div class="modal fade" id="ajouterLotModal" tabindex="-1" aria-labelledby="ajouterLotModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content ajout_catalog">
            <div class="modal-header">
                <h5 class="modal-title" id="ajouterLotModalLabel">Ajouter un nouveau lot</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
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


<div class="table1">
    <!-- Le tableau de données sera inséré ici via AJAX -->
</div>
<div class="ajouter_table2"></div>
<div class="table2">
    <!-- Autres contenus -->
</div>

<script>
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
        $(document).on('click', '.modify-btn', function(e) {
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

    $(document).ready(function() {
        // Gérer le clic sur le bouton d'ajout de lot
        $('#openAddLotModal').on('click', function(e) {
            e.preventDefault();

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
                        // Rechargez ou mettez à jour la table des lots ici si nécessaire
                        $.ajax({
                            url: 'lot_table.php',
                            method: 'GET',
                            success: function(response) {
                                $('.table1').html(response);
                            }
                        });
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



</script>
</body>
</html>
