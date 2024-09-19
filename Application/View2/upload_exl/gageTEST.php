<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau Dynamique</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>

<h2>Liste des Doublons</h2>
<div id="table-container"></div>

<script>

    // Fonction pour créer le tableau
    const data = [
        {"lot":"lot1","sous lot":"hhh","fournisseur":"hysdh sdhhj","articles":"hhhhhhhhhh","description":"jjjjjjj","unité":"hhhh","p.u.ttc":"YYY","stock initial":"110,000","stock min":"22"},
        {"lot":"lot5","sous lot":"hhh","fournisseur":"gsfdg sdfhjgh","articles":"LAIT DE COCO 400G","description":"FG","unité":"BT","p.u.ttc":"――","stock initial":"10,000","stock min":"22"},
        {"lot":"lot1","sous lot":"hhh","fournisseur":"DRISS ADIL","articles":"hhhhhhhhhh","description":"FG","unité":"KG","p.u.ttc":"――","stock initial":"29,000","stock min":"22"}
    ];

    // Fonction pour créer le tableau

    // Fonction pour créer le tableau
    function createTable(data) {
        const tableContainer = document.getElementById('table-container');
        tableContainer.innerHTML = ''; // Effacer le contenu précédent

        if (data.length === 0) {
            tableContainer.textContent = 'Aucune donnée à afficher.';
            return;
        }

        const table = document.createElement('table');
        const thead = document.createElement('thead');
        const tbody = document.createElement('tbody');

        // Créer les en-têtes de tableau
        const headers = [
            "Lot", "Sous Lot", "Fournisseur", "Article", "Description", "Unité", "Prix TTC", "Stock Initial", "Stock Min", "Raison du doublon"
        ];
        const headerRow = document.createElement('tr');
        headers.forEach(header => {
            const th = document.createElement('th');
            th.textContent = header;
            headerRow.appendChild(th);
        });
        thead.appendChild(headerRow);

        // Créer les lignes de tableau
        data.duplicates.forEach(entry => {
            const item = entry.item;
            const row = document.createElement('tr');
            const cells = [
                item.lot,
                item['sous lot'],
                item.fournisseur,
                item.articles,
                item.description,
                item.unité,
                item['p.u.ttc'],
                item['stock initial'],
                item['stock min'],
                entry.reason
            ];
            cells.forEach(cell => {
                const td = document.createElement('td');
                td.textContent = cell; // Utiliser textContent pour éviter le HTML
                row.appendChild(td);
            });
            tbody.appendChild(row);
        });

        table.appendChild(thead);
        table.appendChild(tbody);
        tableContainer.appendChild(table);
    }

    function filterData(data) {
        const seen = {
            articles: new Set(),
            lotToSousLots: new Map(),  // Map pour suivre les sous lots à l'intérieur de chaque lot
            sousLotToLots: new Map()   // Map pour suivre les sous lots à travers différents lots
        };

        const errors = {
            duplicates: []
        };

        const filteredData = data.filter((item, index) => {
            // Transformer les articles, lot et sous lot en minuscules et enlever les espaces
            const articleKey = item.articles.trim().toLowerCase();
            const lotKey = item.lot.trim().toLowerCase();
            const sousLotKey = item['sous lot'].trim().toLowerCase();

            // Vérifier les doublons d'articles
            if (seen.articles.has(articleKey)) {
                errors.duplicates.push({
                    item,
                    reason: `Nom d'article en doublon dans la colonne ${index + 1}`
                });
                return false;
            }
            seen.articles.add(articleKey);

            // Vérifier si le sous lot existe dans un autre lot
            if (seen.sousLotToLots.has(sousLotKey)) {
                const existingLot = seen.sousLotToLots.get(sousLotKey);
                if (existingLot !== lotKey) {
                    errors.duplicates.push({
                        item,
                        reason: `Sous lot '${sousLotKey}' existe dans un autre lot : ${existingLot} (colonne ${index + 1})`
                    });
                    return false;
                }
            } else {
                seen.sousLotToLots.set(sousLotKey, lotKey);
            }

            // Permettre les sous lots en doublon à l'intérieur du même lot
            if (!seen.lotToSousLots.has(lotKey)) {
                seen.lotToSousLots.set(lotKey, new Set());
            }
            const sousLotsInLot = seen.lotToSousLots.get(lotKey);
            sousLotsInLot.add(sousLotKey);

            return true;
        });

        return {
            filteredData,
            errors
        };
    }

    // استدعاء الدالة
    const { filteredData, errors } = filterData(data);

    console.log('Filtered Data:', filteredData);
    console.log('Errors:', errors);

    createTable(errors);

</script>

</body>
</html>
