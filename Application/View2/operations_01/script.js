// filtrer les operations par date
document.addEventListener('DOMContentLoaded', ()=>{
    document.body.style.filter = "none";
})

setTimeout(() => {


    // reclamation code :
    // Get the modal and form elements
    var reclamationModal = document.getElementById('reclamationModal');
    var reclamationForm = document.getElementById('reclamationForm');
    var operationIdInput = document.getElementById('operationId');

    // Add an event listener to the modal to capture the operation ID
    reclamationModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget; // Button that triggered the modal
        var operationId = button.getAttribute('data-operation-id'); // Extract info from data-* attributes
        operationIdInput.value = operationId; // Update the hidden input field
    });

    // Add an event listener to the form to handle the submission
    reclamationForm.addEventListener('submit', function (event) {
        event.preventDefault(); // Prevent default form submission

        var operationId = operationIdInput.value;
        var reclamationText = document.getElementById('reclamationText').value;

        // Send an AJAX request to save the reclamation
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "enregistrer_reclamation.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        xhr.onreadystatechange = function() {
            if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {
                var response = JSON.parse(this.responseText);
                if (response.success)
                {
                    // Rediriger l'utilisateur vers la page avec le message de succès
                    window.location.href = "option_Ent_Sor.php?message=" + encodeURIComponent(response.message);
                } else {
                    // Afficher un message d'erreur à l'utilisateur (par exemple, avec une alerte)
                    alert(response.message);
                }
                reclamationModal.hide(); // Close the modal
            }
        };

        xhr.send("operationId=" + operationId + "&reclamationText=" + reclamationText);
    });


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

function envoyerRequete2() {
    var xhr = new XMLHttpRequest();
    xhr.open("GET", "ajouter_operation.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    // Envoi de la requête AJAX
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            // Récupérer la réponse JSON
            var response = JSON.parse(xhr.responseText);

            // Optionnel : Ajouter une classe pour styliser le message (success ou error)
            if (response.status === 'ss') {
                console.log('1234')

            }
        }
    };
}
envoyerRequete2()

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
                    serviceSelect.innerHTML += '<option value="' + service.id + '">' + service.service + '</option>';
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
                    fournisseurSelect.innerHTML += '<option value="' + fournisseur.id_fournisseur + '">' + fournisseur.nom_fournisseur + "  "+ fournisseur.prenom_fournisseur + '</option>';
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


