

<?php include '../../Config/connect_db.php'; $pageName= 'Catalogue du temps'; ?>
<?php
$querySelect = "SELECT * FROM fournisseurs";
$paramsSelect = [];
$data = selectData($querySelect, $paramsSelect);

$queryProduit = "SELECT DISTINCT nom_fournisseur FROM fournisseurs";
$nom_fournisseur = selectData($queryProduit, []);

$queryElement = "SELECT DISTINCT prenom_fournisseur FROM fournisseurs";
$prenom_fournisseur = selectData($queryElement, []);

//$queryFamille = "SELECT DISTINCT FamilleOperation FROM fournisseurs";
//$Familles = selectData($queryFamille, []);
?>



<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="../../includes/jquery.sheetjs.js"></script>

    <title>Document</title>
    <link rel="stylesheet" href="../../includes/css/bootstrap.min.css">
</head>
<body>
<?php
$pageName= 'Opration';
include '../../includes/header.php';
?>









</body>
<script src="../../includes/js/bootstrap.bundle.min.js"></script>

</html>
