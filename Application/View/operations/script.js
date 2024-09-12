// filtrer les operations par date


setTimeout(() => {
    document.getElementById('filterBtn').addEventListener('click', function () {
        // Récupérer les valeurs des inputs
        var startDate = document.getElementById('startDate').value;
        var endDate = document.getElementById('endDate').value;

        if (startDate === '' || endDate === '') {
            alert("Veuillez sélectionner une plage de dates.");
            return;
        }

        // Convertir les dates en objets Date pour comparaison
        var start = new Date(startDate);
        var end = new Date(endDate);

        // Parcourir les lignes du tableau et appliquer le filtre
        var table = document.getElementById('operationTable');
        var rows = table.getElementsByTagName('tbody')[0].getElementsByTagName('tr');

        for (var i = 0; i < rows.length; i++) {
            var dateCell = rows[i].getElementsByTagName('td')[1]; // La date est dans la 3e colonne (index 2)
            var dateText = dateCell.innerText.trim();

            // Convertir la date de la ligne en objet Date
            var operationDate = new Date(dateText);

            // Comparer la date de l'opération avec la plage de dates sélectionnée
            if (operationDate >= start && operationDate <= end) {
                rows[i].style.display = ''; // Afficher la ligne si elle est dans la plage de dates
            } else {
                rows[i].style.display = 'none'; // Masquer la ligne si elle n'est pas dans la plage de dates
            }
        }
    });

    document.getElementById('afficher_tous').addEventListener('click', function () {
        location.reload()
    })

}, 1000)


