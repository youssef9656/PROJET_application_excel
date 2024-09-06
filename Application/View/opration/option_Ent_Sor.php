

<?php include '../../Config/connect_db.php'; $pageName= 'Catalogue du temps'; ?>
<?php
$querySelect = "SELECT * FROM lots";
$paramsSelect = [];
$data = selectData($querySelect, $paramsSelect);

$queryProduit = "SELECT DISTINCT lot_name FROM lots";
$lot_name = selectData($queryProduit, []);

$queryElement = "SELECT DISTINCT prenom_fournisseur FROM fournisseurs";
$prenom_fournisseur = selectData($queryElement, []);

if( !empty(isset($_GET["lot_name"]))){
    $lot_name = $_GET["lot_name"];
    $query2 = "
    SELECT sous_lots.sous_lot_id, sous_lots.sous_lot_name, sous_lots.lot_id, lots.lot_name
    FROM sous_lots
    JOIN lots ON sous_lots.lot_id = lots.lot_id where lots.lot_name ='$lot_name'";
    $result2 = mysqli_query($conn, $query2);
};

if (!empty(isset($_GET["lot_name"])) && !empty(isset($_GET["lot_name"]))){




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
    <div style="display:flex;flex-flow: row wrap ; ">
        <form>
        <h4 class="mt-2 ms-5"> Opration  <button class="show-form-btn" onclick="toggleForm()">+</button> </h4>
        <div class="col ms-5 mt-2">
            <div class="filter-inputs mb-3">
                <div class="form row" >
                    <div class="col-3">
                        <input type="text" list='nom' class="form-control keepDatalist" placeholder="Nom"
                               id="nom_fournisseur" onchange="filterTable()">
                        <datalist id='nom'>
                            <option value=""></option>
                            <?php foreach($lot_name as $p):?>
                                <option value='<?= $p['lot_name'] ?>'><?= $p['lot_name'] ?></option>
                            <?php endforeach;?>
                        </datalist>
                    </div>
                    <div class="col-3">
                        <input type="text" list='prenom' class="form-control keepDatalist" placeholder="Prenom"
                               id="prenom_fournisseur" onchange="filterTable()">
                        <datalist id='prenom'>
                            <option value=""></option>
                            <?php foreach($prenom_fournisseur as $e):?>
                                <option value='<?= $e['prenom_fournisseur'] ?>'><?= $e['prenom_fournisseur'] ?></option>
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
<script>
    $('#tbl_fournisseur').load('operation_table.php #tab1',function (){


    });


</script>
</html>
