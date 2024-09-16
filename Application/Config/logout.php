<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
session_destroy();
session_unset();

header("Location: ../../Application/index.php");
// Détruit la session
?>

