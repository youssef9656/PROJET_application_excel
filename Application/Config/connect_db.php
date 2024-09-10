<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "journale";
$port=3308;
// Créer la connexion
$conn = new mysqli($servername, $username, $password, $dbname,$port);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fonction pour exécuter une requête SELECT avec des paramètres
function selectData($query, $params) {
    global $conn;
    $stmt = $conn->prepare($query);
    $data = [];

    if ($stmt) {
        if ($params) {
            $types = str_repeat('s', count($params)); // Types de paramètres, tous 's' pour string (à ajuster selon vos besoins)
            $stmt->bind_param($types, ...$params);
        }

        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        }

        $stmt->close();
    } else {
        echo "Error preparing statement: " . $conn->error;
    }

    return $data;
}

// Fonction pour exécuter une requête UPDATE avec des paramètres
function updateData($query, $params) {
    global $conn;
    $stmt = $conn->prepare($query);

    if ($stmt) {
        if ($params) {
            $types = str_repeat('s', count($params)); // Types de paramètres, tous 's' pour string (à ajuster selon vos besoins)
            $stmt->bind_param($types, ...$params);
        }

        if ($stmt->execute()) {
            echo "Record updated successfully";
        } else {
            echo "Error updating record: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Error preparing statement: " . $conn->error;
    }
}

// Fonction pour exécuter une requête DELETE avec des paramètres
function deleteData($query, $params) {
    global $conn;
    $stmt = $conn->prepare($query);

    if ($stmt) {
        if ($params) {
            $types = str_repeat('s', count($params)); // Types de paramètres, tous 's' pour string (à ajuster selon vos besoins)
            $stmt->bind_param($types, ...$params);
        }

        if ($stmt->execute()) {
            echo "Record deleted successfully";
        } else {
            echo "Error deleting record: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Error preparing statement: " . $conn->error;
    }
}

// Sélectionner des données avec des paramètres dynamiques
/* $querySelect = "SELECT * FROM utilisateurs WHERE nom = ? AND email = ?";
$paramsSelect = ["John", "john@example.com"];
$data = selectData($conn, $querySelect, $paramsSelect);

// Affichage des données sélectionnées
foreach ($data as $row) {
    echo "id: " . $row["id"] . " - Nom: " . $row["nom"] . " - Email: " . $row["email"] . "<br>";
} */

// Modifier une donnée avec des paramètres dynamiques
/* $queryUpdate = "UPDATE utilisateurs SET nom = ?, email = ? WHERE id = ?";
$paramsUpdate = ["Nouveau Nom", "nouveauemail@example.com", 1];
updateData($conn, $queryUpdate, $paramsUpdate); */

// Supprimer des données avec des paramètres dynamiques
/* $queryDelete = "DELETE FROM utilisateurs WHERE nom = ? AND email = ?";
$paramsDelete = ["Jane", "jane@example.com"];
deleteData($conn, $queryDelete, $paramsDelete); */

//$conn->close();
?>
