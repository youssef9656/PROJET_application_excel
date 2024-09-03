<?php
// Inclure le fichier de configuration pour la connexion à la base de données
include "../../Config/connect_db.php";

// Requête pour récupérer tous les fournisseurs
$sql = "SELECT * FROM fournisseurs";
$result = $conn->query($sql);

// Vérifier si la requête a renvoyé des résultats
?>
<!DOCTYPE html>
    <html lang='fr'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>Liste des Fournisseurs</title>
        <style>
            
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
        <table>
            <thead>
                <tr>
                    <th>ID</th>
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
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>

    <?php
    if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . htmlspecialchars($row['id_fournisseur']) . "</td>
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
                <td class='actions'>
                    <button onclick='editFournisseur(" . $row['id_fournisseur'] . ")'>Modifier</button>
                    <button onclick='deleteFournisseur(" . $row['id_fournisseur'] . ")'>Supprimer</button>
                </td>
            </tr>";
    }}


?>
 </tbody>
        </table>
        <script>
            function editFournisseur(id) {
                // Code pour modifier le fournisseur
                alert('Modifier fournisseur avec ID: ' + id);
            }

            function deleteFournisseur(id) {
                // Code pour supprimer le fournisseur
                if (confirm('Êtes-vous sûr de vouloir supprimer ce fournisseur ?')) {
                    fetch('deletefournisseur.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                        },
                        body: 'id_fournisseur=' + id
                    })
                    .then(response => response.text())
                    .then(result => {
                        alert(result);
                        location.reload(); // Recharger la page pour voir les changements
                    })
                    .catch(error => {
                        console.error('Erreur:', error);
                    });
                }
            }
        </script>
    </body>
    </html>";

