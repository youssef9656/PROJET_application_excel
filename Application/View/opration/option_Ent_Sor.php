
<?php $pageName = 'operation'; include '../../config/connect_db.php'; include '../../includes/header.php'; ?>
<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// Récupérer les lots pour la première liste déroulante
$queryLots = "SELECT lot_id, lot_name FROM lots";
$resultLots = mysqli_query($conn, $queryLots);

if (!$resultLots) {
    die('Erreur de requête : ' . mysqli_error($conn));
}

//$querySelect = "SELECT * FROM lots";
//$paramsSelect = [];
//$data = selectData($querySelect, $paramsSelect);
//
//$queryProduit = "SELECT DISTINCT lot_name FROM lots";
//$lot_name = selectData($queryProduit, []);
//
//
//if( isset($_GET["lot_name"]) && empty(isset($_GET["sous_lot_name"]))){
//    $lot_name = $_GET["lot_name"];
//
//    $query2 = "
//    SELECT sous_lots.sous_lot_id, sous_lots.sous_lot_name, sous_lots.lot_id, lots.lot_name
//    FROM sous_lots
//    JOIN lots ON sous_lots.lot_id = lots.lot_id where lots.lot_name ='$lot_name'";
//
//    $queryProduit = "SELECT DISTINCT lot_name FROM lots";
//
//    $lot_name = selectData($queryProduit, []);
//    $sous_lot_name = mysqli_query($conn, $query2);
//
//};
//
//if (!empty(isset($_GET["lot_name"])) && !empty(isset($_GET["sous_lot_name"]))){
//    echo "hhhh";
//    $lot_name = $_GET["lot_name"];
//    $sous_lot_name = $_GET["sous_lot_name"];
//
//    $sql ="SELECT * FROM article
//WHERE id_article IN (
//    SELECT article_id
//    FROM `sous_lot_articles`
//    WHERE sous_lot_id = (
//        SELECT sous_lot_id
//        FROM `sous_lots`
//        WHERE sous_lot_name = '$sous_lot_name'
//    )
//);";
// $result = $conn->query($sql);
//
//
//
//}
//?>

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

<!-- Bouton pour ouvrir la modal -->
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#ajouterOperationModal">
    Ajouter Opération
</button>

<!-- Modal -->
<div class="modal fade" id="ajouterOperationModal" tabindex="-1" aria-labelledby="ajouterOperationModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ajouterOperationModalLabel">Ajouter Opération</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="ajouterOperationForm" method="POST" action="ajouter_operation.php">
                    <div class="mb-3">
                        <label for="lot" class="form-label">Sélectionner Lot:</label>
                        <select id="lot" name="lot" class="form-select">
                            <option value="">-- Sélectionner Lot --</option>
                            <?php while ($row = mysqli_fetch_assoc($resultLots)) { ?>
                                <option value="<?php echo $row['lot_id']; ?>"><?php echo $row['lot_name']; ?></option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="sousLot" class="form-label">Sélectionner Sous-lot:</label>
                        <select id="sousLot" name="sousLot" class="form-select" disabled>
                            <option value="">-- Sélectionner Sous-lot --</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="article" class="form-label">Sélectionner Article:</label>
                        <select id="article" name="article" class="form-select" disabled>
                            <option value="">-- Sélectionner Article --</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="entree" class="form-label">Entrée:</label>
                        <input type="number" id="entree" name="entree" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label for="sortie" class="form-label">Sortie:</label>
                        <input type="number" id="sortie" name="sortie" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label for="fournisseur" class="form-label">Fournisseur:</label>
                        <select id="fournisseur" name="fournisseur" class="form-select" disabled>
                            <option value="">-- Sélectionner Fournisseur --</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="service" class="form-label">Service:</label>
                        <select id="service" name="service" class="form-select" disabled>
                            <option value="">-- Sélectionner Service --</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="prix" class="form-label">Prix:</label>
                        <input type="number" id="prix" name="prix" class="form-control" step="0.01" min="0" placeholder="Entrez le prix">
                    </div>

                    <button type="submit" class="btn btn-primary">Ajouter Opération</button>
                </form>
            </div>
        </div>
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
