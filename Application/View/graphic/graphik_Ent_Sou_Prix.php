
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <script src="node_modules/chart.js"></script>
    <script>
        const myChart = new Chart(ctx, {...});
    </script>
</head>
<style>
    #mych{
        width: 500px;
        height: 400px;
        font-size: 300px;
    }
</style>
<body>
<div class="container">
    <h3 class="mb">Etat des stocks</h3>
    <div class="form col-12 mb-3 " style="display: flex;flex-flow: row;gap: 20px">
        <div class="col-2">
            <label for="start_date">Date de début:</label>
            <input type="date" id="start_date" class="form-control">
        </div>
        <div class="col-2">
            <label for="end_date">Date de fin:</label>
            <input type="date" id="end_date" class="form-control">
        </div>
        <button onclick="fetchData()" class="btn btn-primary">Rechercher</button>
    </div>

</div>


<div id="mych">
    <canvas id="myChart" ></canvas>
</div>

<script src="node_modules/chart.js/dist/chart.umd.js"></script>

<script>

    function fetchData(){

    }


    const labels = ['January', 'February', 'March', 'April', 'May', 'June', 'July'];

    const data = {
        labels: labels,
        datasets: [{
            label: 'My First Dataset',
            data: [65, 59, 80, 81, 56, 55, 40],
            fill: false,
            borderColor: 'rgb(75, 192, 192)',
            tension: 0.1
        }]
    };

    const config = {
        type: 'line',
        data: data,
    };

    // Sélection de l'élément canvas et création du graphique
    const ctx = document.getElementById('myChart').getContext('2d');
    const myChart = new Chart(ctx, config);

</script>
</body>

</html>