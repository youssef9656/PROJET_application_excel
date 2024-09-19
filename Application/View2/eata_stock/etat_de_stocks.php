<?php
include '../../Config/check_session.php';
checkUserRole('admin');

include '../../Config/connect_db.php'; $pageName= 'Catalogue du temps'; ?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Etat des stocks</title>
    <script src="../../includes/jquery.sheetjs.js"></script>
    <link rel="stylesheet" href="../../includes/css/bootstrap.min.css">
<!--    <script src="libriryPdf/unpkg/jspdf.min.js"></script>-->
    <script src="libriryPdf/unpkg/jspdf.umd.min.js"></script>


    <style>
        #divbesoin{
            /*position: absolute;*/
            /*top: 20%;*/
            /*z-index: 10 !important;*/
            /*height: 500px;*/

        }


        .table-container {
            max-height: 500px; /* Adjust as needed */
            overflow-y: auto;
            border: 1px solid #dee2e6;
            border-radius: .25rem;
            width: 100%;

        }
        .table thead th {
            position: sticky;
            top: 0;
            background-color: #115faf; /* Dark background for sticky header */
            color: white;
            z-index: 10;
        }
        .btn {
            margin-top: 10px;
        }

        @media print {
            body * {
                visibility: hidden;
            }

            #articles_table * {
                visibility: visible;
            }
            #articles_table{
                position: absolute;
                left: 0;
                top:0;
            }



        }
    </style>
</head>
<body>
<?php
$pageName= 'Etat des stocks';
include '../../includes/header.php';
?>

<div id="divbesoin"  class="container m-2">

</div>
<style>
    /* From Uiverse.io by vinodjangid07 */
    .Btn {
        width: 50px;
        height: 50px;
        border: none;
        border-radius: 50%;
        background-color: rgb(27, 27, 27);
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        position: relative;
        transition-duration: .3s;
        box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.11);
    }

    .svgIcon {
        fill: rgb(214, 178, 255);
    }

    .icon2 {
        width: 18px;
        height: 5px;
        border-bottom: 2px solid rgb(182, 143, 255);
        border-left: 2px solid rgb(182, 143, 255);
        border-right: 2px solid rgb(182, 143, 255);
    }

    .tooltip {
        position: absolute;
        right: -105px;
        opacity: 0;
        background-color: rgb(12, 12, 12);
        color: white;
        padding: 5px 10px;
        border-radius: 5px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition-duration: .2s;
        pointer-events: none;
        letter-spacing: 0.5px;
    }

    .tooltip::before {
        position: absolute;
        content: "";
        width: 10px;
        height: 10px;
        background-color: rgb(12, 12, 12);
        background-size: 1000%;
        background-position: center;
        transform: rotate(45deg);
        left: -5%;
        transition-duration: .3s;
    }

    .Btn:hover .tooltip {
        opacity: 1;
        transition-duration: .3s;
    }

    .Btn:hover {
        background-color: rgb(150, 94, 255);
        transition-duration: .3s;
    }

    .Btn:hover .icon2 {
        border-bottom: 2px solid rgb(235, 235, 235);
        border-left: 2px solid rgb(235, 235, 235);
        border-right: 2px solid rgb(235, 235, 235);
    }

    .Btn:hover .svgIcon {
        fill: rgb(255, 255, 255);
        animation: slide-in-top 0.6s cubic-bezier(0.250, 0.460, 0.450, 0.940) both;
    }

    @keyframes slide-in-top {
        0% {
            transform: translateY(-10px);
            opacity: 0;
        }

        100% {
            transform: translateY(0px);
            opacity: 1;
        }
    }

</style>


<div class="m-2">
<!--    <h3 class="mb">Etat des stocks</h3>-->
    <div class="form col-12 mb-3 " style="display: flex;flex-flow: row;gap: 20px">
        <div class="col-2">
            <label for="start_date">Date de début:</label>
            <input type="date" id="start_date" class="form-control">
        </div>
        <div class="col-2">
            <label for="end_date">Date de fin:</label>
            <input type="date" id="end_date" class="form-control">
        </div>
        <div class="col-2">
            <label for="status_filter">Filtrer par statut:</label>
            <select id="status_filter" class="form-control">
                <option value="">Tous</option>
                <option value="besoin">Besoin</option>
                <option value="bon">Bon</option>
            </select>
        </div>
        <button onclick="fetchData()" class="btn btn-primary">Rechercher</button>
        <button class="Btn btn" id="downloadPdfButton">
            <svg class="svgIcon" viewBox="0 0 384 512" height="1em" xmlns="http://www.w3.org/2000/svg"><path d="M169.4 470.6c12.5 12.5 32.8 12.5 45.3 0l160-160c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L224 370.8 224 64c0-17.7-14.3-32-32-32s-32 14.3-32 32l0 306.7L54.6 265.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3l160 160z"></path></svg>
            <span class="icon2"></span>
            <span class="tooltip">Download</span>
        </button>
<!--        <button class="Btn btn" onclick="printtable()" id="downloadPdfButton">-->
<!--            <svg class="svgIcon" viewBox="0 0 384 512" height="1em" xmlns="http://www.w3.org/2000/svg"><path d="M169.4 470.6c12.5 12.5 32.8 12.5 45.3 0l160-160c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L224 370.8 224 64c0-17.7-14.3-32-32-32s-32 14.3-32 32l0 306.7L54.6 265.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3l160 160z"></path></svg>-->
<!--            <span class="icon2"></span>-->
<!--            <span class="tooltip">Download</span>-->
<!--        </button>-->
    </div>

