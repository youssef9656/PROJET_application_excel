<?php
session_start();

// Vérifier si la session est définie
if (!isset($_SESSION['role'])) {
    // Si l'utilisateur n'est pas connecté, redirection vers la page de connexion
    header('Location: ../../index.php');
    exit(); // Arrêter l'exécution du reste de la page
}

// Vous pouvez aussi ajouter ici une vérification par rapport au rôle de l'utilisateur
// et rediriger en fonction du rôle s'il n'a pas accès à cette page.
function checkUserRole($requiredRole) {
    // Vérifie si le rôle de l'utilisateur correspond au rôle requis
    if ($_SESSION['role'] !== $requiredRole) {
        // Si l'utilisateur n'a pas le bon rôle, le rediriger
        header('Location: ../../index.php');
        exit();
    }
}
?>

