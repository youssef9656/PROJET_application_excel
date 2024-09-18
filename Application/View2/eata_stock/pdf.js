
document.getElementById('downloadPdfButton').addEventListener('click', function() {
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF({
        orientation: 'landscape', // Orientation paysage pour plus de largeur
        unit: 'pt', // Unité de mesure en points
        format: 'A4'
    });

    // Ajouter le logo (utiliser une URL ou un chemin d'accès à l'image locale)
    const logoUrl = 'image1.jpg'; // Remplacez par l'URL de votre logo
    const imgWidth = 50; // Largeur de l'image (ajuster selon les besoins)
    const imgHeight = 50; // Hauteur de l'image (ajuster selon les besoins)

    // Charger l'image et ajouter un titre
    const title = "Titre du document"; // Titre à afficher

    // Date actuelle
    const currentDate = new Date().toLocaleDateString(); // Formater la date

    // Charger l'image (cela peut être une URL ou une base64 image)
    doc.addImage(logoUrl, 'PNG', 10, 10, imgWidth, imgHeight); // Positionner le logo
    doc.setFontSize(18);
    doc.text(title, imgWidth + 20, 30); // Placer le titre à côté du logo

    // Ajouter la date sous le titre
    doc.setFontSize(12);
    doc.text(`Date: ${currentDate}`, imgWidth + 20, 50); // Position de la date sous le titre

    // Variables pour dessiner le tableau
    const table = document.getElementById('articles_table');
    const rows = table.querySelectorAll('tr');
    let y = 80; // Déplacement en bas du logo, du titre, et de la date

    // Configuration de la police
    doc.setFont('helvetica');
    doc.setFontSize(10);

    // Calculer la largeur des colonnes en fonction du contenu des cellules
    const columnWidths = [];
    rows.forEach((row) => {
        const cells = row.querySelectorAll('td, th');
        cells.forEach((cell, cellIndex) => {
            const textWidth = doc.getTextWidth(cell.textContent);
            columnWidths[cellIndex] = Math.max(columnWidths[cellIndex] || 0, textWidth + 10); // Ajouter un padding
        });
    });

    // Dessiner le tableau
    rows.forEach((row) => {
        const cells = row.querySelectorAll('td, th');
        let x = 10;
        cells.forEach((cell, cellIndex) => {
            const cellBgColor = window.getComputedStyle(cell).backgroundColor;
            const colorMatch = cellBgColor.match(/rgba?\((\d+),\s*(\d+),\s*(\d+)/);
            const color = colorMatch ? [parseInt(colorMatch[1]), parseInt(colorMatch[2]), parseInt(colorMatch[3])] : [255, 255, 255];

            doc.setFillColor(...color);

            // Dessiner la cellule
            const cellWidth = columnWidths[cellIndex];
            doc.rect(x, y, cellWidth, 20, 'F'); // Dessiner le rectangle pour la cellule
            doc.setTextColor(0, 0, 0);
            doc.text(cell.textContent, x + 2, y + 14); // Texte de la cellule

            x += cellWidth; // Se déplacer à la colonne suivante
        });
        y += 20; // Se déplacer à la ligne suivante

        // Ajouter une nouvelle page si le contenu dépasse la hauteur de la page
        if (y > doc.internal.pageSize.height - 80) { // Laisser de la place pour la signature
            doc.addPage();
            y = 20; // Réinitialiser la position en Y après le saut de page
        }
    });

    // Ajouter une ligne pour la signature à la fin du document
    y += 30; // Espacement avant la ligne de signature
    doc.setFontSize(12);
    doc.text('Signature:', 10, y); // Texte pour la signature
    doc.line(80, y, 300, y); // Dessiner la ligne pour la signature

    doc.save('tableau.pdf');
});
