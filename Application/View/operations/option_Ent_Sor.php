
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

<style>

    .ajouter-fournisseur-btn{
        width: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
        margin-top: 50px;
        margin-bottom: 50px;
    }

    #ajouterOperationModal{
        /*display: flex;*/
        /*justify-content: center;*/
        /*align-items: center;*/

    }
    .table-operation{
        width: 100%;
        overflow: scroll;

    }
    .table-operation thead{
        position: sticky;
        overflow: auto;
    }
    .table-operation th{
        position: sticky;
        top: 0;
    }



</style>



<!--Boutton pour ouvrir le modal ajouter operation-->
<div class="ajouter-fournisseur-btn">
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#ajouterOperationModal">
        Ajouter Opération
    </button>

</div>
<!-- Modal ajouter operation -->
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
                        <select id="lot" name="lot" class="form-select" required>
                            <option value="">-- Sélectionner Lot --</option>
                            <?php while ($row = mysqli_fetch_assoc($resultLots)) { ?>
                                <option value="<?php echo $row['lot_id']; ?>"><?php echo $row['lot_name']; ?></option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="sousLot" class="form-label">Sélectionner Sous-lot:</label>
                        <select id="sousLot" name="sousLot" class="form-select" disabled required>
                            <option value="">-- Sélectionner Sous-lot --</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="article" class="form-label">Sélectionner Article:</label>
                        <select id="article" name="article" class="form-select" disabled required>
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

<!-- Modal de modification d'article -->


<!-- Modal Structure -->
<!-- Modal -->
<!-- Modal pour modifier une opération -->
<div id="modifierOperationModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modifier Opération</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="modifierOperationForm">
                    <input type="hidden" id="operationId" name="operationId" value="">
                    <div class="form-group">
                        <label for="operationDate">Date</label>
                        <input type="datetime-local" id="operationDate" name="date_operation" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="operationLot">Lot</label>
                        <select id="operationLot" name="lot_id" class="form-control"></select>
                    </div>
                    <div class="form-group">
                        <label for="operationSousLot">Sous-lot</label>
                        <select id="operationSousLot" name="sous_lot_id" class="form-control"></select>
                    </div>
                    <div class="form-group">
                        <label for="operationArticle">Article</label>
                        <select id="operationArticle" name="article_id" class="form-control"></select>
                    </div>
                    <div class="form-group">
                        <label for="operationEntree">Entrée</label>
                        <input type="number" step="0.01" id="operationEntree" name="entree_operation" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="operationSortie">Sortie</label>
                        <input type="number" step="0.01" id="operationSortie" name="sortie_operation" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="operationFournisseur">Fournisseur</label>
                        <select id="operationFournisseur" name="fournisseur_id" class="form-control"></select>
                    </div>
                    <div class="form-group">
                        <label for="operationPrix">Prix</label>
                        <input type="number" step="0.01" id="operationPrix" name="prix_operation" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="operationService">Service</label>
                        <select id="operationService" name="service_id" class="form-control"></select>
                    </div>
                    <button type="submit" class="btn btn-primary">Modifier</button>
                </form>
            </div>
        </div>
    </div>
</div>





















<div id="tab1" class="table-operation">

</div>






</body>
<script src="../../includes/js/bootstrap.bundle.min.js"></script>
<script src="script.js"></script>
<script>

    $('#tab1').load('operation_table.php #tableoperationdiv');


</script>
</html>
