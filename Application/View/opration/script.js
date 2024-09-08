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
            var dateCell = rows[i].getElementsByTagName('td')[2]; // La date est dans la 3e colonne (index 2)
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
                serviceSelect.disabled = false;
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
        } else {
            // Si le champ "entrée" est vide
            document.getElementById('sortie').disabled = false;
            document.getElementById('service').disabled = false;
            document.getElementById('fournisseur').disabled = false;
        }
    });

    document.getElementById('sortie').addEventListener('input', function() {
        if (this.value) {
            // Si le champ "sortie" n'est pas vide
            document.getElementById('entree').disabled = true;
            document.getElementById('fournisseur').disabled = true;
            document.getElementById('service').disabled = false;
        } else {
            // Si le champ "sortie" est vide
            document.getElementById('entree').disabled = false;
            document.getElementById('fournisseur').disabled = false;
            document.getElementById('service').disabled = false;
        }
    });

});


// modifier operation codes

$(document).ready(function() {
    // Ouvrir le modal avec les données actuelles de l'article
   setTimeout(()=>{
       $(document).on('click', '.btn-modifier-article', function () {
           const articleId = $(this).data('id');
           $('#modifierArticleModal').modal('show');
           // Faire une requête pour récupérer les informations de l'article
           $.ajax({
               url: 'get_article_details.php', // Un fichier PHP qui récupère les détails d'un article
               type: 'GET',
               data: { id_article: articleId },
               success: function(response) {
                   $('#submitButton').prop('disabled', false);  // Réactiver le bouton

                   console.log("Réponse du serveur : ", response);  // Affiche la réponse pour débogage

                   try {
                       var data = JSON.parse(response);  // Tente de parser la réponse JSON
                       if (data.status === 'success') {
                           alert(data.message);  // Affiche le message de succès
                       } else {
                           alert(data.message);  // Affiche le message d'erreur
                       }
                   } catch (e) {
                       console.error("Erreur lors du parsing JSON:", e);
                       alert('Réponse inattendue du serveur.');
                   }
               }


           });
       });

       // Désactiver le bouton de soumission lors de l'envoi du formulaire
       $('#formulaire').on('submit', function(e) {
           e.preventDefault(); // Empêche l'envoi du formulaire normal

           // Crée un objet FormData à partir du formulaire
           var formData = new FormData(this);

           $('#modifierArticleForm').prop('disabled', true); // Désactiver le bouton de soumission

           $.ajax({
               url: 'modifier_article.php',
               type: 'POST',
               data: formData,
               processData: false, // Indispensable pour envoyer des données au format FormData
               contentType: false, // Empêche jQuery de définir un Content-Type incorrect
               success: function(response) {
                   $('#submitButton').prop('disabled', false);  // Réactiver le bouton
                   try {
                       var data = JSON.parse(response);
                       if (data.status === 'success') {
                           alert(data.message);  // Affiche le message de succès
                       } else {
                           alert(data.message);  // Affiche le message d'erreur
                       }
                   } catch (e) {
                       console.error("Erreur lors du parsing JSON:", e);
                       alert('Réponse inattendue du serveur.');
                   }
               },
               error: function(xhr, status, error) {
                   $('#submitButton').prop('disabled', false);  // Réactiver le bouton
                   console.error('Erreur AJAX:', xhr, status, error);
                   alert('Une erreur est survenue : ' + error);
               }
           });
       });



   } , 100)


});


