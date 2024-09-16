<?php
// Afficher les erreurs (utile pour le débogage)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Démarrer la session
session_start();

// Inclure le fichier de connexion à la base de données
include 'connect_db.php';

// Vérifier si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les informations du formulaire
    $userName = $_POST['user_name'];
    $password = $_POST['password'];

    // Préparer et exécuter la requête SQL pour obtenir le mot de passe correspondant à l'utilisateur
    $stmt = $conn->prepare("SELECT password FROM users WHERE user_name = ?");
    $stmt->bind_param("s", $userName);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($storedPassword);
    $stmt->fetch();

    // Vérifier si le mot de passe est correct
    if ($password === $storedPassword) {
        // Vérifier le nom d'utilisateur et définir la session
        if ($userName === 'admin') {
            $_SESSION['role'] = 'admin';  // Définir la session pour l'admin
            header("Location: ../View2/operations_01/option_Ent_Sor.php");
        } elseif ($userName === 'user') {
            $_SESSION['role'] = 'user';   // Définir la session pour l'utilisateur
            header("Location: ../View/operations_01/option_Ent_Sor.php");
        } else {
            // Utilisateur non reconnu
            echo "Utilisateur non reconnu.";
        }
    } else {
        // Mot de passe incorrect
        echo "<script>alert('Le mot de passe ou le nom d\'utilisateur est incorrect.')</script>";
        header('Location: ../index.php');
    }

    // Fermer la requête et la connexion
    $stmt->close();
    $conn->close();
} else {
    // Si le formulaire n'a pas été soumis, redirection vers la page de connexion
    header('Location: ../index.php');
}
?>
