<?php
// Inclure le fichier de configuration pour la connexion à la base de données
include "../../Config/connect_db.php";
$querySelect = "SELECT * FROM fournisseurs WHERE 1=1 ";
if (isset($_GET['nom_fournisseur']) && !empty($_GET['nom_fournisseur']))
    $querySelect .= " AND nom_fournisseur ='" . $_GET['nom_fournisseur'] . "' ";
if (isset($_GET['prenom_fournisseur']) &&  !empty($_GET['prenom_fournisseur']))
    $querySelect .= " AND prenom_fournisseur ='" . $_GET['prenom_fournisseur'] . "' ";
$querySelect .= " ORDER BY action_A_D DESC, nom_fournisseur ASC";


$paramsSelect = [];
$result = $conn->query($querySelect);

//$result = selectData($querySelect, $paramsSelect);

?>
<!DOCTYPE html>
    <html lang='fr'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>Liste des Fournisseurs</title>
        <style>
            #tblfr th {
                background-color: #f2f2f2;
                position: sticky;
                top: 0;
                z-index: 1;
            }

            /*#tblfr tbody {*/
            /*    display: block;*/
            /*    height: 300px; !* يمكنك ضبط الارتفاع كما تريد *!*/
            /*    overflow-y: auto;*/
            /*}*/

            /*#tblfr thead, #tblfr tbody tr {*/
            /*    display: table;*/
            /*    width: 100%;*/
            /*    table-layout: fixed;*/
            /*}*/

            table {
                width: 600px;
                border-collapse: collapse;
                margin-top: 20px;
                margin: auto;
            }
            table, th, td {
                border: 1px solid #ddd;
            }
            th, td {
                padding: 8px;
                text-align: left;
                font-size: 0.9em;
            }
            th {
                background-color: #f4f4f4;
            }
            .actions {
                text-align: center;
            }
            .actions button {
                background-color: #007bff;
                color: white;
                border: none;
                padding: 5px 10px;
                cursor: pointer;
                border-radius: 4px;
                font-size: 0.8em;
            }
            .actions button:hover {
                background-color: #0056b3;
            }
        </style>
    </head>
    <body>
        <h1>Liste des Fournisseurs</h1>
        <table id="tblfr" class="table table-light  table-bordered table-hover sheetjs" >
            <thead>
                <tr>
                    <th>Actions</th>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Code Postal</th>
                    <th>Ville</th>
                    <th>Pays</th>
                    <th>Téléphone Fixe</th>
                    <th>Téléphone Portable</th>
                    <th>Commande</th>
                    <th>Conditions de Livraison</th>
                    <th>Coordonnées du Livre</th>
                    <th>Calendrier de Livraison</th>
                    <th>Détails de Livraison</th>
                    <th>Conditions de Paiement</th>
                    <th>Facturation</th>
                    <th>Certification</th>
                    <th>Produit/Service</th>
                    <th>SIUVI</th>
                    <th>Email</th>
                    <th>Groupe</th>
                    <th>Adresse</th>
