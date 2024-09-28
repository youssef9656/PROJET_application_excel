 document.getElementById('downloadPdf').addEventListener('click', function () {
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF('p', 'mm', 'a4');

    // Définir les marges pour éviter le chevauchement
    const margin = {
        top: 60,    // Augmenter la marge supérieure pour l'en-tête
        bottom: 40, // Augmenter la marge inférieure pour le pied de page
        left: 20,
        right: 20
    };

    // Charger le logo
    const logo = new Image();
    logo.src = '../../includes/logoImage/logo.png'; // Assurez-vous que le chemin vers votre image est correct

    // Charger le logo et attendre qu'il soit prêt avant de générer le PDF
    logo.onload = function() {
        // Fonction pour formater les dates au format dd/MM/yyyy
        function formatDate(dateString) {
            const date = new Date(dateString);
            const day = String(date.getDate()).padStart(2, '0');
            const month = String(date.getMonth() + 1).padStart(2, '0'); // Janvier est 0
            const year = date.getFullYear();
            return `${day}/${month}/${year}`;
        }

        // Fonction pour ajouter l'en-tête
        const header = function(data) {
            // Ajouter le logo
            // doc.addImage(logo, 'JPEG', margin.left, 10, 30, 15);
            // Définir les dimensions et le rayon du bord
            const imageWidth = 50;
            const imageHeight = 50;
            const borderRadius = 5; // Rayon du bord

// Position de l'image
            const xPos = margin.left -20;
            const yPos = 0;

// Dessiner un rectangle arrondi comme fond
            doc.setFillColor(255, 255, 255); // Couleur de remplissage (blanc dans cet exemple)
            doc.roundedRect(xPos, yPos, imageWidth, imageHeight, borderRadius, borderRadius, 'F');

// Ajouter l'image au-dessus du rectangle arrondi
            doc.addImage(logo, 'JPEG', xPos, yPos, imageWidth, imageHeight);


            // Obtenir le titre du rapport
            const reportTitle = document.getElementById('reportTitle').textContent || "Titre du Rapport";
            doc.setFont(reportTitle, "bold"); // Définir la police en gras
            doc.setFontSize(20);
            doc.text(reportTitle, margin.left + 70, 20);

            // // Obtenir et formater les dates de début et de fin
            // const startDateInput = document.getElementById('start_date').value;
            // const endDateInput = document.getElementById('end_date').value;
            //
            // const startDate = startDateInput ? formatDate(startDateInput) : "Date de début non spécifiée";
            // const endDate = endDateInput ? formatDate(endDateInput) : "Date de fin non spécifiée";
            //
            // doc.setFontSize(12);
            // if (startDate === endDate) {
            //     doc.text("Date : " + startDate, margin.left + 40, 30);
            // } else {
            //     doc.text("Date : " + startDate + " -- " + endDate, margin.left + 40, 30);
            // }
            const currentDate = new Date().toLocaleDateString(); // Formater la date

            doc.setFontSize(8); // Définir la taille de la police
            doc.text("Date d'étude : : " + currentDate, margin.left + 150, 5); // Afficher la date


            // Obtenir les valeurs des sélecteurs
            const lot = document.getElementById('lot').value || ".......................";
            const article = document.getElementById('article').value || ".......................";
            const fournisseur = document.getElementById('fournisseur').value || ".......................";
            const sousLot = document.getElementById('sous_lot').value || ".......................";
            const dateLivraison = document.getElementById('date_livraison').value || ".......................";



            doc.setFontSize(12);
            doc.text("Lot                   : " + lot, margin.left + 40, 30);

// Supposons que vous avez déjà défini les variables `fournisseur` et `dateLivraison` quelque part dans votre code.
          const donneFournisour =  document.getElementById("lesdonneFournisseur").textContent

            doc.text("Fournisseur     : " + fournisseur +" "+ donneFournisour, margin.left + 40, 40);
            // Après avoir affiché les détails du fournisseur, vous pouvez ensuite afficher la date de livraison
            doc.text("Date Livraison : " + dateLivraison, margin.left + 40, 50);
        };

        // Fonction pour ajouter le pied de page
        const footer = function(data) {
            const pageHeight = doc.internal.pageSize.getHeight();
            doc.setFontSize(10);
            doc.text("Page " + data.pageNumber, margin.left + 80, pageHeight - 10);
            doc.setFontSize(12);
            doc.text("Signature :", margin.left, pageHeight - 25);
            doc.line(margin.left + 20, pageHeight - 25, margin.left + 100, pageHeight - 25);
        };

        // Collecter les données du tableau en excluant les dernières colonnes si nécessaire
        const table = document.getElementById('articles_table');
        const headers = [];
        const headerCells = table.querySelectorAll('thead th');

        // Exclure les trois derniers en-têtes (ajustez selon vos besoins)
        for (let i = 0; i < headerCells.length - 3; i++) {
            headers.push(headerCells[i].textContent.trim());
        }

        const data = [];
        table.querySelectorAll('tbody tr').forEach(tr => {
            const row = [];
            const cells = tr.querySelectorAll('td');
            // Exclure la dernière cellule de chaque rangée (ajustez selon vos besoins)
            for (let i = 0; i < cells.length - 1; i++) {
                const td = cells[i];
                if (headers[i] === 'Quantité') {
                    const input = td.querySelector('input');
                    row.push(input && input.value ? input.value : '.........'); // Si la valeur est vide, mettre "........."
                } else {
                    row.push(td.textContent.trim());
                }
            }
            data.push(row);
        });

        // Utiliser autoTable pour créer le tableau dans le PDF
        doc.autoTable({
            head: [headers],
            body: data,
            startY: margin.top, // Commencer le tableau après la marge supérieure
            styles: {
                cellPadding: 1,
                fontSize: 10,
                halign: 'center',
                valign: 'middle',
                lineWidth: 0.1,
                lineColor: [0, 0, 0],
            },
            headStyles: {
                fillColor: [255, 255, 255],
                textColor: [52, 58, 64],
                halign: 'center',
            },
            didDrawPage: function (data) {
                // Ajouter l'en-tête et le pied de page à chaque page
                header(data);
                footer(data);
            },
            margin: { top: margin.top, bottom: margin.bottom }, // Définir les marges supérieure et inférieure
            theme: 'grid',
            showHead: 'everyPage',
        });

        // Sauvegarder le fichier PDF
        doc.save('Bon_Commande.pdf');
    };

    // Gérer l'erreur de chargement du logo
    logo.onerror = function() {
        alert('Échec du chargement du logo');
    };
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








