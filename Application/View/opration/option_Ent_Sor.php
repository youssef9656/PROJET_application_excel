

<?php include '../../Config/connect_db.php'; $pageName= 'Catalogue du temps'; ?>
<?php
$querySelect = "SELECT * FROM lots";
$paramsSelect = [];
$data = selectData($querySelect, $paramsSelect);

$queryProduit = "SELECT DISTINCT lot_name FROM lots";
$lot_name = selectData($queryProduit, []);


if( isset($_GET["lot_name"]) && empty(isset($_GET["sous_lot_name"]))){
    $lot_name = $_GET["lot_name"];

    $query2 = "
    SELECT sous_lots.sous_lot_id, sous_lots.sous_lot_name, sous_lots.lot_id, lots.lot_name
    FROM sous_lots
    JOIN lots ON sous_lots.lot_id = lots.lot_id where lots.lot_name ='$lot_name'";

    $queryProduit = "SELECT DISTINCT lot_name FROM lots";

    $lot_name = selectData($queryProduit, []);
    $sous_lot_name = mysqli_query($conn, $query2);

};

if (!empty(isset($_GET["lot_name"])) && !empty(isset($_GET["sous_lot_name"]))){
    echo "hhhh";
    $lot_name = $_GET["lot_name"];
    $sous_lot_name = $_GET["sous_lot_name"];

    $sql ="SELECT * FROM article
WHERE id_article IN (
    SELECT article_id
    FROM `sous_lot_articles`
    WHERE sous_lot_id = (
        SELECT sous_lot_id
        FROM `sous_lots`
        WHERE sous_lot_name = '$sous_lot_name'
    )
);";
 $result = $conn->query($sql);



}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="../../includes/jquery.sheetjs.js"></script>

    <title>Document</title>
    <link rel="stylesheet" href="../../includes/css/bootstrap.min.css">
</head>
<body>
<?php
$pageName= 'Opration';
include '../../includes/header.php';
?>
<div>
    <div style="display:flex;flex-flow: row wrap ;" id="divlotSous">
        <form>
        <h4 class="mt-2 ms-5"> Opration  <button class="show-form-btn" onclick="toggleForm()">+</button> </h4>
        <div class="col ms-5 mt-2">
            <div class="filter-inputs mb-3">
                <div class="form row"  >
                    <div class="col-3">
                        <input type="text" list='nom' class="form-control keepDatalist" placeholder="Nom"
                               id="lot_name" onchange="filterTable()">
                        <datalist id='nom'>
                            <option value=""></option>
                            <?php foreach($lot_name as $p):?>
                                <option value='<?= $p['lot_name'] ?>'><?= $p['lot_name'] ?></option>
                            <?php endforeach;?>
                        </datalist>
                    </div>
                    <div class="col-3" id="divsous_lot">
                        <input type="text" list='sous_lot' class="form-control keepDatalist" placeholder="Prenom"
                               id="sous_lot_name" >
                        <datalist id='sous_lot'>
                            <option value=""></option>
                            <?php foreach($sous_lot_name as $e):?>
                                <option value='<?= $e['sous_lot_name'] ?>'><?= $e['sous_lot_name'] ?></option>
                            <?php endforeach;?>
                        </datalist>
                    </div>
                </div>
            </div>
        </form>

        </div>
</div>

<div id="tab1">

</div>






</body>
<script src="../../includes/js/bootstrap.bundle.min.js"></script>
<script src="script.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const  lot_name = document.getElementById('lot_name');
        const  sous_lot_name = document.getElementById('sous_lot_name');
        window.filterTable = function() {


            var url = 'filtreoption.php?lot_name=' + encodeURI(lot_name.value) + '&sous_lot_name=' + encodeURI(sous_lot_name.value);
            $("#divlotSous").load(url + ' #divlotSous',function (){
                console.log(lot_name.value)
                console.log(sous_lot_name.value)

                 document.getElementById('lot_name').value= lot_name.value
                 // document.getElementById('sous_lot_name').value= sous_lot_name
            });

        }

    });



    $('#tab1').load('operation_table.php #tableoperationdiv');


</script>
</html>
