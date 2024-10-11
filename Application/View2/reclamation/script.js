document.querySelectorAll('.note-div').forEach(noteDiv => {
    const contentHeight = noteDiv.offsetHeight;
    noteDiv.querySelectorAll('.note-ligne').forEach(noteLigne => {
        noteLigne.style.height = `${contentHeight - 10}px`;
        // noteLigne.style.width = "5px"
    });
});

// $(document).on('click', '.modifier-operation', function() {
//     var operationId = $(this).data('id'); // Récupérer l'ID de l'opération à partir de l'attribut data-id du bouton
//
//     // Faire une requête AJAX pour obtenir les données de l'opération
//     $.ajax({
//         url: 'get_operation.php', // Page qui récupérera les données de l'opération
//         method: 'POST',
//         data: { operation_id: operationId }, // Envoyer l'ID de l'opération au serveur
//         success: function(response) {
//             var data = JSON.parse(response); // Analyser la réponse JSON
//
//             // Pré-remplir les champs du modal avec les données récupérées
//             $('#operationId').val(data.id); // Champ caché pour l'ID de l'opération
//             $('#lot').val(data.lot_id); // Assurez-vous que 'lot_id' est la valeur à utiliser
//             $('#sousLot').val(data.sous_lot_id); // Assurez-vous que 'sous_lot_id' est correct
//             $('#article').val(data.article_id); // ID de l'article
//             $('#fournisseur').val(data.fournisseur_id); // ID du fournisseur
//             $('#service').val(data.service_id); // ID du service
//             $('#ref').val(data.ref); // Référence
//             $('#entree').val(data.entree); // Montant d'entrée
//             $('#sortie').val(data.sortie); // Montant de sortie
//             $('#prix').val(data.prix); // Prix
//             $('#date_operation').val(data.date_operation); // Date de l'opération
//
//             // Afficher le modal
//             $('#modifierOperationModal').modal('show'); // Ouvrir le modal
//         },
//         error: function(xhr, status, error) {
//             console.error("Erreur lors de la récupération des données : ", error); // Gérer les erreurs
//         }
//     });
// });
//
// $('#modifierOperationForm').submit(function(e) {
//     e.preventDefault();
//
//     var formData = $(this).serialize();
//
//     $.ajax({
//         url: 'modifier_operation.php',
//         method: 'POST',
//         data: formData,
//         success: function(response) {
//             // Fermer le modal et afficher un message de succès
//             $('#modifierOperationModal').modal('hide');
//             alert('Opération modifiée avec succès');
//
//             // Rafraîchir le tableau des opérations ou faire un rechargement AJAX pour refléter les modifications
//         }
//     });
// });
//
// $(document).ready(function() {
//     // Fonction pour charger les lots dans le modal
//     function loadLots() {
//         $.ajax({
//             url: 'get_lots.php',
//             type: 'GET',
//             success: function(response) {
//                 var lots = JSON.parse(response);
//                 var lotSelect = $('#lot'); // Sélecteur du champ Lot dans le modal
//
//                 lotSelect.empty(); // Vider les options existantes
//                 lotSelect.append('<option value="">Sélectionnez un lot</option>'); // Option par défaut
//
//                 lots.forEach(function(lot) {
//                     lotSelect.append('<option value="' + lot.lot_id + '">' + lot.lot_name + '</option>');
//                 });
//             },
//             error: function(xhr, status, error) {
//                 console.error('Erreur lors du chargement des lots:', error);
//             }
//         });
//     }
//
//     // Fonction pour charger les sous-lots en fonction du lot sélectionné
//     function loadSousLots(lotId) {
//         if (lotId) {
//             $.ajax({
//                 url: 'get_sous_lots.php',
//                 type: 'GET',
//                 data: { lot_id: lotId },
//                 success: function(response) {
//                     var sousLots = JSON.parse(response);
//                     var sousLotSelect = $('#sousLot');
//
//                     sousLotSelect.empty(); // Vider les options existantes
//                     sousLotSelect.append('<option value="">Sélectionnez un sous-lot</option>'); // Option par défaut
//                     sousLotSelect.prop('disabled', sousLots.length === 0);
//
//                     sousLots.forEach(function(sousLot) {
//                         sousLotSelect.append('<option value="' + sousLot.sous_lot_id + '">' + sousLot.sous_lot_name + '</option>');
//                     });
//                 },
//                 error: function(xhr, status, error) {
//                     console.error('Erreur lors du chargement des sous-lots:', error);
//                 }
//             });
//         } else {
//             $('#sousLot').prop('disabled', true).empty().append('<option value="">Sélectionnez un sous-lot</option>');
//         }
//     }
//
//     // Fonction pour charger les articles en fonction du sous-lot sélectionné
//     function loadArticles(sousLotId) {
//         if (sousLotId) {
//             $.ajax({
//                 url: 'get_articles.php',
//                 type: 'GET',
//                 data: { sous_lot_id: sousLotId },
//                 success: function(response) {
//                     var articles = JSON.parse(response);
//                     var articleSelect = $('#article');
//
//                     articleSelect.empty(); // Vider les options existantes
//                     articleSelect.append('<option value="">Sélectionnez un article</option>'); // Option par défaut
//                     articleSelect.prop('disabled', articles.length === 0);
//
//                     articles.forEach(function(article) {
//                         articleSelect.append('<option value="' + article.id_article + '">' + article.nom + '</option>');
//                     });
//                 },
//                 error: function(xhr, status, error) {
//                     console.error('Erreur lors du chargement des articles:', error);
//                 }
//             });
//         } else {
//             $('#article').prop('disabled', true).empty().append('<option value="">Sélectionnez un article</option>');
//         }
//     }
//
//     function loadFournisseurs(lotId) {
//         if (lotId) {
//             $.ajax({
//                 url: 'get_fournisseurs.php',
//                 type: 'GET',
//                 data: { lot_id: lotId },
//                 success: function(response) {
//                     var fournisseurs = JSON.parse(response);
//                     var fournisseurSelect = $('#fournisseur');
//
//                     fournisseurSelect.empty(); // Vider les options existantes
//                     fournisseurSelect.append('<option value="">Sélectionnez un fournisseur</option>'); // Option par défaut
//                     fournisseurSelect.prop('disabled', fournisseurs.length === 0);
//
//                     fournisseurs.forEach(function(fournisseur) {
//                         fournisseurSelect.append('<option value="' + fournisseur.id_fournisseur + '">' + fournisseur.nom_fournisseur + ' ' + fournisseur.prenom_fournisseur + '</option>');
//                     });
//                 },
//                 error: function(xhr, status, error) {
//                     console.error('Erreur lors du chargement des fournisseurs:', error);
//                 }
//             });
//         } else {
//             $('#fournisseur').prop('disabled', true).empty().append('<option value="">Sélectionnez un fournisseur</option>');
//         }
//     }
//
//
//     // Charger les lots lorsque le modal s'ouvre
//     $('#modifierOperationModal').on('show.bs.modal', function() {
//         loadLots();
//     });
//
//     // Charger les sous-lots lorsque le lot est sélectionné
//     $('#lot').on('change', function() {
//         var lotId = $(this).val();
//         loadSousLots(lotId);
//         loadFournisseurs(lotId); // Charger les fournisseurs lorsque le lot est sélectionné
//     })
//
//     // Charger les articles lorsque le sous-lot est sélectionné
//     $('#sousLot').on('change', function() {
//         var sousLotId = $(this).val();
//         loadArticles(sousLotId);
//     });
// });


























