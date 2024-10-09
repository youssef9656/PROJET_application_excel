<?php
include '../../Config/check_session.php';
checkUserRole('admin');
include '../../Config/connect_db.php';
$pageName = 'Acceuil ';
include '../../includes/header.php';


$query = "SELECT id, reclamation FROM operation WHERE reclamation IS NOT NULL";
$result = $conn->query($query);

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

</head>
<body>

<div class="accueil">
    Accueil
</div>
<!--div pour statistique-->
<div class="content1">


</div>
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
                <button class="btn-12 note-modifier modifier-operation" data-id="<?php echo $id_operation; ?>"><span>Modifier</span></button>
            </div>
            <?php
        }
    } else {
        echo "<p>Aucune réclamation trouvée.</p>";
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
                <h5 class="modal-title" id="modifierOperationLabel">Modifier l'opération</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
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
