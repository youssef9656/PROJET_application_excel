<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Graph with Filters</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
<h1>Graph with Filters</h1>

<!-- فلاتر الاختيار -->
<label for="lotSelect">Lot:</label>
<select id="lotSelect" onchange="updateSousLot()">
    <option value="">All</option>
    <!-- سيتم ملء الخيارات بناءً على البيانات -->
</select>

<label for="sousLotSelect">Sous-lot:</label>
<select id="sousLotSelect" onchange="updateArticle()">
    <option value="">All</option>
    <!-- سيتم ملء الخيارات بناءً على البيانات -->
</select>

<label for="articleSelect">Article:</label>
<select id="articleSelect">
    <option value="">All</option>
    <!-- سيتم ملء الخيارات بناءً على البيانات -->
</select>

<label for="fournisseurSelect">Fournisseur:</label>
<select id="fournisseurSelect">
    <option value="">All</option>
    <!-- سيتم ملء الخيارات بناءً على البيانات -->
</select>

<label for="startDate">Start Date:</label>
<input type="date" id="startDate">

<label for="endDate">End Date:</label>
<input type="date" id="endDate">

<button onclick="fetchData()">Apply Filters</button>

<!-- الرسم البياني الأول -->
<canvas id="chart1" width="400" height="200"></canvas>
<!-- الرسم البياني الثاني -->
<canvas id="chart2" width="400" height="200"></canvas>

<script>
    let chart1, chart2;

    function fetchData() {
        const lot = document.getElementById('lotSelect').value;
        const sousLot = document.getElementById('sousLotSelect').value;
        const article = document.getElementById('articleSelect').value;
        const fournisseur = document.getElementById('fournisseurSelect').value;
        const startDate = document.getElementById('startDate').value;
        const endDate = document.getElementById('endDate').value;

        fetch(`getData.php?lot=${lot}&sous_lot=${sousLot}&article=${article}&fournisseur=${fournisseur}&start_date=${startDate}&end_date=${endDate}`)
            .then(response => response.json())
            .then(data => {
                const labels = data.map(d => d.date_operation);
                const entreeOperationData = data.map(d => d.entree_operation);
                const prixOperationData = data.map(d => d.prix_operation);

                // تحديث الرسم البياني الأول
                if (chart1) chart1.destroy();
                const ctx1 = document.getElementById('chart1').getContext('2d');
                chart1 = new Chart(ctx1, {
                    type: 'line',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Entree Operation',
                            data: entreeOperationData,
                            borderColor: 'blue',
                            backgroundColor: 'rgba(0, 0, 255, 0.2)'
                        }]
                    },
                    options: {
                        scales: {
                            x: { title: { text: 'Date', display: true } },
                            y: { title: { text: 'Entree Operation', display: true } }
                        }
                    }
                });

                // تحديث الرسم البياني الثاني
                if (chart2) chart2.destroy();
                const ctx2 = document.getElementById('chart2').getContext('2d');
                chart2 = new Chart(ctx2, {
                    type: 'line',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Prix Operation',
                            data: prixOperationData,
                            borderColor: 'red',
                            backgroundColor: 'rgba(255, 0, 0, 0.2)'
                        }]
                    },
                    options: {
                        scales: {
                            x: { title: { text: 'Date', display: true } },
                            y: { title: { text: 'Prix Operation', display: true } }
                        }
                    }
                });
            })
            .catch(error => console.error('Error fetching data:', error));
    }

    function updateSousLot() {
        const lot = document.getElementById('lotSelect').value;
        fetch(`getSousLot.php?lot=${lot}`)
            .then(response => response.json())
            .then(data => {
                const sousLotSelect = document.getElementById('sousLotSelect');
                sousLotSelect.innerHTML = '<option value="">All</option>';
                data.forEach(sousLot => {
                    const option = document.createElement('option');
                    option.value = sousLot.sous_lot_name;
                    option.textContent = sousLot.sous_lot_name;
                    sousLotSelect.appendChild(option);
                });
                updateArticle(); // تحديث قائمة المقالات عند تغيير الـ sous-lot
            });
    }

    function updateArticle() {
        const sousLot = document.getElementById('sousLotSelect').value;
        fetch(`getArticle.php?sous_lot=${sousLot}`)
            .then(response => response.json())
            .then(data => {
                const articleSelect = document.getElementById('articleSelect');
                articleSelect.innerHTML = '<option value="">All</option>';
                data.forEach(article => {
                    const option = document.createElement('option');
                    option.value = article.nom_article;
                    option.textContent = article.nom_article;
                    articleSelect.appendChild(option);
                });
            });
    }

    window.onload = function() {
        fetchData();

        fetch('getFilters.php')
            .then(response => response.json())
            .then(filters => {
                const lotSelect = document.getElementById('lotSelect');
                const fournisseurSelect = document.getElementById('fournisseurSelect');

                filters.lot.forEach(lot => {
                    const option = document.createElement('option');
                    option.value = lot.lot_name;
                    option.textContent = lot.lot_name;
                    lotSelect.appendChild(option);
                });

                filters.fournisseur.forEach(fournisseur => {
                    const option = document.createElement('option');
                    option.value = fournisseur.nom_pre_fournisseur;
                    option.textContent = fournisseur.nom_pre_fournisseur;
                    fournisseurSelect.appendChild(option);
                });
            });
    };
    function updateSousLot() {
        const lot = document.getElementById('lotSelect').value;
        fetch(`getSousLot.php?lot=${lot}`)
            .then(response => response.json())
            .then(data => {
                const sousLotSelect = document.getElementById('sousLotSelect');
                sousLotSelect.innerHTML = '<option value="">All</option>';
                data.forEach(sousLot => {
                    const option = document.createElement('option');
                    option.value = sousLot.sous_lot_name;
                    option.textContent = sousLot.sous_lot_name;
                    sousLotSelect.appendChild(option);
                });
                updateArticle(); // تحديث قائمة المقالات عند تغيير الـ sous-lot
            })
            .catch(error => console.error('Error fetching sous-lots:', error));
    }


    function updateArticle() {
        const sousLot = document.getElementById('sousLotSelect').value;
        fetch(`getArticle.php?sous_lot=${sousLot}`)
            .then(response => response.json())
            .then(data => {
                const articleSelect = document.getElementById('articleSelect');
                articleSelect.innerHTML = '<option value="">All</option>';
                data.forEach(article => {
                    const option = document.createElement('option');
                    option.value = article.nom_article;
                    option.textContent = article.nom_article;
                    articleSelect.appendChild(option);
                });
            })
            .catch(error => console.error('Error fetching articles:', error));
    }

    window.onload = function() {
        fetchData();
        fetch('getFilters.php')
            .then(response => response.json())
            .then(filters => {
                const lotSelect = document.getElementById('lotSelect');
                const fournisseurSelect = document.getElementById('fournisseurSelect');

                filters.lot.forEach(lot => {
                    const option = document.createElement('option');
                    option.value = lot.lot_name;
                    option.textContent = lot.lot_name;
                    lotSelect.appendChild(option);
                });

                filters.fournisseur.forEach(fournisseur => {
                    const option = document.createElement('option');
                    option.value = fournisseur.nom_pre_fournisseur;
                    option.textContent = fournisseur.nom_pre_fournisseur;
                    fournisseurSelect.appendChild(option);
                });
            })
            .catch(error => console.error('Error fetching filters:', error));
    };

</script>

</body>
</html>
