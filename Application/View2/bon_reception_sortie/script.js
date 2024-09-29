document.getElementById("downloadPdf").addEventListener("click", function () {
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF();

    // Récupérer les valeurs de la date de livraison, du fournisseur et du lot
    let dateLivraison = document.getElementById("dateLivraison").value;
    let fournisseur = document.getElementById("service").value;
    let lot = document.getElementById("lot").value;

    // Charger l'image depuis le dossier
    const logoPath = 'image1.jpg'; // Chemin de votre image
    fetch(logoPath)
        .then(response => {
            if (!response.ok) {
                throw new Error('Erreur lors du chargement de l\'image');
            }
            return response.blob(); // Convertir la réponse en Blob
        })
        .then(blob => {
            const reader = new FileReader();
            reader.onloadend = function () {
                const logo = reader.result; // Image encodée en Base64

                // Fonction pour ajouter l'en-tête sur chaque page
                function addHeader() {
                    // Ajouter le logo à gauche
                    doc.addImage(logo, 'JPEG', 10, 10, 30, 30);

                    // Titre "Bon entrée" centré
                    doc.setFontSize(20);
                    doc.text("Bon sorties", doc.internal.pageSize.getWidth() / 2, 20, { align: "center" });

                    // Ajouter la date de création (date actuelle)
                    const currentDate = new Date().toLocaleDateString('fr-FR', {
                        day: '2-digit', month: '2-digit', year: 'numeric'
                    });
                    doc.setFontSize(10);
                    doc.text(`Édité le : ${currentDate}`, doc.internal.pageSize.getWidth() - 60, 15);

                    // Ajouter les informations à droite : date de livraison, fournisseur, lot
                    doc.setFontSize(12);
                    doc.text(`Date de livraison: ${dateLivraison}`, doc.internal.pageSize.getWidth() - 80, 35);
                    doc.text(`Fournisseur: ${fournisseur}`, doc.internal.pageSize.getWidth() - 80, 45);
                    doc.text(`Lot: ${lot}`, doc.internal.pageSize.getWidth() - 80, 55);
                }

                // Fonction pour ajouter le pied de page sur chaque page
                function addFooter(pageNumber, totalPages) {
                    // Ajouter la signature en bas à gauche
                    doc.setFontSize(12);
                    doc.text("Signature: ____________________", 10, doc.internal.pageSize.getHeight() - 15);

                    // Ajouter une petite table dans le pied de page
                    doc.autoTable({
                        head: [['Nom', 'Prenom', 'youssef']],
                        body: [
                            ['...................................', '...................................', '...................................'],
                            ['...................................', '...................................', '...................................'],
                            ['...................................', '...................................', '...................................'],
                            ['...................................', '...................................', '...................................']
                        ],
                        startY: doc.internal.pageSize.getHeight() - 65, // Positionner avant le pied de page
                        // margin: { left: (doc.internal.pageSize.getWidth() - 80) / 2 }, // Centrer la table (80 est la largeur estimée du tableau)
                        theme: 'plain', // Pour une table sans style
                        tableWidth: 'auto', // Peut être 'auto', 'wrap', ou un nombre (par exemple, 100 pour 100 unités)

                        styles: {
                            halign: 'center', // Centrer le contenu horizontalement
                            valign: 'middle',
                            minCellHeight: 8,
                            fontSize: 8,
                            lineWidth: 0.01, // Largeur de la bordure
                            lineColor: [0, 0, 0] // Couleur de la bordure (noir)
                        },
                    });

                    // Ajouter la pagination en bas à droite
                    doc.setFontSize(10);
                    doc.text(`Page ${pageNumber} / ${totalPages}`, doc.internal.pageSize.getWidth() - 40, doc.internal.pageSize.getHeight() - 15);
                }


                // Récupérer les données du tableau sans la colonne "Action"
                const table = document.querySelector("#articles_table");

// Récupérer les lignes du tbody
                const rows = Array.from(table.querySelectorAll("tbody tr")).map(row => {
                    return Array.from(row.querySelectorAll("td")).slice(0, -1).map(cell => cell.innerText);
                });

// Récupérer les en-têtes du thead sans la colonne "Action"
                const headers = Array.from(table.querySelectorAll("thead th")).slice(0, -1).map(header => header.innerText);

// Récupérer les données du tfoot si elles existent
                const footerRow = table.querySelector("tfoot tr");
                let footer = [];
                if (footerRow) {
                    footer = Array.from(footerRow.querySelectorAll("td")).slice(0, -1).map(cell => cell.innerText);
                }

// Calculer la hauteur disponible pour le tableau
                const pageHeight = doc.internal.pageSize.getHeight();
                const headerHeight = 60; // Ajuster selon la taille de votre en-tête
                const footerHeight = 60; // Ajuster selon la taille de votre pied de page (avec table)
                const tableHeight = pageHeight - headerHeight - footerHeight; // Hauteur disponible pour le tableau

// Ajouter le tableau paginé avec une hauteur maximale définie
                doc.autoTable({
                    head: [headers],
                    body: rows, // Ajouter uniquement les lignes du tbody au début
                    startY: headerHeight + 10, // Ajuster pour éviter le chevauchement (sous l'en-tête)
                    margin: { top: headerHeight + 10, bottom: footerHeight + 10 }, // Marges pour éviter chevauchement
                    pageBreak: 'auto',
                    styles: {
                        halign: 'center', // Aligner le texte dans les cellules
                        cellPadding: 3, // Ajuster l'espace dans les cellules
                    },
                    bodyStyles: {
                        minCellHeight: 8, // Ajuster la hauteur minimale des cellules
                    },
                    theme: 'grid',
                    tableWidth: 'auto',
                    didDrawPage: function (data) {
                        let pageNumber = doc.internal.getNumberOfPages();
                        let currentPage = doc.internal.getCurrentPageInfo().pageNumber;

                        // Ajouter l'en-tête et le pied de page à chaque page
                        addHeader();
                        addFooter(pageNumber, totalPagesExp);

                        // Si on est sur la dernière page, ajouter le tfoot
                        if (pageNumber === currentPage && footer.length > 0) {
                            // Ajouter le tfoot comme une ligne supplémentaire
                            doc.autoTable({
                                body: [footer],
                                startY: data.cursor.y + 10, // Positionner après la dernière ligne du tableau
                                theme: 'grid',
                                tableWidth: 'auto',
                                styles: {
                                    halign: 'center',
                                    fillColor: [255, 255, 255], // Fond blanc pour se distinguer du corps
                                    textColor: [0, 0, 0], // Couleur du texte noir
                                    fontStyle: 'bold',
                                },
                                bodyStyles: {
                                    minCellHeight: 8,
                                }
                            });
                        }
                    },
                    showHead: 'everyPage', // Afficher les en-têtes sur chaque page
                });

                // Mettre à jour la pagination après avoir calculé le total de pages
                const finalDoc = doc.internal.getNumberOfPages();
                if (typeof doc.putTotalPages === 'function') {
                    doc.putTotalPages(totalPagesExp);
                }

                // Sauvegarder le PDF
                doc.save("bon_sortie.pdf");
            };

            // Lire le Blob comme une URL de données (Base64)
            reader.readAsDataURL(blob);
        })
        .catch(error => {
            console.error("Erreur lors de l'importation de l'image : ", error);
        });
});
