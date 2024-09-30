<?php
// Affichage des erreurs pour le débogage
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include '../../config/connect_db.php';

function article_besoin($article, $besoin, $conn)
{
    // Préparation de la requête avec un paramètre MySQLi (sans les deux-points)
    $queryBesoin = "SELECT Requirement_Status FROM etat_de_stocks WHERE Article = ?";
    $stmt = $conn->prepare($queryBesoin);

    // Associe le paramètre (s pour chaîne de caractères)
    $stmt->bind_param("s", $article);

    // Exécute la requête
    $stmt->execute();

    // Récupère le résultat
    $result = $stmt->get_result();

    // Vérifie si le résultat existe et récupère le Requirement_Status
    if ($result->num_rows > 0) {
        $status = $result->fetch_assoc()['Requirement_Status'];
    } else {
        return false; // Aucun résultat trouvé
    }

    // Ferme la requête
    $stmt->close();

    // Compare le status avec le besoin
    if ($status === $besoin) {
        return true; // Si le besoin correspond au status, retourne vrai
    } else {
        return false; // Sinon retourne faux
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Récupération des données du formulaire
    $operationId = isset($_POST['operation_id']) ? intval($_POST['operation_id']) : 0;
    $lotId = isset($_POST['lot']) ? intval($_POST['lot']) : 0;
    $sousLotId = isset($_POST['sousLot']) ? intval($_POST['sousLot']) : 0;
    $articleId = isset($_POST['article']) ? intval($_POST['article']) : 0;
    $fournisseurId = isset($_POST['fournisseur']) ? intval($_POST['fournisseur']) : 0;
    $serviceId = isset($_POST['service']) ? intval($_POST['service']) : 0;
    $ref = isset($_POST['ref']) ? $_POST['ref'] : '';
    $entree = isset($_POST['entree']) ? floatval($_POST['entree']) : 0.00;
    $sortie = isset($_POST['sortie']) ? floatval($_POST['sortie']) : 0.00;
    $prix = isset($_POST['prix']) ? floatval($_POST['prix']) : 0.00;
    $dateOperation = isset($_POST['date_operation']) ? $_POST['date_operation'] : '';

    // Convertir la date et l'heure en format DATETIME
    $formattedDateOperation = date('Y-m-d H:i:s', strtotime($dateOperation));

    if ($formattedDateOperation === false) {
        echo "La date d'opération est invalide.";
        exit();
    }

    // Supprimer l'ancienne opération
    if ($operationId > 0) {
        $deleteQuery = "DELETE FROM operation WHERE id = ?";
        if ($deleteStmt = $conn->prepare($deleteQuery)) {
            $deleteStmt->bind_param("i", $operationId);
            if (!$deleteStmt->execute()) {
                echo "Erreur lors de la suppression de l'opération : " . $deleteStmt->error;
                exit();
            }
            $deleteStmt->close();
        } else {
            echo "Erreur lors de la préparation de la suppression de l'opération : " . $conn->error;
            exit();
        }
    }

    // Fonction pour récupérer un nom à partir d'une table et d'un ID
    function getNom($conn, $table, $idColonne, $nomColonne, $id) {
        $query = "SELECT $nomColonne FROM $table WHERE $idColonne = ?";
        if ($stmt = $conn->prepare($query)) {
            $stmt->bind_param("i", $id);
            if ($stmt->execute()) {
                $result = $stmt->get_result();
                if ($result->num_rows > 0) {
                    $data = $result->fetch_assoc();
                    $stmt->close();
                    return $data[$nomColonne];
                }
            } else {
                echo "Erreur lors de l'exécution de la requête : " . $stmt->error;
                exit();
            }
            $stmt->close();
        } else {
            echo "Erreur lors de la préparation de la requête : " . $conn->error;
            exit();
        }
        return '';
    }

    // Obtenir le nom du lot, sous-lot, article, fournisseur et service
    $lotName = getNom($conn, 'lots', 'lot_id', 'lot_name', $lotId);
    $sousLotName = getNom($conn, 'sous_lots', 'sous_lot_id', 'sous_lot_name', $sousLotId);
    $articleName = getNom($conn, 'article', 'id_article', 'nom', $articleId);
    $unite = getNom($conn, 'article', 'id_article', 'unite', $articleId);
    $fournisseurName = getNom($conn, 'fournisseurs', 'id_fournisseur', 'nom_fournisseur', $fournisseurId) . ' ' .
        getNom($conn, 'fournisseurs', 'id_fournisseur', 'prenom_fournisseur', $fournisseurId);
    $serviceName = getNom($conn, 'service_zone', 'id', 'service', $serviceId);

    // Obtenir le prix de la dernière opération
    $queryPrix = "SELECT prix_operation FROM operation WHERE nom_article = ? ORDER BY date_operation DESC LIMIT 1";
    if ($stmt = $conn->prepare($queryPrix)) {
        $stmt->bind_param("s", $articleName);
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                $prix_sortie = floatval($result->fetch_assoc()['prix_operation']);
            } else {
                $prix_sortie = 0.00; // Ou une autre valeur par défaut si aucune opération précédente n'est trouvée
            }
            $stmt->close();
        } else {
            echo "Erreur lors de l'exécution de la requête pour le prix : " . $stmt->error;
            exit();
        }
    } else {
        echo "Erreur lors de la préparation de la requête pour le prix : " . $conn->error;
        exit();
    }

    // Calcul du prix et des dépenses
    $prix = ($entree == 0.00) ? $prix_sortie : $prix;
    $depense_sortie = $prix * $sortie;
    $depense_entre = $entree * $prix;

    // Déterminer la valeur de pj_operation
    $pjOperation = null;
    if (!empty($entree)) {
        $pjOperation = "Bon entrée";
    } elseif (!empty($sortie)) {
        $pjOperation = "Bon sortie";
    }

    // Préparer la requête pour insérer les données dans la table operation
    $queryInsert = "INSERT INTO operation (lot_name, sous_lot_name, nom_article, date_operation, entree_operation, sortie_operation, nom_pre_fournisseur, service_operation, prix_operation, unite_operation, pj_operation, ref, depense_entre, depense_sortie)
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    if ($stmt = $conn->prepare($queryInsert)) {
        $stmt->bind_param("ssssssssssssss", $lotName, $sousLotName, $articleName, $formattedDateOperation, $entree, $sortie, $fournisseurName, $serviceName, $prix, $unite, $pjOperation, $ref, $depense_entre, $depense_sortie);

        // Exécution de la requête
        if ($stmt->execute()) {
            $start_date = '1000-01-01'; // Date de début
            $end_date = '9024-12-31'; // Date de fin

            $sql_select = "
                SELECT 
                    a.id_article AS ID,
                    a.nom AS Article,
                    a.stock_initial AS Stock_Initial,
                    COALESCE(SUM(o.entree_operation), 0) AS Total_Entry_Operations,
                    COALESCE(SUM(o.sortie_operation), 0) AS Total_Exit_Operations,
                    a.stock_initial + COALESCE(SUM(o.entree_operation), 0) - COALESCE(SUM(o.sortie_operation), 0) AS Stock_Final,
                    (
                        SELECT AVG(p.prix_operation)
                        FROM operation p
                        WHERE p.nom_article = a.nom
                        AND p.date_operation BETWEEN '$start_date' AND '$end_date'
                        ORDER BY p.date_operation DESC
                        LIMIT 30
                    ) AS Prix,
                    (
                        a.stock_initial + COALESCE(SUM(o.entree_operation), 0) - COALESCE(SUM(o.sortie_operation), 0)
                    ) * (
                        SELECT AVG(p.prix_operation)
                        FROM operation p
                        WHERE p.nom_article = a.nom
                        AND p.date_operation BETWEEN '$start_date' AND '$end_date'
                        ORDER BY p.date_operation DESC
                        LIMIT 30
                    ) AS Stock_Value,
                    a.stock_min AS Stock_Min,
                    CASE 
                        WHEN a.stock_initial +
                        COALESCE(SUM(o.entree_operation), 0) - COALESCE(SUM(o.sortie_operation), 0) < a.stock_min 
                        THEN 'besoin' 
                        ELSE 'bon' 
                    END AS Requirement_Status
                FROM 
                    article a
                LEFT JOIN 
                    operation o ON o.nom_article = a.nom
                WHERE 
                    o.date_operation BETWEEN '$start_date' AND '$end_date'
                GROUP BY 
                    a.id_article, a.nom, a.stock_initial, a.stock_min

            ";

            $result = $conn->query($sql_select);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $id = $row['ID'];
                    $article = $row['Article'];
                    $stock_initial = $row['Stock_Initial'];
                    $total_entry_operations = $row['Total_Entry_Operations'];
                    $total_exit_operations = $row['Total_Exit_Operations'];
                    $stock_final = $row['Stock_Final'];
                    $prix = $row['Prix'];
                    $stock_value = $row['Stock_Value'];
                    $stock_min = $row['Stock_Min'];
                    $requirement_status = $row['Requirement_Status'];

                    // Calculer les dépenses
                    $total_depenses_entree = $total_entry_operations * $prix;
                    $total_depenses_sortie = $total_exit_operations * $prix;

                    // Vérifier si les données existent dans la table
                    $sql_check = "SELECT ID FROM etat_de_stocks WHERE ID = ?";
                    if ($stmtCheck = $conn->prepare($sql_check)) {
                        $stmtCheck->bind_param("i", $id);
                        $stmtCheck->execute();
                        $stmtCheck->store_result();

                        if ($stmtCheck->num_rows > 0) {
                            // Mettre à jour les données si elles existent
                            $sql_update = "UPDATE etat_de_stocks SET 
                                            Article=?, Stock_Initial=?, Total_Entry_Operations=?, Total_Exit_Operations=?, 
                                            Stock_Final=?, Prix=?, Stock_Value=?, Total_Depenses_Entree=?, 
                                            Total_Depenses_Sortie=?, Stock_Min=?, Requirement_Status=? WHERE ID=?";
                            if ($stmtUpdate = $conn->prepare($sql_update)) {
                                $stmtUpdate->bind_param("sssiiidddisi", $article, $stock_initial, $total_entry_operations, $total_exit_operations, $stock_final, $prix, $stock_value, $total_depenses_entree, $total_depenses_sortie, $stock_min, $requirement_status, $id);
                                if (!$stmtUpdate->execute()) {
                                    echo "Erreur lors de la mise à jour d'etat_de_stocks : " . $stmtUpdate->error;
                                }
                                $stmtUpdate->close();
                            } else {
                                echo "Erreur lors de la préparation de la mise à jour d'etat_de_stocks : " . $conn->error;
                            }
                        } else {
                            // Insérer les données si elles n'existent pas
                            $sql_insert = "
                                INSERT INTO etat_de_stocks (ID, Article, Stock_Initial, Total_Entry_Operations, Total_Exit_Operations, 
                                    Stock_Final, Prix, Stock_Value, Total_Depenses_Entree, Total_Depenses_Sortie, Stock_Min, Requirement_Status)
                                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
                            ";
                            if ($stmtInsert = $conn->prepare($sql_insert)) {
                                $stmtInsert->bind_param("isssiiidddis", $id, $article, $stock_initial, $total_entry_operations, $total_exit_operations, $stock_final, $prix, $stock_value, $total_depenses_entree, $total_depenses_sortie, $stock_min, $requirement_status);
                                if (!$stmtInsert->execute()) {
                                    echo "Erreur lors de l'insertion dans etat_de_stocks : " . $stmtInsert->error;
                                }
                                $stmtInsert->close();
                            } else {
                                echo "Erreur lors de la préparation de l'insertion dans etat_de_stocks : " . $conn->error;
                            }
                        }
                        $stmtCheck->close();
                    } else {
                        echo "Erreur lors de la préparation de la vérification d'etat_de_stocks : " . $conn->error;
                    }
                }
            } else {
                echo "Aucune donnée à traiter.";
            }

            // Redirection avec message de succès
            if (article_besoin($articleName, "besoin", $conn)) {
                header("Location: option_Ent_Sor.php?message=ss&nomArticle=$articleName");
            } else {
                header("Location: option_Ent_Sor.php");
            }

            exit();
        } else {
            echo "Erreur lors de l'ajout de l'opération : " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Erreur lors de la préparation de l'insertion de l'opération : " . $conn->error;
    }

    // Fermer la connexion
    $conn->close();
}
?>