<div style="display:flex;flex-flow: row">
    <div class="table-container mt-4" >
        <table id="articles_table" class="table table-Primary table-bordered table-hover  table-group-divider sheetjs" >
            <thead class="thead-dark">
            <tr>
                <th>ID</th>
                <th>Article</th>
                <th>Stock Initial</th>
                <th>Total Entrées</th>
                <th>Total Sorties</th>
                <th>Stock Final</th>
                <th>Prix Moyen</th>
                <th>Valeur Stock</th>
                <th>Total Depenses Entrées</th> <!-- العمود الجديد -->
                <th>Total Depenses Sorties</th> <!-- العمود الجديد -->
                <th>Stock Min</th>
                <th>Besoin</th>
            </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>

    <table class="table table-bordered table-hover table-primary sheetjs" style="width: 150px; margin-left:10px; height: 150px ">
        <thead>
        <tr>
            <th >Valeur Stock final </th>
            <td id="totale_Stock_final"></td>

        </tr>
        <tr>
            <th>Total Depenses Entrées final </th>
            <td id="Total_Entrees_final"></td>

        </tr>
        <tr>
            <th> Entrées Total Depenses Sorties final </th>
            <td id="Total_Sorties_final"></td>

        </tr>
        <tr >
            <td style="background-color: #00a357">Total </td>
            <td id="Total_final" style="background-color: #00a357"></td>

        </tr>
        </thead>

    </table>

</div>
</div>

<!-- Bootstrap JS and dependencies -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
    function fetchData() {
        let currentDate = new Date();
        currentDate.setFullYear(currentDate.getFullYear() + 2);

        const startDate = document.getElementById('start_date').value || '1970-01-01'; // Default start date
        const endDate = document.getElementById('end_date').value || currentDate.toISOString().split('T')[0]; // Default end date
        const statusFilter = document.getElementById('status_filter').value;

        fetch(`fetch_data.php?start_date=${startDate}&end_date=${endDate}&status_filter=${statusFilter}`)
            .then(response => response.json())
            .then(data => {
                const tableBody = document.getElementById('articles_table').getElementsByTagName('tbody')[0];
                tableBody.innerHTML = ''; // Clear the current table content

                data.forEach(row => {
                    const tr = document.createElement('tr');

                    // Add cells in the specified order
                    const fields = ['ID', 'Article', 'Stock_Initial', 'Total_Entry_Operations', 'Total_Exit_Operations', 'Stock_Final', 'Prix', 'Stock_Value', 'Total_Depenses_Entree', 'Total_Depenses_Sortie', 'Stock_Min', 'Requirement_Status'];

                    fields.forEach(field => {
                        const td = document.createElement('td');
                        td.textContent = row[field] || ''; // Ensure to handle missing data
                        tr.appendChild(td);
                    });

                    tableBody.appendChild(tr);
                });

                color();  // assuming color is a function defined elsewhere
                calcule();  // assuming calcule is a function defined elsewhere

            })
            .catch(error => console.error('Error fetching data:', error));
    }

    function color(){
        let article = []
         document.querySelectorAll("td").forEach((td)=>{
             if(td.innerText=="besoin"){
                 td.style.backgroundColor="rgba(255,0,26,0.74)"
                 article.push(td.parentElement.children[1].innerText)

             }else if(td.innerText=="bon"){
                 td.style.backgroundColor="rgba(80,227,143,0.72)"

             }

         })
        let meesge = `<div class="alert alert-danger alert-dismissible fade show" role="alert" role="alert" >Nous constatons que l'article <a href="#" class="alert-link fs-4"> ${article}</a> est en rupture ou en quantité insuffisante. Il est essentiel de réapprovisionner cet article dans les plus brefs délais afin de garantir la continuité des opérations. Merci de prendre les mesures nécessaires pour assurer la disponibilité de ${article}.  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>`
        if(article.length>0){
            document.getElementById("divbesoin").innerHTML=meesge

        }

    }

    function calcule(){
        var totale_Stock_final = 0
        var Total_Entrees_final = 0
        var Total_Sorties_final = 0
        let Total_final = 0


        document.querySelectorAll("#articles_table > tbody > tr").forEach((row)=>{

            totale_Stock_final+=parseFloat(row.children[7].innerText)
            Total_Entrees_final	+=parseFloat(row.children[8].innerText)
            Total_Sorties_final+=parseFloat(row.children[9].innerText)
            Total_final = (totale_Stock_final + Total_Entrees_final - Total_Sorties_final)

        })
document.getElementById("totale_Stock_final").innerText=totale_Stock_final.toFixed(2)
document.getElementById("Total_Entrees_final").innerText=Total_Entrees_final.toFixed(2)
 document.getElementById("Total_Sorties_final").innerText=Total_Sorties_final.toFixed(2)
 document.getElementById("Total_final").innerText=Total_final.toFixed(2)



    }

    function printtable(){
        window.print()
    }

    // Fetch data on page load without any filters (show all data)
    document.addEventListener('DOMContentLoaded', fetchData);
</script>
<script src="../../includes/js/bootstrap.bundle.min.js"></script>
<script src="pdf.js"></script>


</body>
</html>
