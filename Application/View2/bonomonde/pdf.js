document.getElementById('downloadPdf').addEventListener('click', function () {
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF('p', 'mm', 'a4');

    // Charger le logo à partir de l'image téléchargée
    const logo = new Image();
    logo.src = 'image1.jpg'; // Assurez-vous que le chemin vers votre image est correct

    // Charger le logo et la signature avant de créer le PDF
    logo.onload = function() {
        const totalPagesExp = "{total_pages_count_string}";

        // Fonction pour ajouter l'en-tête et le pied de page
        const header = function(data) {
            // Ajouter le logo
            doc.addImage(logo, 'JPEG', data.settings.margin.left, 10, 30, 15);

            // Récupérer le titre du rapport
            const reportTitle = document.getElementById('reportTitle').textContent || "Titre du Rapport";
            doc.setFontSize(20);
            doc.text(reportTitle, data.settings.margin.left + 80, 20);

            // Récupérer et formater les dates de début et de fin
            const startDateInput = document.getElementById('start_date').value;
            const endDateInput = document.getElementById('end_date').value;

            const startDate = startDateInput ? formatDate(startDateInput) : "Date de début non spécifiée";
            const endDate = endDateInput ? formatDate(endDateInput) : "Date de fin non spécifiée";

            // Afficher les dates sous le format souhaité
            doc.setFontSize(12);
            if (startDate === endDate) {
                doc.text("Date : " + startDate, data.settings.margin.left + 40, 30);
            } else {
                doc.text("Date : " + startDate + " -- " + endDate, data.settings.margin.left + 40, 30);
            }

            // Récupérer les valeurs des sélecteurs
            const lot = document.getElementById('lot').value || "Lot non spécifié";
            const article = document.getElementById('article').value || "Article non spécifié";
            const fournisseur = document.getElementById('fournisseur').value || "Fournisseur non spécifié";
            const sousLot = document.getElementById('sous_lot').value || "Sous Lot non spécifié";
            const service = document.getElementById('service').value || "Service non spécifié";

            doc.setFontSize(12);
            doc.text("Lot : " + lot, data.settings.margin.left + 40, 40);
            doc.text("Fournisseur : " + fournisseur, data.settings.margin.left + 40, 50);


        };

// Fonction pour formater les dates au format dd/MM/yyyy
        function formatDate(dateString) {
            const date = new Date(dateString);
            const day = String(date.getDate()).padStart(2, '0');
            const month = String(date.getMonth() + 1).padStart(2, '0'); // Janvier est 0
            const year = date.getFullYear();
            return `${day}/${month}/${year}`;
        }

// Fonction pour formater les dates au format dd/MM/yyyy
        function formatDate(dateString) {
            const date = new Date(dateString);
            const day = String(date.getDate()).padStart(2, '0');
            const month = String(date.getMonth() + 1).padStart(2, '0'); // Janvier est 0
            const year = date.getFullYear();
            return `${day}/${month}/${year}`;
        }

        const footer = function(data) {
            let str = "Page " + data.pageNumber;
            doc.setFontSize(10);
            doc.text(str, data.settings.margin.left + 80, doc.internal.pageSize.getHeight() - 10);
            doc.setFontSize(12);
            doc.text("Signature :", data.settings.margin.left, doc.internal.pageSize.getHeight() - 20);
            doc.line(data.settings.margin.left + 20, doc.internal.pageSize.getHeight() - 20, 100, doc.internal.pageSize.getHeight() - 20);
        };

        // Collecter les données du tableau en excluant le dernier <th> et <td>
        const table = document.getElementById('articles_table');
        const headers = [];
        const headerCells = table.querySelectorAll('thead th');

        // Exclure le dernier en-tête
        for (let i = 0; i < headerCells.length - 3; i++) {
            headers.push(headerCells[i].textContent.trim());
        }

        const data = [];
        table.querySelectorAll('tbody tr').forEach(tr => {
            const row = [];
            const cells = tr.querySelectorAll('td');
            // Exclure le dernier <td>
            for (let i = 0; i < cells.length - 1; i++) {
                const td = cells[i];
                if (headers[i] === 'Quantité') {
                    const input = td.querySelector('input');
                    row.push(input && input.value ? input.value : '.........'); // Si la valeur est vide, mettre "...."
                } else {
                    row.push(td.textContent.trim());
                }
            }
            data.push(row);
        });

        // Utiliser autoTable pour créer le tableau
        doc.autoTable(
            {
            head: [headers],
            body: data,
            startY: 55, // Commencer en bas de l'en-tête
            styles: {
                cellPadding: 3,
                fontSize: 10,
                halign: 'center',
                valign: 'middle',
                lineWidth: 0.1,
                lineColor: [0, 0, 0],
            },
            headStyles: {
                fillColor:  [255, 255, 255],
                textColor: [52, 58, 64] ,
                halign: 'center',
            },
            didDrawPage: function (data) {
                header(data);
                footer(data);
            },
            margin: { top: 0 },
            theme: 'grid',
            showHead: 'everyPage',
        });

        // Sauvegarder le fichier
        doc.save('Bon Commande.pdf');
    };

    logo.onerror = function() {
        alert('Échec du chargement du logo');
    };
});
