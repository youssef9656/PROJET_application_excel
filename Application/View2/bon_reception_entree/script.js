$(document).ready(function() {
    // Charger les données de la table via AJAX
    $.ajax({
        url: 'bon_entree_table.php',
        method: 'GET',
        success: function (response) {
            $('.table_entree').html(response);
        },
        error: function (xhr, status, error) {
            console.error('Une erreur s\'est produite:', status, error);
        }
    });
    $(document).ready(function () {
        $.ajax({
            url: 'path/to/get_fournisseurs.php', // Mettez ici le bon chemin vers votre fichier PHP
            method: 'GET',
            success: function (data) {
                data.forEach(function (fournisseur) {
                    $('#fournisseur').append(`<option value="${fournisseur.nom_fournisseur}">${fournisseur.nom_fournisseur}</option>`);
                });
            }
        });

        // Ajoutez ici le code pour charger les lots et sous-lots de manière similaire

        $('#filter_btn').click(function () {
            // Code AJAX pour appliquer les filtres...
        });
    });

});