// document.addEventListener('DOMContentLoaded', function () {
//     setTimeout(() => {
//         // Gère l'activation/désactivation des champs en fonction de l'entrée/sortie
//         document.getElementById('entree').addEventListener('input', function() {
//             if (this.value) {
//                 document.getElementById('sortie').disabled = true;
//                 document.getElementById('service').disabled = true;
//                 document.getElementById('fournisseur').disabled = false;
//                 document.getElementById('prix').disabled = false;
//             } else {
//                 document.getElementById('sortie').disabled = false;
//                 document.getElementById('service').disabled = true;
//                 document.getElementById('fournisseur').disabled = true;
//             }
//         });
//
//         document.getElementById('sortie').addEventListener('input', function() {
//             if (this.value) {
//                 document.getElementById('entree').disabled = true;
//                 document.getElementById('fournisseur').disabled = true;
//                 document.getElementById('service').disabled = false;
//                 document.getElementById('prix').disabled = true;
//             } else {
//                 document.getElementById('entree').disabled = false;
//                 document.getElementById('fournisseur').disabled = true;
//                 document.getElementById('service').disabled = true;
//             }
//         });
//
//         const modifierButtons = document.querySelectorAll('.modifier-operation');
//         const lotModifier = document.getElementById('lot');
//         const sousLotModifier = document.getElementById('sousLot');
//         const articleModifier = document.getElementById('article');
//         const fournisseurModifier = document.getElementById('fournisseur');
//         const serviceModifier = document.getElementById('service');
//         const dateOperationModifier = document.getElementById('date_operation');
//         const operationIdInput = document.getElementById('operationId');
//         const reclamationModal = document.querySelector('#text-reclamation-modal');
//
//         // Écouter les événements sur les boutons de modification
//         modifierButtons.forEach(button => {
//             button.addEventListener('click', function () {
//                 const operationId = this.getAttribute('data-id');
//                 const lotName = this.getAttribute('data-lot');
//                 const sousLotName = this.getAttribute('data-sous-lot');
//                 const articleName = this.getAttribute('data-article');
//                 const sortieValue = this.getAttribute('data-sortie');
//
//                 // Pré-remplir les champs avec les valeurs actuelles de l'opération
//                 operationIdInput.value = operationId;
//
//                 // Charger les lots
//                 fetch('get_lots.php')
//                     .then(response => response.json())
//                     .then(data => {
//                         lotModifier.innerHTML = '<option value="">-- Sélectionner Lot --</option>';
//                         // Vérifier si data est un tableau
//                         if (Array.isArray(data)) {
//                             data.forEach(lot => {
//                                 const option = document.createElement('option');
//                                 option.value = lot.lot_id;
//                                 option.textContent = lot.lot_name;
//
//                                 // Ajouter la valeur par défaut
//                                 if (lot.lot_name === lotName) {
//                                     option.selected = true;
//                                 }
//                                 lotModifier.appendChild(option);
//                             });
//                         } else {
//                             console.error("Erreur lors du chargement des lots :", data);
//                         }
//                         lotModifier.dispatchEvent(new Event('change'));
//                     })
//                     .catch(error => {
//                         console.error('Erreur lors de la récupération des lots :', error);
//                     });
//
//                 // Charger les sous-lots en fonction du lot sélectionné
//                 lotModifier.addEventListener('change', function () {
//                     const lotId = this.value;
//                     fetch(`get_sous_lots.php?lot_id=${lotId}`)
//                         .then(response => response.json())
//                         .then(data => {
//                             sousLotModifier.innerHTML = '<option value="">-- Sélectionner Sous-lot --</option>';
//                             // Vérifier si data est un tableau
//                             if (Array.isArray(data)) {
//                                 data.forEach(sousLot => {
//                                     const option = document.createElement('option');
//                                     option.value = sousLot.sous_lot_id;
//                                     option.textContent = sousLot.sous_lot_name;
//                                     sousLotModifier.appendChild(option);
//                                 });
//                             } else {
//                                 console.error("Erreur lors du chargement des sous-lots :", data);
//                             }
//                             sousLotModifier.disabled = !lotId;
//                             sousLotModifier.dispatchEvent(new Event('change'));
//                         })
//                         .catch(error => {
//                             console.error('Erreur lors de la récupération des sous-lots :', error);
//                         });
//                 });
//
//                 // Charger les articles en fonction du sous-lot sélectionné
//                 sousLotModifier.addEventListener('change', function () {
//                     const sousLotId = this.value;
//                     fetch(`get_articles.php?sous_lot_id=${sousLotId}`)
//                         .then(response => response.json())
//                         .then(data => {
//                             articleModifier.innerHTML = '<option value="">-- Sélectionner Article --</option>';
//                             // Vérifier si data est un tableau
//                             if (Array.isArray(data)) {
//                                 data.forEach(article => {
//                                     const option = document.createElement('option');
//                                     option.value = article.id_article;
//                                     option.textContent = article.nom;
//                                     articleModifier.appendChild(option);
//                                 });
//                             } else {
//                                 console.error("Erreur lors du chargement des articles :", data);
//                             }
//                             articleModifier.disabled = !sousLotId;
//                         })
//                         .catch(error => {
//                             console.error('Erreur lors de la récupération des articles :', error);
//                         });
//                 });
//
//                 // Charger les fournisseurs et services en fonction de l'article sélectionné
//                 articleModifier.addEventListener('change', function () {
//                     const articleId = this.value;
//                     fetch(`get_fournisseurs.php?article_id=${articleId}`)
//                         .then(response => response.json())
//                         .then(data => {
//                             fournisseurModifier.innerHTML = '<option value="">-- Sélectionner Fournisseur --</option>';
//                             // Vérifier si data est un tableau
//                             if (Array.isArray(data)) {
//                                 data.forEach(fournisseur => {
//                                     const option = document.createElement('option');
//                                     option.value = fournisseur.id_fournisseur;
//                                     option.textContent = `${fournisseur.nom_fournisseur} ${fournisseur.prenom_fournisseur}`;
//                                     fournisseurModifier.appendChild(option);
//                                 });
//                             } else {
//                                 console.error("Erreur lors du chargement des fournisseurs :", data);
//                             }
//                             fournisseurModifier.disabled = false; // Activer le sélecteur
//                         })
//                         .catch(error => {
//                             console.error('Erreur lors de la récupération des fournisseurs :', error);
//                         });
//
//                     fetch(`get_services.php?article_id=${articleId}`)
//                         .then(response => response.json())
//                         .then(data => {
//                             serviceModifier.innerHTML = '<option value="">-- Sélectionner Service --</option>';
//                             // Vérifier si data est un tableau
//                             if (Array.isArray(data)) {
//                                 data.forEach(service => {
//                                     const option = document.createElement('option');
//                                     option.value = service.id;
//                                     option.textContent = service.service;
//                                     serviceModifier.appendChild(option);
//                                 });
//                             } else {
//                                 console.error("Erreur lors du chargement des services :", data);
//                             }
//                             serviceModifier.disabled = false; // Activer le sélecteur
//                         })
//                         .catch(error => {
//                             console.error('Erreur lors de la récupération des services :', error);
//                         });
//                 });
//
//                 // Charger les détails de l'opération actuelle
//                 fetch(`get_operation_details.php?operation_id=${operationId}`)
//                     .then(response => response.json())
//                     .then(data => {
//                         if (data) {
//                             console.log("Détails de l'opération :", data);
//                             sousLotModifier.value = data.sous_lot_name; // Assurez-vous que le nom du sous-lot est correct
//                             articleModifier.value = data.nom_article; // Assurez-vous que le nom de l'article est correct
//                             fournisseurModifier.value = data.nom_pre_fournisseur; // Assurez-vous que le nom du fournisseur est correct
//                             serviceModifier.value = data.service_operation; // Assurez-vous que le nom du service est correct
//                             reclamationModal.textContent = data.reclamation;
//
//                             const formattedDate = data.date_operation.replace(" ", "T").substring(0, 16);
//                             dateOperationModifier.value = formattedDate;
//
//                             document.getElementById('ref').value = data.ref;
//                             document.getElementById('entree').value = data.entree;
//                             document.getElementById('sortie').value = sortieValue; // Utiliser la valeur de sortie du bouton
//                             document.getElementById('prix').value = data.prix;
//                         }
//                     })
//                     .catch(error => {
//                         console.error('Erreur lors de la récupération des détails de l\'opération :', error);
//                     });
//
//                 // Ouvrir le modal
//                 const modal = new bootstrap.Modal(document.getElementById('modifierOperationModal'));
//                 modal.show();
//             });
//         });
//     }, 100);
// });




