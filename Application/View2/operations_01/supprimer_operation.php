<?php
// Inclure le fichier de connexion à la base de données
include '../../config/connect_db.php';

// Vérifier si l'ID de l'opération a été passé dans l'URL
if (isset($_GET['id'])) {
    $operation_id = intval($_GET['id']);

    // Préparer la requête SQL pour supprimer l'opération
    $query = "DELETE FROM operation WHERE id = ?";

    // Initialiser une déclaration préparée
    if ($stmt = mysqli_prepare($conn, $query)) {
        // Associer les paramètres à la requête préparée
        mysqli_stmt_bind_param($stmt, "i", $operation_id);

        // Exécuter la requête
        if (mysqli_stmt_execute($stmt)) {

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
            WHEN a.stock_initial + COALESCE(SUM(o.entree_operation), 0) - COALESCE(SUM(o.sortie_operation), 0) < a.stock_min 
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
    LIMIT 0, 25
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
                    $stmt = $conn->prepare($sql_check);
                    $stmt->bind_param("i", $id);
                    $stmt->execute();
                    $stmt->store_result();

                    if ($stmt->num_rows > 0) {
                        // Mettre à jour les données si elles existent
                        $sql_update = "TRUNCATE TABLE etat_de_stocks";
                        if ($conn->query($sql_update) === TRUE) {
                            $sql_insert = "
                INSERT INTO etat_de_stocks (ID, Article, Stock_Initial, Total_Entry_Operations, Total_Exit_Operations, 
                    Stock_Final, Prix, Stock_Value, Total_Depenses_Entree, Total_Depenses_Sortie, Stock_Min, Requirement_Status)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
            ";
                            $stmt = $conn->prepare($sql_insert);
                            $stmt->bind_param("isssiiidddis", $id, $article, $stock_initial, $total_entry_operations, $total_exit_operations, $stock_final, $prix, $stock_value, $total_depenses_entree, $total_depenses_sortie, $stock_min, $requirement_status);
                        }

                    } else {
                        // Insérer les données si elles n'existent pas
                        $sql_insert = "
                INSERT INTO etat_de_stocks (ID, Article, Stock_Initial, Total_Entry_Operations, Total_Exit_Operations, 
                    Stock_Final, Prix, Stock_Value, Total_Depenses_Entree, Total_Depenses_Sortie, Stock_Min, Requirement_Status)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
            ";
                        $stmt = $conn->prepare($sql_insert);
                        $stmt->bind_param("isssiiidddis", $id, $article, $stock_initial, $total_entry_operations, $total_exit_operations, $stock_final, $prix, $stock_value, $total_depenses_entree, $total_depenses_sortie, $stock_min, $requirement_status);
                    }

                    $stmt->execute();
                }
            } else {
                echo "Aucune donnée à traiter.";
            }
            header('Location: option_Ent_Sor.php?message=operation_supprimee');
            exit;
        } else {
            echo "Erreur lors de la suppression de l'opération : " . mysqli_error($conn);
        }

        // Fermer la déclaration
        mysqli_stmt_close($stmt);
    } else {
        echo "Erreur de préparation de la requête : " . mysqli_error($conn);
    }
} else {
    echo "ID d'opération non spécifié.";
}

// Fermer la connexion à la base de données
mysqli_close($conn);
?>
