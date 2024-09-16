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
    // Données JSON
    const data = [{"lot":"youssef","sous lot":"hhh","fournisseur":"hysdh sdhhj","articles":"hhhhhhhhhh","description":"jjjjjjj","unité":"hhhh","p.u.ttc":"YYY","stock initial":"110,000","stock min":"22"},{"lot":"jjjjjjjjjjjj","sous lot":"hhh","fournisseur":"gsfdg sdfhjgh","articles":"LAIT DE COCO 400G","description":"FG","unité":"BT","p.u.ttc":"――","stock initial":"10,000","stock min":"22"},{"lot":"LOT PRODUITS LAITIREES","sous lot":"hhh","fournisseur":"DRISS ADIL","articles":"RECOTTA 294G","description":"FG","unité":"KG","p.u.ttc":"――","stock initial":"29,000","stock min":"22"},{"lot":"LOT PRODUITS LAITIREES","sous lot":"e","fournisseur":"DRISS ADIL","articles":"FROMAGE PARMESAN","description":"GG","unité":"KG","p.u.ttc":"――","stock initial":"6,900","stock min":"2"},{"lot":"MOU","sous lot":"JJJJJJJJ","fournisseur":"KKK MPOY","articles":"FRO","description":"yyyyyyyyyyyyyy","unité":"SEAU","p.u.ttc":"――","stock initial":"1,000","stock min":"2"},{"lot":"LOT EPICERIE,CONSERV ET SAUCE","sous lot":"S/LOT CONSERVES","fournisseur":"MED ALI","articles":"FILET D'ANCHOIS MARINE 0,75 KG","description":"FG","unité":"BT","p.u.ttc":"――","stock initial":"12,000","stock min":"2"},{"lot":"LOT EPICERIE,CONSERV ET SAUCE","sous lot":"S/LOT CONSERVES","fournisseur":"MED ALI","articles":"CAPRE AU VINAIGRE BANGOR 4/4","description":"DF","unité":"BT","p.u.ttc":"――","stock initial":"3,000","stock min":"2"},{"lot":"LOT EPICERIE,CONSERV ET SAUCE","sous lot":"S/LOT CONSERVES","fournisseur":"MED ALI","articles":"CORNICHONS 1,6 KG","description":"CV","unité":"UT","p.u.ttc":"――","stock initial":"7,000","stock min":"2"},{"lot":"LOT EPICERIE,CONSERV ET SAUCE","sous lot":"S/LOT CONSERVES","fournisseur":"MED ALI","articles":"POIVRE VERT 35G","description":"DF","unité":"UT","p.u.ttc":"jjj","stock initial":"21,000","stock min":"222"},{"lot":"LOT EPICERIE,CONSERV ET SAUCE","sous lot":"S/LOT CONSERVES","fournisseur":"MED ALI","articles":"GERM DE SOJA","description":"DF","unité":"BT","p.u.ttc":"――","stock initial":"21,000","stock min":"222"},{"lot":"LOT EPICERIE,CONSERV ET SAUCE","sous lot":"S/LOT CONSERVES","fournisseur":"MED ALI","articles":"MAIS DADISOL BOITE 1/2","description":"DF","unité":"BT","p.u.ttc":"――","stock initial":"0,000","stock min":"222"},{"lot":"LOT EPICERIE,CONSERV ET SAUCE","sous lot":"S/LOT CONSERVES","fournisseur":"MED ALI","articles":"TOMATE CONCENTRE 4/4","description":"FG","unité":"BT","p.u.ttc":"――","stock initial":"21,000","stock min":"222"},{"lot":"h+I14+A2:I14","sous lot":"hhh","fournisseur":"ttt","articles":"hhhhhhhhhh","description":"jjjjjjj","unité":"hhhh","p.u.ttc":"YYY","stock initial":"110,001","stock min":"228.060606060606"},{"lot":"LOT PRODUITS LAITIREES","sous lot":"e","fournisseur":"gsfdg sdfhjgh","articles":"LAIT DE COCO 400G","description":"FG","unité":"BT","p.u.ttc":"――","stock initial":"10,001","stock min":"250.787878787879"},{"lot":"LOT PRODUITS LAITIREES","sous lot":"e7777778","fournisseur":"DRISS ADIL","articles":"RECOTTA 294G","description":"FG","unité":"KG","p.u.ttc":"――","stock initial":"29,001","stock min":"273.515151515151"},{"lot":"LOT PRODUITS LAITIREES","sous lot":"e","fournisseur":"DRISS ADIL","articles":"FROMAGE PARMESAN","description":"GG","unité":"KG","p.u.ttc":"――","stock initial":"6,901","stock min":"296.242424242424"},{"lot":"MOU","sous lot":"JJJJJJJJ","fournisseur":"KKK MPOY","articles":"FRO","description":"yyyyyyyyyyyyyy","unité":"SEAU","p.u.ttc":"――","stock initial":"1,001","stock min":"318.969696969697"},{"lot":"LOT EPICERIE,CONSERV ET SAUCE","sous lot":"S/LOT CONSERVES","fournisseur":"MED ALI","articles":"FILET D'ANCHOIS MARINE 0,75 KG","description":"FG","unité":"BT","p.u.ttc":"――","stock initial":"12,001","stock min":"341.69696969697"},{"lot":"LOT EPICERIE,CONSERV ET SAUCE","sous lot":"S/LOT CONSERVES","fournisseur":"MED ALI","articles":"CAPRE AU VINAIGRE BANGOR 4/5","description":"DF","unité":"BT","p.u.ttc":"――","stock initial":"3,001","stock min":"364.424242424242"},{"lot":"LOT EPICERIE,CONSERV ET SAUCE","sous lot":"S/LOT CONSERVES","fournisseur":"MED ALI","articles":"CORNICHONS 1,6 KG","description":"CV","unité":"UT","p.u.ttc":"――","stock initial":"7,001","stock min":"387.151515151515"},{"lot":"LOT EPICERIE,CONSERV ET SAUCE","sous lot":"S/LOT CONSERVES","fournisseur":"MED ALI","articles":"POIVRE VERT 35G","description":"DF","unité":"UT","p.u.ttc":"jjj","stock initial":"21,000","stock min":"409.878787878788"},{"lot":"LOT EPICERIE,CONSERV ET SAUCE","sous lot":"S/LOT CONSERVES","fournisseur":"MED ALI","articles":"GERM DE SOJA","description":"DF","unité":"BT","p.u.ttc":"――","stock initial":"21,000","stock min":"432.606060606061"},{"lot":"LOT EPICERIE,CONSERV ET SAUCE","sous lot":"S/LOT CONSERVES","fournisseur":"MED ALI","articles":"MAIS DADISOL BOITE 1/3","description":"DF","unité":"BT","p.u.ttc":"――","stock initial":"0,001","stock min":"455.333333333333"},{"lot":"LOT EPICERIE,CONSERV ET SAUCE","sous lot":"S/LOT CONSERVES","fournisseur":"MED ALI","articles":"TOMATE CONCENTRE 4/5","description":"FG","unité":"BT","p.u.ttc":"――","stock initial":"21,001","stock min":"478.060606060606"},{"lot":"h+I14+A2:I15","sous lot":"hhh","fournisseur":"hysdh sdhhj","articles":"hhhhhhhhhh","description":"jjjjjjj","unité":"hhhh","p.u.ttc":"YYY","stock initial":"110,002","stock min":"500.787878787879"},{"lot":"LOT PRODUITS LAITIREES","sous lot":"e","fournisseur":"gsfdg sdfhjgh","articles":"LAIT DE COCO 400G","description":"FG","unité":"BT","p.u.ttc":"――","stock initial":"10,002","stock min":"523.515151515151"},{"lot":"LOT PRODUITS LAITIREES","sous lot":"e7777779","fournisseur":"DRISS ADIL","articles":"RECOTTA 294G","description":"FG","unité":"KG","p.u.ttc":"――","stock initial":"29,002","stock min":"546.242424242424"},{"lot":"LOT PRODUITS LAITIREES","sous lot":"e","fournisseur":"DRISS ADIL","articles":"FROMAGE PARMESAN","description":"GG","unité":"KG","p.u.ttc":"――","stock initial":"6,902","stock min":"568.969696969697"},{"lot":"MOU","sous lot":"JJJJJJJJ","fournisseur":"KKK MPOY","articles":"FRO","description":"yyyyyyyyyyyyyy","unité":"SEAU","p.u.ttc":"――","stock initial":"1,002","stock min":"591.69696969697"},{"lot":"LOT EPICERIE,CONSERV ET SAUCE","sous lot":"S/LOT CONSERVES","fournisseur":"MED ALI","articles":"FILET D'ANCHOIS MARINE 0,75 KG","description":"FG","unité":"BT","p.u.ttc":"――","stock initial":"12,002","stock min":"614.424242424242"},{"lot":"LOT EPICERIE,CONSERV ET SAUCE","sous lot":"S/LOT CONSERVES","fournisseur":"MED ALI","articles":"CAPRE AU VINAIGRE BANGOR 4/6","description":"DF","unité":"BT","p.u.ttc":"――","stock initial":"3,002","stock min":"637.151515151515"},{"lot":"LOT EPICERIE,CONSERV ET SAUCE","sous lot":"S/LOT CONSERVES","fournisseur":"MED ALI","articles":"CORNICHONS 1,6 KG","description":"CV","unité":"UT","p.u.ttc":"――","stock initial":"7,002","stock min":"659.878787878788"},{"lot":"LOT EPICERIE,CONSERV ET SAUCE","sous lot":"S/LOT CONSERVES","fournisseur":"MED ALI","articles":"POIVRE VERT 35G","description":"DF","unité":"UT","p.u.ttc":"jjj","stock initial":"21,000","stock min":"682.606060606061"},{"lot":"LOT EPICERIE,CONSERV ET SAUCE","sous lot":"S/LOT CONSERVES","fournisseur":"MED ALI","articles":"GERM DE SOJA","description":"DF","unité":"BT","p.u.ttc":"――","stock initial":"21,000","stock min":"705.333333333333"},{"lot":"LOT EPICERIE,CONSERV ET SAUCE","sous lot":"S/LOT CONSERVES","fournisseur":"MED ALI","articles":"MAIS DADISOL BOITE 1/4","description":"DF","unité":"BT","p.u.ttc":"――","stock initial":"0,002","stock min":"728.060606060606"},{"lot":"LOT EPICERIE,CONSERV ET SAUCE","sous lot":"S/LOT CONSERVES","fournisseur":"MED ALI","articles":"TOMATE CONCENTRE 4/6","description":"FG","unité":"BT","p.u.ttc":"――","stock initial":"21,002","stock min":"750.787878787879"},{"lot":"h+I14+A2:I16","sous lot":"hhh","fournisseur":"hysdh sdhhj","articles":"hhhhhhhhhh","description":"jjjjjjj","unité":"hhhh","p.u.ttc":"YYY","stock initial":"110,003","stock min":"773.515151515152"},{"lot":"LOT PRODUITS LAITIREES","sous lot":"e","fournisseur":"gsfdg sdfhjgh","articles":"LAIT DE COCO 400G","description":"FG","unité":"BT","p.u.ttc":"――","stock initial":"10,003","stock min":"796.242424242424"},{"lot":"LOT PRODUITS LAITIREES","sous lot":"e7777780","fournisseur":"DRISS ADIL","articles":"RECOTTA 294G","description":"FG","unité":"KG","p.u.ttc":"――","stock initial":"29,003","stock min":"818.969696969697"},{"lot":"LOT PRODUITS LAITIREES","sous lot":"e","fournisseur":"DRISS ADIL","articles":"FROMAGE PARMESAN","description":"GG","unité":"KG","p.u.ttc":"――","stock initial":"6,903","stock min":"841.69696969697"},{"lot":"MOU","sous lot":"JJJJJJJJ","fournisseur":"KKK MPOY","articles":"FRO","description":"yyyyyyyyyyyyyy","unité":"SEAU","p.u.ttc":"――","stock initial":"1,003","stock min":"864.424242424243"},{"lot":"LOT EPICERIE,CONSERV ET SAUCE","sous lot":"S/LOT CONSERVES","fournisseur":"MED ALI","articles":"FILET D'ANCHOIS MARINE 0,75 KG","description":"FG","unité":"BT","p.u.ttc":"――","stock initial":"12,003","stock min":"887.151515151515"},{"lot":"LOT EPICERIE,CONSERV ET SAUCE","sous lot":"S/LOT CONSERVES","fournisseur":"MED ALI","articles":"CAPRE AU VINAIGRE BANGOR 4/7","description":"DF","unité":"BT","p.u.ttc":"――","stock initial":"3,003","stock min":"909.878787878788"},{"lot":"LOT EPICERIE,CONSERV ET SAUCE","sous lot":"S/LOT CONSERVES","fournisseur":"MED ALI","articles":"CORNICHONS 1,6 KG","description":"CV","unité":"UT","p.u.ttc":"――","stock initial":"7,003","stock min":"932.606060606061"},{"lot":"LOT EPICERIE,CONSERV ET SAUCE","sous lot":"S/LOT CONSERVES","fournisseur":"MED ALI","articles":"POIVRE VERT 35G","description":"DF","unité":"UT","p.u.ttc":"jjj","stock initial":"21,000","stock min":"955.333333333333"},{"lot":"LOT EPICERIE,CONSERV ET SAUCE","sous lot":"S/LOT CONSERVES","fournisseur":"MED ALI","articles":"GERM DE SOJA","description":"DF","unité":"BT","p.u.ttc":"――","stock initial":"21,000","stock min":"978.060606060603"},{"lot":"LOT EPICERIE,CONSERV ET SAUCE","sous lot":"S/LOT CONSERVES","fournisseur":"MED ALI","articles":"MAIS DADISOL BOITE 1/5","description":"DF","unité":"BT","p.u.ttc":"――","stock initial":"0,003","stock min":"1000.78787878788"},{"lot":"LOT EPICERIE,CONSERV ET SAUCE","sous lot":"S/LOT CONSERVES","fournisseur":"MED ALI","articles":"TOMATE CONCENTRE 4/7","description":"FG","unité":"BT","p.u.ttc":"――","stock initial":"21,003","stock min":"1023.51515151515"},{"lot":"h+I14+A2:I17","sous lot":"hhh","fournisseur":"hysdh sdhhj","articles":"hhhhhhhhhh","description":"jjjjjjj","unité":"hhhh","p.u.ttc":"YYY","stock initial":"110,004","stock min":"1046.24242424242"},{"lot":"LOT PRODUITS LAITIREES","sous lot":"e","fournisseur":"gsfdg sdfhjgh","articles":"LAIT DE COCO 400G","description":"FG","unité":"BT","p.u.ttc":"――","stock initial":"10,004","stock min":"1068.96969696969"},{"lot":"LOT PRODUITS LAITIREES","sous lot":"e7777781","fournisseur":"DRISS ADIL","articles":"RECOTTA 294G","description":"FG","unité":"KG","p.u.ttc":"――","stock initial":"29,004","stock min":"1091.69696969697"},{"lot":"LOT PRODUITS LAITIREES","sous lot":"e","fournisseur":"DRISS ADIL","articles":"FROMAGE PARMESAN","description":"GG","unité":"KG","p.u.ttc":"――","stock initial":"6,904","stock min":"1114.42424242424"},{"lot":"MOU","sous lot":"JJJJJJJJ","fournisseur":"KKK MPOY","articles":"FRO","description":"yyyyyyyyyyyyyy","unité":"SEAU","p.u.ttc":"――","stock initial":"1,004","stock min":"1137.15151515151"},{"lot":"LOT EPICERIE,CONSERV ET SAUCE","sous lot":"S/LOT CONSERVES","fournisseur":"MED ALI","articles":"FILET D'ANCHOIS MARINE 0,75 KG","description":"FG","unité":"BT","p.u.ttc":"――","stock initial":"12,004","stock min":"1159.87878787879"},{"lot":"LOT EPICERIE,CONSERV ET SAUCE","sous lot":"S/LOT CONSERVES","fournisseur":"MED ALI","articles":"CAPRE AU VINAIGRE BANGOR 4/8","description":"DF","unité":"BT","p.u.ttc":"――","stock initial":"3,004","stock min":"1182.60606060606"},{"lot":"LOT EPICERIE,CONSERV ET SAUCE","sous lot":"S/LOT CONSERVES","fournisseur":"MED ALI","articles":"CORNICHONS 1,6 KG","description":"CV","unité":"UT","p.u.ttc":"――","stock initial":"7,004","stock min":"1205.33333333333"},{"lot":"LOT EPICERIE,CONSERV ET SAUCE","sous lot":"S/LOT CONSERVES","fournisseur":"MED ALI","articles":"POIVRE VERT 35G","description":"DF","unité":"UT","p.u.ttc":"jjj","stock initial":"21,000","stock min":"1228.0606060606"},{"lot":"LOT EPICERIE,CONSERV ET SAUCE","sous lot":"S/LOT CONSERVES","fournisseur":"MED ALI","articles":"GERM DE SOJA","description":"DF","unité":"BT","p.u.ttc":"――","stock initial":"21,000","stock min":"1250.78787878788"},{"lot":"LOT EPICERIE,CONSERV ET SAUCE","sous lot":"S/LOT CONSERVES","fournisseur":"MED ALI","articles":"MAIS DADISOL BOITE 1/6","description":"DF","unité":"BT","p.u.ttc":"――","stock initial":"0,004","stock min":"1273.51515151515"},{"lot":"LOT EPICERIE,CONSERV ET SAUCE","sous lot":"S/LOT CONSERVES","fournisseur":"MED ALI","articles":"TOMATE CONCENTRE 4/8","description":"FG","unité":"BT","p.u.ttc":"――","stock initial":"21,004","stock min":"1296.24242424242"},{"lot":"h+I14+A2:I18","sous lot":"hhh","fournisseur":"hysdh sdhhj","articles":"hhhhhhhhhh","description":"jjjjjjj","unité":"hhhh","p.u.ttc":"YYY","stock initial":"110,005","stock min":"1318.96969696969"},{"lot":"LOT PRODUITS LAITIREES","sous lot":"e","fournisseur":"gsfdg sdfhjgh","articles":"LAIT DE COCO 400G","description":"FG","unité":"BT","p.u.ttc":"――","stock initial":"10,005","stock min":"1341.69696969697"},{"lot":"LOT PRODUITS LAITIREES","sous lot":"e7777782","fournisseur":"DRISS ADIL","articles":"RECOTTA 294G","description":"FG","unité":"KG","p.u.ttc":"――","stock initial":"29,005","stock min":"1364.42424242424"},{"lot":"LOT PRODUITS LAITIREES","sous lot":"e","fournisseur":"DRISS ADIL","articles":"FROMAGE PARMESAN","description":"GG","unité":"KG","p.u.ttc":"――","stock initial":"6,905","stock min":"1387.15151515151"},{"lot":"MOU","sous lot":"JJJJJJJJ","fournisseur":"KKK MPOY","articles":"FRO","description":"yyyyyyyyyyyyyy","unité":"SEAU","p.u.ttc":"――","stock initial":"1,005","stock min":"1409.87878787879"},{"lot":"LOT EPICERIE,CONSERV ET SAUCE","sous lot":"S/LOT CONSERVES","fournisseur":"MED ALI","articles":"FILET D'ANCHOIS MARINE 0,75 KG","description":"FG","unité":"BT","p.u.ttc":"――","stock initial":"12,005","stock min":"1432.60606060606"},{"lot":"LOT EPICERIE,CONSERV ET SAUCE","sous lot":"S/LOT CONSERVES","fournisseur":"MED ALI","articles":"CAPRE AU VINAIGRE BANGOR 4/9","description":"DF","unité":"BT","p.u.ttc":"――","stock initial":"3,005","stock min":"1455.33333333333"},{"lot":"LOT EPICERIE,CONSERV ET SAUCE","sous lot":"S/LOT CONSERVES","fournisseur":"MED ALI","articles":"CORNICHONS 1,6 KG","description":"CV","unité":"UT","p.u.ttc":"――","stock initial":"7,005","stock min":"1478.0606060606"},{"lot":"LOT EPICERIE,CONSERV ET SAUCE","sous lot":"S/LOT CONSERVES","fournisseur":"MED ALI","articles":"POIVRE VERT 35G","description":"DF","unité":"UT","p.u.ttc":"jjj","stock initial":"21,000","stock min":"1500.78787878788"},{"lot":"LOT EPICERIE,CONSERV ET SAUCE","sous lot":"S/LOT CONSERVES","fournisseur":"MED ALI","articles":"GERM DE SOJA","description":"DF","unité":"BT","p.u.ttc":"――","stock initial":"21,000","stock min":"1523.51515151515"},{"lot":"LOT EPICERIE,CONSERV ET SAUCE","sous lot":"S/LOT CONSERVES","fournisseur":"MED ALI","articles":"MAIS DADISOL BOITE 1/7","description":"DF","unité":"BT","p.u.ttc":"――","stock initial":"0,005","stock min":"1546.24242424242"},{"lot":"LOT EPICERIE,CONSERV ET SAUCE","sous lot":"S/LOT CONSERVES","fournisseur":"MED ALI","articles":"TOMATE CONCENTRE 4/9","description":"FG","unité":"BT","p.u.ttc":"――","stock initial":"21,005","stock min":"1568.96969696969"},{"lot":"hhhhhhhhhhhhhhhhhhhhhhhhhh","sous lot":"S/LOT CONSERVES","fournisseur":"MED ALI","articles":"TOMATE CONCENTRE 4/10","description":"FG","unité":"BT","p.u.ttc":"――","stock initial":"21,006","stock min":"1569.96969696969"}];

    // Fonction pour créer le tableau
    // const data = [
    //     {"lot":"youssef","sous lot":"hhh","fournisseur":"hysdh sdhhj","articles":"hhhhhhhhhh","description":"jjjjjjj","unité":"hhhh","p.u.ttc":"YYY","stock initial":"110,000","stock min":"22"},
    //     {"lot":"jjjjjjjjjjjj","sous lot":"hhh","fournisseur":"gsfdg sdfhjgh","articles":"LAIT DE COCO 400G","description":"FG","unité":"BT","p.u.ttc":"――","stock initial":"10,000","stock min":"22"},
    //     {"lot":"LOT PRODUITS LAITIREES","sous lot":"hhh","fournisseur":"DRISS ADIL","articles":"RECOTTA 294G","description":"FG","unité":"KG","p.u.ttc":"――","stock initial":"29,000","stock min":"22"}
    // ];

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
            lotToSousLots: new Map(),  // Map لتتبع sous lots داخل كل lot
            sousLotToLots: new Map()   // Map لتتبع sous lots عبر lots مختلفة
        };

        const errors = {
            duplicates: [],
            uniqueSousLots: []
        };

        const filteredData = data.filter(item => {
            const articleKey = item.articles;
            const lotKey = item.lot;
            const sousLotKey = item['sous lot'];

            // التحقق من تكرار articles
            if (seen.articles.has(articleKey)) {
                errors.duplicates.push({ item, reason: 'Duplicate article name' });
                return false;
            }
            seen.articles.add(articleKey);

            // التحقق من وجود sous lot في lot آخر
            if (seen.sousLotToLots.has(sousLotKey)) {
                const existingLot = seen.sousLotToLots.get(sousLotKey);
                if (existingLot !== lotKey) {
                    errors.uniqueSousLots.push({ item, reason: `Sous lot '${sousLotKey}' موجود في lot آخر: ${existingLot}` });
                    return false;
                }
            } else {
                seen.sousLotToLots.set(sousLotKey, lotKey);
            }

            // التحقق من التكرار داخل نفس lot
            if (!seen.lotToSousLots.has(lotKey)) {
                seen.lotToSousLots.set(lotKey, new Set());
            }
            const sousLotsInLot = seen.lotToSousLots.get(lotKey);
            if (sousLotsInLot.has(sousLotKey)) {
                errors.duplicates.push({ item, reason: `Duplicate sous lot '${sousLotKey}' in lot '${lotKey}'` });
                return false;
            }
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
