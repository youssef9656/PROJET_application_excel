
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
    if (isset($_GET['nomArticle'])){
        $nomArticle = htmlspecialchars($_GET['nomArticle']);
    }else{
        $nomArticle = 'l\'article inconnu' ;
    }

    if (isset($_GET['stockFinaleValue'])){
        $stockFinaleValue = htmlspecialchars($_GET['stockFinaleValue']) ;
    }else{
        $stockFinaleValue = 'l\'article inconnu' ;
    }

    switch ($_GET['message']) {
        case 'ssajouter':
            echo '
<div class="modalBesoin" id="myModal">
    <div id="container11">
        <div id="error-box">
            <button class="close">
                <svg xmlns="http://www.w3.org/2000/svg" width="60" height="60" fill="currentColor" class="bi bi-x-circle" viewBox="0 0 16 16">
                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                    <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708"/>
                </svg>
            </button>
            <div class="face2">
                <div class="eye"></div>
                <div class="eye right"></div>
                <div class="mouth sad"></div>
            </div>
            <div class="shadow move"></div>
            <div class="message"><h1 class="alert">Alert !</h1><p class="modaleBody">    Il y a un besoin dans l\'article : ' . $nomArticle . '    </div>
        </div>
    </div>

</div>


';
            break;
                case 'stock_insuffisant':
                    echo '
<div class="modalBesoin" id="myModal">
    <div id="container11">
        <div id="error-box">
            <button class="close">
                <svg xmlns="http://www.w3.org/2000/svg" width="60" height="60" fill="currentColor" class="bi bi-x-circle" viewBox="0 0 16 16">
                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                    <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708"/>
                </svg>
            </button>
            <div class="face2">
                <div class="eye"></div>
                <div class="eye right"></div>
                <div class="mouth sad"></div>
            </div>
            <div class="shadow move"></div>
            <div class="message"><h1 class="alert">Alert !</h1><p class="modaleBody">  Vous avez dépassé le stock final pour l\'article :  ' . $nomArticle . '   <br> Le stock actuel est :' . $stockFinaleValue . '  </div>
        </div>
    </div>

</div>


';
            break;


        case 'ss':
            echo '
<div class="modalBesoin" id="myModal">
    <div id="container11">
        <div id="error-box">
            <button class="close">
                <svg xmlns="http://www.w3.org/2000/svg" width="60" height="60" fill="currentColor" class="bi bi-x-circle" viewBox="0 0 16 16">
                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                    <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708"/>
                </svg>
            </button>
            <div class="face2">
                <div class="eye"></div>
                <div class="eye right"></div>
                <div class="mouth sad"></div>
            </div>
            <div class="shadow move"></div>
            <div class="message"><h1 class="alert">Alert !</h1><p class="modaleBody">    Il y a un besoin dans l\'article : ' . $nomArticle . '    <br> Le stock actuel est :' . $stockFinaleValue . '   </div>
        </div>
    </div>

</div>

';
            break;

        case 'eppuisement':
            echo '
<div class="modalBesoin" id="myModal">
    <div id="container11">
        <div id="error-box">
            <button class="close">
                <svg xmlns="http://www.w3.org/2000/svg" width="60" height="60" fill="currentColor" class="bi bi-x-circle" viewBox="0 0 16 16">
                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                    <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708"/>
                </svg>
            </button>
            <div class="face2">
                <div class="eye"></div>
                <div class="eye right"></div>
                <div class="mouth sad"></div>
            </div>
            <div class="shadow move"></div>
            <div class="message"><h1 class="alert">Alert !</h1><p class="modaleBody">  Vous avez dépassé le stock final pour l\'article :  ' . $nomArticle. ' <br> Le stock actuel est :' . $stockFinaleValue . '    </div>
        </div>
    </div>

</div>

';
            break;

        case 'reclamationError' :
            echo '
<div class="modalBesoin" id="myModal">
    <div id="container11">
        <div id="error-box">
            <button class="close">
                <svg xmlns="http://www.w3.org/2000/svg" width="60" height="60" fill="currentColor" class="bi bi-x-circle" viewBox="0 0 16 16">
                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                    <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708"/>
                </svg>
            </button>
            <div class="face2">
                <div class="eye"></div>
                <div class="eye right"></div>
                <div class="mouth sad"></div>
            </div>
            <div class="shadow move"></div>
            <div class="message"><h1 class="alert">Alert !</h1><p class="modaleBody">   Erreur lors de l\'enregistrement de la réclamation. Veuillez réessayer.  </div>
        </div>
    </div>

</div>


';
            break ;
        case 'reclamationSuccess':
            echo '
<div class="modalBesoin" id="myModal">
    <div id="container11">
        <div class="success-box">
            <button class="close">
                <svg xmlns="http://www.w3.org/2000/svg" width="60" height="60" fill="currentColor" class="bi bi-x-circle" viewBox="0 0 16 16">
                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                    <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708"/>
                </svg>
            </button>
            <div class="face2">
                <div class="eye"></div>
                <div class="eye right"></div>
                <div class="mouth happy"></div>
            </div>
            <div class="shadow move"></div>
            <div class="message"><h1 class="alert">Alert !</h1><p class="modaleBody">   Votre reclamation a été ajouter avec succès .   </div>
        </div>
    </div>

</div>

';
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
    <link rel="stylesheet" href="lato_styles/lato_style.css">
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
    .modalBesoin{
        width: 100%;
        height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(149, 149, 149 , 0.9);
        position: fixed;
        top: 0;
        left: 0;
        z-index: 20000;
        transition: 1s;
    }
    .modaleContent{
        width: 60%;
        height: 50%;
        background: white;
        display: flex;
        flex-direction: column;
        justify-content: space-around;
        border:2px solid black;
        border-radius: 50px;
        box-shadow: 0px 0px 35px #ffa549;
        transition: 0.4s;
    }
    .modaleHeader{
        padding-left: 10px;
        width: 100%;
        display: flex;
        margin-bottom: 10px;
        /*text-align: center;*/
        /*font-size: 50px;*/
        /*font-weight: 900;*/
        /*color: red;*/
    }
    .modaleHeader > div{
        width: 85%;
        text-align: center;
        font-size: 50px;
        font-weight: 900;
        color: red;
    }
    .modaleFooter{
        width: 90%;
        text-align: center;
    }
    .modaleBody{
        text-align: center;
        width: 100%;
        font-size: 40px;
        font-weight: 400;
        margin-bottom: 100px;
    }
    .close{
        width:100%;
        /*height: 100px;*/
        text-align: end;
        background: none;
        border: none;
        transition: 0.2s;
        /*animation: modaleAnimation 2s forwards;*/


    }
    .close:hover{
        color: red;
    }
    @keyframes modaleAnimation{
        0%{
            transform: translateX(0);
        }
        40%{
            transform: translateX(190px);
        }
        80%{
            transform: translateX(-10000px);
        }
        100%{
            transform: translateX(-100000px);
        }
    }


    .sortie_value{
        width: 0;
        height: 0;
        border: none;
        background-color: white;
        color: white;
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

                    <input type="text" name="sortie_value" class="sortie_value" id="sortie_value">

                    <button type="submit" class="btn btn-primary">Modifier Opération</button>
                </form>
            </div>
        </div>
    </div>
</div>



<!-- Modal de saisie du mot de passe -->


<!--<div class="modalBesoin" id="myModal">-->
<!--    <div id="container11">-->
<!--        <div id="error-box">-->
<!--            <button class="close">-->
<!--                <svg xmlns="http://www.w3.org/2000/svg" width="60" height="60" fill="currentColor" class="bi bi-x-circle" viewBox="0 0 16 16">-->
<!--                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>-->
<!--                    <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708"/>-->
<!--                </svg>-->
<!--            </button>-->
<!--            <div class="face2">-->
<!--                <div class="eye"></div>-->
<!--                <div class="eye right"></div>-->
<!--                <div class="mouth sad"></div>-->
<!--            </div>-->
<!--            <div class="shadow move"></div>-->
<!--            <div class="message"><h1 class="alert">Alert !</h1><p class="modaleBody">    Il y a un besoin dans l\'article : ' . $nomArticle . '    </div>-->
<!--        </div>-->
<!--    </div>-->
<!---->
<!--</div>-->





<!--<div class="modalBesoin" id="myModal">-->
<!--    <div class="modaleContent" id="modaleContent">-->
<!---->
<!--        <div class="modaleHeader">-->
<!--            <div>Alert</div>-->
<!--            <button class="close"><svg xmlns="http://www.w3.org/2000/svg" width="60" height="60" fill="currentColor" class="bi bi-x-circle" viewBox="0 0 16 16">-->
<!--                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>-->
<!--                    <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708"/>-->
<!--                </svg></button>-->
<!--        </div>-->
<!--        <div class="modaleBody">-->
<!--            Il y a un besoin dans l\'article : ' . $nomArticle . '-->
<!--        </div>-->
<!--        <div class="modaleFooter">-->
<!---->
<!--        </div>-->
<!---->
<!--    </div>-->
<!--</div>-->
<!---->


<!-- modale reclamation -->
<div class="modal fade" id="reclamationModal" tabindex="-1" aria-labelledby="reclamationModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="reclamationModalLabel">Ajouter une réclamation</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="reclamationForm">
                    <input type="hidden" id="operationId" name="operationId">
                    <div class="mb-3">
                        <label for="reclamationText" class="form-label">Réclamation:</label>
                        <textarea class="form-control" id="reclamationText" name="reclamationText" rows="3"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                </form>
                <button id="saveNullButton" class="btn btn-secondary">Enregistrer comme NULL</button>
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

<script src="../../includes/js/bootstrap123.min.js"></script>

<script src="../../includes/js/bootstrap.bundle.min.js"></script>

<script src="script.js"></script>
<script>

    $('#tab1').load('operation_table.php #tableoperationdiv');


    document.addEventListener("DOMContentLoaded" , ()=>{
        let close = document.querySelector(".close");
        let modale = document.querySelector('#container11');
        let myModale = document.querySelector("#myModal")
        close.addEventListener('click' , ()=> {
            modale.style.animation = "modaleAnimation 2s forwards"
            setTimeout(() => {
                myModale.style.opacity = "0"
            }, 1000)
            setTimeout(() => {
                myModale.style.display = "none"
            }, 3300)






        })


        setTimeout(()=>{


        },1000)


    })



    // $('#myModal').show()
    // Default Notification

</script>
</html>
