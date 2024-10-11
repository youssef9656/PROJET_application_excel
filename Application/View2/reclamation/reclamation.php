<?php
include '../../Config/check_session.php';
checkUserRole('admin');
include '../../Config/connect_db.php';
$pageName = 'Acceuil ';
include '../../includes/header.php';


$query = "SELECT id, reclamation FROM operation WHERE reclamation IS NOT NULL";
$result = $conn->query($query);

if (isset($_GET['message'])) {
    if (isset($_GET['nomArticle'])) {
        $nomArticle = htmlspecialchars($_GET['nomArticle']);
    } else {
        $nomArticle = 'l\'article inconnu';
    }
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

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Etat des stocks</title>
    <script src="../../includes/jquery.sheetjs.js"></script>
    <!--    <link rel="stylesheet" href="../../includes/css/bootstrap.min.css">-->
    <link rel="stylesheet" href="../../includes/css/bootstrap.css">
    <script src="../../includes/libriryPdf/unpkg/jspdf.umd.min.js"></script>
    <script src="../../includes/libriryPdf/jspdf.plugin.autotable.min.js"></script>
    <!--    <script src="../../includes/html2canvas.min.js"></script>-->
    <!--    <script src="../../includes/libriryPdf/cdnjs/jspdf.min.js"></script>-->
    <!--    <script src="../../includes/xlsx.full.min.js"></script>-->
    <script src="../../includes/js/jquery.min.js"></script> <!-- Assurez-vous d'utiliser la version complète -->
    <script src="../../includes/js/bootstrap.bundle.min.js"></script>
    <script src="../../includes/js/bootstrap123.min.js"></script>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="lato_styles/lato_style.css">

</head>
<body>

<div class="accueil">
    Accueil
</div>
<!--div pour statistique-->
<!--<div class="content1">-->
<!---->
<!---->
<!--</div>-->
<div class="content2">


    <?php
    if ($result->num_rows > 0) {
        // Boucle à travers chaque réclamation
        while ($row = $result->fetch_assoc()) {
            $id_operation = $row['id'];  // ID de l'opération
            $reclamation = $row['reclamation'];   // Texte de la réclamation
            ?>
            <div class="note-div">
                <div class="note-ligne"></div>
                <div class="note-text"><?php echo htmlspecialchars($reclamation); ?></div>
                <div class="note-buttons">
                    <button class="btn-12 note-modifier modifier-operation" data-id="<?php echo $id_operation; ?>"><span>Modifier</span></button>
                    <button class="btn-12 note-modifier supprimer_reclamation" data-id="<?php echo $id_operation; ?>"><span>Supprimer</span></button>
                </div>
            </div>
            <?php
        }
    } else {
        echo "<div class='aucune'>Aucune réclamation trouvée.</div>";
    }
    ?>

<!--    <div class="note-div">-->
<!--        <div class="note-ligne"></div>-->
<!--        <div class="note-text"></div>-->
<!--        <button class="btn-12 note-modifier"><span>Modifier</span></button>-->
<!---->
<!--    </div>-->



</div>

<!-- Modal Bootstrap pour modifier une opération -->
<div class="modal fade" id="modifierOperationModal" tabindex="-1" role="dialog" aria-labelledby="modifierOperationLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title w-75" id="modifierOperationLabel">Modifier l'opération</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" style="font-size: 40px">&times;</span>
                </button>
            </div>
            <div class="note-div">
<!--                <div class="note-ligne"></div>-->
                <div class="note-text" id="text-reclamation-modal"></div>
            </div>

            <form id="modifierOperationForm" method="POST" action="modifier_operation.php">

                <div class="modal-body">
                    <input type="hidden" id="operationId" name="operation_id">

                    <div class="form-group">
                        <label for="lot">Lot :</label>
                        <select id="lot" name="lot" class="form-control" required>
                            <!-- Options dynamiques ajoutées via AJAX -->
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="sousLot">Sous-lot :</label>
                        <select id="sousLot" name="sousLot" class="form-control" required disabled>
                            <!-- Options dynamiques ajoutées via AJAX -->
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="article">Article :</label>
                        <select id="article" name="article" class="form-control" required disabled>
                            <!-- Options dynamiques ajoutées via AJAX -->
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="ref">Référence :</label>
                        <input type="text" id="ref" name="ref" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="entree">Entrée :</label>
                        <input type="number" id="entree" name="entree" step="0.01" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="sortie">Sortie :</label>
                        <input type="number" id="sortie" name="sortie" step="0.01" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="fournisseur">Fournisseur :</label>
                        <select id="fournisseur" name="fournisseur" class="form-control" required disabled>
                            <!-- Options dynamiques ajoutées via AJAX -->
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="service">Service :</label>
                        <select id="service" name="service" class="form-control" required disabled>
                            <!-- Options dynamiques ajoutées via AJAX -->
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="prix">Prix :</label>
                        <input type="number" id="prix" name="prix" step="0.01" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="date_operation">Date d'opération :</label>
                        <input type="datetime-local" id="date_operation" name="date_operation" class="form-control" required>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                    <button type="submit" class="btn btn-primary">Modifier</button>
                </div>
            </form>
        </div>
    </div>
</div>


<script src="script.js"></script>
</body>
</html>
