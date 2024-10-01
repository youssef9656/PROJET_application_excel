
//
// window.onload = function () {
//     document.body.style.opacity = "1";
//     document.body.style.filter = "none"
// }

document.getElementById("downloadPdf").addEventListener("click", function () {
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF();

    // Récupérer les valeurs de la date de livraison, du fournisseur et du lot
    let dateLivraison = document.getElementById("dateLivraison").value;
    let fournisseur = document.getElementById("fournisseur").value;
    let lot = document.getElementById("lot").value;

    // Charger l'image depuis le dossier
    const logoPath = '../../includes/logoImage/logo.png'; // Chemin de votre image
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
                    doc.addImage(logo, 'JPEG', 10, 10, 30, 30);
                    doc.setFontSize(20);
                    doc.text("Bon entrée", doc.internal.pageSize.getWidth() / 2, 20, { align: "center" });
                    const currentDate = new Date().toLocaleDateString('fr-FR', {
                        day: '2-digit', month: '2-digit', year: 'numeric'
                    });
                    doc.setFontSize(10);
                    doc.text(`Édité le : ${currentDate}`, doc.internal.pageSize.getWidth() - 60, 15);
                    doc.setFontSize(10);
                    doc.text(`Date de livraison: ${dateLivraison}`, doc.internal.pageSize.getWidth() - 150, 32);
                    const donneFournisour =  document.getElementById("lesdonneFournisseur").textContent

                    // doc.text("Fournisseur     : " + fournisseur +" "+ donneFournisour, margin.left + 40, 40);
                    doc.text(`Fournisseur: ${fournisseur + donneFournisour}`, doc.internal.pageSize.getWidth() - 150, 42);
                    doc.text(`Lot: ${lot}`, doc.internal.pageSize.getWidth() - 150, 52);
                }

                // Fonction pour ajouter le pied de page sur chaque page
                function addFooter(pageNumber, totalPages) {
                    doc.setFontSize(12);
                    doc.text("Signature: ____________________", 10, doc.internal.pageSize.getHeight() - 15);
                    doc.autoTable({
                        head: [['Nom', 'Prenom', 'youssef']],
                        body: [
                            ['...................................', '...................................', '...................................'],
                            ['...................................', '...................................', '...................................'],
                            ['...................................', '...................................', '...................................'],
                            ['...................................', '...................................', '...................................']
                        ],
                        startY: doc.internal.pageSize.getHeight() - 65, // Positionner avant le pied de page
                        theme: 'plain',
                        tableWidth: 'auto',
                        styles: {
                            halign: 'center',
                            valign: 'middle',
                            minCellHeight: 8,
                            fontSize: 8,
                            lineWidth: 0.01,
                            lineColor: [0, 0, 0]
                        },
                    });
                    doc.setFontSize(10);
                    doc.text(`Page ${pageNumber} / ${totalPages}`, doc.internal.pageSize.getWidth() - 40, doc.internal.pageSize.getHeight() - 15);
                }

                // Récupérer les données du tableau sans la colonne "Action"
                const table = document.querySelector("#articles_table");
                const rows = Array.from(table.querySelectorAll("tbody tr")).map(row => {
                    return Array.from(row.querySelectorAll("td")).slice(0, -1).map(cell => cell.innerText);
                });

                // Récupérer les en-têtes du tableau sans la colonne "Action"
                const headers = Array.from(table.querySelectorAll("thead th")).slice(0, -1).map(header => header.innerText);

                // Récupérer les données du tfoot si elles existent
                const footerRow = table.querySelector("tfoot tr");
                let footer = [];
                if (footerRow) {
                    footer = Array.from(footerRow.querySelectorAll("td")).map(cell => cell.innerText);
                }

                // Ajouter la ligne du tfoot avec colspan="4"
                const footerWithColspan = [[{ content: footer.join(' '), colSpan: headers.length }]]; // Remplacez `headers.length` par le nombre de colonnes approprié

                // Calculer la hauteur disponible pour le tableau
                const pageHeight = doc.internal.pageSize.getHeight();
                const headerHeight = 60; // Ajuster selon la taille de votre en-tête
                const footerHeight = 60; // Ajuster selon la taille de votre pied de page (avec table)
                const tableHeight = pageHeight - headerHeight - footerHeight; // Hauteur disponible pour le tableau

                // Ajouter l'en-tête et le pied de page à chaque page
                const totalPagesExp = "{total_pages_count_string}"; // Placeholder pour la pagination

                // Ajouter le tableau paginé avec une hauteur maximale définie
                doc.autoTable({
                    head: [headers],
                    body: rows.concat(footerWithColspan), // Ajout de la ligne du footer comme une ligne dans le tableau
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
                        addHeader(); // Fixe l'en-tête sur chaque page
                        addFooter(pageNumber, totalPagesExp); // Fixe le pied de page sur chaque page
                    },
                    showHead: 'everyPage', // Afficher les en-têtes sur chaque page
                });

                // Mettre à jour la pagination après avoir calculé le total de pages
                const finalDoc = doc.internal.getNumberOfPages();
                if (typeof doc.putTotalPages === 'function') {
                    doc.putTotalPages(totalPagesExp);
                }

                // Sauvegarder le PDF
                doc.save("bon_entree.pdf");
            };

            // Lire le Blob comme une URL de données (Base64)
            reader.readAsDataURL(blob);
        })
        .catch(error => {
            console.error("Erreur lors de l'importation de l'image : ", error);
        });
});


function getFournisseurDetails() {
    return new Promise((resolve, reject) => {
        var select = document.getElementById('fournisseur');
        var selectedValue = select.value;
        var values = selectedValue.split(' ');
        var nom = values[0];
        var prenom = values[1];

        // Crée une nouvelle requête XHR
        var xhr = new XMLHttpRequest();
        xhr.open('GET', 'get_fournisseur.php?nom_fournisseur=' + encodeURIComponent(nom) + '&prenom_fournisseur=' + encodeURIComponent(prenom), true);

        xhr.onload = function() {
            if (xhr.status === 200) {
                // Parse the JSON response
                var json = JSON.parse(xhr.responseText);

                // Prepare the details to be returned


                var lesDonne = ( (json.data.adresse !=null ) ? json.data.adresse  : "" ) +((json.data.telephone_portable != null) ? " , " +json.data.telephone_portable  : ""  ) +( (json.data.telephone_fixe !=null) ?  " , " +json.data.telephone_fixe :  "");

                // Resolve the promise with the retrieved data
                resolve(lesDonne);
            } else {
                console.error("Erreur lors de la requête : " + xhr.status);
                reject("Erreur lors de la requête : " + xhr.status); // Reject the promise with an error message
            }
        };

        xhr.onerror = function() {
            console.error("Une erreur s'est produite lors de l'envoi de la requête.");
            reject("Une erreur s'est produite lors de l'envoi de la requête."); // Reject the promise with an error message
        };

        xhr.send();
    });
}



document.getElementById("fournisseur").addEventListener("change",()=>{
    getFournisseurDetails()
        .then(function(details) {
            console.log(details);
            document.getElementById("lesdonneFournisseur").innerHTML=details

        })
        .catch(function(error) {
            // Gère les erreurs
            // document.getElementById('fournisseur-details').innerHTML = "Erreur : " + error;
        });

})