<!--                    <th>Actions</th>-->
                </tr>
            </thead>
            <tbody>

    <?php
    if ($result->num_rows >= 0) {
    while ($row = $result->fetch_assoc()) {

                if ($row['action_A_D'] == 0 ){
                    echo "<tr>
    <td>        <button class='custom-button inactive' id='toggleButton' onclick='toggleActionAD(this," . htmlspecialchars($row['id_fournisseur']) . ")'>  Désactivé</button></td>
    <td>" . htmlspecialchars($row['nom_fournisseur']) . "</td>
    <td>" . htmlspecialchars($row['prenom_fournisseur']) . "</td>
    <td>" . htmlspecialchars($row['cp_fournisseur']) . "</td>
    <td>" . htmlspecialchars($row['ville_fournisseur']) . "</td>
    <td>" . htmlspecialchars($row['pay_fournisseur']) . "</td>
    <td>" . htmlspecialchars($row['telephone_fixe_fournisseur']) . "</td>
    <td>" . htmlspecialchars($row['telephone_portable_fournisseur']) . "</td>
    <td>" . htmlspecialchars($row['commande_fournisseur']) . "</td>
    <td>" . htmlspecialchars($row['condition_livraison']) . "</td>
    <td>" . htmlspecialchars($row['coord_livreur']) . "</td>
    <td>" . htmlspecialchars($row['calendrier_livraison']) . "</td>
    <td>" . htmlspecialchars($row['details_livraison']) . "</td>
    <td>" . htmlspecialchars($row['condition_paiement']) . "</td>
    <td>" . htmlspecialchars($row['facturation']) . "</td>
    <td>" . htmlspecialchars($row['certificatione']) . "</td>
    <td>" . htmlspecialchars($row['produit_service_fourni']) . "</td>
    <td>" . htmlspecialchars($row['siuvi_fournisseur']) . "</td>
    <td>" . htmlspecialchars($row['mail_fournisseur']) . "</td>
    <td>" . htmlspecialchars($row['groupe_fournisseur']) . "</td>
    <td>" . htmlspecialchars($row['adress_fournisseur']) . "</td>
</tr>";
                }
                else{
                    echo "<tr >
    <td class='acctiveCLOUR'>        <button class='custom-button active ' id='toggleButton ' onclick='toggleActionAD(this," . htmlspecialchars($row['id_fournisseur']) . ")'>  active</button>
</td>
    <td class='acctiveCLOUR'>" . htmlspecialchars($row['nom_fournisseur']) . "</td>
    <td class='acctiveCLOUR'>" . htmlspecialchars($row['prenom_fournisseur']) . "</td>
    <td class='acctiveCLOUR'>" . htmlspecialchars($row['cp_fournisseur']) . "</td>
    <td class='acctiveCLOUR'>" . htmlspecialchars($row['ville_fournisseur']) . "</td>
    <td class='acctiveCLOUR'>" . htmlspecialchars($row['pay_fournisseur']) . "</td>
    <td class='acctiveCLOUR'>" . htmlspecialchars($row['telephone_fixe_fournisseur']) . "</td>
    <td class='acctiveCLOUR'>" . htmlspecialchars($row['telephone_portable_fournisseur']) . "</td>
    <td class='acctiveCLOUR'>" . htmlspecialchars($row['commande_fournisseur']) . "</td>
    <td class='acctiveCLOUR'>" . htmlspecialchars($row['condition_livraison']) . "</td>
    <td class='acctiveCLOUR'>" . htmlspecialchars($row['coord_livreur']) . "</td>
    <td class='acctiveCLOUR'>" . htmlspecialchars($row['calendrier_livraison']) . "</td>
    <td class='acctiveCLOUR'>" . htmlspecialchars($row['details_livraison']) . "</td>
    <td class='acctiveCLOUR'>" . htmlspecialchars($row['condition_paiement']) . "</td>
    <td class='acctiveCLOUR'>" . htmlspecialchars($row['facturation']) . "</td>
    <td class='acctiveCLOUR'>" . htmlspecialchars($row['certificatione']) . "</td>
    <td class='acctiveCLOUR'>" . htmlspecialchars($row['produit_service_fourni']) . "</td>
    <td class='acctiveCLOUR'>" . htmlspecialchars($row['siuvi_fournisseur']) . "</td>
    <td class='acctiveCLOUR'>" . htmlspecialchars($row['mail_fournisseur']) . "</td>
    <td class='acctiveCLOUR'>" . htmlspecialchars($row['groupe_fournisseur']) . "</td>
    <td class='acctiveCLOUR'>" . htmlspecialchars($row['adress_fournisseur']) . "</td>

</tr>";

                }

    }}


?>
 </tbody>
        </table>
        </div>


    </body>
    </html>