document.addEventListener('DOMContentLoaded', function () {
    setTimeout(() => {

        document.getElementById('entree_modifier').addEventListener('input', function() {
            if (this.value) {
                // Si le champ "entrée" n'est pas vide
                document.getElementById('sortie_modifier').disabled = true;
                document.getElementById('service_modifier').disabled = true;
                document.getElementById('fournisseur_modifier').disabled = false;
                document.getElementById('prix_modifier').disabled = false;
            } else {
                // Si le champ "entrée" est vide
                document.getElementById('sortie_modifier').disabled = false;
                document.getElementById('service_modifier').disabled = true;
                document.getElementById('fournisseur_modifier').disabled = true;
            }


            document.getElementById('sortie_modifier').addEventListener('input', function() {

                if (this.value) {
                    console.log(document.getElementById('sortie_modifier'))
                    // Si le champ "sortie" n'est pas vide
                    document.getElementById('entree_modifier').disabled = true;
                    document.getElementById('fournisseur_modifier').disabled = true;
                    document.getElementById('service_modifier').disabled = false;
                    document.getElementById('prix_modifier').disabled = true
                } else {
                    // Si le champ "sortie" est vide
                    document.getElementById('entree_modifier').disabled = false;
                    document.getElementById('fournisseur_modifier').disabled = true;
                    document.getElementById('service_modifier').disabled = true;
                }
            })

        })

        const modifierButtons = document.querySelectorAll('.modify-btn');
        const lotModifier = document.getElementById('lot-modifier');
        const sousLotModifier = document.getElementById('sousLot-modifier');
        const articleModifier = document.getElementById('article-modifier');
        const fournisseurModifier = document.getElementById('fournisseur_modifier');
        const serviceModifier = document.getElementById('service_modifier');
        const dateOperationModifier = document.getElementById('date_operation');
        const operationIdInput = document.getElementById('operation-id');

        modifierButtons.forEach(button => {
            button.addEventListener('click', function () {
                const operationId = this.getAttribute('data-id');
                const lotName = this.getAttribute('data-lot');
                const sousLotName = this.getAttribute('data-sous-lot');
                const articleName = this.getAttribute('data-article');
                const sortie_value = this.getAttribute('data-sortie');


                document.getElementById('sortie_value').value = sortie_value

                // Remplir le modal avec les données existantes
                operationIdInput.value = operationId;

                // Charge les options du lot
                fetch('get_lots.php')
                    .then(response => response.json())
                    .then(data => {
                        lotModifier.innerHTML = '<option value="">-- Sélectionner Lot --</option>';
                        data.forEach(lot => {
                            const option = document.createElement('option');
                            option.value = lot.lot_id;
                            option.textContent = lot.lot_name;
                            if (lot.lot_name === lotName) {
                                option.selected = true;
                            }
                            lotModifier.appendChild(option);
                        });
                        lotModifier.dispatchEvent(new Event('change')); // Déclenche l'événement pour charger les sous-lots
                    });

                // Charge les options du sous-lot, article, fournisseur, et service en fonction du lot sélectionné
                lotModifier.addEventListener('change', function () {
                    const lotId = this.value;
                    fetch(`get_sous_lots.php?lot_id=${lotId}`)
                        .then(response => response.json())
                        .then(data => {
                            sousLotModifier.innerHTML = '<option value="">-- Sélectionner Sous-lot --</option>';
                            data.forEach(sousLot => {
                                const option = document.createElement('option');
                                option.value = sousLot.sous_lot_id;
                                option.textContent = sousLot.sous_lot_name;
                                sousLotModifier.appendChild(option);
                            });
                            sousLotModifier.disabled = !lotId;
                            sousLotModifier.dispatchEvent(new Event('change')); // Déclenche l'événement pour charger les articles
                        });
                });

                sousLotModifier.addEventListener('change', function () {
                    const sousLotId = this.value;
                    fetch(`get_articles.php?sous_lot_id=${sousLotId}`)
                        .then(response => response.json())
                        .then(data => {
                            articleModifier.innerHTML = '<option value="">-- Sélectionner Article --</option>';
                            data.forEach(article => {
                                const option = document.createElement('option');
                                option.value = article.id_article;
                                option.textContent = article.nom;
                                articleModifier.appendChild(option);
                            });
                            articleModifier.disabled = !sousLotId;
                        });
                });

                lotModifier.addEventListener('change', function () {
                    const articleId = this.value;

                    fetch(`get_fournisseurs.php?lot_id=${articleId}`)
                        .then(response => response.json())
                        .then(data => {
                            fournisseurModifier.innerHTML = '<option value="">-- Sélectionner Fournisseur --</option>';
                            data.forEach(fournisseur => {
                                const option = document.createElement('option');
                                option.value = fournisseur.id_fournisseur;
                                option.textContent = fournisseur.nom_fournisseur +" "+ fournisseur.prenom_fournisseur;
                                fournisseurModifier.appendChild(option);
                            });
                            fournisseurModifier.disabled = !articleId;
                        });

                    fetch(`get_services.php?article_id=${articleId}`)
                        .then(response => response.json())
                        .then(data => {
                            serviceModifier.innerHTML = '<option value="">-- Sélectionner Service --</option>';
                            data.forEach(service => {
                                const option = document.createElement('option');
                                option.value = service.id;
                                option.textContent = service.service;
                                serviceModifier.appendChild(option);
                            });
                            serviceModifier.disabled = !articleId;
                        });
                });

                // Pré-remplir les champs restants
                fetch(`get_operation_details.php?operation_id=${operationId}`)
                    .then(response => response.json())
                    .then(data => {
                        // Remplir les champs du modal avec les détails de l'opération
                        if (data) {
                            sousLotModifier.value = data.lot_name;
                            articleModifier.value = data.nom_article;
                            fournisseurModifier.value = data.nom_pre_fournisseur;
                            serviceModifier.value = data.service_operation;

                            // dateOperationModifier.value = data.date_operation;
                            const formattedDate = data.date_operation.replace(" ", "T").substring(0, 16);
                            dateOperationModifier.value = formattedDate;

                            // Remplir les champs supplémentaires
                            document.getElementById('ref-modifier').value = data.ref;
                            document.getElementById('entree_modifier').value = data.entree;
                            document.getElementById('sortie_modifier').value = data.sortie;
                            document.getElementById('prix_modifier').value = data.prix;
                        }
                    });



                function envoyerRequete() {
                    var xhr = new XMLHttpRequest();
                    xhr.open("GET", "modifier_operation.php", true);
                    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

                    // Envoi de la requête AJAX
                    xhr.onreadystatechange = function() {
                        if (xhr.readyState === 4 && xhr.status === 200) {
                            // Récupérer la réponse JSON
                            var response = JSON.parse(xhr.responseText);

                            // Optionnel : Ajouter une classe pour styliser le message (success ou error)
                            if (response.status === 'success') {

                                console.log('1234')


                            }
                        }
                    };
                }

                envoyerRequete()
                // Ouvrir le modal
                const modal = new bootstrap.Modal(document.getElementById('modifierOperationModal'));
                modal.show();
            });
        });

    }, 100);
});

// les code de modale de saisir le mot de pass
function ret(){
    // $('#modifierOperationModal').hide()
    location.reload()
}

// functions article filter


    function populateDatalist() {
        const datalist = document.getElementById('article_list');
        const rows = document.querySelectorAll('#operationTable tbody tr');
        const articles = new Set(); // Utilisation de Set pour éviter les doublons

        rows.forEach(row => {
            const article = row.querySelector('td').textContent.trim(); // Extraire le contenu de la première cellule
            articles.add(article); // Ajouter l'article au Set
        });

        // Vider la datalist avant de la remplir
        datalist.innerHTML = '';

        // Ajouter les articles à la datalist
        articles.forEach(article => {
            const option = document.createElement('option');
            option.value = article;
            datalist.appendChild(option);
        });
    }



    // Appeler la fonction pour remplir la datalist après le chargement du DOM
    document.addEventListener('DOMContentLoaded',()=>{
        setTimeout(()=>{
            populateDatalist()
        },1000)
    });
function filterArticle(){
    populateDatalist(); // Appelle la fonction pour mettre à jour le datalist, si nécessaire
    const filter = document.getElementById('article_filter').value.toLowerCase(); // Convertir en minuscule pour une comparaison insensible à la casse
    const rows = document.querySelectorAll('#tbodyTableOperation tr');

    rows.forEach(row => {
        const article = row.querySelector('td').textContent.toLowerCase(); // Convertir en minuscule pour correspondre au filtre
        if (article.includes(filter)) {
            console.log(1);
            console.log(row);
            row.style.display = ''; // Affiche la ligne (valeur par défaut pour les éléments de tableau)
        } else {
            console.log(0);
            console.log(row);
            row.style.display = 'none'; // Cache la ligne
        }
    });
}