// ajouter operation
document.addEventListener('DOMContentLoaded', function() {
    // Gérer le changement de lot pour charger les sous-lots et les fournisseurs
    document.getElementById('lot').addEventListener('change', function() {
        var lotId = this.value;
        if (lotId) {
            fetchSousLots(lotId);
            fetchFournisseurs(lotId);  // Ajouter la fonction pour récupérer les fournisseurs
        } else {
            document.getElementById('sousLot').disabled = true;
            document.getElementById('article').disabled = true;
            document.getElementById('fournisseur').disabled = true;
            document.getElementById('sousLot').innerHTML = '<option value="">-- Sélectionner Sous-lot --</option>';
            document.getElementById('article').innerHTML = '<option value="">-- Sélectionner Article --</option>';
            document.getElementById('fournisseur').innerHTML = '<option value="">-- Sélectionner Fournisseur --</option>';
        }
    });

    // Gérer le changement de sous-lot pour charger les articles
    document.getElementById('sousLot').addEventListener('change', function() {
        var sousLotId = this.value;
        if (sousLotId) {
            fetchArticles(sousLotId);
        } else {
            document.getElementById('article').disabled = true;
            document.getElementById('article').innerHTML = '<option value="">-- Sélectionner Article --</option>';
        }
    });

    // Fonction pour récupérer les sous-lots via AJAX
    function fetchSousLots(lotId) {
        var xhr = new XMLHttpRequest();
        xhr.open('GET', 'get_sous_lots.php?lot_id=' + lotId, true);
        xhr.onload = function() {
            if (xhr.status === 200) {
                var sousLots = JSON.parse(xhr.responseText);
                var sousLotSelect = document.getElementById('sousLot');
                sousLotSelect.disabled = false;
                sousLotSelect.innerHTML = '<option value="">-- Sélectionner Sous-lot --</option>';
                sousLots.forEach(function(sousLot) {
                    sousLotSelect.innerHTML += '<option value="' + sousLot.sous_lot_id + '">' + sousLot.sous_lot_name + '</option>';
                });
            } else {
                console.error("Erreur de requête AJAX pour les sous-lots.");
            }
        };
        xhr.onerror = function() {
            console.error("Erreur de requête AJAX.");
        };
        xhr.send();
    }

    // Fonction pour récupérer les articles via AJAX
    function fetchArticles(sousLotId) {
        var xhr = new XMLHttpRequest();
        xhr.open('GET', 'get_articles.php?sous_lot_id=' + sousLotId, true);
        xhr.onload = function() {
            if (xhr.status === 200) {
                var articles = JSON.parse(xhr.responseText);
                var articleSelect = document.getElementById('article');
                articleSelect.disabled = false;
                articleSelect.innerHTML = '<option value="">-- Sélectionner Article --</option>';
                articles.forEach(function(article) {
                    articleSelect.innerHTML += '<option value="' + article.id_article + '">' + article.nom + '</option>';
                });
            } else {
                console.error("Erreur de requête AJAX pour les articles.");
            }
        };
        xhr.onerror = function() {
            console.error("Erreur de requête AJAX.");
        };
        xhr.send();
    }

    function fetchServices() {
        var xhr = new XMLHttpRequest();
        xhr.open('GET', 'get_services.php', true);
        xhr.onload = function() {
            if (xhr.status === 200) {
                var services = JSON.parse(xhr.responseText);
                var serviceSelect = document.getElementById('service');
                serviceSelect.disabled = true;
                serviceSelect.innerHTML = '<option value="">-- Sélectionner Service --</option>';
                services.forEach(function(service) {
                    serviceSelect.innerHTML += '<option value="' + service.id + '">' + service.nom_service + '</option>';
                });
            }
        };
        xhr.onerror = function() {
            console.error("Erreur de requête AJAX.");
        };
        xhr.send();
    }

    fetchServices();
    // Fonction pour récupérer les fournisseurs via AJAX
    function fetchFournisseurs(lotId) {
        var xhr = new XMLHttpRequest();
        xhr.open('GET', 'get_fournisseurs.php?lot_id=' + lotId, true);
        xhr.onload = function() {
            if (xhr.status === 200) {
                var fournisseurs = JSON.parse(xhr.responseText);
                var fournisseurSelect = document.getElementById('fournisseur');
                fournisseurSelect.disabled = false;
                fournisseurSelect.innerHTML = '<option value="">-- Sélectionner Fournisseur --</option>';
                fournisseurs.forEach(function(fournisseur) {
                    fournisseurSelect.innerHTML += '<option value="' + fournisseur.id_fournisseur + '">' + fournisseur.nom_fournisseur + '</option>';
                });
            } else {
                console.error("Erreur de requête AJAX pour les fournisseurs.");
            }
        };
        xhr.onerror = function() {
            console.error("Erreur de requête AJAX.");
        };
        xhr.send();
    }

    // Gestion du blocage des champs en fonction de l'entrée et de la sortie
    document.getElementById('entree').addEventListener('input', function() {
        if (this.value) {
            // Si le champ "entrée" n'est pas vide
            document.getElementById('sortie').disabled = true;
            document.getElementById('service').disabled = true;
            document.getElementById('fournisseur').disabled = false;
            document.getElementById('prix').disabled = false;
        } else {
            // Si le champ "entrée" est vide
            document.getElementById('sortie').disabled = false;
            document.getElementById('service').disabled = true;
            document.getElementById('fournisseur').disabled = true;
        }
    });

    document.getElementById('sortie').addEventListener('input', function() {
        if (this.value) {
            // Si le champ "sortie" n'est pas vide
            document.getElementById('entree').disabled = true;
            document.getElementById('fournisseur').disabled = true;
            document.getElementById('service').disabled = false;
            document.getElementById('prix').disabled = true
        } else {
            // Si le champ "sortie" est vide
            document.getElementById('entree').disabled = false;
            document.getElementById('fournisseur').disabled = true;
            document.getElementById('service').disabled = true;
        }
    });

});


// modifier operation codes


