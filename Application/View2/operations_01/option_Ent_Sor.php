
<?php

include '../../Config/check_session.php';
checkUserRole('admin');

?>

<?php $pageName = 'operation';
include '../../includes/header.php';
?>
<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// Récupérer les lots pour la première liste déroulante
include '../../config/connect_db.php';
$queryLots = "SELECT lot_id, lot_name FROM lots";
$resultLots = mysqli_query($conn, $queryLots);


if (!$resultLots) {
    die('Erreur de requête : ' . mysqli_error($conn));
}


if (isset($_GET['message'])) {
    $nomArticle = isset($_GET['nomArticle']) ? htmlspecialchars($_GET['nomArticle']) : 'l\'article inconnu';

    switch ($_GET['message']) {
        case 'ssajouter':
            echo '<div class="alert alert-dismissible alert-success" role="alert">
                    Il y a un besoin dans l\'article : ' . $nomArticle . '
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
            break;


        case 'ss':
            echo '<div class="alert alert-dismissible alert-success">
                    Il y\'a un besoin dans l\'article : ' . $nomArticle . '
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
            break;

        default:
            echo '<div class="alert alert-dismissible alert-warning">
                    Message non reconnu !
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
            break;
    }
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
<!--    <link rel="stylesheet" href="../../includes/css/bootstrap.min.css">-->
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


    .modal23 {
        display: none;
        position: fixed;
        z-index: 8999997;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgb(0, 0, 0);
    }

    .modal-content23 {
        background-color: white;
        margin: 15% auto;
        padding: 20px;
        width: 30%;
        border-radius: 10px;
    }

    .close23 {
        float: right;
        font-size: 20px;
        cursor: pointer;
    }

    #submitPassword {
        margin: 10px;
    }

    .tla3{
        position: fixed;
        bottom: 80px;
        right: 30px;
        z-index: 20;
        border: 2px solid white;
        border-radius: 50%;
        background-color: white;

    }

</style>


<!--Boutton pour ouvrir le modal ajouter operation-->
<!--<div class="ajouter-fournisseur-btn">-->
<!--    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#ajouterOperationModal">-->
<!--        Ajouter Opération-->
<!--    </button>-->
<!---->
<!--</div>-->
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
                        <label for="ref" class="form-label">Réference :</label>
                        <input type="text" id="ref" name="ref" class="form-control">
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
                        <input type="number" id="prix" name="prix" class="form-control" step="0.01" min="0" placeholder="Entrez le prix" disabled >
                    </div>

                    <button type="submit" class="btn btn-primary">Ajouter Opération</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal modifier operation -->
<div class="modal fade" id="modifierOperationModal" tabindex="-1" aria-labelledby="modifierOperationModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modifierOperationModalLabel">Modifier Opération</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="modifierOperationForm" method="POST" action="modifier_operation.php">
                    <input type="hidden" id="operation-id" name="operation_id"> <!-- ID de l'opération à modifier -->
                    <div class="mb-3">
                        <label for="lot-modifier" class="form-label">Sélectionner Lot:</label>
                        <select id="lot-modifier" name="lot" class="form-select" required>
                            <option value="">-- Sélectionner Lot --</option>
                            <!-- Options seront ajoutées dynamiquement -->
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="sousLot-modifier" class="form-label">Sélectionner Sous-lot:</label>
                        <select id="sousLot-modifier" name="sousLot" class="form-select" disabled required>
                            <option value="">-- Sélectionner Sous-lot --</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="article-modifier" class="form-label">Sélectionner Article:</label>
                        <select id="article-modifier" name="article" class="form-select" disabled required>
                            <option value="">-- Sélectionner Article --</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="ref-modifier" class="form-label">Référence:</label>
                        <input type="text" id="ref-modifier" name="ref" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label for="entree-modifier" class="form-label">Entrée:</label>
                        <input type="number" id="entree_modifier" name="entree" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label for="sortie-modifier" class="form-label">Sortie:</label>
                        <input type="number" id="sortie_modifier" name="sortie" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label for="fournisseur-modifier" class="form-label">Fournisseur:</label>
                        <select id="fournisseur_modifier" name="fournisseur" class="form-select" disabled>
                            <option value="">-- Sélectionner Fournisseur --</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="service-modifier" class="form-label">Service:</label>
                        <select id="service_modifier" name="service" class="form-select" disabled>
                            <option value="">-- Sélectionner Service --</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="prix-modifier" class="form-label">Prix:</label>
                        <input type="number" id="prix_modifier" name="prix" class="form-control" step="0.01" min="0" placeholder="Entrez le prix" disabled>
                    </div>

                    <div class="mb-3">
                        <label for="date-operation-modifier" class="form-label">Date de l'opération :</label>
                        <input type="datetime-local" id="date_operation" name="date_operation" required>
                    </div>

                    <button type="submit" class="btn btn-primary">Modifier Opération</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal de saisie du mot de passe -->




<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
    Ouvrir le Modal
</button>

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Titre du Modal</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Contenu du modal ici...</p>
                <input type="text" class="form-control" placeholder="Entrez quelque chose...">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                <button type="button" class="btn btn-primary">Soumettre</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Titre du Modal</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Contenu du modal ici...</p>
                <input type="text" class="form-control" placeholder="Entrez quelque chose...">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                <button type="button" class="btn btn-primary">Soumettre</button>
            </div>
        </div>
    </div>
</div>










<div id="tab1" class="table-operation">

</div>






</body>
<!--<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>-->
<!--<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>-->
<!--<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>-->

<script src="../../includes/js/bootstrap123.min.js"

<script src="../../includes/js/bootstrap.bundle.min.js"></script>

<script src="script.js"></script>
<script>

    $('#tab1').load('operation_table.php #tableoperationdiv');

    // $('#myModal').show()
    // Default Notification

</script>
</html>