<!--if ($result->num_rows > 0) {-->
<!--while ($row = $result->fetch_assoc()) {-->
<!--if ($row['action_A_D'] == 0){-->
<!--echo "<tr>-->
<!--    <td>" . htmlspecialchars($row['id_fournisseur']) . "</td>-->
<!--    <td>" . htmlspecialchars($row['nom_fournisseur']) . "</td>-->
<!--    <td>" . htmlspecialchars($row['prenom_fournisseur']) . "</td>-->
<!--    <td>" . htmlspecialchars($row['cp_fournisseur']) . "</td>-->
<!--    <td>" . htmlspecialchars($row['ville_fournisseur']) . "</td>-->
<!--    <td>" . htmlspecialchars($row['pay_fournisseur']) . "</td>-->
<!--    <td>" . htmlspecialchars($row['telephone_fixe_fournisseur']) . "</td>-->
<!--    <td>" . htmlspecialchars($row['telephone_portable_fournisseur']) . "</td>-->
<!--    <td>" . htmlspecialchars($row['commande_fournisseur']) . "</td>-->
<!--    <td>" . htmlspecialchars($row['condition_livraison']) . "</td>-->
<!--    <td>" . htmlspecialchars($row['coord_livreur']) . "</td>-->
<!--    <td>" . htmlspecialchars($row['calendrier_livraison']) . "</td>-->
<!--    <td>" . htmlspecialchars($row['details_livraison']) . "</td>-->
<!--    <td>" . htmlspecialchars($row['condition_paiement']) . "</td>-->
<!--    <td>" . htmlspecialchars($row['facturation']) . "</td>-->
<!--    <td>" . htmlspecialchars($row['certificatione']) . "</td>-->
<!--    <td>" . htmlspecialchars($row['produit_service_fourni']) . "</td>-->
<!--    <td>" . htmlspecialchars($row['siuvi_fournisseur']) . "</td>-->
<!--    <td>" . htmlspecialchars($row['mail_fournisseur']) . "</td>-->
<!--    <td>" . htmlspecialchars($row['groupe_fournisseur']) . "</td>-->
<!--    <td>" . htmlspecialchars($row['adress_fournisseur']) . "</td>-->
<!--    <td class='actions'>-->
<!--        <button onclick='editFournisseur(this, " . $row['id_fournisseur'] . ")' class='btn btn-success' style='font-size: 10px; width: 60px'>Modifier</button>-->
<!--        <button onclick='deleteFournisseur(" . $row['id_fournisseur'] . ")' class='btn btn-danger' style='font-size: 10px; width: 60px;'>Supprime-->
<!---->
<!--        <button class='custom-button inactive' id='toggleButton' onclick='toggleActionAD(this," . htmlspecialchars($row['id_fournisseur']) . ")'>  Désactivé</button>-->
<!---->
<!--    </td>-->
<!--</tr>";-->
<!--}-->
<!--else{-->
<!--echo "<tr>-->
<!--    <td>" . htmlspecialchars($row['id_fournisseur']) . "</td>-->
<!--    <td>" . htmlspecialchars($row['nom_fournisseur']) . "</td>-->
<!--    <td>" . htmlspecialchars($row['prenom_fournisseur']) . "</td>-->
<!--    <td>" . htmlspecialchars($row['cp_fournisseur']) . "</td>-->
<!--    <td>" . htmlspecialchars($row['ville_fournisseur']) . "</td>-->
<!--    <td>" . htmlspecialchars($row['pay_fournisseur']) . "</td>-->
<!--    <td>" . htmlspecialchars($row['telephone_fixe_fournisseur']) . "</td>-->
<!--    <td>" . htmlspecialchars($row['telephone_portable_fournisseur']) . "</td>-->
<!--    <td>" . htmlspecialchars($row['commande_fournisseur']) . "</td>-->
<!--    <td>" . htmlspecialchars($row['condition_livraison']) . "</td>-->
<!--    <td>" . htmlspecialchars($row['coord_livreur']) . "</td>-->
<!--    <td>" . htmlspecialchars($row['calendrier_livraison']) . "</td>-->
<!--    <td>" . htmlspecialchars($row['details_livraison']) . "</td>-->
<!--    <td>" . htmlspecialchars($row['condition_paiement']) . "</td>-->
<!--    <td>" . htmlspecialchars($row['facturation']) . "</td>-->
<!--    <td>" . htmlspecialchars($row['certificatione']) . "</td>-->
<!--    <td>" . htmlspecialchars($row['produit_service_fourni']) . "</td>-->
<!--    <td>" . htmlspecialchars($row['siuvi_fournisseur']) . "</td>-->
<!--    <td>" . htmlspecialchars($row['mail_fournisseur']) . "</td>-->
<!--    <td>" . htmlspecialchars($row['groupe_fournisseur']) . "</td>-->
<!--    <td>" . htmlspecialchars($row['adress_fournisseur']) . "</td>-->
<!--    <td class='actions'>-->
<!--        <button onclick='editFournisseur(this, " . $row['id_fournisseur'] . ")' class='btn btn-success' style='font-size: 10px; width: 60px'>Modifier</button>-->
<!--        <button onclick='deleteFournisseur(" . $row['id_fournisseur'] . ")' class='btn btn-danger' style='font-size: 10px; width: 60px;'>Supprime-->
<!---->
<!--        <button class='custom-button active ' id='toggleButton ' onclick='toggleActionAD(this," . htmlspecialchars($row['id_fournisseur']) . ")'>  active</button>-->
<!---->
<!--    </td>-->
<!--</tr>";-->
<!---->
<!--}-->
<!--}}-->
