<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Inclure le fichier de connexion à la base de données
include 'connect_db.php';

// Vérifier si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les informations du formulaire
    $userName = $_POST['user_name'];
    $password = $_POST['password'];

    // Préparer et exécuter la requête SQL
    $stmt = $conn->prepare("SELECT password FROM users WHERE user_name = ?");
    $stmt->bind_param("s", $userName);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($storedPassword);
    $stmt->fetch();

    // Vérifier si le mot de passe est correct
    if ($password === $storedPassword) {
        // Redirection en fonction du nom d'utilisateur
        if ($userName === 'admin') {
            header("Location: ../View2/operations_01/option_Ent_Sor.php");
        } elseif ($userName === 'user') {
            header("Location: ../View/operations_01/option_Ent_Sor.php");
        } else {
            // Utilisateur non reconnu
            echo "Utilisateur non reconnu.";
        }
    } else {
        // Mot de passe incorrect
        header('Location: ../index.php');
        echo "<script>alert('le mot de passe ou le nom d\'uitilisateur est incorrect')</script>";
    }

    // Fermer la connexion
    $stmt->close();
    $conn->close();
} else {
    // Si le formulaire n'a pas été soumis
    header('Location: ../index.php');
}
?>