document.addEventListener('DOMContentLoaded', function () {
    setTimeout(() => {
        // Gère l'activation/désactivation des champs en fonction de l'entrée/sortie


        const modifierButtons = document.querySelectorAll('.modifier-operation');


        // Écouter les événements sur les boutons de modification
        modifierButtons.forEach(button => {
            button.addEventListener('click', function () {


                document.getElementById('entree').addEventListener('input', function() {
                    if (this.value) {
                        document.getElementById('sortie').disabled = true;
                        document.getElementById('service').disabled = true;
                        document.getElementById('fournisseur').disabled = false;
                        document.getElementById('prix').disabled = false;
                    } else {
                        document.getElementById('sortie').disabled = false;
                        document.getElementById('service').disabled = true;
                        document.getElementById('fournisseur').disabled = true;
                    }
                });

                document.getElementById('sortie').addEventListener('input', function() {
                    if (this.value) {
                        document.getElementById('entree').disabled = true;
                        document.getElementById('fournisseur').disabled = true;
                        document.getElementById('service').disabled = false;
                        document.getElementById('prix').disabled = true;
                    } else {
                        document.getElementById('entree').disabled = false;
                        document.getElementById('fournisseur').disabled = true;
                        document.getElementById('service').disabled = true;
                    }
                });

                const lotModifier = document.getElementById('lot');
                const sousLotModifier = document.getElementById('sousLot');
                const articleModifier = document.getElementById('article');
                const fournisseurModifier = document.getElementById('fournisseur');
                const serviceModifier = document.getElementById('service');
                const dateOperationModifier = document.getElementById('date_operation');
                const operationIdInput = document.getElementById('operationId');
                const reclamationModal = document.querySelector('#text-reclamation-modal');


                const operationId = this.getAttribute('data-id');
                const lotName = this.getAttribute('data-lot');
                const sousLotName = this.getAttribute('data-sous-lot');
                const articleName = this.getAttribute('data-article');
                const sortieValue = this.getAttribute('data-sortie');

                // Pré-remplir les champs avec les valeurs actuelles de l'opération
                operationIdInput.value = operationId;

                // Charger les lots
                fetch(`get_operation_details.php?operation_id=${operationId}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data) {
                            console.log("Détails de l'opération :", data);
                            const formattedDate = data.date_operation.replace(" ", "T").substring(0, 16);
                            dateOperationModifier.value = formattedDate;
                            let lot_value = data.lot_name;
                            let sous_lot_value = data.sous_lot_name
                            let article_value = data.nom_article
                            let ref_value = data.ref
                            let entree_value = parseFloat(data.entree_operation)
                            let sortie_value = parseFloat(data.sortie_operation)
                            let prix_value = data.prix_operation
                            let fournisseur_value = ''
                            if (data.nom_pre_fournisseur !== null && data.nom_pre_fournisseur !== ''){
                                fournisseur_value = data.nom_pre_fournisseur
                            }
                            let service_value = ''
                            if (data.service_operation !== null && data.service_operation !== ''){
                                service_value = data.service_operation
                            }
                            reclamationModal.textContent = data.reclamation;

                            document.getElementById('ref').value = ref_value
                            document.getElementById('prix').value = prix_value


                            fetch('get_lots.php')
                                .then(response => response.json())
                                .then(data => {
                                    lotModifier.innerHTML = '<option value="">-- Sélectionner Lot --</option>';
                                    // Vérifier si data est un tableau
                                    if (Array.isArray(data)) {
                                        data.forEach(lot => {
                                            const option = document.createElement('option');
                                            option.value = lot.lot_id;
                                            option.textContent = lot.lot_name;

                                            // Ajouter la valeur par défaut
                                            if (lot.lot_name === lotName) {
                                                option.selected = true;
                                            }
                                            lotModifier.appendChild(option);

                                            if (option.innerHTML === lot_value){
                                                option.selected = true ;
                                            }
                                        });
                                    } else {
                                        console.error("Erreur lors du chargement des lots :", data);
                                    }
                                    lotModifier.dispatchEvent(new Event('change'));
                                })
                                .catch(error => {
                                    console.error('Erreur lors de la récupération des lots :', error);
                                });

                            // Charger les sous-lots en fonction du lot sélectionné
                            lotModifier.addEventListener('change', function () {
                                const lotId = this.value;
                                fetch(`get_sous_lots.php?lot_id=${lotId}`)
                                    .then(response => response.json())
                                    .then(data => {
                                        sousLotModifier.innerHTML = '<option value="">-- Sélectionner Sous-lot --</option>';
                                        // Vérifier si data est un tableau
                                        if (Array.isArray(data)) {
                                            data.forEach(sousLot => {
                                                const option = document.createElement('option');
                                                option.value = sousLot.sous_lot_id;
                                                option.textContent = sousLot.sous_lot_name;
                                                sousLotModifier.appendChild(option);

                                                if (option.innerHTML === sous_lot_value){
                                                    sousLotModifier.disabled = false
                                                    option.selected = true
                                                }
                                            });
                                        } else {
                                            console.error("Erreur lors du chargement des sous-lots :", data);
                                        }
                                        // sousLotModifier.disabled = !lotId;
                                        sousLotModifier.dispatchEvent(new Event('change'));
                                    })
                                    .catch(error => {
                                        console.error('Erreur lors de la récupération des sous-lots :', error);
                                    });
                            });

                            // Charger les articles en fonction du sous-lot sélectionné
                            sousLotModifier.addEventListener('change', function () {
                                const sousLotId = this.value;
                                fetch(`get_articles.php?sous_lot_id=${sousLotId}`)
                                    .then(response => response.json())
                                    .then(data => {
                                        articleModifier.innerHTML = '<option value="">-- Sélectionner Article --</option>';
                                        // Vérifier si data est un tableau
                                        if (Array.isArray(data)) {
                                            data.forEach(article => {
                                                const option = document.createElement('option');
                                                option.value = article.id_article;
                                                option.textContent = article.nom;
                                                articleModifier.appendChild(option);

                                                if (option.innerHTML === article_value){
                                                    // articleName.disabled = false;
                                                    option.selected = true;
                                                }
                                            });
                                        } else {
                                            console.error("Erreur lors du chargement des articles :", data);
                                        }
                                        articleModifier.disabled = !sousLotId;
                                    })
                                    .catch(error => {
                                        console.error('Erreur lors de la récupération des articles :', error);
                                    });
                            });

                            // Charger les fournisseurs et services en fonction de l'article sélectionné
                            lotModifier.addEventListener('change', function () {
                                const articleId = this.value;
                                fetch(`get_fournisseurs.php?lot_id=${articleId}`)
                                    .then(response => response.json())
                                    .then(data => {
                                        fournisseurModifier.innerHTML = '<option value="">-- Sélectionner Fournisseur --</option>';
                                        // Vérifier si data est un tableau
                                        if (Array.isArray(data)) {
                                            data.forEach(fournisseur => {
                                                const option = document.createElement('option');
                                                option.value = fournisseur.id_fournisseur;
                                                option.textContent = `${fournisseur.nom_fournisseur} ${fournisseur.prenom_fournisseur}`;
                                                fournisseurModifier.appendChild(option);
                                                if (option.innerHTML === fournisseur_value){
                                                    fournisseurModifier.disabled = false;
                                                    option.selected = true
                                                    serviceModifier.disabled = true;
                                                }
                                                else{
                                                    option.selected = false
                                                    fournisseurModifier.disabled = true;
                                                }
                                            });
                                        } else {
                                            console.error("Erreur lors du chargement des fournisseurs :", data);
                                        }
                                        fournisseurModifier.disabled = false; // Activer le sélecteur
                                    })
                                    .catch(error => {
                                        console.error('Erreur lors de la récupération des fournisseurs :', error);
                                    });

                                fetch(`get_services.php`)
                                    .then(response => response.json())
                                    .then(data => {
                                        serviceModifier.innerHTML = '<option value="">-- Sélectionner Service --</option>';
                                        // Vérifier si data est un tableau
                                        if (Array.isArray(data)) {
                                            data.forEach(service => {
                                                const option = document.createElement('option');
                                                option.value = service.id;
                                                option.textContent = service.service;
                                                serviceModifier.appendChild(option);

                                                console.log(service_value)
                                                if (option.innerHTML === service_value){
                                                    serviceModifier.disabled = false;
                                                    option.selected = true;
                                                    fournisseurModifier.disabled = true;
                                                }else{
                                                    option.selected = false
                                                    serviceModifier.disabled = true;
                                                }

                                            });
                                        } else {
                                            console.error("Erreur lors du chargement des services :", data);
                                        }
                                        serviceModifier.disabled = false; // Activer le sélecteur
                                    })
                                    .catch(error => {
                                        console.error('Erreur lors de la récupération des services :', error);
                                    });
                            });

                            let entrer = document.getElementById('entree');
                            let sortie = document.getElementById('sortie');

                            if (entree_value === 0 || entrer === ''){
                                serviceModifier.disabled = false
                                fournisseurModifier.disabled = true
                                entrer.value = ''
                                entrer.disabled = true
                            }
                            else{
                                entrer.disabled = false
                                entrer.value = entree_value;
                                sortie.value = ''
                                sortie.disabled = true
                                serviceModifier.disabled = true
                                fournisseurModifier.disabled = false
                            }

                            if (sortie_value === 0 || sortie === ''){
                                fournisseurModifier.disabled = false
                                serviceModifier.disabled = true
                                sortie.value = ''
                                sortie.disabled = true


                            }else{
                                sortie.disabled = false
                                sortie.value = sortie_value;
                                entrer.value = ''
                                entrer.disabled = true
                                fournisseurModifier.disabled = true
                                serviceModifier.disabled = false


                            }








                        }
                    })
                    .catch(error => {
                        console.error('Erreur lors de la récupération des détails de l\'opération :', error);
                    });

                // Charger les détails de l'opération actuelle


                // Ouvrir le modal
                const modal = new bootstrap.Modal(document.getElementById('modifierOperationModal'));
                modal.show();
            });
        });
    }, 100);
});

// Ouvrir le modal


// modale besoin function

document.addEventListener("DOMContentLoaded" , ()=> {
    let close = document.querySelector(".close");
    let modale = document.querySelector('#container11');
    let myModale = document.querySelector("#myModal")
    close.addEventListener('click', () => {
        modale.style.animation = "modaleAnimation 2s forwards"
        setTimeout(() => {
            myModale.style.opacity = "0"
        }, 1000)
        setTimeout(() => {
            myModale.style.display = "none"
        }, 3300)


    })

})


var supprimer_reclamation = document.querySelectorAll('.supprimer_reclamation');

supprimer_reclamation.forEach((supp)=>{
    supp.addEventListener('click', function (event) {
        var operationId = this.dataset.id;

        function deleteFunction(operationId){
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "supprimer_reclamation.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function () {
                if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {
                    var response = JSON.parse(this.responseText);
                    if (response.success) {
                        // Rediriger l'utilisateur vers la page avec le message de succès
                        // window.location.href = "option_Ent_Sor.php?message=" + encodeURIComponent(response.message);
                        location.reload()
                    } else {
                        // Afficher un message d'erreur à l'utilisateur (par exemple, avec une alerte)
                        alert(response.message);
                    }
                    reclamationModal.hide(); // Fermer le modal
                }
            };
            xhr.send("operationId=" + operationId);
        }


        function confirmDeletion() {
            if (window.confirm("Voulez-vous vraiment supprimer cette réclamation ?")) {
                deleteFunction(operationId);
            } else {
                console.log("Suppression annulée.");
            }
        }

        confirmDeletion()

        // Envoyer une requête AJAX pour enregistrer la réclamation avec la valeur NULL

    });
})