$(document).ready(function() {
    // Ouvrir le modal avec les données actuelles de l'opération
    setTimeout(function () {

        $(document).ready(function() {
            $('#modifierOperationForm').on('submit', function(e) {
                e.preventDefault(); // Empêcher le rechargement de la page

                var id = $('#operationId').val();
                if (!id) {
                    alert('ID de l\'opération est manquant.');
                    return;
                }

                var formData = $(this).serialize(); // Sérialiser les données du formulaire

                $.ajax({
                    type: 'POST',
                    url: 'modifier_operation.php', // Page PHP qui traite la modification
                    data: formData,
                    success: function(response) {
                        alert('Opération modifiée avec succès');
                        $('#modifierOperationModal').modal('hide'); // Fermer le modal
                        location.reload(); // Rafraîchir la page pour voir les changements
                    },
                    error: function(xhr, status, error) {
                        alert('Erreur lors de la modification de l\'opération : ' + error);
                    }
                });
            });

            // Ouvrir le modal avec les données actuelles de l'opération
            $(document).on('click', '.modify-btn', function() {
                var id = $(this).data('id');
                var lotId = $(this).data('lot-id');
                var sousLotId = $(this).data('sous-lot-id');
                var articleId = $(this).data('article-id');
                var date = $(this).closest('tr').find('td:nth-child(3)').text().trim();
                var entree = $(this).closest('tr').find('td:nth-child(4)').text().trim();
                var sortie = $(this).closest('tr').find('td:nth-child(5)').text().trim();
                var fournisseur = $(this).closest('tr').find('td:nth-child(7)').text().trim();
                var prix = $(this).closest('tr').find('td:nth-child(10)').text().trim();
                var service = $(this).closest('tr').find('td:nth-child(9)').text().trim();

                // Convertir la date au format requis pour datetime-local
                var formattedDate = new Date(date).toISOString().slice(0,16); // Format YYYY-MM-DDTHH:MM

                $('#operationId').val(id);
                $('#operationDate').val(formattedDate);
                $('#operationEntree').val(entree);
                $('#operationSortie').val(sortie);
                $('#operationFournisseur').val(fournisseur);
                $('#operationPrix').val(prix);
                $('#operationService').val(service);

                // Charger les options des selects
                loadOptions('get_lots.php', '#operationLot', lotId, 'lot_id', 'lot_name');
                loadOptions('get_sous_lots.php', '#operationSousLot', sousLotId, 'sous_lot_id', 'sous_lot_name', { lot_id: lotId });
                loadOptions('get_articles.php', '#operationArticle', articleId, 'id_article', 'nom', { sous_lot_id: sousLotId });
                loadOptions('get_fournisseurs.php', '#operationFournisseur', fournisseur, 'id_fournisseur', 'nom_fournisseur', { lot_id: lotId });
                loadOptions('get_services.php', '#operationService', service, 'id', 'nom_service');

                $('#modifierOperationModal').modal('show');
            });

            // Fonction pour charger les options dans un select
            function loadOptions(url, selectId, selectedId, idField, nameField, params = {}) {
                $.ajax({
                    url: url,
                    method: 'GET',
                    data: params,
                    success: function(data) {
                        try {
                            var options = JSON.parse(data);
                            var select = $(selectId);
                            select.empty(); // Vider les options existantes
                            select.append('<option value="">Sélectionner</option>'); // Option par défaut
                            $.each(options, function(index, item) {
                                var selected = item[idField] == selectedId ? ' selected' : '';
                                select.append('<option value="' + item[idField] + '"' + selected + '>' + item[nameField] + '</option>');
                            });
                        } catch (e) {
                            console.error('Erreur de parsing JSON :', e);
                        }
                    },
                    error: function(xhr, status, error) {
                        alert('Erreur lors du chargement des options : ' + error);
                    }
                });
            }

            // Gestion des champs
            $('#operationEntree').on('input', function() {
                var entree = $(this).val();
                $('#operationSortie').prop('disabled', entree.length > 0);
                $('#operationFournisseur').prop('disabled', entree.length > 0);
            });

            $('#operationSortie').on('input', function() {
                var sortie = $(this).val();
                $('#operationEntree').prop('disabled', sortie.length > 0);
                $('#operationFournisseur').prop('disabled', sortie.length > 0);
            });

            // Charger les sous-lots lorsque le lot change
            $('#operationLot').on('change', function() {
                var lotId = $(this).val();
                loadOptions('get_sous_lots.php', '#operationSousLot', '', 'sous_lot_id', 'sous_lot_name', { lot_id: lotId });
                $('#operationArticle').empty().append('<option value="">Sélectionner</option>'); // Réinitialiser les articles
            });

            // Charger les articles lorsque le sous-lot change
            $('#operationSousLot').on('change', function() {
                var sousLotId = $(this).val();
                loadOptions('get_articles.php', '#operationArticle', '', 'id_article', 'nom', { sous_lot_id: sousLotId });
            });
        });









    }, 100)


});


