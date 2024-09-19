<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exporter en PDF et Excel</title>
    <script src="../../includes/libriryPdf/unpkg/jspdf.umd.min.js"></script>
    <script src="../../includes/xlsx.full.min.js"></script>

<!--    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>-->
<!--    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.0/xlsx.full.min.js"></script>-->
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
        }
        th {
            background-color: #f2f2f2;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .highlight {
            background-color: #e0f7fa; /* Couleur spécifique pour le PDF */
        }
        .section {
            background-color: #e8f5e9; /* Couleur spécifique pour le PDF */
        }
        button {
            margin: 10px;
            padding: 10px;
            font-size: 16px;
        }
    </style>
</head>
<body>

<table id="myTable">
    <thead>
    <tr>
        <th>Nom</th>
        <th>Description</th>
        <th>Stock Min</th>
        <th>Stock Initial</th>
        <th>Prix</th>
        <th>Unité</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td class="highlight">Article 1</td>
        <td class="highlight">Description 1</td>
        <td class="highlight">10</td>
        <td class="highlight">100</td>
        <td class="highlight">15.00</td>
        <td class="highlight">Unité 1</td>
    </tr>
    <tr>
        <td class="section">Article 2</td>
        <td class="section">Description 2</td>
        <td class="section">20</td>
        <td class="section">200</td>
        <td class="section">25.00</td>
        <td class="section">Unité 2</td>
    </tr>
    </tbody>
</table>

<button id="downloadPdfButton">Télécharger en PDF</button>
<button id="downloadExcelButton">Télécharger en Excel</button>

<script>

    document.getElementById('downloadExcelButton').addEventListener('click', function() {
        const table = document.getElementById('myTable');
        const wb = XLSX.utils.book_new();
        const ws = XLSX.utils.table_to_sheet(table);
        const ws_data = XLSX.utils.sheet_to_json(ws, { header: 1 });

        ws_data.forEach((row, rowIndex) => {
            row.forEach((cell, cellIndex) => {
                const cellAddress = XLSX.utils.encode_cell({ r: rowIndex, c: cellIndex });
                const cellElem = table.querySelector(`tr:nth-child(${rowIndex + 1}) td:nth-child(${cellIndex + 1})`);
                if (cellElem) {
                    const bgColor = window.getComputedStyle(cellElem).backgroundColor;
                    const colorMatch = bgColor.match(/rgba?\((\d+),\s*(\d+),\s*(\d+)/);
                    const color = colorMatch ? `#${parseInt(colorMatch[1]).toString(16).padStart(2, '0')}${parseInt(colorMatch[2]).toString(16).padStart(2, '0')}${parseInt(colorMatch[3]).toString(16).padStart(2, '0')}` : 'FFFFFF';
                    ws[cellAddress].s = { fill: { fgColor: { rgb: color.replace('#', '') } } };
                }
            });
        });

        XLSX.utils.book_append_sheet(wb, ws, "Feuille1");
        XLSX.writeFile(wb, 'tableau.xlsx');
    });
</script>

</body>
</html>
